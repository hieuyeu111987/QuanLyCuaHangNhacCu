<?php

$router = new Apps_Libs_Router();
$user = new Apps_Libs_UserIdentity();

$hoadonnhap = new Apps_Models_HoaDonNhap();
$nhaccu = new Apps_Models_NhacCu();
$nhanvien = new Apps_Models_NhanVien();
$kho = new Apps_Models_Kho();
$laymang = $hoadonnhap->buildQueryParams(["select"=>"COUNT(IDHoaDonNhap)"])->selectOne();

$laytennhaccu = "";
$laytennhanvien = "";
$laytenkho = "";

$sophantu = 1;
foreach ($laymang as $row) {
    $sophantu = $row;
}
$trangdau = 0;
$trangcuoi = (int)((int)$sophantu/10);
if(((int)$sophantu%10)==0){
    $trangcuoi--;
}
$i = intval($router->getGET("SoTrang"));
if($i<$trangdau){
    $i=$trangdau;
}
if($i>$trangcuoi){
    $i = $trangcuoi;
}
$sotrang = $i;
$query = $hoadonnhap->buildQueryParams(["other"=>"limit 10 offset ".$sotrang*10])->select();
?>

<html>
    <head>
        <title>Home</title>
        <link rel="stylesheet" type="text/css" href="Index.css">
    </head>
    <body>
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
        <div class="tentrang">
            <p><b>Hoa don nhap</b></p>
        </div>
        <div class="thaotac">
            <div class="timkiem">
                <form action="<?= $router->createUrl("HoaDonNhap/Index",["SoTrang"=>$i])?>" method="POST">
                    <div class="btntimkiem">
                        <input type="submit" name="btntimkiem" value="Tim">
                    </div>
                    <div class="txttimkiem">
                        <input type="text" name="txttimkiem" value="">
                    </div>
                </form>
            </div>
        </div>
        <div class="bang">
            <p>Danh sach hoa don nhap</p>
            <div>
                <table class="bangloainhaccu">
                    <tr class="tencot">
                        <td><p>ID</p></td>
                        <td><p>Nhac cu</p></td>
                        <td><p>So luong</p></td>
                        <td><p>Gia nhap</p></td>
                        <td><p>Nhan vien</p></td>
                        <td><p>Kho</p></td>
                        <td><p>Ngay thanh toan</p></td>
                        <td><p>Xoa</p></td>
                    </tr>
                    <?php foreach ($query as $row) {
                        $tennhaccu = $nhaccu->buildQueryParams(["select"=>"TenNhacCu","where"=>"IDNhacCu = :id","params"=>[":id"=>$row["IDNhacCu"]]])->selectOne();
                        foreach($tennhaccu as $j){
                            $laytennhaccu = $j;
                        }
                        $tennhanvien = $nhanvien->buildQueryParams(["select"=>"TenNhanVien","where"=>"IDNhanVien = :id","params"=>[":id"=>$row["IDNhanVien"]]])->selectOne();
                        foreach($tennhanvien as $j){
                            $laytennhanvien = $j;
                        }
                        $tenkho = $kho->buildQueryParams(["select"=>"TenKho","where"=>"IDKho = :id","params"=>[":id"=>$row["IDKho"]]])->selectOne();
                        foreach($tenkho as $j){
                            $laytenkho = $j;
                        }?>
                    <tr class="noidung">
                        <td><p><?= $row["IDHoaDonNhap"]?></p></td>
                        <td><a href="<?= $router->createUrl("HoaDonNhap/Detail", ["IDHoaDonNhap"=>$row["IDHoaDonNhap"]])?>"><?= $laytennhaccu?></a></td>
                        <td><p><?= $row['SoLuong']?></p></td>
                        <td><p><?= $row['GiaNhap']?></p></td>
                        <td><p><?= $laytennhanvien?></p></td>
                        <td><p><?= $laytenkho?></p></td>
                        <td><p><?= $row['NgayThanhToan']?></p></td>
                        <td><a href="<?= $router->createUrl("HoaDonNhap/Delete",["IDHoaDonNhap"=>$row["IDHoaDonNhap"]])?>">Xoa</a></td>
                    </tr>
                    <?php }?>
                </table>
            </div>
        </div>
        <div class="danhsachtrang">
            <a class="dauds" href="<?= $router->createUrl("HoaDonNhap/Index",["SoTrang"=>$trangdau])?>">dau</a>
            <a class="truocsauds" href="<?= $router->createUrl("HoaDonNhap/Index",["SoTrang"=>$i-1])?>">truoc</a>
            <a href="<?= $router->createUrl("HoaDonNhap/Index",["SoTrang"=>$i])?>"><?= $i+1?></a>
            <a class="truocsauds" href="<?= $router->createUrl("HoaDonNhap/Index",["SoTrang"=>$i+1])?>">sau</a>
            <a class="cuoids" href="<?= $router->createUrl("HoaDonNhap/Index",["SoTrang"=>$trangcuoi])?>">cuoi</a>
        </div>
    </body>
</html>