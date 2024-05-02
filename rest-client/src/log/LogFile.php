<?php

namespace RestClient\Log;

use RestClient\Extension\LogExtension;
use RestClient\Response;

class LogFile implements LogExtension{

    protected $prefix;
    protected $dir;

    public function __construct(string $dir, string $prefix = ''){
        $this->dir = trim($dir, './');
        $this->prefix = str_replace(array('\\','/',':','*','?','"','<','>','|'),'',$prefix);
    }

    public function isReady():bool{
        return is_dir($this->dir) && is_writable($this->dir);
    }

    public function register(Response $response):void {
        $request = $response->request;

        $info = function($field, $data){
            return "{$field}: {$data} \n";
        };

        $request_headers = empty($request->headers) ? null : json_encode($request->headers);
        $request_params = empty($request->parameters) ? null : json_encode($request->parameters);
        $request_curl_options = empty($request->curl_options) ? null : json_encode($request->curl_options);
        $response_headers = json_encode($response->headers);
        
        $content = '';
        $content.= $info('request_id', $request->id); 
        $content.= $info('request_from_server', $request->from_server); 
        $content.= $info('request_from_address', $request->from_address); 
        $content.= $info('request_url', $request->url); 
        $content.= $info('request_method', $request->method); 
        $content.= $info('request_idempotencykey', $request->idempotencykey); 
        $content.= $info('request_headers', $request_headers); 
        $content.= $info('request_params', $request_params); 
        $content.= $info('request_curl_options', $request_curl_options); 
        $content.= $info('request_datetime', $request->creation_at); 
        $content.= $info('request_execution_time', $request->execution_time); 
        $content.= $info('request_additional_info', $request->info); 
        $content.= $info('response_code', $response->code); 
        $content.= $info('response_error', $response->error); 
        $content.= $info('response_format', $response->format); 
        $content.= $info('response_headers', $response_headers); 
        $content.= $info('response_body', is_array($response->body) ? json_encode($response->body) : $response->body);

        $filename = $this->prefix.date('YmdHis_').uniqid().'.txt';
        
        file_put_contents($this->dir.'/'.$filename, $content);
    }

}