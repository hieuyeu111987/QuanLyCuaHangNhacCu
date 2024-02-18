<?php

$router = new Apps_Libs_Router();
$user = new Apps_Libs_UserIdentity();
$nhaccu = new Apps_Models_NhacCu();
$chitiethoadonxuat = new Apps_Models_ChiTietHoaDonXuat();
$loainhaccu = new Apps_Models_LoaiNhacCu();
$laymang = $nhaccu->buildQueryParams(["select"=>"COUNT(IDNhacCu)"])->selectOne();

$idnhaccubanchay = $chitiethoadonxuat->buildQueryParams(["select"=>"IDNhacCu, SUM(SoLuong)","other"=>"GROUP BY IDNhacCu LIMIT 5"])->select();
$tennhaccu = "";
$hinhnhaccu = "";
$so = 1;
foreach ($laymang as $row) {
    $so = $row;
}
$trangdau = 0;
$trangcuoi = (int)((int)$so/20);
$i = intval($router->getGET("SoTrang"));
if($i<$trangdau){
    $i=$trangdau;
}
if($i>$trangcuoi){
    $i = $trangcuoi;
}
$sotrang = $i;
$query = $nhaccu->buildQueryParams(["other"=>"limit 20 offset ".$sotrang*20])->select();
$nhaccuphim = $loainhaccu->buildQueryParams(["select"=>"TenLoaiNhacCu","where"=>"BoNhacCu = ".'"'."Phim".'"'])->select();
$nhaccuday = $loainhaccu->buildQueryParams(["select"=>"TenLoaiNhacCu","where"=>"BoNhacCu = ".'"'."Day".'"'])->select();
$nhaccugo = $loainhaccu->buildQueryParams(["select"=>"TenLoaiNhacCu","where"=>"BoNhacCu = ".'"'."Go".'"'])->select();
$nhaccuhoi = $loainhaccu->buildQueryParams(["select"=>"TenLoaiNhacCu","where"=>"BoNhacCu = ".'"'."Hoi".'"'])->select();
// var_dump(strstr($cateDetail['HinhNhacCu'],"NhacCu\Hinh"));die();
?>

<html>
    <head>
        <title>Shop nhac cu UFO</title>
        <link rel="stylesheet" type="text/css" href="Home.css">
        <link rel="stylesheet" type="text/css" href="FileCopyNgoai/Font/fontawesome-free-5.12.0-web/css/all.css">
    </head>
    <body>

<!--------------------------------------------------------------------------------------------------------->
<!-- Head ------------------------------------------------------------------------------------------------->
<!--------------------------------------------------------------------------------------------------------->
        <header>
            <a href="#"><img class="logo" src="./Hinh/Logo2.jpg" alt="Logo"></a>
            <div class="timkiem">
                <form action="" method="POST">
                    <div class="txttimkiem">
                        <input type="text" name="txttimkiem" value="">
                    </div>
                    <div class="btntimkiem">
                        <input type="submit" name="btntimkiem" value="Tim">
                    </div>
                </form>
            </div>
            <div class="giohang">
                <a href="#"><img src="./Hinh/GioHang01.png" alt="Logo"></a>
            </div>
            <div class="danhsachtrang">
                <a href="#menu">Menu</a>
                <a href="#hanghoa">Nhac cu</a>
                <a href="#">Ban chay</a>
                <a href="#">Lien he</a>
                <a href="<?= str_replace("Public","Admin",$router->createUrl("login"))?>">Dang nhap</a>
            </div>
        </header>

<!--------------------------------------------------------------------------------------------------------->
<!-- Menu ------------------------------------------------------------------------------------------------->
<!--------------------------------------------------------------------------------------------------------->
        
        <ul class="menu">
            <li><a href="#">Phim</a>
                <ul class="menucon">
                    <?php foreach ($nhaccuphim as $row) {?>
                    <li><a href="#"><?= $row['TenLoaiNhacCu']?></a></li>
                    <?php }?>
                </ul>
            </li>
            <li><a href="#">Day</a>
                <ul class="menucon">
                    <?php foreach ($nhaccuday as $row) {?>
                    <li><a href="#"><?= $row['TenLoaiNhacCu']?></a></li>
                    <?php }?>
                </ul>
            </li>
            <li><a href="#">Go</a>
                <ul class="menucon">
                    <?php foreach ($nhaccugo as $row) {?>
                    <li><a href="#"><?= $row['TenLoaiNhacCu']?></a></li>
                    <?php }?>
                </ul>
            </li>
            <li><a href="#">Hoi</a>
                <ul class="menucon">
                    <?php foreach ($nhaccuhoi as $row) {?>
                    <li><a href="#"><?= $row['TenLoaiNhacCu']?></a></li>
                    <?php }?>
                </ul>
            </li>
        </ul>

