<?php

namespace FakeData\Extension;

interface StorageExtension{

    public function save(Array $data, string $collection = null, string $guid = null):string|false;

    public function load(string $guid):object|null;
    
    public function loadAll():Array;
    
    public function loadByCollection(string $collection):Array;
    
    public function delete(string $guid):bool;
    
    public function deleteByCollection(string $collection):bool;
    
    public function deleteAll():bool;

}