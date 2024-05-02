<?php

/**
 * @method static boolean isValid(mixed $value, string $mask)
 */

namespace DataValidator\Field;

class Mask extends Field{

    CONST AVAILABLE_MASKS = [
        'cpf'               => '^([0-9]{3}[\.][0-9]{3}[\.][0-9]{3}[-][0-9]{2}|\d{11})$',
        'cnpj'              => '^([0-9]{2}[\.][0-9]{3}[\.][0-9]{3}[\/][0-9]{4}[-][0-9]{2}|\d{14}))$',
        'cep'               => '^([0-9]{5}[\-][0-9]{3}|\d{8})$',
        'uuid'              => '^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$',
        'phone'             => '^((\+?\d{1,3})(\(\d{1,3}\)|\d{1,3})((\d{3,5})-?(\d{4}))|(\(\d{2}\)|\d{2})?(?:((?:9\d|[2-9])\d{3})-?(\d{4})))$',
        'phone_number'      => '^(?:((?:9\d|[2-9])\d{3})-?(\d{4}))$',
        'phone_with_ddd'    => '^(\(\d{2}\)|\d{2})(?:((?:9\d|[2-9])\d{3})-?(\d{4}))$',
        'phone_with_ddi'    => '^\+?\d{1,3}(\(\d{1,3}\)|\d{1,3})((\d{3,5})-?(\d{4}))$',
        'phone_E1641'       => '^\+[1-9][0-9]\d{1,14}$'
    ];

    private $mask;

    public function validate($value):bool {
        if($this->mask){
            $regex = self::AVAILABLE_MASKS[$this->mask];

            if( !preg_match("/{$regex}/", $value) ){
                $name = parent::getName();

                parent::newError("Field {$name} does not contain a valid {$this->mask} mask.");   
                
                return false;
            }            
        }
        return true;
    }
    
    public function setMask(string $mask):void {
        if(!array_key_exists($mask, self::AVAILABLE_MASKS)){
            throw new \Exception('Invalid mask.');
        }

        $this->mask = $mask;
    }

    public static function create(string $fieldname, string $mask):Field {
        $field = new self($fieldname);
        $field->setMask($mask);

        return $field;
    }

}