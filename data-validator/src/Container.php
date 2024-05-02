<?php

/**
 * @method void type_string(string $fieldname)
 * 
 * @method void type_float(string $fieldname)
 *
 * @method void type_int(string $fieldname)
 * 
 * @method void type_boolean(string $fieldname)
 * 
 * @method void type_bool(string $fieldname)
 * 
 * @method void type_email(string $fieldname)
 * 
 * @method void type_ip(string $fieldname)
 * 
 * @method void type_mac(string $fieldname)
 * 
 * @method void type_url(string $fieldname)
 * 
 * @method void type_json(string $fieldname)
 * 
 * @method void type_hex(string $fieldname)
 * 
 * @method void type_array(string $fieldname)
 * 
 * @method void type_object(string $fieldname)
 * 
 * @method void type_callable(string $fieldname)
 * 
 * @method void mask_cpf(string $fieldname)
 * 
 * @method void mask_cnpj(string $fieldname)
 *
 * @method void mask_cep(string $fieldname)
 * 
 * @method void mask_uuid(string $fieldname)
 * 
 * @method void mask_phone(string $fieldname)
 * 
 * @method void mask_phone_number(string $fieldname)
 * 
 * @method void mask_phone_with_ddd(string $fieldname)
 * 
 * @method void mask_phone_with_ddi(string $fieldname)
 * 
 * @method void mask_phone_E1641(string $fieldname)
 * 
 * @method void cpf(string $fieldname, bool $allow_mask = true)
 * 
 * @method void cnpj(string $fieldname, bool $allow_mask = true)
 * 
 * @method void custom(string $fieldname, callable $callable_validation)
 * 
 * @method void date(string $fieldname, string $min_date = null, string $max_date = null, string $format = 'Y-m-d')
 * 
 * @method void enum(string $fieldname, Array $options)
 * 
 * @method void length(string $fieldname, int $min = 0, int|null $max = null)
 * 
 * @method void not_empty(string $fieldname)
 * 
 * @method void numeric(string $fieldname, $allow_options = ['integer', 'float', 'infinite', 'nan', 'number_string', 'negative'])
 * 
 * @method void range(string $fieldname, int|float $min = null, int|float $max = null)
 * 
 * @method void regex(string $fieldname, string $regex)
 */

namespace DataValidator;

use DataValidator\Field\Field;

class Container{

    const ALIAS = [
        'type_string'         => ['field' => '\Field\VarType',             'params' => ['string']],
        'type_float'          => ['field' => '\Field\VarType',             'params' => ['float']],
        'type_int'            => ['field' => '\Field\VarType',             'params' => ['int']],
        'type_boolean'        => ['field' => '\Field\VarType',             'params' => ['boolean']],
        'type_bool'           => ['field' => '\Field\VarType',             'params' => ['bool']],
        'type_email'          => ['field' => '\Field\VarType',             'params' => ['email']],
        'type_ip'             => ['field' => '\Field\VarType',             'params' => ['ip']],
        'type_mac'            => ['field' => '\Field\VarType',             'params' => ['mac']],
        'type_url'            => ['field' => '\Field\VarType',             'params' => ['url']],
        'type_json'           => ['field' => '\Field\VarType',             'params' => ['json']],
        'type_hex'            => ['field' => '\Field\VarType',             'params' => ['hex']],
        'type_array'          => ['field' => '\Field\VarType',             'params' => ['array']],
        'type_object'         => ['field' => '\Field\VarType',             'params' => ['object']],
        'type_callable'       => ['field' => '\Field\VarType',             'params' => ['callable']],
        'mask_cpf'            => ['field' => '\Field\Mask',                'params' => ['cpf']],
        'mask_cnpj'           => ['field' => '\Field\Mask',                'params' => ['cnpj']],
        'mask_cep'            => ['field' => '\Field\Mask',                'params' => ['cep']],
        'mask_uuid'           => ['field' => '\Field\Mask',                'params' => ['uuid']],
        'mask_phone'          => ['field' => '\Field\Mask',                'params' => ['phone']],
        'mask_phone_number'   => ['field' => '\Field\Mask',                'params' => ['phone_number']],
        'mask_phone_with_ddd' => ['field' => '\Field\Mask',                'params' => ['phone_with_ddd']],
        'mask_phone_with_ddi' => ['field' => '\Field\Mask',                'params' => ['phone_with_ddi']],
        'mask_phone_E1641'    => ['field' => '\Field\Mask',                'params' => ['phone_E1641']],
        'cpf'                 => ['field' => '\Field\Cpf',                 'params' => []],
        'cnpj'                => ['field' => '\Field\Cnpj',                'params' => []],
        'custom'              => ['field' => '\Field\Custom',              'params' => []],
        'date'                => ['field' => '\Field\Date',                'params' => []],
        'enum'                => ['field' => '\Field\Enum',                'params' => []],
        'length'              => ['field' => '\Field\Length',              'params' => []],
		'not_empty'           => ['field' => '\Field\NotEmpty',            'params' => []],
        'numeric'             => ['field' => '\Field\Numeric',             'params' => []],
        'range'               => ['field' => '\Field\Range',               'params' => []],
        'regex'               => ['field' => '\Field\Regex',               'params' => []],
    ];

