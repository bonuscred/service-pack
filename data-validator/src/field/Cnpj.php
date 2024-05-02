<?php

/**
 * @method static boolean isValid(mixed $value, bool $mask = true)
 */

namespace DataValidator\Field;

class Cnpj extends Field{

    private $mask = true;

    public function validate($value):bool {
        try {
            $name = parent::getName();
            
            if( !$this->mask && !ctype_digit($value)){
                throw new \Exception("Field {$name} only accepts numbers.");
            }
            
            if($this->mask && !ctype_digit($value) && !preg_match("/[0-9]{2}[\.][0-9]{3}[\.][0-9]{3}[\/][0-9]{4}[-][0-9]{2}/", $value)) {
                throw new \Exception("Field {$name} is not a valid CNPJ.");
            }
    
            $cnpj = preg_replace( "@[./-]@", "", $value );
            if(strlen( $cnpj ) <> 14 or !is_numeric($cnpj)){
                throw new \Exception("Field {$name} is not a valid CNPJ.");
            }

            $k = 6;
            $soma1 = 0;
            $soma2 = 0;
            for($i = 0; $i < 13; $i++){
                $k = $k == 1 ? 9 : $k;
                $soma2 += ( substr($cnpj, $i, 1) * $k );
                $k--;
                if($i < 12)
                {
                    if($k == 1)
                    {
                        $k = 9;
                        $soma1 += ( substr($cnpj, $i, 1) * $k );
                        $k = 1;
                    }
                    else
                    {
                        $soma1 += ( substr($cnpj, $i, 1) * $k );
                    }
                }
            }
            
            $digito1 = $soma1 % 11 < 2 ? 0 : 11 - $soma1 % 11;
            $digito2 = $soma2 % 11 < 2 ? 0 : 11 - $soma2 % 11;
            
            $valid = ( substr($cnpj, 12, 1) == $digito1 and substr($cnpj, 13, 1) == $digito2 );
            
            if (!$valid){
                throw new \Exception("Field {$name} is not a valid CNPJ.");
            }
    
            return true;
        }
        catch(\Exception $e){
            parent::newError("Field {$name} is not a valid CNPJ.");

            return false;
        }
    }

    public function allowMask(bool $option):void {
        $this->mask = $option;
    }
    
    public static function create(string $fieldname, bool $mask = true):Field {
        $field = new self($fieldname);
        $field->allowMask($mask);    

        return $field;
    }

}