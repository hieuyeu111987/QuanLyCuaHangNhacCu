<?php
$user = new Apps_Libs_UserIdentity();
$router = new Apps_Libs_Router();
$loainhaccu = new Apps_Models_LoaiNhacCu();
$id = intval($router->getGET("IDLoaiNhacCu"));

if($id){
    $cateDetail = $loainhaccu->buildQueryParams(["where"=>"IDLoaiNhacCu=:id","params"=>[":id"=>$id]])->selectOne();
    if(!$cateDetail){
        $router->pageNotFound();
    }
}else{
    $cateDetail = ["IDLoaiNhacCu"=>"","TenLoaiNhacCu"=>""];
}

if($router->getPOST("submit")&&$router->getPOST("name")){
    $params = [":name"=>$router->getPOST("name")];
    $name = $router->getPOST("name");
    $result = FALSE;
    if($id){
        $params[":id"] = $id;
        $result = $loainhaccu->buildQueryParams(["value"=>"TenLoaiNhacCu = ".'"'.$name.'"',"where"=>"IDLoaiNhacCu = ".$id])->update();
    }else{
        $result = $loainhaccu->buildQueryParams(["field"=>"(TenLoaiNhacCu) VALUES (?)","value"=>[$params[":name"]]])->insert();
    }
    if($result){
        $router->redirect("LoaiNhacCu/Index");
    }else{
        $router->pageError("Can Not Update Database");
    }
}
?>

<html>
    <head>
        <title>Detail</title>
        <link rel="stylesheet" type="text/css" href="Detail.css">
    </head>
    <body>

<!------------------------------------------------------------------------------------------------------------>
<!--head------------------------------------------------------------------------------------------------------>
<!------------------------------------------------------------------------------------------------------------>
        <div class="dau">
            <a href="<?= $router->createUrl("Home")?>"><img class="Logo" src="./Hinh/Logo2.jpg" alt="Logo"></a>
            <div class="dongdau">
                <ul>
                    <li><a href="<?= $router->createUrl("CaNhan/XemHoSo",["IDNhanVien"=>$user->getId()])?>">Xem ho so</a></li>
                    <li><a href="<?= $router->createUrl("CaNhan/DoiMatKhau",["IDNhanVien"=>$user->getId()])?>">Doi mat khau</a></li>
                    <li><a href="<?= $router->createUrl("logout")?>">Dang xuat</a></li>
                </ul>
            </div>
        </div>
            
<!------------------------------------------------------------------------------------------------------------>
<!--menu------------------------------------------------------------------------------------------------------>
<!------------------------------------------------------------------------------------------------------------>
        <div class="menu">
            <ul>
                <li><div><a href="<?= $router->createUrl('NhanVien/Index')?>">Nhan vien</a></div></li>
                <li><div class="trangdangdung"><a href="<?= $router->createUrl('LoaiNhacCu/Index')?>">Loai nhac cu</a></div></li>
                <li><div><a href="<?= $router->createUrl('NhacCu/Index')?>">Nhac cu</a></div></li>
                <li><div><a href="<?= $router->createUrl('GiaNhacCu/Index')?>">Gia nhac cu</a></div></li>
                <li><div><a href="<?= $router->createUrl('Kho/Index')?>">Kho</a></div></li>
                <li><div><a href="<?= $router->createUrl('DonHang/Index')?>">Don hang</a></div></li>
                <li><div><a href="<?= $router->createUrl('ThuGopY/Index')?>">Thu gop y</a></div></li>
                <li><div><a href="<?= $router->createUrl('HoaDonNhap/Index')?>">Hoa don nhap</a></div></li>
                <li><div><a href="<?= $router->createUrl('HoaDonXuat/Index')?>">Hoa don xuat</a></div></li>
            </ul>
        </div>

<!------------------------------------------------------------------------------------------------------------>
<!--tentrang------------------------------------------------------------------------------------------------------>
<!------------------------------------------------------------------------------------------------------------>
        <div class="tentrang">
            <p><b><?= !$id ? "Them " : "Sua thong tin"?> loai nhac cu : <?= $cateDetail["TenLoaiNhacCu"]?></b></p>
        </div>

<!------------------------------------------------------------------------------------------------------------>
<!--thaotac------------------------------------------------------------------------------------------------------>
<!------------------------------------------------------------------------------------------------------------>
        <div class="thaotac"></div>
    
<!------------------------------------------------------------------------------------------------------------>
<!--thong yin------------------------------------------------------------------------------------------------------>
<!------------------------------------------------------------------------------------------------------------>
        <form action="<?php echo $router->createUrl('LoaiNhacCu/Detail',["IDLoaiNhacCu"=>$cateDetail["IDLoaiNhacCu"]])?>" method="POST">
            <div class="lbthongtin">
                <p>Ten loai nhac cu</p>
                <p>Ten bo nhac cu</p>
            </div>
            <div class="txtthongtin">
                <input type="text" name="name" value="<?= $cateDetail["TenLoaiNhacCu"]?>">
                <select>
                    <option value="phim">Phim</option>
                    <option value="day">Day</option>
                    <option value="go">Go</option>
                    <option value="hoi">Hoi</option>
                </select>
            </div>
            </div>
            <div class="thaotac">
                <input class="btn" type="submit" name="submit" value = "Dong y">
                <input class="btn" onclick="window.location.href = '<?= $router->createUrl("LoaiNhacCu/Index") ?>'" type="button" value="Thoat">
            </div>
        </form>
    </body>
</html>