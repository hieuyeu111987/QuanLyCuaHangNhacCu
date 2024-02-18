<?php
$user = new Apps_Libs_UserIdentity();
$router = new Apps_Libs_Router();
$gianhaccu = new Apps_Models_GiaNhacCu();
$id = intval($router->getGET("IDGiaNhacCu"));

if($id){
    $cateDetail = $gianhaccu->buildQueryParams(["where"=>"IDGiaNhacCu=:id","params"=>[":id"=>$id]])->selectOne();
    if(!$cateDetail){
        $router->pageNotFound();
    }
}else{
    $cateDetail = ["IDGiaNhacCu"=>"","Gia"=>"","NgayApDung"=>""];
}

if($router->getPOST("submit")&&$router->getPOST("name")){
    $params = [":gia"=>$router->getPOST("name"),":ngayapdung"=>$router->getPOST("ngayapdung")];
    // $params = [":sdt"=>$router->getPOST("sdt")];
    // $params = [":taikhoan"=>$router->getPOST("taikhoan")];
    $name = $router->getPOST("name");
    $ngayapdung = $router->getPOST("ngayapdung");
    $result = FALSE;
    if($id){
        $params[":id"] = $id;
        $result = $nhanvien->buildQueryParams(["value"=>"Gia = ".'"'.$name.'"'.', NgayApDung = '.'"'.$ngayapdung.'"',"where"=>"IDGiaNhacCu = ".$id])->update();
    }else{
        $result = $nhanvien->buildQueryParams(["field"=>"(TenNhanVien,SDT,QuyenQuanLy,TaiKhoan,MatKhau) VALUES (?,?,0,?,1)","value"=>[$params[":name"],$params[":sdt"],$params[":taikhoan"]]])->insert();
    }
    if($result){
        $router->redirect("GiaNhacCu/Index");
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
                <li><div><a href="<?= $router->createUrl('LoaiNhacCu/Index')?>">Loai nhac cu</a></div></li>
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
            <p><b><?= !$id ? "Them " : "Sua thong tin"?> gia nhac cu ID : <?= $cateDetail["IDGiaNhacCu"]?></b></p>
        </div>

<!------------------------------------------------------------------------------------------------------------>
<!--thaotac------------------------------------------------------------------------------------------------------>
<!------------------------------------------------------------------------------------------------------------>
        <div class="thaotac"></div>

<!------------------------------------------------------------------------------------------------------------>
<!--thong yin------------------------------------------------------------------------------------------------------>
<!------------------------------------------------------------------------------------------------------------>
        <form action="<?php echo $router->createUrl('GiaNhacCu/Detail',["IDGiaNhacCu"=>$cateDetail["IDGiaNhacCu"]])?>" method="POST">
            <div class="lbthongtin">
                <p>Gia nhac cu</p>
                <p>Ngay ap dung</p>
            </div>
            <div class="txtthongtin">
                <input class="txt" type="text" name="name" value="<?= $cateDetail["Gia"]?>">
                <input class="txt" type="date" name="ngayapdung" value="<?= $cateDetail["NgayApDung"]?>">
            </div>
            <div class="thaotac">
                <input class="btn" type="submit" name="submit" value = "Dong y">
                <input class="btn" onclick="window.location.href = '<?= $router->createUrl("GiaNhacCu/Index") ?>'" type="button" value="Thoat">
            </div>
        </form>
    </body>
</html>