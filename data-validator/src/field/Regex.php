<?php

/**
 * @method static boolean isValid(mixed $value, string $regex)
 */

namespace DataValidator\Field;

class Regex extends Field{

    private $regex = '';

    public function validate($value):bool {
        if( !preg_match("/{$this->regex}/", $value) ){
            $name = parent::getName();

            parent::newError("Field {$name} does not contain the required valid pattern.");   
            
            return false;
        }
        return true;
    }

    public function setRegex(string $regex){
        $this->regex = $regex;
    }

    public static function create(string $fieldname, string $regex):Field {
        $field = new self($fieldname);
        $field->setRegex($regex);

        return $field;
    }

}