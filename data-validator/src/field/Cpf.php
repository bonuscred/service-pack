<?php

/**
 * @method static boolean isValid(mixed $value, bool $mask = true)
 */

namespace DataValidator\Field;

class Cpf extends Field{

    private $mask = true;

    public function validate($value):bool {
        try{
            $name = parent::getName();
            
            if( !$this->mask && !ctype_digit($value)){
                throw new \Exception("Field {$name} only accepts numbers.");
            }
      
            if($this->mask && !ctype_digit($value) && !preg_match("/[0-9]{3}[\.][0-9]{3}[\.][0-9]{3}[-][0-9]{2}/", $value)){
                throw new \Exception("Field {$name} is not a valid CPF.");
            }

            // cpfs inválidos
            $nulos = array("12345678909","11111111111","22222222222","33333333333",
                          "44444444444","55555555555","66666666666","77777777777",
                          "88888888888","99999999999","00000000000");
            // Retira todos os caracteres que nao sejam 0-9
            $cpf = preg_replace("/[^0-9]/", "", $value);
            
            if (strlen($cpf) <> 11){
                throw new \Exception("Field {$name} is not a valid CPF.");
            }
            
            // Retorna falso se houver letras no cpf
            if (!(preg_match("/[0-9]/",$cpf))){
                throw new \Exception("Field {$name} is not a valid CPF.");
            }
    
            // Retorna falso se o cpf for nulo
            if( in_array($cpf, $nulos) ){
                throw new \Exception("Field {$name} is not a valid CPF.");
            }
    
            // Calcula o penúltimo dígito verificador
            $acum=0;
            for($i=0; $i<9; $i++){
              $acum+= $cpf[$i]*(10-$i);
            }
    
            $x=$acum % 11;
            $acum = ($x>1) ? (11 - $x) : 0;
            // Retorna falso se o digito calculado eh diferente do passado na string
            if ($acum != $cpf[9]){
                throw new \Exception("Field {$name} is not a valid CPF.");
            }
            // Calcula o último dígito verificador
            $acum=0;
            for ($i=0; $i<10; $i++)
            {
              $acum+= $cpf[$i]*(11-$i);
            }  
    
            $x=$acum % 11;
            $acum = ($x > 1) ? (11-$x) : 0;
            // Retorna falso se o digito calculado eh diferente do passado na string
            if ($acum != $cpf[10]){
                throw new \Exception("Field {$name} is not a valid CPF.");
            }

            return true;
        }
        catch(\Exception $e){
            parent::newError($e->getMessage());
  
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