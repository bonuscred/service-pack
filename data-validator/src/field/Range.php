<?php

/**
 * @method static boolean isValid(mixed $value, int|float $min = null, int|float $max = null)
 */

namespace DataValidator\Field;

class Range extends Field{

    private $min;
    private $max;

    public function validate($value):bool {
        $name = parent::getName();

        if( !is_numeric($value) ){
            parent::newError("Field {$name} accepts only numeric values");   
            
            return false;
        }

        if($this->min && $value < $this->min) {
            parent::newError("Field {$name} requires {$this->min} as minimum value");   
        }

        if($this->max && $value > $this->max) {
            parent::newError("Field {$name} allows {$this->max} as maximum value");   
        }

        return empty(parent::getErrors());
    }

    public function setMin(int|float|null $min):void {
        $this->min = $min;
    }

    public function setMax(int|float|null $max):void {
        $this->max = $max;
    }

    public static function create(string $fieldname, int|float $min = null, int|float $max = null):Field {
        $field = new self($fieldname);        
        $field->setMin($min);
        $field->setMax($max);

        return $field;
    }

}