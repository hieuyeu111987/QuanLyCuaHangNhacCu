<?php
$user = new Apps_Libs_UserIdentity();
$router = new Apps_Libs_Router();
$nhanvien = new Apps_Models_NhanVien();
$hoadonnhap = new Apps_Models_HoaDonNhap();
$hoadonxuat = new Apps_Models_HoaDonXuat();
$id = intval($router->getGET("IDNhanVien"));
$cateDetail = $nhanvien->buildQueryParams(["where"=>"IDNhanVien=:id","params"=>[":id"=>$id]])->selectOne();

if(!$cateDetail){
    $router->pageNotFound();
}
if($id && $router->getPOST("submit")){
    // if($loainhaccu->delete('IDLoaiNhacCu=:id',['id'=>$id])){
    if(($hoadonnhap->buildQueryParams(["where"=>"IDNhanVien= ".$id])->delete())&&($hoadonxuat->buildQueryParams(["where"=>"IDNhanVien= ".$id])->delete())&&($nhanvien->buildQueryParams(["where"=>"IDNhanVien= ".$id])->delete())){
        $router->redirect('NhanVien/Index');
    }else{
        $router->pageError("Khong the xoa!");
    }
}
?>

<html>
    <head>
        <title>Delete</title>
        <link rel="stylesheet" type="text/css" href="LoaiNhacCu/Delete.css">
    </head>
    <body>
        <div class="dau">
            <a href="<?= $router->createUrl("Home")?>"><img class="Logo" src="./Hinh/Logo2.jpg" alt="Logo"></a>
            <div class="dongdau">
                <ul>
                    <li><a href="<?= $router->createUrl("CaNhan/XemHoSo")?>">Xem ho so</a></li>
                    <li><a href="<?= $router->createUrl("CaNhan/DoiMatKhau")?>">Doi mat khau</a></li>
                    <li><a href="<?= $router->createUrl("logout")?>">Dang xuat</a></li>
                </ul>
            </div>
        </div>
            
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
        <div class="phangiua1">
            <p><b>Ban muon xoa nhan vien : <?= $cateDetail["TenNhanVien"]?></b></p>
        </div>
        <div class="phangiua2">
            <form action="<?php echo $router->createUrl('NhanVien/Delete',["IDNhanVien"=>$id]) ?>" method="POST">
                <input class="btn" type="submit" name="submit" value="Dong y">
                <input class="btn" onclick="window.location.href = '<?= $router->createUrl("NhanVien/Index") ?>'" type="button" value="Cancel">
            </form>
        </div>
    </body>
</html>