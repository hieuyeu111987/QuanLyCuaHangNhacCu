<?php
$user = new Apps_Libs_UserIdentity();
$router = new Apps_Libs_Router();
$hoadonxuat = new Apps_Models_HoaDonXuat();
$id = intval($router->getGET("IDHoaDonXuat"));
if($id){
    $cateDetail = $hoadonxuat->buildQueryParams(["where"=>"IDHoaDonXuat=:id","params"=>[":id"=>$id]])->selectOne();
    if(!$cateDetail){
        $router->pageNotFound();
    }
}else{
    $cateDetail = ["IDHoaDonXuat"=>"","SDT"=>"","DiaChi"=>"","NgayThanhToan"=>""];
}

if($router->getPOST("submit")&&$router->getPOST("diachi")){
    $params = [":diachi"=>$router->getPOST("diachi"),":sdt"=>$router->getPOST("sdt"),":ngaythanhtoan"=>$router->getPOST("ngaythanhtoan")];
    // $params = [":sdt"=>$router->getPOST("sdt")];
    // $params = [":taikhoan"=>$router->getPOST("taikhoan")];
    $diachi = $router->getPOST("diachi");
    $sdt = $router->getPOST("sdt");
    $ngaythanhtoan = $router->getPOST("ngaythanhtoan");
    $result = FALSE;
    if($id){
        $params[":id"] = $id;
        $result = $hoadonxuat->buildQueryParams(["value"=>"SDT = ".'"'.$sdt.'"'.', DiaChi = '.'"'.$diachi.'"'.', NgayThanhToan = '.'"'.$ngaythanhtoan.'"',"where"=>"IDHoaDonXuat = ".$id])->update();
    }else{
        $result = $hoadonxuat->buildQueryParams(["field"=>"(DiaChi,SDT,NgayThanhToan) VALUES (?,?,0,?,1)","value"=>[$params[":diachi"],$params[":sdt"],$params[":ngaythanhtoan"]]])->insert();
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
                <li><div><a href="<?= $router->createUrl('NhacCu/Index')?>">Nhac cu</a></div></li>
                <li><div><a href="<?= $router->createUrl('GiaNhacCu/Index')?>">Gia nhac cu</a></div></li>
                <li><div><a href="<?= $router->createUrl('Kho/Index')?>">Kho</a></div></li>
                <li><div><a href="<?= $router->createUrl('DonHang/Index')?>">Don hang</a></div></li>
                <li><div><a href="<?= $router->createUrl('ThuGopY/Index')?>">Thu gop y</a></div></li>
                <li><div><a href="<?= $router->createUrl('HoaDonNhap/Index')?>">Hoa don nhap</a></div></li>
                <li><div class="trangdangdung"><a href="<?= $router->createUrl('HoaDonXuat/Index')?>">Hoa don xuat</a></div></li>
            </ul>
        </div>

<!------------------------------------------------------------------------------------------------------------>
<!--tentrang------------------------------------------------------------------------------------------------------>
<!------------------------------------------------------------------------------------------------------------>
        <div class="tentrang">
            <p><b><?= !$id ? "Them " : "Sua thong tin"?> hoa don xuat : <?= $cateDetail["IDHoaDonXuat"]?></b></p>
        </div>

<!------------------------------------------------------------------------------------------------------------>
<!--thaotac------------------------------------------------------------------------------------------------------>
<!------------------------------------------------------------------------------------------------------------>
        <div class="thaotac" style="padding-left: 0%;">
            <?= 
            !$id ? "" : '<a class="btn" href="'.$router->createUrl("ChiTietHoaDonXuat/Index", ["IDHoaDonXuat"=>$id]).'">Chi tiet hoa don</a>';
            ?>

        </div>

<!------------------------------------------------------------------------------------------------------------>
<!--thong tin------------------------------------------------------------------------------------------------------>
<!------------------------------------------------------------------------------------------------------------>
        <form action="<?php echo $router->createUrl('HoaDonXuat/Detail',["IDHoaDonXuat"=>$cateDetail["IDHoaDonXuat"]])?>" method="POST">
            
            <div class="lbthongtin">
                <p>SDT</p>
                <p>Dia chi</p>
                <p>Ngay thanh toan</p>
            </div>

            <div class="txtthongtin">
                <input type="text" name="diachi" value="<?= $cateDetail["DiaChi"]?>">
                <input type="text" name="sdt" value="<?= $cateDetail["SDT"]?>">
                <input type="date" name="ngaythanhtoan" value="<?= $cateDetail["NgayThanhToan"]?>">
            </div>
            <div class="thaotac">
                <input class="btn" type="submit" name="submit" value = "Dong y">
                <input class="btn" onclick="window.location.href = '<?= $router->createUrl("HoaDonXuat/Index") ?>'" type="button" value="Thoat">
            </div>
        </form>
    </body>
</html>