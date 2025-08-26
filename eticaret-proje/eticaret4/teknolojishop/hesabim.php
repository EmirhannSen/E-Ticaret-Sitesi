<?php include 'header.php'; 

// Oturum kontrolü - eğer giriş yapılmadıysa ana sayfaya yönlendir
if(!isset($_SESSION['kullanici_mail'])) {
    header("Location:index.php");
    exit;
}

// Şehirleri çek
$sehirler = [];
$sehirSor = $db->prepare("SELECT * FROM sehir ORDER BY sehir_ad ASC");
$sehirSor->execute();
while($sehirCek = $sehirSor->fetch(PDO::FETCH_ASSOC)) {
    $sehirler[$sehirCek['sehir_id']] = $sehirCek['sehir_ad'];
}

// İlçeleri çek
$ilceler = [];
$ilceSor = $db->prepare("SELECT * FROM ilceler ORDER BY ilce_ad ASC");
$ilceSor->execute();
while($ilceCek = $ilceSor->fetch(PDO::FETCH_ASSOC)) {
    $ilceler[$ilceCek['ilce_id']] = $ilceCek['ilce_ad'];
}

// Kullanıcı bilgilerini güncelleme işlemi
$mesaj = "";
if(isset($_POST['hesap_guncelle'])) {
    $kullanici_id = $kullanicicek['kullanici_id'];
    $kullanici_adsoyad = $_POST['kullanici_adsoyad'];
    $kullanici_gsm = $_POST['kullanici_gsm'];
    $kullanici_mail = $_POST['kullanici_mail'];
    $kullanici_adres = $_POST['kullanici_adres'];
    $kullanici_il = $_POST['kullanici_il'];
    $kullanici_ilce = $_POST['kullanici_ilce'];
    
    // Kullanıcı bilgilerini güncelleme
    $kullaniciGuncelle = $db->prepare("UPDATE kullanicilar SET 
        kullanici_adsoyad = :kullanici_adsoyad,
        kullanici_gsm = :kullanici_gsm,
        kullanici_mail = :kullanici_mail,
        kullanici_adres = :kullanici_adres,
        kullanici_il = :kullanici_il,
        kullanici_ilce = :kullanici_ilce
        WHERE kullanici_id = :kullanici_id");
    
    $guncelle = $kullaniciGuncelle->execute([
        'kullanici_adsoyad' => $kullanici_adsoyad,
        'kullanici_gsm' => $kullanici_gsm,
        'kullanici_mail' => $kullanici_mail, 
        'kullanici_adres' => $kullanici_adres,
        'kullanici_il' => $kullanici_il,
        'kullanici_ilce' => $kullanici_ilce,
        'kullanici_id' => $kullanici_id
    ]);
    
    if($guncelle) {
        $mesaj = '<div class="alert alert-success">Bilgileriniz başarıyla güncellendi!</div>';
        
        // Oturum bilgilerini güncelle
        $_SESSION['kullanici_mail'] = $kullanici_mail;
        
        // Güncel bilgileri çek
        $kullanicisor = $db->prepare("SELECT * FROM kullanicilar where kullanici_mail=:mail");
        $kullanicisor->execute(['mail' => $kullanici_mail]);
        $kullanicicek = $kullanicisor->fetch(PDO::FETCH_ASSOC);
    } else {
        $mesaj = '<div class="alert alert-danger">Bilgileriniz güncellenirken bir hata oluştu!</div>';
    }
}

// Şifre güncelleme işlemi
if(isset($_POST['sifre_guncelle'])) {
    $kullanici_id = $kullanicicek['kullanici_id'];
    $eski_sifre = md5($_POST['eski_sifre']);
    $yeni_sifre = md5($_POST['yeni_sifre']);
    $yeni_sifre_tekrar = md5($_POST['yeni_sifre_tekrar']);
    
    // Eski şifre kontrolü
    if($eski_sifre != $kullanicicek['kullanici_password']) {
        $mesaj = '<div class="alert alert-danger">Eski şifreniz hatalı!</div>';
    } 
    // Yeni şifre kontrolü
    else if($yeni_sifre != $yeni_sifre_tekrar) {
        $mesaj = '<div class="alert alert-danger">Yeni şifreler eşleşmiyor!</div>';
    } 
    // Şifre güncelle
    else {
        $sifreGuncelle = $db->prepare("UPDATE kullanicilar SET 
            kullanici_password = :yeni_sifre
            WHERE kullanici_id = :kullanici_id");
        
        $guncelle = $sifreGuncelle->execute([
            'yeni_sifre' => $yeni_sifre,
            'kullanici_id' => $kullanici_id
        ]);
        
        if($guncelle) {
            $mesaj = '<div class="alert alert-success">Şifreniz başarıyla güncellendi!</div>';
        } else {
            $mesaj = '<div class="alert alert-danger">Şifreniz güncellenirken bir hata oluştu!</div>';
        }
    }
}
?>

<div class="users_main_div" style="background-color: #fff; font-family: 'Poppins',sans-serif;">
    <div class="user_subpage_div">
        <div class="user_page_header_subpage" style="padding: 15px; background-color: #f8f9fa; border-bottom: 1px solid #e9ecef; margin-bottom: 20px;">
            <a href="index.php" style="color: #1f1f1f;">Anasayfa</a>
            <i class="las la-angle-double-right" style="color: #999;"></i>
            <a style="color: #1f1f1f;">Hesabım</a>
        </div>
        
        <div class="container mt-4 mb-5">
            <div class="row">
                <!-- Sol menü - Kullanıcı bilgileri -->
                <div class="col-md-3">
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-dark text-white" style="background-color: #1f1f1f !important; border-color: #1f1f1f;">
                            <h5 class="mb-0"><i class="fa fa-user-circle-o mr-2"></i> Hesabım</h5>
                        </div>
                        <div class="card-body">
                        
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a class="nav-link active" href="hesabim.php" style="color: #1f1f1f; font-weight: bold;">
                                        <i class="fa fa-user mr-2"></i> Hesap Bilgilerim
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="siparislerim.php" style="color: #666;">
                                        <i class="fa fa-shopping-bag mr-2"></i> Siparişlerim
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="favorilerim.php" style="color: #666;">
                                        <i class="fa fa-heart mr-2"></i> Favori Ürünlerim
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="logout.php" style="color: #dc3545;">
                                        <i class="fa fa-sign-out mr-2"></i> Güvenli Çıkış
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <!-- Sağ içerik - Bilgi güncelleme -->
                <div class="col-md-9">
                    <?php echo $mesaj; ?>
                    
                    <!-- Hesap bilgileri -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-dark text-white" style="background-color: #1f1f1f !important; border-color: #1f1f1f;">
                            <h5 class="mb-0"><i class="fa fa-id-card mr-2"></i> Hesap Bilgilerim</h5>
                        </div>
                        <div class="card-body">
                            <form action="" method="POST">
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">Ad Soyad</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="kullanici_adsoyad" value="<?php echo $kullanicicek['kullanici_adsoyad']; ?>" required>
                                    </div>
                                </div>
                                
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">E-posta</label>
                                    <div class="col-md-9">
                                        <input type="email" class="form-control" name="kullanici_mail" value="<?php echo $kullanicicek['kullanici_mail']; ?>" required>
                                    </div>
                                </div>
                                
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">Telefon</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="kullanici_gsm" value="<?php echo $kullanicicek['kullanici_gsm']; ?>">
                                    </div>
                                </div>
                                
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">Adres</label>
                                    <div class="col-md-9">
                                        <textarea class="form-control" name="kullanici_adres" rows="3"><?php echo $kullanicicek['kullanici_adres']; ?></textarea>
                                    </div>
                                </div>
                                
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">İl</label>
                                    <div class="col-md-9">
                                        <select class="form-control" name="kullanici_il">
                                            <option value="">İl Seçiniz</option>
                                            <?php foreach($sehirler as $sehir_id => $sehir_ad): ?>
                                                <option value="<?php echo $sehir_id; ?>" <?php echo ($kullanicicek['kullanici_il'] == $sehir_id) ? 'selected' : ''; ?>>
                                                    <?php echo $sehir_ad; ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">İlçe</label>
                                    <div class="col-md-9">
                                        <select class="form-control" name="kullanici_ilce">
                                            <option value="">İlçe Seçiniz</option>
                                            <?php foreach($ilceler as $ilce_id => $ilce_ad): ?>
                                                <option value="<?php echo $ilce_id; ?>" <?php echo ($kullanicicek['kullanici_ilce'] == $ilce_id) ? 'selected' : ''; ?>>
                                                    <?php echo $ilce_ad; ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="form-group row">
                                    <div class="col-md-9 offset-md-3">
                                        <button type="submit" name="hesap_guncelle" class="btn button-black button-2x">
                                            <i class="fa fa-save mr-1"></i> Bilgilerimi Güncelle
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    
                    <!-- Şifre güncelleme -->
                    <div class="card shadow-sm">
                        <div class="card-header bg-dark text-white" style="background-color: #1f1f1f !important; border-color: #1f1f1f;">
                            <h5 class="mb-0"><i class="fa fa-lock mr-2"></i> Şifre Güncelleme</h5>
                        </div>
                        <div class="card-body">
                            <form action="" method="POST">
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">Mevcut Şifre</label>
                                    <div class="col-md-9">
                                        <input type="password" class="form-control" name="eski_sifre" required>
                                    </div>
                                </div>
                                
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">Yeni Şifre</label>
                                    <div class="col-md-9">
                                        <input type="password" class="form-control" name="yeni_sifre" required>
                                    </div>
                                </div>
                                
                                <div class="form-group row">
                                    <label class="col-md-3 col-form-label">Yeni Şifre Tekrar</label>
                                    <div class="col-md-9">
                                        <input type="password" class="form-control" name="yeni_sifre_tekrar" required>
                                    </div>
                                </div>
                                
                                <div class="form-group row">
                                    <div class="col-md-9 offset-md-3">
                                        <button type="submit" name="sifre_guncelle" class="btn button-black button-2x">
                                            <i class="fa fa-key mr-1"></i> Şifremi Güncelle
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Buton hover düzeltmesi */
.button-black:hover,
.button-black:focus,
.button-black:active {
    color: #fff !important;
    background-color: #1f1f1f !important;
    border-color: #1f1f1f !important;
}

.btn-sm.button-black:hover {
    color: #fff !important;
}
</style>

<?php include 'footer.php'; ?>
