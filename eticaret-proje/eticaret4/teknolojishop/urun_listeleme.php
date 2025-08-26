<?php
// Tanımlama sabiti
define('INCLUDED', true);

//error_reporting(E_ALL);
//ini_set('display_errors', 1);
include 'settings/baglan.php';

// AJAX talebi mi kontrol et
$isAjaxRequest = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
                 strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';

// Sayfa için marka veya kategori bilgisini al (Yeni eklenen kısım)
$filtre_turu = "";
$marka_id = 0;
$kategori_id = 0;

if (isset($_GET['marka'])) {
    $filtre_turu = "marka";
    $marka = $_GET['marka'];
    
    // Marka adına göre marka ID'sini al
    $markaSor = $db->prepare("SELECT * FROM marka WHERE marka_adi = :marka_adi");
    $markaSor->execute(['marka_adi' => $marka]);
    $markaCek = $markaSor->fetch(PDO::FETCH_ASSOC);
    
    if ($markaCek) {
        $marka_id = $markaCek['marka_id'];
    }
} elseif (isset($_GET['kategori_id'])) {
    $filtre_turu = "kategori";
    $kategori_id = $_GET['kategori_id'];
}

// Debug için mevcut mantık
if ($isAjaxRequest) {
    // echo "AJAX isteği alındı";
    // Sadece sağ içeriği yükle
    include 'urun_listeleme_sag_icerik.php';
    exit;
}

// Normal sayfa yüklemesi için tüm sayfayı göster
include 'header.php';

function alt_kategorileri_bul($db, $kategori_id) {
    $alt_kategoriler = [];
    $kategoriSor = $db->prepare("SELECT kategori_id FROM kategori WHERE kategori_ust = :kategori_id");
    $kategoriSor->execute(['kategori_id' => $kategori_id]);
    $kategoriler = $kategoriSor->fetchAll(PDO::FETCH_ASSOC);

    foreach ($kategoriler as $kategori) {
        $alt_kategoriler[] = $kategori['kategori_id'];
        $alt_kategoriler = array_merge($alt_kategoriler, alt_kategorileri_bul($db, $kategori['kategori_id']));
    }

    return $alt_kategoriler;
}

// Filtre bilgilerini oturum değişkenlerine aktar (sol ve sağ içerik dosyaları tarafından kullanılması için)
$_SESSION['filtre_turu'] = $filtre_turu;
$_SESSION['marka_id'] = $marka_id;
$_SESSION['kategori_id'] = $kategori_id;
?>

<body>

<link rel="stylesheet" href="assets/css/category_style.css"/>
<div class="cat-detail-main-div" style="padding: 0 !important; ">
    <!-- Page Header !-->
    <!--  <========SON=========>>> Page Header SON !-->
</div>

<div class="cat-detail-main-div">
    <div class="cat-detail-main-div-in">


        <!-- left Nav !-->

        <?php include 'urun_listeleme_sol_icerik.php'; ?>
        
        <!-- Products Area !-->

        <?php include 'urun_listeleme_sag_icerik.php'; ?>

        <!--  <========SON=========>>> Products Area SON !-->
    </div>
</div>


<!-- CONTENT AREA ============== !-->


<?php include'footer.php'; ?>

</body>
</html>


<script src="assets/js/niceselect/jquery.nice-select.min.js"></script>
<script src="assets/js/niceselect/fastclick.js"></script>
<script src="assets/js/niceselect/prism.js"></script>

<script>
    $(document).ready(function () {
        $('.select').niceSelect();
    });
    $(function () {
        $('#dynamic_select').on('change', function () {
            var url = $(this).val();
            if (url) {
                window.location = url;
            }
            return false;
        });
    });
</script>



</div>
