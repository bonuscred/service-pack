<?php

namespace FakeData\Storage;

use FakeData\Extension\StorageExtension;

class SQLite implements StorageExtension{

    private string $path;

    public function __construct(string $locate = './', string $dbname = 'fakedata'){
        if(!is_dir($locate)){
            throw new \InvalidArgumentException('$locate must be a valid directory');
        }

        $this->path = trim($locate, '/').'/'.$dbname.'.db';
    }
    
    public function save(Array $data, string $collection = null, string $guid = null):string|false {
        $db = self::getDb();

        if(!$guid){
            $guid = strtoupper(implode('-', [
                bin2hex(random_bytes(4)),
                bin2hex(random_bytes(2)),
                bin2hex(chr((ord(random_bytes(1)) & 0x0F) | 0x40)) . bin2hex(random_bytes(1)),
                bin2hex(chr((ord(random_bytes(1)) & 0x3F) | 0x80)) . bin2hex(random_bytes(1)),
                bin2hex(random_bytes(6))
            ]));

            $created_at = date('Y-m-d H:i:s');
            $updated_at = $created_at;

            $query = "INSERT INTO storage(_guid, _content, _collection, _updated_at, _created_at) VALUES (:_guid, :_content, :_collection, :_updated_at, '{$created_at}')";
        }
        else{
            $updated_at = date('Y-m-d H:i:s');
            
            $query = 'UPDATE storage SET _content = :_content, _collection = :_collection, _updated_at = :_updated_at WHERE _guid = :_guid';
        }

        $stmt = $db->prepare($query);        
        $stmt->bindValue(':_guid', $guid);
        $stmt->bindValue(':_content', serialize($data));
        $stmt->bindValue(':_collection', $collection);
        $stmt->bindValue(':_updated_at', $updated_at);
        
        return $stmt->execute() ? $guid : false;
    }

    public function load(string $guid):object|null {
        $db = self::getDb();

        $stmt = $db->prepare("SELECT * FROM storage where _guid = ?");
        $stmt->bindValue(1, $guid);
        $result = $stmt->execute();
        
        $cache = $result->fetchArray(SQLITE3_ASSOC);

        if(empty($cache) ){
            return null;
        }
        else{
            $object = (object) $cache;
            $object->data = unserialize($cache['_content']);
            
            return $object;
        }
    }

    public function loadAll():Array {
        $db = self::getDb();

        $stmt = $db->prepare("SELECT * FROM storage");
        $result = $stmt->execute();

        $return = [];

        if($result){
            while ($cache = $result->fetchArray(SQLITE3_ASSOC)) {
                $object = (object) $cache;
                $object->data = unserialize($cache['_content']);
                
                $return[] = $object;
            }
        }

        return $return;
    }

    public function loadByCollection(string $collection):Array {
        $db = self::getDb();

        $stmt = $db->prepare("SELECT * FROM storage where _collection = ?");
        $stmt->bindValue(1, $collection);
        $result = $stmt->execute();
        
        $return = [];

        if($result){
            while ($cache = $result->fetchArray(SQLITE3_ASSOC)) {
                $object = (object) $cache;
                $object->data = unserialize($cache['_content']);
                
                $return[] = $object;
            }
        }
                      
        return $return;
    }

    public function delete(string $guid):bool {
        $db = self::getDb();

        $stmt = $db->prepare("DELETE FROM storage where _guid = ?");
        $stmt->bindValue(1, $guid);
        
        return $stmt->execute() ? true : false;
    }

    public function deleteByCollection(string $collection):bool {
        $db = self::getDb();

        $stmt = $db->prepare("DELETE FROM storage where _collection = ?");
        $stmt->bindValue(1, $collection);
        
        return $stmt->execute() ? true : false;
    }

    public function deleteAll():bool {
        $db = self::getDb();

        $stmt = $db->prepare("DELETE FROM storage where _guid != '0000'");
                
        return $stmt->execute() ? true : false;
    }

    private function getDb():\SQLite3 {
        $db = new \SQLite3($this->path);        
        
        $stmt = $db->query("SELECT name FROM sqlite_master WHERE type='table' AND name='storage'");

        if( empty($stmt->fetchArray()) ){
            $create_table = 'CREATE TABLE "storage" (
                                "_guid" VARCHAR(45) NOT NULL UNIQUE,
                                "_content" LONGTEXT,
                                "_collection" TEXT,
                                "_created_at" DATETIME,
                                "_updated_at" DATETIME,
                                PRIMARY KEY("_guid")
                            )
            ';

            $db->exec($create_table);
            $db->close();
            
            $db = new \SQLite3($this->path);  
        }

        return $db;        
    }

}