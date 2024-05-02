<?php

namespace ApiManager\Provider;

use ApiManager\Log\LogData;

abstract class Log{

    abstract public function isReady():bool;

    abstract public function register(LogData $data):void;

    abstract public function findByIdempotency(string $key, string $value):?LogData;

}