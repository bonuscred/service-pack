<?php

/**
 * @method static boolean isValid(mixed $value, Array $options)
 */

namespace DataValidator\Field;

class Enum extends Field{

    private $options = [];

    public function validate($value):bool {
        if( !in_array($value, $this->options) ){
            $name = parent::getName();

            parent::newError("Field {$name} does not contain a valid option.");   
            
            return false;
        }
        return true;
    }

    public function addOptions(Array $options):void {
        foreach($options as $option){
            $this->options[] = $option;
        }        
    }

    public static function create(string $fieldname, Array $options):Field {
        $field = new self($fieldname);
        $field->addOptions($options);        

        return $field;
    }

}