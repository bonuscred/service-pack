<?php

namespace ApiManager\Log;

use ApiManager\Provider\Log;

class LogFile extends Log{

    protected $dir;

    public function __construct(string $dir){
        $this->dir = trim($dir, './');
    }

    public function isReady():bool{
        return is_dir($this->dir) && is_writable($this->dir);
    }

    public function register(LogData $data):void {
        $info = function($field, $data){
            return "{$field}: {$data} \n";
        };
        
        $content = '';
        $content.= $info('server_id', $data->server_id);
        $content.= $info('request_id', $data->request_id);
        $content.= $info('server_name', $data->server_name);
        $content.= $info('ip_origin', $data->ip_origin);
        $content.= $info('protocol', $data->protocol);
        $content.= $info('uri', $data->uri);
        $content.= $info('http_method', $data->http_method);
        $content.= $info('prefix', $data->prefix);
        $content.= $info('sufix', $data->sufix);
        $content.= $info('header_params', $data->header_params);
        $content.= $info('body_params', $data->body_params);
        $content.= $info('creation_datetime', $data->creation_datetime);
        $content.= $info('query_params', $data->query_params);
        $content.= $info('middleware_params', $data->middleware_params);
        $content.= $info('response_code', $data->response_code);
        $content.= $info('response_headers', $data->response_headers);
        $content.= $info('response_body', $data->response_body);
        $content.= $info('response_execution_time', $data->response_execution_time);
        $content.= $info('idempotencykey', $data->idempotencykey);
        $content.= $info('send_to_service', $data->send_to_service);

        $filename = $data->idempotencykey ? str_replace(':', '_', $data->idempotencykey) : date('YmdHis_').uniqid();
        $filename.= '.txt';
        
        file_put_contents($this->dir.'/'.$filename, $content);
    }

    public function findByIdempotency(string $key, string $value):?LogData {
        $filename = "{$key}_{$value}.txt";
        $path = $this->dir.'/'.$filename;
        
        $info = [];

        if(file_exists($path)){
            $content = file($path);

            foreach($content as $line) {
                $pos = strpos($line, ':');
    
                if($pos === FALSE){
                    continue;
                }
    
                $line_key = substr($line, 0, $pos);
                $line_value = substr($line, ($pos+1));
    
                $info[$line_key] = trim($line_value);
            }            
        }

        if(empty($info['idempotencykey']) || $info['idempotencykey'] != "{$key}:{$value}"){
            return null;
        }

        $log = new LogData;
        $log->parse($info);

        return $log;
    }

}