    private $validations = [];
    private $conditional_validations = [];
    private $errors = [];


    public function getErrors(){
        return $this->errors;    
    }

    public function getFirstError(){
        if( !empty($this->getErrors()) ){
            return $this->getErrors()[0];
        }
    }

    public function getLastError(){
        if( !empty($this->getErrors()) ){
            return end($this->getErrors());
        }
    }

    public function add(Field $validator, string $custom_error_message = ''){
        $this->validations[] = [
            'validator' => $validator,
            'custom_error_message' => $custom_error_message
        ]; 
    }

    public function addConditional(string $reference_fieldname, mixed $reference_fieldname_value, Field $validator, string $custom_error_message = ''){
        $this->conditional_validations[] = [
            'reference' => $reference_fieldname,
            'reference_value' => $reference_fieldname_value,
            'validator' => $validator,
            'custom_error_message' => $custom_error_message
        ];
    }
    
    public function validate(Array|object $data){
        if( is_array($data) ){
            $data = (object) $data;
        }
        
        foreach( $this->validations as $validation ){
            $custom_error_message = $validation['custom_error_message'];
            $validator = $validation['validator'];
            $fieldname = $validator->getName(); 

            if( !property_exists($data, $fieldname) ){
                $this->errors[] = \DataValidator\Error::new($fieldname, 'Field not sent in data.');

                continue;
            }
                
            $validator->setCustomErrorMessage($custom_error_message);

            if( !$validator->validate($data->{$fieldname}) ){
                foreach( $validator->getErrors() as $error ){
                    $this->errors[] = $error;
                }
            }             
        }

        foreach($this->conditional_validations as $cv){
            $reference = $cv['reference'];
            $reference_value = $cv['reference_value'];
            $validator = $cv['validator'];
            $fieldname = $validator->getName(); 
            $custom_error_message = $cv['custom_error_message'];
            
            if( property_exists($data, $reference) ){
                if($reference_value instanceof Field){
                    if( !$reference_value->validate($data->{$reference}) ){
                        continue;    
                    }
                }
                else if($data->{$reference} != $reference_value){
                    continue;
                }

                if( !property_exists($data, $fieldname) ){
                    $this->errors[] = \DataValidator\Error::new($fieldname, 'Field not sent in data.');
    
                    continue;
                }

                $validator->setCustomErrorMessage($custom_error_message);

                if( !$validator->validate($data->{$fieldname}) ){
                    foreach( $validator->getErrors() as $error ){
                        $this->errors[] = $error;
                    }
                }
            }
        }
        
        return empty($this->getErrors());
    }

    public function __call(string $method, Array $args){
        if(!array_key_exists($method, self::ALIAS)){
            throw new \Exception("Method {$method} does not exists.");
        }

        if(empty($args)){
            throw new \Exception("Argument #1 (fieldname) is required for {$method}.");         
        }

        $fieldname = array_shift($args);

        $alias = self::ALIAS[$method];
        
        $params = [$fieldname];
            
        foreach($alias['params'] as $param){
            $params[] = $param;
        }
        
        foreach($args as $arg){
            $params[] = $arg;
        }
        
        $classname = __NAMESPACE__.$alias['field'];

        if(method_exists($classname, 'create')){
            $field = call_user_func_array([$classname, 'create'], $params);
        }
        else{
            $field = new $classname($fieldname);
        }

        $this->add($field);
    }

}