<!--------------------------------------------------------------------------------------------------------->
<!-- Hang hoa --------------------------------------------------------------------------------------------->
<!--------------------------------------------------------------------------------------------------------->
        <div class="hanghoa">
            <div class="tenbang"><p>Nhac cu</p></div>
            <div class="nhaccu">
                <?php foreach ($query as $row) {?>
                    <div class="machang">
                        <a href="#"><img src="<?= strstr($row['HinhNhacCu'],"NhacCu\Hinh") ?>" alt="nhaccu"></a>
                        <a href="#"><?= $row["TenNhacCu"]?></a>
                    </div>
                <?php }?>
            </div>
            
            <div class="chuyentrang">
                <a class="dauds" href="<?= $router->createUrl("Home",["SoTrang"=>$trangdau])?>">dau</a>
                <a class="truocsauds" href="<?= $router->createUrl("Home",["SoTrang"=>$i-1])?>">truoc</a>
                <a href="<?= $router->createUrl("Home",["SoTrang"=>$i])?>"><?= $i+1?></a>
                <a class="truocsauds" href="<?= $router->createUrl("Home",["SoTrang"=>$i+1])?>">sau</a>
                <a class="cuoids" href="<?= $router->createUrl("Home",["SoTrang"=>$trangcuoi])?>">cuoi</a>
            </div>
        </div>
        
<!--------------------------------------------------------------------------------------------------------->
<!-- Hang ban chay ---------------------------------------------------------------------------------------->
<!--------------------------------------------------------------------------------------------------------->
        <div class="hangbanchay">
            <div class="tenbang"><p>Nhac cu ban chay</p></div>
            <div class="nhaccu">
                <?php foreach ($idnhaccubanchay as $row) {
                    $nhaccubanchay = $nhaccu->buildQueryParams(["select"=>"TenNhacCu,HinhNhacCu","where"=>"IDNhacCu = :id","params"=>[":id"=>$row["IDNhacCu"]]])->select();
                    foreach($nhaccubanchay as $j){
                        $tennhaccu = $j["TenNhacCu"];
                        $hinhnhaccu = $j["HinhNhacCu"];
                    }?>
                    <div class="machang">
                        <a href="#"><img src="<?= strstr($j['HinhNhacCu'],"NhacCu\Hinh") ?>" alt="nhaccu"></a>
                        <a href="#"><?= $j["TenNhacCu"]?></a>
                    </div>
                <?php }?>
            </div>
        </div>

<!--------------------------------------------------------------------------------------------------------->
<!-- Thong tin cua hang ----------------------------------------------------------------------------------->
<!--------------------------------------------------------------------------------------------------------->
        <div class="thongtin">
            <div class="diachi">
                <ul class="information">
                    <li><i class="fas fa-map-marker-alt small-icon"></i> Dia chi: 311, duong Nguyen Van Cu, Can Tho</li>
                    <li><i class="fas fa-envelope small-icon"></i>Gmail: hieuyeu111987@gmail.com</li>
                    <li><i class="fas fa-phone small-icon"></i>SDT: (+84)972-639-656</li>
                </ul>
                <ul class="social-icon">
                    <li><i class="fab fa-facebook"></i></li>
                    <li><i class="fab fa-twitter-square"></i></li>
                    <li><i class="fab fa-instagram"></i></li>
                    <li><i class="fab fa-google-plus-square"></i></li>
                </ul>
            </div>
        </div>

<!--------------------------------------------------------------------------------------------------------->
<!-- Lien he ---------------------------------------------------------------------------------------------->
<!--------------------------------------------------------------------------------------------------------->
        <div class="lienhe">
            <form>
                <ul>
                    <li>
                        <label class="label-khoangcach-ten">Ten</label>
                        <input class="input-Ten" type="text" placeholder="Ten">
                    </li>
                    <li>
                        <label class="label-khoangcach">Gmail</label>
                        <input class="input-Gmail" type="text" placeholder="Gmail">
                    </li>
                    <li>
                        <label class="label-khoangcach">Gop y</label>
                        <textarea class="textarea-GopY" type="text" placeholder="Gop y"></textarea>
                    </li>
                    <li>
                        <input type="submit" class="btn" value="Gui">
                    </li>
                </ul>
            </form>
        </div>
        
<!--------------------------------------------------------------------------------------------------------->
<!-- Footer ----------------------------------------------------------------------------------------------->
<!--------------------------------------------------------------------------------------------------------->
        <footer>
            <p>
                Copyright &copy; 2020 by UFO Team
            </p>
        </footer>
    </body>
</html>