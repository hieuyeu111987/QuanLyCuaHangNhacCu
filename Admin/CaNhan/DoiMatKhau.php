<?php
$user = new Apps_Libs_UserIdentity();
$router = new Apps_Libs_Router();
$nhanvien = new Apps_Models_NhanVien();
$id = intval($router->getGET("IDNhanVien"));

if($id){
    $cateDetail = $nhanvien->buildQueryParams(["where"=>"IDNhanVien=:id","params"=>[":id"=>$id]])->selectOne();
    if(!$cateDetail){
        $router->pageNotFound();
    }
}else{
    $cateDetail = ["IDNhanVien"=>"","TenNhanVien"=>"","MatKhau"=>"","TaiKhoan"=>""];
}

if($router->getPOST("submit")&&$router->getPOST("name")){
    $params = [":name"=>$router->getPOST("name"),":matkhau"=>$router->getPOST("maykhau"),":taikhoan"=>$router->getPOST("taikhoan")];
    // $params = [":sdt"=>$router->getPOST("sdt")];
    // $params = [":taikhoan"=>$router->getPOST("taikhoan")];
    $name = $router->getPOST("name");
    $matkhau = $router->getPOST("matkhau");
    $result = FALSE;
    if($id){
        $params[":id"] = $id;
        $result = $nhanvien->buildQueryParams(["value"=>', MatKhau = '.'"'.$matkhau.'"',"where"=>"IDNhanVien = ".$id])->update();
    }else{
        $result = $nhanvien->buildQueryParams(["field"=>"(TenNhanVien,SDT,QuyenQuanLy,TaiKhoan,MatKhau) VALUES (?,?,0,?,1)","value"=>[$params[":name"],$params[":sdt"],$params[":taikhoan"]]])->insert();
    }
    if($result){
        $router->redirect("NhanVien/Index");
    }else{
        $router->pageError("Can Not Update Database");
    }
}
?>

<html>
    <head>
        <title>Detail</title>
        <link rel="stylesheet" type="text/css" href="LoaiNhacCu/Detail.css">
    </head>
    <body>

<!---------------------------------------------------------------------------------------------------------->
<!--head---------------------------------------------------------------------------------------------------->
<!---------------------------------------------------------------------------------------------------------->
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
            
<!---------------------------------------------------------------------------------------------------------->
<!--menu---------------------------------------------------------------------------------------------------->
<!---------------------------------------------------------------------------------------------------------->
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

<!---------------------------------------------------------------------------------------------------------->
<!--tentrang------------------------------------------------------------------------------------------------>
<!---------------------------------------------------------------------------------------------------------->
        <div class="tentrang">
            <p><b>Doi mat khau</b></p>
        </div>

<!---------------------------------------------------------------------------------------------------------->
<!--thaotac------------------------------------------------------------------------------------------------->
<!---------------------------------------------------------------------------------------------------------->
        <div class="thaotac"></div>

<!---------------------------------------------------------------------------------------------------------->
<!--thong yin----------------------------------------------------------------------------------------------->
<!---------------------------------------------------------------------------------------------------------->
        <form action="<?php echo $router->createUrl('NhanVien/Detail',["IDNhanVien"=>$cateDetail["IDNhanVien"]])?>" method="POST">
            <div class="lbthongtin">
                <p>Ten</p>
                <p>Tai khoan</p>
                <p>Mat khau moi</p>
            </div>
            <div class="txtthongtin">
                <input class="txt" type="text" name="name" value="<?= $cateDetail["TenNhanVien"]?>">
                <input class="txt" type="text" name="taikhoan" value="<?= $cateDetail["TaiKhoan"]?>">
                <input class="txt" type="text" name="matkhaumoi" value="">
            </div>
            <div class="thaotac">
                <input class="btn" type="submit" name="submit" value = "Dong y">
                <input class="btn" onclick="window.location.href = '<?= $router->createUrl("NhanVien/Index") ?>'" type="button" value="Thoat">
            </div>
        </form>
    </body>
</html>