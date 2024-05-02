<?php

namespace RestClient\Log;

use RestClient\Extension\LogExtension;
use RestClient\Response;

class LogSQL implements LogExtension{

    private $pdo;
    private $tablename;

    public function __construct(\PDO $pdo, $tablename = '__log_client_request'){
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
        
            $query =  "
                CREATE TABLE {$this->tablename} (
                    `id` int NOT NULL AUTO_INCREMENT,
                    `request_id` varchar(45) DEFAULT NULL,
                    `request_from_server` varchar(100) DEFAULT NULL,
                    `request_from_address` varchar(20) DEFAULT NULL,
                    `request_url` varchar(255) DEFAULT NULL,
                    `request_method` varchar(10) DEFAULT NULL,
                    `request_idempotencykey` varchar(45) DEFAULT NULL,
                    `request_headers` text,
                    `request_params` text,
                    `request_curl_options` text,
                    `request_execution_time` decimal(10,2) DEFAULT NULL,
                    `request_additional_info` varchar(255) DEFAULT NULL,
                    `response_code` int DEFAULT NULL,
                    `response_error` text,
                    `response_format` varchar(20) DEFAULT NULL,
                    `response_headers` text,
                    `response_body` longtext,
                    `request_datetime` datetime DEFAULT NULL,
                    PRIMARY KEY (`id`),
                    UNIQUE KEY `id_UNIQUE` (`id`)
                ) ENGINE=InnoDB;
            ";
        
            return $this->pdo->query($query) ? true : false;
        }
        catch(\Throwable $e){
            return false;
        }
    }

    public function register(Response $response):void {
        try{
            $request = $response->request;

            $request_headers = empty($request->headers) ? null : json_encode($request->headers);
            $request_params = empty($request->parameters) ? null : json_encode($request->parameters);
            $request_curl_options = empty($request->curl_options) ? null : json_encode($request->curl_options);
            $response_headers = json_encode($response->headers);
            
            $query = "
                INSERT INTO {$this->tablename} (
                    request_id, 
                    request_from_server,
                    request_from_address,
                    request_url, 
                    request_method, 
                    request_idempotencykey, 
                    request_headers, 
                    request_params, 
                    request_curl_options, 
                    request_datetime, 
                    request_execution_time, 
                    request_additional_info,
                    response_code, 
                    response_error, 
                    response_format, 
                    response_headers, 
                    response_body
                    ) VALUES (
                    :request_id,
                    :request_from_server,
                    :request_from_address,
                    :request_url, 
                    :request_method, 
                    :request_idempotencykey, 
                    :request_headers, 
                    :request_params, 
                    :request_curl_options, 
                    :request_datetime, 
                    :request_execution_time, 
                    :request_additional_info,
                    :response_code, 
                    :response_error, 
                    :response_format, 
                    :response_headers, 
                    :response_body
                );
            ";
            
            $stmt = $this->pdo->prepare($query);
            $stmt->bindValue('request_id', $request->id); 
            $stmt->bindValue('request_from_server', $request->from_server); 
            $stmt->bindValue('request_from_address', $request->from_address); 
            $stmt->bindValue('request_url', $request->url); 
            $stmt->bindValue('request_method', $request->method); 
            $stmt->bindValue('request_idempotencykey', $request->idempotencykey); 
            $stmt->bindValue('request_headers', $request_headers); 
            $stmt->bindValue('request_params', $request_params); 
            $stmt->bindValue('request_curl_options', $request_curl_options); 
            $stmt->bindValue('request_datetime', $request->creation_at); 
            $stmt->bindValue('request_execution_time', $request->execution_time); 
            $stmt->bindValue('request_additional_info', $request->info); 
            $stmt->bindValue('response_code', $response->code); 
            $stmt->bindValue('response_error', $response->error); 
            $stmt->bindValue('response_format', $response->format); 
            $stmt->bindValue('response_headers', $response_headers); 
            $stmt->bindValue('response_body', is_array($response->body) ? json_encode($response->body) : $response->body);
            $stmt->execute();
        }
        catch(\Throwable $e){
            return;
        }
    }   

}