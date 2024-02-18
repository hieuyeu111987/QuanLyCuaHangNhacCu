<?php

class Apps_Libs_Router{
    const PARAM_NAME = "r";
    const HOME_PAGE = "Home";
    const INDEX_PAGE = "Index";

    public static $sourcePath;

    public function __construct($sourcePath = ""){
        if($sourcePath){
            self::$sourcePath = $sourcePath;
        }
    }

    public function getGET($name = NULL){
        if($name !== NULL){
            return isset($_GET[$name])?$_GET[$name]:NULL;
        }
        return $_GET;
    }

    public function getPOST($name = NULL){
        if($name !== NULL){
            return isset($_POST[$name])?$_POST[$name]:NULL;
        }
        return $_POST;
    }

    public function router(){
        $url = $this->getGET(self::PARAM_NAME);
        if(!is_string($url)||!$url||$url==self::INDEX_PAGE){
            $url = self::HOME_PAGE;
        }
        $path = self::$sourcePath."/".$url.".php";
        if(file_exists($path)){
            return require_once $path;
        }else{
            return $this->pageNotFound();
        }
    }

    public function pageNotFound(){
        echo "404 Page Not Found";
        die();
    }

    public function createUrl($url,$params=[]){
        if($url){
            $params[self::PARAM_NAME] = $url;
        }
        return $_SERVER['PHP_SELF'].'?'.http_build_query($params);
    }

    public function redirect($url){
        $u = $this->createUrl($url);
        header("Location:$u");
    }

    public function homePage(){
        $this->redirect(self::HOME_PAGE);
    }

    public function loginPage(){
        $this->redirect("login");
    }

    public function pageError($error){
        echo $error;
        die();
    }

    public function pagePublic(){
        var_dump($sourcePath);die();
        return $path = str_replace("Admin","Public",$sourcePath);
    }

    public function soPhanTu($mang){
        $sonhanvien = 1;
        foreach ($mang as $row) {
            $sonhanvien = $row;
        }
        return $sonhanvien;
    }

    public function viTri($i, $trangdau, $trangcuoi){
        if($i<$trangdau){
            $i=$trangdau;
        }
        if($i>$trangcuoi){
            $i = $trangcuoi;
        }
        return $i;
    }

    
}