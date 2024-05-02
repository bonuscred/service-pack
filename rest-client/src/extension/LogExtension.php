<?php

namespace RestClient\Extension;

use RestClient\Response;

interface LogExtension{

    public function isReady():bool;

    public function register(Response $response):void;

}