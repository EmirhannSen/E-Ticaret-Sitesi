<?php 
include 'header.php';

// Sipariş numarasını al
$siparis_no = isset($_GET['siparis_no']) ? $_GET['siparis_no'] : null;

// Kullanıcı giriş kontrolü
if(!isset($_SESSION['kullanici_mail']) || !$siparis_no) {
    header("Location:index.php");
    exit;
}

// Siparişi getir
$siparissor = $db->prepare("SELECT s.*, sd.durum_adi, sd.durum_renk 
                           FROM siparis s 
                           INNER JOIN siparis_durumlari sd ON s.siparis_durum_id = sd.durum_id
                           WHERE s.siparis_no = :siparis_no AND s.kullanici_id = :kullanici_id");
$siparissor->execute([
    'siparis_no' => $siparis_no,
    'kullanici_id' => $kullanicicek['kullanici_id']
]);

$siparis = $siparissor->fetch(PDO::FETCH_ASSOC);

// Sipariş yoksa ana sayfaya yönlendir
if(!$siparis) {
    header("Location:index.php");
    exit;
}

// Şehir ve ilçe adını getir
$sehir_ad = "";
$ilce_ad = "";

// Şehir adını al
$sehirsor = $db->prepare("SELECT sehir_ad FROM sehir WHERE sehir_id = :sehir_id");
$sehirsor->execute(['sehir_id' => $kullanicicek['kullanici_il']]);
$sehircek = $sehirsor->fetch(PDO::FETCH_ASSOC);
if($sehircek) {
    $sehir_ad = $sehircek['sehir_ad'];
}

// İlçe adını al
$ilcesor = $db->prepare("SELECT ilce_ad FROM ilceler WHERE ilce_id = :ilce_id");
$ilcesor->execute(['ilce_id' => $kullanicicek['kullanici_ilce']]);
$ilcecek = $ilcesor->fetch(PDO::FETCH_ASSOC);
if($ilcecek) {
    $ilce_ad = $ilcecek['ilce_ad'];
}

// Sipariş detaylarını getir
$siparis_detaysor = $db->prepare("SELECT sd.*, u.urun_adi, u.urun_resim1 
                                FROM siparis_detay sd 
                                INNER JOIN urun u ON sd.urun_id = u.urun_id 
                                WHERE sd.siparis_id = :siparis_id");
$siparis_detaysor->execute(['siparis_id' => $siparis['siparis_id']]);
$siparis_detaylari = $siparis_detaysor->fetchAll(PDO::FETCH_ASSOC);

// Ödeme tipi bilgisi
$odeme_tipi = $siparis['siparis_tip'];
$banka = $siparis['siparis_banka'];
?>

<style>
    .page-banner-main {
        background: #1f1f1f;
        padding: 30px 0 30px 0;
        font-family: 'Roboto', sans-serif;
        border-bottom: 1px solid #ffffff;
        border-top: 1px solid #ffffff;
        margin-top: 0px;
        margin-bottom: 0px;
    }

    .page-banner-in-text {
        margin: 0 auto;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .page-banner-h {
        font-size: 28px;
        color: #ffffff;
        font-weight: 400;
        line-height: 28px;
    }

    .page-banner-links {
        text-align: right;
        color: #cccccc;
    }

    .page-banner-links span {
        color: #cccccc;
        font-size: 13px;
    }

    .page-banner-links a {
        color: #cccccc;
        font-size: 13px;
    }

    .page-banner-links a:hover {
        color: #cccccc;
    }

    .success-main-div {
        font-family: 'Roboto', Sans-serif;
        background-color: #fff;
        padding: 20px 0;
    }

    .success-section {
        background: #f9f9f9;
        border: 1px solid #ebebeb;
        padding: 20px;
        margin-bottom: 20px;
    }

    .success-header {
        text-align: center;
        padding: 20px 0;
        margin-bottom: 20px;
    }

    .success-icon {
        font-size: 48px;
        color: #0F9D58;
        margin-bottom: 15px;
    }

    .order-details-section {
        margin-bottom: 30px;
    }

    .order-details-title {
        font-size: 18px;
        font-weight: bold;
        padding-bottom: 15px;
        margin-bottom: 15px;
        border-bottom: 1px solid #ebebeb;
    }

    .order-info-item {
        display: flex;
        margin-bottom: 10px;
    }

    .order-info-label {
        width: 40%;
        font-weight: 600;
    }

    .order-info-value {
        width: 60%;
    }

    .product-list-item {
        display: flex;
        align-items: center;
        padding: 10px 0;
        border-bottom: 1px solid #ebebeb;
    }

    .product-image {
        width: 60px;
        margin-right: 15px;
    }

    .product-details {
        flex-grow: 1;
    }

    .product-price {
        text-align: right;
        font-weight: bold;
    }

    .button-blue {
        background-color: #4285F4;
        color: white;
        border: none;
        padding: 8px 15px;
        cursor: pointer;
        text-decoration: none;
        display: inline-block;
    }

    .button-blue:hover {
        background-color: #3367d6;
        color: white;
        text-decoration: none;
    }

    .button-2x {
        font-size: 16px;
        padding: 10px 20px;
    }
</style>

<!-- Sayfa Başlık Alanı -->
<div class="page-banner-main">
    <div class="container">
        <div class="page-banner-in-text">
            <div class="page-banner-h">Sipariş Tamamlandı</div>
            <div class="page-banner-links">
                <a href="index.php"><i class="fa fa-home"></i> Anasayfa</a>
                <span>/</span>
                <a>Sipariş Tamamlandı</a>
            </div>
        </div>
    </div>
</div>

<div class="success-main-div">
    <div class="container">
        <div class="success-section">
            <div class="success-header">
                <div class="success-icon">
                    <i class="fa fa-check-circle"></i>
                </div>
                <h2>Siparişiniz Başarıyla Alındı!</h2>
                <p class="lead">Siparişiniz için teşekkür ederiz. Siparişiniz işleme alındı.</p>
                <div class="alert alert-info mt-3">
                    <strong>Sipariş Numaranız:</strong> #<?php echo $siparis_no; ?>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="order-details-section">
                        <div class="order-details-title">
                            <i class="fa fa-file-text-o mr-2"></i> Sipariş Bilgileri
                        </div>
                        <div class="order-info-item">
                            <div class="order-info-label">Sipariş Numarası:</div>
                            <div class="order-info-value">#<?php echo $siparis_no; ?></div>
                        </div>
                        <div class="order-info-item">
                            <div class="order-info-label">Sipariş Tarihi:</div>
                            <div class="order-info-value"><?php echo date("d.m.Y H:i", strtotime($siparis['siparis_zaman'])); ?></div>
                        </div>
                        <div class="order-info-item">
                            <div class="order-info-label">Toplam Tutar:</div>
                            <div class="order-info-value"><?php echo number_format($siparis['siparis_toplam'], 2, ',', '.'); ?> TL</div>
                        </div>
                        <div class="order-info-item">
                            <div class="order-info-label">Ödeme Yöntemi:</div>
                            <div class="order-info-value"><?php echo $odeme_tipi; ?></div>
                        </div>
                        <div class="order-info-item">
                            <div class="order-info-label">Sipariş Durumu:</div>
                            <div class="order-info-value">
                                <span class="badge badge-<?php echo $siparis['durum_renk']; ?>"><?php echo $siparis['durum_adi']; ?></span>
                            </div>
                        </div>
                        <?php if($odeme_tipi == 'Banka Havalesi' && !empty($banka)): ?>
                        <div class="order-info-item">
                            <div class="order-info-label">Banka:</div>
                            <div class="order-info-value"><?php echo $banka; ?></div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="order-details-section">
                        <div class="order-details-title">
                            <i class="fa fa-user mr-2"></i> Teslimat Bilgileri
                        </div>
                        <div class="order-info-item">
                            <div class="order-info-label">Ad Soyad:</div>
                            <div class="order-info-value"><?php echo $kullanicicek['kullanici_ad'] . ' ' . $kullanicicek['kullanici_soyad']; ?></div>
                        </div>
                        <?php if(!empty($kullanicicek['kullanici_tc'])): ?>
                        <div class="order-info-item">
                            <div class="order-info-label">T.C. Kimlik No:</div>
                            <div class="order-info-value"><?php echo $kullanicicek['kullanici_tc']; ?></div>
                        </div>
                        <?php endif; ?>
                        <div class="order-info-item">
                            <div class="order-info-label">E-posta:</div>
                            <div class="order-info-value"><?php echo $kullanicicek['kullanici_mail']; ?></div>
                        </div>
                        <?php if(!empty($kullanicicek['kullanici_gsm'])): ?>
                        <div class="order-info-item">
                            <div class="order-info-label">Telefon:</div>
                            <div class="order-info-value"><?php echo $kullanicicek['kullanici_gsm']; ?></div>
                        </div>
                        <?php endif; ?>
                        <div class="order-info-item">
                            <div class="order-info-label">Adres:</div>
                            <div class="order-info-value"><?php echo $kullanicicek['kullanici_adres']; ?></div>
                        </div>
                        <div class="order-info-item">
                            <div class="order-info-label">İl/İlçe:</div>
                            <div class="order-info-value"><?php echo $sehir_ad . '/' . $ilce_ad; ?></div>
                        </div>
                    </div>
                </div>
            </div>
            
            <?php if($odeme_tipi == 'Banka Havalesi'): ?>
            <div class="alert alert-warning my-4">
                <h5 class="alert-heading">Banka Havalesi ile Ödeme</h5>
                <p>Lütfen toplam sipariş tutarını yukarıda belirtilen banka hesabına havale ediniz. Havale işleminizi gerçekleştirdikten sonra müşteri hizmetlerimizi arayarak veya e-posta göndererek bilgilendirmenizi rica ederiz.</p>
                <p class="mb-0">Havale dekontunuza sipariş numaranızı (<?php echo $siparis_no; ?>) mutlaka belirtiniz.</p>
            </div>
            <?php endif; ?>
            
            <div class="text-center my-4">
                <a href="index.php" class="btn btn-dark">
                    <i class="fa fa-home mr-2"></i> Anasayfaya Dön
                </a>
                <a href="siparislerim.php" class="btn btn-primary ml-2">
                    <i class="fa fa-list mr-2"></i> Siparişlerim
                </a>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
