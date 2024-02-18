<?php

$router = new Apps_Libs_Router();
$user = new Apps_Libs_UserIdentity();

$nhaccu = new Apps_Models_NhacCu();
$loainhaccu = new Apps_Models_LoaiNhacCu();
$laymang = $nhaccu->buildQueryParams(["select"=>"COUNT(IDNhacCu)"])->selectOne();
$laytenloainhaccu = "";

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

$tentimkiem = trim($router->getPOST('txttimkiem'));
if($router->getPOST("btntimkiem")&&$tentimkiem){
    $query = $nhaccu->buildQueryParams(["where"=>"TenNhacCu LIKE ".'"%'.$tentimkiem.'%"',"other"=>"limit 10 offset ".$sotrang*10])->select();
    $router->createUrl("NhacCu/Index",["SoTrang"=>$i]);
}else{
    $query = $nhaccu->buildQueryParams(["other"=>"limit 10 offset ".$sotrang*10])->select();
}
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
                <li><div class="trangdangdung"><a href="<?= $router->createUrl('NhacCu/Index')?>">Nhac cu</a></div></li>
                <li><div><a href="<?= $router->createUrl('GiaNhacCu/Index')?>">Gia nhac cu</a></div></li>
                <li><div><a href="<?= $router->createUrl('Kho/Index')?>">Kho</a></div></li>
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
            <p><b>Nhac cu</b></p>
        </div>

<!--  --------------------------------------------------------------------------------------------------->
<!-- Thao tac ------------------------------------------------------------------------------------------->
<!--  --------------------------------------------------------------------------------------------------->
        <div class="thaotac">
            <div class="btn"><a href="<?= $router->createUrl("NhacCu/Detail")?>">Them nhac cu</a></div>
            <div class="timkiem">
                <form action="<?= $router->createUrl("LoaiNhacCu/Index",["SoTrang"=>$i])?>" method="POST">
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
            <p>Danh sach nhac cu</p>
            <div>
                <table class="bangloainhaccu">
                    <tr class="tencot">
                        <td><p>ID</p></td>
                        <td><p>Ten nhac cu</p></td>
                        <td><p>Mo ta</p></td>
                        <td><p>Loai nhac cu</p></td>
                        <td><p>Xoa</p></td>
                    </tr>
                    <?php foreach ($query as $row) { 
                        $tenloainhaccu = $loainhaccu->buildQueryParams(["select"=>"TenLoaiNhacCu","where"=>"IDLoaiNhacCu = :id","params"=>[":id"=>$row["IDLoaiNhacCu"]]])->selectOne();
                        foreach($tenloainhaccu as $j){
                            $laytenloainhaccu = $j;
                        }?>
                    <tr class="noidung">
                        <td><p><?= $row["IDNhacCu"]?></p></td>
                        <td><a href="<?= $router->createUrl("NhacCu/Detail", ["IDNhacCu"=>$row["IDNhacCu"]])?>"><?= $row['TenNhacCu']?></a></td>
                        <td><p><?= $row['MoTa']?></p></td>
                        <td><p><?= $laytenloainhaccu?></p></td>
                        <td><a href="<?= $router->createUrl("NhacCu/Delete",["IDNhacCu"=>$row["IDNhacCu"]])?>">Xoa</a></td>
                    </tr>
                    <?php }?>
                </table>
            </div>
        </div>

<!--  --------------------------------------------------------------------------------------------------->
<!-- Chuyen trang --------------------------------------------------------------------------------------->
<!--  --------------------------------------------------------------------------------------------------->
        <div class="danhsachtrang">
            <a class="dauds" href="<?= $router->createUrl("NhacCu/Index",["SoTrang"=>$trangdau])?>">dau</a>
            <a class="truocsauds" href="<?= $router->createUrl("NhacCu/Index",["SoTrang"=>$i-1])?>">truoc</a>
            <a href="<?= $router->createUrl("NhacCu/Index",["SoTrang"=>$i])?>"><?= $i+1?></a>
            <a class="truocsauds" href="<?= $router->createUrl("NhacCu/Index",["SoTrang"=>$i+1])?>">sau</a>
            <a class="cuoids" href="<?= $router->createUrl("NhacCu/Index",["SoTrang"=>$trangcuoi])?>">cuoi</a>
        </div>
    </body>
</html>