<?php

/**
 * @method static boolean isValid(mixed $value)
 */

namespace DataValidator\Field;

class NotEmpty extends Field{

    public function validate($value) : bool{
        
        if ( (is_null($value))
          OR (self::scalarEmpty($value))
          OR (is_array($value) AND count($value)==1 AND isset($value[0]) AND self::scalarEmpty($value[0]))
          OR (is_array($value) AND empty($value)) )
        {
            $name = parent::getName();
            
            parent::newError("Field {$name} cannot be empty.");   
            
            return false;
        }           
        
        return true;
    }

    private static function scalarEmpty($attr):bool {
        return ( is_scalar($attr) AND !is_bool($attr) AND trim($attr) == '' );
    }

}