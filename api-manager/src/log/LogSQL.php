<?php

namespace ApiManager\Log;

use ApiManager\Provider\Log;

class LogSQL extends Log{

    private \PDO $pdo;
    private string $tablename;

    public function __construct(\PDO $pdo, string $tablename = '__log_server_request'){
        $this->pdo = $pdo;
        $this->tablename = $tablename;
    }

    public function isReady():bool {
        try{
            $stmt = $this->pdo->query("SHOW TABLES LIKE '{$this->tablename}'");
            $result = $stmt->fetchAll();

            if(!empty($result)) {
                return true;
            }
            
            $query = "
                CREATE TABLE {$this->tablename} (
                    `id` int NOT NULL AUTO_INCREMENT,
                    `request_id` varchar(45) NOT NULL,
                    `server_id` varchar(45) DEFAULT NULL,
                    `server_name` varchar(45) DEFAULT NULL,
                    `protocol` varchar(5) DEFAULT NULL,
                    `uri` varchar(255) DEFAULT NULL,
                    `http_method` varchar(10) DEFAULT NULL,
                    `prefix` varchar(100) DEFAULT NULL,
                    `sufix` varchar(255) DEFAULT NULL,
                    `header_params` text DEFAULT NULL,
                    `body_params` longtext,
                    `query_params` text,
                    `middleware_params` text,
                    `ip_origin` varchar(45) DEFAULT NULL,
                    `send_to_service` tinyint(1) NOT NULL DEFAULT '0',
                    `response_code` int DEFAULT NULL,
                    `response_headers` text,
                    `response_body` longtext,
                    `response_execution_time` decimal(10,2) DEFAULT NULL,
                    `idempotencykey` varchar(100) DEFAULT NULL,
                    `creation_datetime` datetime NOT NULL,
                    PRIMARY KEY (`id`),
                    UNIQUE KEY `id_UNIQUE` (`id`),
                    UNIQUE KEY `request_id_UNIQUE` (`request_id`)
                ) ENGINE=InnoDB;
            ";

            return $this->pdo->query($query) ? true : false;       
        }
        catch(\Throwable $e){
            return false;
        }
    }

    public function register(LogData $data):void {
        try{
            $query = "
                INSERT INTO {$this->tablename} (
                    request_id, 
                    server_id, 
                    server_name, 
                    ip_origin, 
                    protocol, 
                    uri, 
                    http_method, 
                    prefix, 
                    sufix, 
                    header_params, 
                    body_params,
                    creation_datetime,
                    query_params,
                    middleware_params,
                    response_code,
                    response_headers,
                    response_body,
                    response_execution_time,
                    idempotencykey,
                    send_to_service
                ) 
                VALUES (
                    :request_id, 
                    :server_id, 
                    :server_name, 
                    :ip_origin, 
                    :protocol, 
                    :uri, 
                    :http_method, 
                    :prefix, 
                    :sufix, 
                    :header_params, 
                    :body_params, 
                    :creation_datetime,
                    :query_params,
                    :middleware_params,
                    :response_code,
                    :response_headers,
                    :response_body,
                    :response_execution_time,
                    :idempotencykey,
                    :send_to_service
                );
            ";
            
            $stmt = $this->pdo->prepare($query);
            $stmt->bindValue('server_id', $data->server_id);
            $stmt->bindValue('request_id', $data->request_id);
            $stmt->bindValue('server_name', $data->server_name);
            $stmt->bindValue('ip_origin', $data->ip_origin);
            $stmt->bindValue('protocol', $data->protocol);
            $stmt->bindValue('uri', $data->uri);
            $stmt->bindValue('http_method', $data->http_method);
            $stmt->bindValue('prefix', $data->prefix);
            $stmt->bindValue('sufix', $data->sufix);
            $stmt->bindValue('header_params', $data->header_params);
            $stmt->bindValue('body_params', $data->body_params);
            $stmt->bindValue('creation_datetime', $data->creation_datetime);
            $stmt->bindValue('query_params', $data->query_params);
            $stmt->bindValue('middleware_params', $data->middleware_params);
            $stmt->bindValue('response_code', $data->response_code);
            $stmt->bindValue('response_headers', $data->response_headers);
            $stmt->bindValue('response_body', $data->response_body);
            $stmt->bindValue('response_execution_time', $data->response_execution_time);
            $stmt->bindValue('idempotencykey', $data->idempotencykey);
            $stmt->bindValue('send_to_service', $data->send_to_service);

            $stmt->execute();
        }
        catch(\Throwable $e){
            return;
        }
    }

    public function findByIdempotency(string $key, string $value):?LogData {
        try{
            $key_value = $key.':'.$value;

            $stmt = $this->pdo->prepare("SELECT * FROM {$this->tablename} WHERE idempotencykey = :idempotencykey;");
            $stmt->bindValue('idempotencykey', $key_value);
            $stmt->execute();
            $result = $stmt->fetch(\PDO::FETCH_ASSOC);

            if(empty($result)){
                return null;
            }

            $data = new LogData;
            $data->parse($result);

            return $data;
        } 
        catch(\Throwable $e){
            return null;
        }
    }

}