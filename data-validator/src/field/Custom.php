<?php

/**
 * @method static boolean isValid(mixed $value, callable $callable)
 */

namespace DataValidator\Field;

class Custom extends Field{

    private $callable = null;
    
    public function validate($value):bool {
        if(empty($this->callable) || !call_user_func($this->callable, $value)){
            $name = parent::getName();

            parent::newError("Field {$name} could not be validated.");   
            
            return false;
        }
        return true;
    }

    public function setCallable(callable $callable):void {
        $this->callable = $callable;
    }

    public static function create(string $fieldname, callable $callable):Field {
        $field = new self($fieldname);
        $field->setCallable($callable);

        return $field;
    }

}