<?php

$router = new Apps_Libs_Router();
$user = new Apps_Libs_UserIdentity();

$gianhaccu = new Apps_Models_GiaNhacCu();
$nhaccu = new Apps_Models_NhacCu();
$laymang = $gianhaccu->buildQueryParams(["select"=>"COUNT(IDGiaNhacCu)"])->selectOne();

$laytennhaccu = "";

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

// $tentimkiem = trim($router->getPOST('txttimkiem'));
// if($router->getPOST("btntimkiem")&&$tentimkiem){
//     $laynhaccu = $nhaccu->buildQueryParams(["select"=>"IDNhacCu","where"=>"TenNhacCu LIKE ".'"%'.$tentimkiem.'%"']);
//     $chuoiidnhaccu = "";
//     foreach ($laynhaccu as $row) {
//         foreach ($row as $j) {
//             $chuoiidnhaccu = "OR ".$chuoiidnhaccu."IDNhacCu = ".$j;
//         }
//     }
//     $chuoiidnhaccu = strstr($chuoiidnhaccu,"IDNhacCu")
//     $query = $gianhaccu->buildQueryParams(["where"=>$chuoiidnhaccu,"other"=>"limit 10 offset ".$sotrang*10])->select();
//     $router->createUrl("NhacCu/Index",["SoTrang"=>$i]);
// }else{
//     $query = $gianhaccu->buildQueryParams(["other"=>"limit 10 offset ".$sotrang*10])->select();
// }

$query = $gianhaccu->buildQueryParams(["other"=>"limit 10 offset ".$sotrang*10])->select();
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
            <p><b>Gia nhac cu</b></p>
        </div>

<!--  --------------------------------------------------------------------------------------------------->
<!-- Thao tac ------------------------------------------------------------------------------------------->
<!--  --------------------------------------------------------------------------------------------------->
        <div class="thaotac">
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
            <p>Danh sach gia nhac cu</p>
            <div>
                <table class="bangloainhaccu">
                    <tr class="tencot">
                        <td><p>ID</p></td>
                        <td><p>Nhac cu</p></td>
                        <td><p>Gia</p></td>
                        <td><p>Ngay ap dung</p></td>
                        <td><p>Xoa</p></td>
                    </tr>
                    <?php foreach ($query as $row) {
                        $tennhaccu = $nhaccu->buildQueryParams(["select"=>"TenNhacCu","where"=>"IDNhacCu = :id","params"=>[":id"=>$row["IDNhacCu"]]])->selectOne();
                        foreach($tennhaccu as $j){
                            $laytennhaccu = $j;
                        }?>
                    <tr class="noidung">
                        <td><p><?= $row["IDGiaNhacCu"]?></p></td>
                        <td><a href="<?= $router->createUrl("GiaNhacCu/Detail", ["IDGiaNhacCu"=>$row["IDGiaNhacCu"]])?>"><?= $laytennhaccu?></a></td>
                        <td><p><?= $row['Gia']?></p></td>
                        <td><p><?= $row['NgayApDung']?></p></td>
                        <td><a href="<?= $router->createUrl("GiaNhacCu/Delete",["IDGiaNhacCu"=>$row["IDGiaNhacCu"]])?>">Xoa</a></td>
                    </tr>
                    <?php }?>
                </table>
            </div>
        </div>

<!--  --------------------------------------------------------------------------------------------------->
<!-- Chuyen trang --------------------------------------------------------------------------------------->
<!--  --------------------------------------------------------------------------------------------------->
        <div class="danhsachtrang">
            <a class="dauds" href="<?= $router->createUrl("GiaNhacCu/Index",["SoTrang"=>$trangdau])?>">dau</a>
            <a class="truocsauds" href="<?= $router->createUrl("GiaNhacCu/Index",["SoTrang"=>$i-1])?>">truoc</a>
            <a href="<?= $router->createUrl("GiaNhacCu/Index",["SoTrang"=>$i])?>"><?= $i+1?></a>
            <a class="truocsauds" href="<?= $router->createUrl("GiaNhacCu/Index",["SoTrang"=>$i+1])?>">sau</a>
            <a class="cuoids" href="<?= $router->createUrl("GiaNhacCu/Index",["SoTrang"=>$trangcuoi])?>">cuoi</a>
        </div>
    </body>
</html>