<?php

/**
 * @method static boolean isValid(mixed $value, Array $allow_formats = ['integer', 'float', 'infinite', 'nan', 'number_string', 'negative'])
 */

namespace DataValidator\Field;

class Numeric extends Field{

    private $allow_integer = true;
    private $allow_float = true;
    private $allow_infinite = true;
    private $allow_nan = true;
    private $allow_number_string = true;
    private $allow_negative = true;

    public function validate($value):bool {
        $name = parent::getName();
        
        if( !is_numeric($value) ){
            parent::newError("Field {$name} is not numeric.");  
            
            return false;
        }

        if( !$this->allow_integer && is_int($value)){
            parent::newError("Field {$name} is a integer number.");

            return false;
        }

        if( !$this->allow_float && is_float($value)){
            parent::newError("Field {$name} is a float number.");

            return false;
        }
        
        if( !$this->allow_infinite && is_float($value) && is_infinite($value)){
            parent::newError("Field {$name} is a infinite number.");

            return false;
        }
        
        if( !$this->allow_nan && is_float($value) && is_nan($value)){
            parent::newError("Field {$name} is a NAN number.");

            return false;
        }
        
        if( !$this->allow_number_string && is_string($value)){
            parent::newError("Field {$name} is a string number.");
            
            return false;
        }
        
        if( !$this->allow_negative && $value < 0 ){
            parent::newError("Field {$name} is a negative number.");

            return false;
        }        

        return true;
    }

    public function allow(Array $options):void {
        $this->allow_integer = false;
        $this->allow_float = false;
        $this->allow_infinite = false;
        $this->allow_nan = false;
        $this->allow_number_string = false;
        $this->allow_negative = false;
        
        foreach($options as $option){
            $var = 'allow_'.$option;
            
            if(property_exists($this, $var)){
                $this->{$var} = true;
            }
        }
    }

    public static function create(string $fieldname, Array $allow_formats = ['integer', 'float', 'infinite', 'nan', 'number_string', 'negative']):Field {
        $field = new self($fieldname);
        $field->allow($allow_formats);
        
        return $field;
    }

}