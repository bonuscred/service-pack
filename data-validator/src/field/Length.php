<?php

/**
 * @method static boolean isValid(mixed $value, int $min = 0, int $max = null)
 */

namespace DataValidator\Field;

class Length extends Field{

    private $min = 0;
    private $max = null;

    public function validate($value):bool {
        $len = strlen($value);
        $name = parent::getName();

        if( $len < $this->min) {
            parent::newError("Field {$name} requires a minimum of {$this->min} characters");   
        }

        if( !empty($this->max) && $len > $this->max) {
            parent::newError("Field {$name} allows a maximum of {$this->max} characters");   
        }

        return empty(parent::getErrors());
    }

    public function setMin(int $min):void {
        $this->min = $min;
    }

    public function setMax(?int $max):void {
        $this->max = $max;
    }

    public static function create(string $fieldname, int $min = 0, int $max = null):Field {
        $field = new self($fieldname);
        $field->setMin($min);
        $field->setMax($max);

        return $field;
    }

}