<?php

namespace DataValidator\Field;

class ComplexArray extends Field{

    private $structure = [];

    public function getStructure():Array {
        return $this->structure;
    }

    public function setAttr(string $attr, Field $validator = null, Array $tree = []):void {
        if(empty($tree)){
            $this->structure[$attr] = $validator;
        }
        else{
            $pointer = &$this->structure;

            foreach($tree as $key){  
                if( empty($pointer[$key]) ){
                    $pointer[$key] = [];
                }

                $pointer = &$pointer[$key];        
            }

            $pointer[$attr] = $validator;
        }
    }    

    public function validate($value):bool {
        if(!is_array($value)){
            $name = parent::getName();

            parent::newError("Field {$name} must be an Array");

            return false;
        }
        
        foreach($this->structure as $attr => $elem){
            $this->compareAttr($value, $attr);
        }

        return empty($this->getErrors());
    }

    private function compareAttr(Array $data, string $attr, Array $tree = []):void {
        if(empty($tree)){            
            if(!isset($data[$attr])){
                parent::newError("Attribute '{$attr}' not found.");
            }                        

            $validator = $this->structure[$attr];
            $value_data = $data[$attr] ?? null;

        }else{
            $pointer = &$this->structure;
            $pointer_data = &$data;

            foreach($tree as $key){                
                $pointer = &$pointer[$key];
                $pointer_data = &$pointer_data[$key];
            }            
            
            if(!isset($pointer_data[$attr])){
                $field_tree = implode('->', $tree).'->'.$attr;
                parent::newError("Attribute '{$field_tree}' not found.");    
            }                
                        
            $validator = &$pointer[$attr];
            $value_data = &$pointer_data[$attr];            
        }

        if(is_array($validator)){
            $tree[] = $attr;
            foreach( $validator as $str_name => $value ){
                $this->compareAttr($data, $str_name, $tree);
            }
        }
        else if($validator instanceof Field){
            if(!$validator->validate($value_data)){
                foreach($validator->getErrors() as $error){
                    parent::newError(str_replace(['Field', 'field'], ['Attribute', 'atribute'], $error->message));
                }    
            }
        }        
    }
}