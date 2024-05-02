<?php

/**
 * @method static boolean isValid(mixed $value, string $min_date = null, string $max_date = null, string $format = 'Y-m-d')
 */

namespace DataValidator\Field;

class Date extends Field{

    private $min_date;
    private $max_date;
    private $format = 'Y-m-d';
    
    public function validate($value):bool {
        $name = parent::getName();
        
        $date = $this->getDatetime($value);

        if(!$date){
            parent::newError("Field {$name} is not a valid date for the format {$this->format}");   
        
            return false;
        }

        if($this->min_date){
            $min_date = $this->getDatetime($this->min_date);

            if(!$min_date){
                parent::newError("Minimum date at field {$name} is not a valid date for the format {$this->format}");   
            
                return false;
            }              
        }

        if($this->max_date){
            $max_date = $this->getDatetime($this->max_date);

            if(!$max_date){
                parent::newError("Maximum date at field {$name} is not a valid date for the format {$this->format}");   
            
                return false;
            }               
        }

        if(!empty($min_date) && $date->getTimestamp() < $min_date->getTimestamp() ){
            parent::newError("Minimum date accepted for field {$name} is {$this->min_date}");   
        } 

        if(!empty($max_date) && $date->getTimestamp() > $max_date->getTimestamp() ){
            parent::newError("Maximum date accepted for field {$name} is {$this->max_date}");    
        }
        
        return empty(parent::getErrors());
    }

    public function setFormat(string $format):void {
        $this->format = $format;
    }

    public function setMinDate(?string $date):void {
        $this->min_date = $date;
    }
    
    public function setMaxDate(?string $date):void {
        $this->max_date = $date;
    }

    private function getDatetime(string $date):?\DateTime {
        $datetime = \DateTime::createFromFormat($this->format, $date);    

        if( $datetime && $datetime->format($this->format) === $date ){
            return $datetime;
        }
        
        return null;
    }

    public static function create(string $fieldname, string $min_date = null, string $max_date = null, string $format = 'Y-m-d'):Field {
        $field = new self($fieldname);
        $field->setMinDate($min_date);
        $field->setMaxDate($max_date);
        $field->setFormat($format);        
        
        return $field;
    }

}