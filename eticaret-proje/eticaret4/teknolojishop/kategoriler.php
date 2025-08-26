<?php
//error_reporting(E_ALL);
//ini_set('display_errors', 1);
include 'settings/baglan.php';
function kategori_agac_olustur($kategoriler, $ust_kategori_id=0){
    $kategori_agaci=[];
    foreach ($kategoriler as $kategori){
        if($kategori['kategori_ust'] == $ust_kategori_id){
            $alt_kategori = kategori_agac_olustur($kategoriler, $kategori['kategori_id']);
            if($alt_kategori) {
                $kategori['alt_kategori']=$alt_kategori;
            } else {
                $kategori['alt_kategori']=[];
            }
            $kategori_agaci[]=$kategori;
        }
    }
    return $kategori_agaci;
}

$kategoriSor = $db->prepare("SELECT * FROM kategori where kategori_durum='1'");
$kategoriSor->execute();
$kategoriCek = $kategoriSor->fetchAll(PDO::FETCH_ASSOC);

$kategoriler=kategori_agac_olustur($kategoriCek,0);

?>



<div class="top-level-menu-main-div">
    <div class="top-level-menu-main-div-in">
        <div class="head-new-area-left">
            <ul class="top-level-menu">

                <?php foreach ($kategoriler as $kategori) { ?>
                    <?php if ($kategori['alt_kategori']) { $altkategoriler1 = $kategori['alt_kategori']; ?>
                        <li class="dropdown-sub-have" style="position: relative"><a
                                href="kategori-<?=seo($kategori["kategori_ad"]).'-'.$kategori["kategori_id"]?>"><span><?php echo htmlspecialchars($kategori['kategori_ad']) ?> <i class="fa fa-angle-down"
                                                                                                                                                                      aria-hidden="true"></i></span></a>

                            <ul class="second-level-menu">
                                <?php foreach ($altkategoriler1 as $altkategori1) { ?>
                                    <li><a href="kategori-<?=seo($altkategori1["kategori_ad"]).'-'.$kategori["kategori_id"]?>"><p><?php echo htmlspecialchars($altkategori1['kategori_ad']) ?> <i
                                                    class="fa fa-angle-right" aria-hidden="true"></i></p></a>
                                        <?php if ($altkategori1['alt_kategori']) { $altkategoriler2 = $altkategori1['alt_kategori']; ?>
                                            <ul class="third-level-menu">
                                                <?php foreach ($altkategoriler2 as $altkategori2) { ?>
                                                    <li><a href="kategori-<?=seo($altkategori2["kategori_ad"]).'-'.$altkategori2["kategori_id"]?>"><p><?php echo htmlspecialchars($altkategori2['kategori_ad']) ?></p></a></li>
                                                <?php } ?>
                                            </ul>
                                        <?php } ?>
                                    </li>
                                <?php } ?>
                            </ul>

                        </li>
                    <?php } else { ?>

                        <li style="position: relative"><a
                                href="kategori-<?=seo($kategori["kategori_ad"]).'-'.$kategori["kategori_id"]?>"><span><?php echo htmlspecialchars($kategori['kategori_ad']) ?></span></a>
                        </li>

                    <?php } } ?>
            </ul>
            <div class="dropdown-overlay-show"></div>
            <script> $(function () {
                    $('.dropdown-sub-have').hover(function () {
                        $('.dropdown-overlay-show').show();
                    }, function () {
                        $('.dropdown-overlay-show').hide();
                    });
                });</script>
        </div>
        <div class="head-new-area-right"><a href="kampanyalar/index.html" class="button-black button-2x"
                                            style="  font-weight: bold;">KAMPANYALAR</a></div>
    </div>
</div>