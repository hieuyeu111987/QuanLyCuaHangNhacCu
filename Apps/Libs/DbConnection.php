<?php

class Apps_Libs_DbConnection{
    protected static $Instance = null;
    protected $username = "root";
    protected $password = "";
    public $host = "localhost:8080";
    protected $database = "quanlycuahangnhaccu";
    protected $queryParams  = [];
    protected $tableName = "";
    public function __construct(){
        $this->connect();
    }

    public function connect(){
        if(self::$Instance===null){
            try {
                self::$Instance = new PDO("mysql:host=localhost;dbname=quanlycuahangnhaccu","root","");
                self::$Instance->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
            } catch (Exception $ex) {
                echo "ERROR: ".$ex->getMessage();
                die();
            }
            return self::$Instance;
        }
    }

    public function query($sql,$param =[]){
        $q = self::$Instance->prepare($sql);
        if(is_array($param)&&$param){
            // var_dump($q);die();
            $q->execute($param);
        }else{
            // var_dump($q);die();
            $q->execute();
        }
        return $q;
    }

    public function buildQueryParams($params){
        $default = ["select"=>"*","where"=>"","other"=>"","params"=>"","field"=>"","value"=>[]];
        $this->queryParams = array_merge($default,$params);
        // var_dump($params);die();
        return $this;
    }

    public function buildCondition($condition){
        if(trim($condition)){
            return "where ".$condition;
        }
        return "";
    }

    public function select(){
        $sql = "select ".$this->queryParams["select"]." from ".$this->tableName."". " ".$this->buildCondition($this->queryParams["where"])." ".$this->queryParams["other"];
        $query = $this->query($sql,$this->queryParams["params"]);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function selectOne(){
        $this->queryParams["other"]="limit 1";
        $data = $this->select();
        if($data){
            return $data[0];
        }
        
        return [];
    }

    public function insert(){
        $sql = "insert into ".$this->tableName." ".$this->queryParams["field"];
        $result = $this->query($sql,$this->queryParams["value"]);
        if($result){
            return self::$Instance->lastInsertId();
        }else{
            return false;
        }
    }

    public function update(){
        $sql = "update ".$this->tableName." set ".$this->queryParams["value"]." ".$this->buildCondition($this->queryParams["where"])." ".$this->queryParams["other"];
        return $this->query($sql);
    }

    public function delete(){
        $sql = "delete from ".$this->tableName." ".$this->buildCondition($this->queryParams["where"])." ".$this->queryParams["other"];
        return $this->query($sql);
    }
}