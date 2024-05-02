<?php

namespace ServicePack;

class Loader{

    public function autoload(string $lib = null){
        if($lib){
            if(!file_exists(__DIR__."/{$lib}/autoload_register.php")){
                throw new \Exception('Library not found: '.$lib);
            }

            require __DIR__."/{$lib}/autoload_register.php";
        }
        else{
            $mapping = array_merge(
                require __DIR__.'/classmap-generator/autoload_classmap.php',
                require __DIR__.'/data-validator/autoload_classmap.php',
                require __DIR__.'/api-manager/autoload_classmap.php',
                require __DIR__.'/rest-client/autoload_classmap.php',
                require __DIR__.'/fake-data/autoload_classmap.php',
                require __DIR__.'/sql-migration/autoload_classmap.php'
            );
            
            spl_autoload_register(function ($class) use ($mapping) {
                if(isset($mapping[$class])) {
                    require_once $mapping[$class];
                    return;
                }
            });
        }
    }

}








