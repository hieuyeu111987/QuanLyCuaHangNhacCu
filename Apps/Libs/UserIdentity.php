<?php
session_start();
class Apps_Libs_UserIdentity{
    public $username;
    public $password;

    protected $IDNhanVien;

    public function __construct($username = "",$password=""){
        $this->username = $username;
        $this->password = $password;
    }

    public function encryptPassword(){
        return md5($this->password);
    }

    public function login(){
        $db = new Apps_Models_NhanVien();
        $query = $db->buildQueryParams(["where"=>"taikhoan =:username AND matkhau =:password","params"=>[":username"=>trim($this->username),":password"=>$this->encryptPassword()]])->selectOne();
        if($query){
            $_SESSION["userId"] = $query["IDNhanVien"];
            $_SESSION["username"] = $query["TenNhanVien"];
            return true;
        }
        return false;
    }

    public function logout(){
        unset($_SESSION["userId"]);
        unset($_SESSION["username"]);
    }

    public function getSESSION($name){
        if($name !== NULL){
            return isset($_SESSION[$name]) ? $_SESSION[$name] : NULL;
        }
        return $_SESSION;
    }

    public function isLogin(){
        if($this->getSESSION("userId")){
            return true;
        }
        return false;
    }

    public function getId(){
        return $this->getSESSION("userId");
    }
}