<?php

namespace DataValidator\Field;

abstract class Field{

    private $name;
    private $custom_error_message;
    private $errors = [];

    public function __construct(string $name = null){
        if(!$name){
            $name = uniqid(rand());
        }
        
        $this->name = $name;
    }

    final public function getName():?string {
        return $this->name;
    }

    final public function setName(string $name):void {
        $this->name = $name;
    }

    final public function getErrors():Array {
        return $this->errors;    
    }

    final public function setCustomErrorMessage(string $custom_error_message):void {
        $this->custom_error_message = $custom_error_message;    
    }

    abstract public function validate(mixed $value):bool;

    final protected function newError(string $message, $detail = null):void {
        if( !empty($this->custom_error_message) ){
            $message = $this->custom_error_message;
        }

        $this->errors[] = \DataValidator\Error::new($this->name, $message, $detail);
    }

    final public static function __callStatic($method, $arguments):bool {
        if($method == 'isValid'){
            if(empty($arguments)){
                throw new \InvalidArgumentException('Argument #1($value) is required');
            }

            $value = array_shift($arguments);

            
            if(method_exists(static::class, 'create')){
                array_unshift($arguments, uniqid(rand()));
                $field = call_user_func_array([static::class, 'create'], $arguments);
            }
            else{
                $field = new static;
            }

            return $field->validate($value);
        }
    }

}