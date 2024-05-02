<?php

/**
 * @method static boolean isValid(mixed $value, string $type)
 */

namespace DataValidator\Field;

class VarType extends Field{

    const AVAILABLE_FILTERS = [
        'ARRAY', 'BOOL', 'BOOLEAN', 'CALLABLE', 'DOMAIN', 
        'EMAIL', 'FLOAT', 'INT', 'IP', 'JSON', 
        'HEX', 'MAC', 'OBJECT', 'STRING', 'URL'         
    ];

    private $filter = 'STRING';
    
    public function validate($value):bool {
        $name = parent::getName();

        switch($this->filter){
            case 'STRING':
                $valid = is_string($value);
                break;
            case 'BOOLEAN':
            case 'BOOL':
                $valid = is_bool($value);
                break;
            case 'ARRAY':
                $valid = is_array($value);
                break;
            case 'OBJECT':
                $valid = is_object($value);
                break;
            case 'CALLABLE':
                $valid = is_callable($value);
                break;
            case 'FLOAT':
            case 'INT':
            case 'DOMAIN':
            case 'EMAIL':
            case 'IP':
            case 'MAC':
            case 'URL':
                $constant = constant('FILTER_VALIDATE_'.$this->filter);
                $valid = filter_var($value, $constant) === false ? false : true; 
                break;                   
            case 'JSON':
                if( phpversion() >= '8.3.0'){
                    $valid = json_validate($value);
                }
                else{
                    json_decode($value);    
                    $valid = json_last_error() === JSON_ERROR_NONE;
                }
                break;
            case 'HEX':
                $valid = ctype_xdigit($value);                    
                break;
        }

        if(!$valid){
            parent::newError("Field {$name} is not a valid {$this->filter}.");   
        }

        return $valid;
    }

    public function setFilter(string $filter):void {
        $filter = strtoupper($filter);
        
        if( !in_array($filter, self::AVAILABLE_FILTERS) ){
            throw new \Exception('Invalid var type.');
        }

        $this->filter = $filter;
    }

    public static function create(string $fieldname, string $type):Field {
        $field = new self($fieldname);
        $field->setFilter($type);

        return $field;
    }

}