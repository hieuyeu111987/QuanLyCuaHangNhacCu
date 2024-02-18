<?php
$user = new Apps_Libs_UserIdentity();
$router = new Apps_Libs_Router();
$nhaccu = new Apps_Models_NhacCu();
$id = intval($router->getGET("IDNhacCu"));
if($id){
    $cateDetail = $nhaccu->buildQueryParams(["where"=>"IDNhacCu=:id","params"=>[":id"=>$id]])->selectOne();
    if(!$cateDetail){
        $router->pageNotFound();
    }
}else{
    $cateDetail = ["IDNhacCu"=>"","TenNhacCu"=>"","MoTa"=>"","IDLoaiNhacCu"=>"","HinhNhacCu"=>""];
}

if($router->getPOST("submit")&&$router->getPOST("name")){
    $params = [":name"=>$router->getPOST("name"),":sdt"=>$router->getPOST("sdt"),":taikhoan"=>$router->getPOST("taikhoan")];
    // $params = [":sdt"=>$router->getPOST("sdt")];
    // $params = [":taikhoan"=>$router->getPOST("taikhoan")];
    $name = $router->getPOST("name");
    $sdt = $router->getPOST("sdt");
    $result = FALSE;
    if($id){
        $params[":id"] = $id;
        $result = $nhaccu->buildQueryParams(["value"=>"TenNhacCu = ".'"'.$name.'"'.', Mota = '.'"'.$mota.'"',"where"=>"IDNhanVien = ".$id])->update();
    }else{
        $result = $nhaccu->buildQueryParams(["field"=>"(TenNhanVien,SDT,QuyenQuanLy,TaiKhoan,MatKhau) VALUES (?,?,0,?,1)","value"=>[$params[":name"],$params[":sdt"],$params[":taikhoan"]]])->insert();
    }
    if($result){
        $router->redirect("NhanVien/Index");
    }else{
        $router->pageError("Can Not Update Database");
    }
}

// var_dump($id);die();
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
<!--head------------------------------------------------------------------------------------------------------>
<!------------------------------------------------------------------------------------------------------------>
        <div class="menu">
            <ul>
                <li><div><a href="<?= $router->createUrl('NhanVien/Index')?>">Nhan vien</a></div></li>
                <li><div><a href="<?= $router->createUrl('LoaiNhacCu/Index')?>">Loai nhac cu</a></div></li>
                <li><div class="trangdangdung"><a href="<?= $router->createUrl('NhacCu/Index')?>">Nhac cu</a></div></li>
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
            <p><b><?= !$id ? "Them " : "Sua thong tin"?> nhac cu : <?= $cateDetail["TenNhacCu"]?></b></p>
        </div>

<!------------------------------------------------------------------------------------------------------------>
<!--thaotac------------------------------------------------------------------------------------------------------>
<!------------------------------------------------------------------------------------------------------------>
        <div class="thaotac" style="padding-left: 0%;">
            <?= 
            !$id ? "" : '<a class="btn" href="'.$router->createUrl("ChiTietNhacCu/Index", ["IDNhacCu"=>$id]).'">Danh gia nhac cu</a>';
            ?>

        </div>

<!------------------------------------------------------------------------------------------------------------>
<!--thong tin------------------------------------------------------------------------------------------------------>
<!------------------------------------------------------------------------------------------------------------>
        <form action="<?php echo $router->createUrl('NhacCu/Detail',["IDNhacCu"=>$cateDetail["IDNhacCu"]])?>" method="POST">
            
            <div class="lbthongtin">
                <p>Ten nhac cu</p>
                <p>Mo ta</p>
                <p>Hinh anh</p>
            </div>

            <div class="txtthongtin">
                <input type="text" name="name" value="<?= $cateDetail["TenNhacCu"]?>">
                <input type="text" name="sdt" value="<?= $cateDetail["MoTa"]?>">
                <input type="file" name="image" >
                <img src="<?= strstr($cateDetail['HinhNhacCu'],"NhacCu\Hinh") ?>" alt="Logo">
            </div>
            <div class="thaotac">
                <input class="btn" type="submit" name="submit" value = "Dong y">
                <input class="btn" onclick="window.location.href = '<?= $router->createUrl("NhacCu/Index") ?>'" type="button" value="Thoat">
            </div>
        </form>
    </body>
</html>