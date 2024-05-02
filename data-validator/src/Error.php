<?php

namespace DataValidator;

class Error {

    public $field;
    public $message;
    public $details;

    const FIELD_ALIAS = [
        '{$field}',
        '{$1}'
    ];

    public static function new(string $field, string $message, $details = null):Error {
        $error = new self;

        $error->field = $field;
        $error->message = str_replace(self::FIELD_ALIAS, $field, $message);
        $error->details = $details;

        return $error;
    }

}