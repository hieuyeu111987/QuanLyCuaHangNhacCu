<?php

$router = new Apps_Libs_Router();
$user = new Apps_Libs_UserIdentity();

$kho = new Apps_Models_Kho();
$laymang = $kho->buildQueryParams(["select"=>"COUNT(IDKho)"])->selectOne();

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
$query = $kho->buildQueryParams(["other"=>"limit 10 offset ".$sotrang*10])->select();
?>

<html>
    <head>
        <title>Home</title>
        <link rel="stylesheet" type="text/css" href="Index.css">
    </head>
    <body>

<!--  --------------------------------------------------------------------------------------------------->
<!-- Header --------------------------------------------------------------------------------------------->
<!--  --------------------------------------------------------------------------------------------------->
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

<!--  --------------------------------------------------------------------------------------------------->
<!-- Menu ----------------------------------------------------------------------------------------------->
<!--  --------------------------------------------------------------------------------------------------->
        <div class="menu">
            <ul>
                <li><div><a href="<?= $router->createUrl('NhanVien/Index')?>">Nhan vien</a></div></li>
                <li><div><a href="<?= $router->createUrl('LoaiNhacCu/Index')?>">Loai nhac cu</a></div></li>
                <li><div><a href="<?= $router->createUrl('NhacCu/Index')?>">Nhac cu</a></div></li>
                <li><div><a href="<?= $router->createUrl('GiaNhacCu/Index')?>">Gia nhac cu</a></div></li>
                <li><div class="trangdangdung"><a href="<?= $router->createUrl('Kho/Index')?>">Kho</a></div></li>
                <li><div><a href="<?= $router->createUrl('DonHang/Index')?>">Don hang</a></div></li>
                <li><div><a href="<?= $router->createUrl('ThuGopY/Index')?>">Thu gop y</a></div></li>
                <li><div><a href="<?= $router->createUrl('HoaDonNhap/Index')?>">Hoa don nhap</a></div></li>
                <li><div><a href="<?= $router->createUrl('HoaDonXuat/Index')?>">Hoa don xuat</a></div></li>
            </ul>
        </div>

<!--  --------------------------------------------------------------------------------------------------->
<!-- Ten trang ------------------------------------------------------------------------------------------>
<!--  --------------------------------------------------------------------------------------------------->
        <div class="tentrang">
            <p><b>Kho</b></p>
        </div>

<!--  --------------------------------------------------------------------------------------------------->
<!-- Thao tac ------------------------------------------------------------------------------------------->
<!--  --------------------------------------------------------------------------------------------------->
        <div class="thaotac">
            <div class="btn"><a href="<?= $router->createUrl("Kho/Detail")?>">Them kho</a></div>
            <div class="timkiem">
                <form action="<?= $router->createUrl("Kho/Index",["SoTrang"=>$i])?>" method="POST">
                    <div class="btntimkiem">
                        <input type="submit" name="btntimkiem" value="Tim">
                    </div>
                    <div class="txttimkiem">
                        <input type="text" name="txttimkiem" value="">
                    </div>
                </form>
            </div>
        </div>

<!--  --------------------------------------------------------------------------------------------------->
<!-- Bang ----------------------------------------------------------------------------------------------->
<!--  --------------------------------------------------------------------------------------------------->
        <div class="bang">
            <p>Danh sach kho</p>
            <div>
                <table class="bangloainhaccu">
                    <tr class="tencot">
                        <td><p>ID</p></td>
                        <td><p>Tên kho</p></td>
                        <td><p>Xóa</p></td>
                    </tr>
                    <?php foreach ($query as $row) {?>
                    <tr class="noidung">
                        <td><p><?= $row["IDKho"]?></p></td>
                        <td><a href="<?= $router->createUrl("Kho/Detail", ["IDKho"=>$row["IDKho"]])?>"><?= $row['TenKho']?></a></td>
                        <td><a href="<?= $router->createUrl("Kho/Delete",["IDKho"=>$row["IDKho"]])?>">Xoa</a></td>
                    </tr>
                    <?php }?>
                </table>
            </div>
        </div>

<!--  --------------------------------------------------------------------------------------------------->
<!-- Chuyen trang --------------------------------------------------------------------------------------->
<!--  --------------------------------------------------------------------------------------------------->
        <div class="danhsachtrang">
            <a class="dauds" href="<?= $router->createUrl("Kho/Index",["SoTrang"=>$trangdau])?>">dau</a>
            <a class="truocsauds" href="<?= $router->createUrl("Kho/Index",["SoTrang"=>$i-1])?>">truoc</a>
            <a href="<?= $router->createUrl("Kho/Index",["SoTrang"=>$i])?>"><?= $i+1?></a>
            <a class="truocsauds" href="<?= $router->createUrl("Kho/Index",["SoTrang"=>$i+1])?>">sau</a>
            <a class="cuoids" href="<?= $router->createUrl("Kho/Index",["SoTrang"=>$trangcuoi])?>">cuoi</a>
        </div>
    </body>
</html>