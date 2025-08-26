<?php 
include 'header.php';

// Favorileri yönetmek için gerekli işlemler
// Önce favoriler tablosu var mı kontrol edelim ve yoksa oluşturalım
try {
    $db->query("CREATE TABLE IF NOT EXISTS favoriler (
        favori_id INT AUTO_INCREMENT PRIMARY KEY,
        kullanici_id INT NOT NULL,
        urun_id INT NOT NULL,
        favori_tarih TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        UNIQUE KEY(kullanici_id, urun_id)
    )");
} catch(PDOException $e) {
    // Tablo zaten varsa hata vermeyecek
}

// Favoriye ekle/çıkar
if(isset($_GET['urun_id']) && is_numeric($_GET['urun_id']) && $say > 0) {
    $urun_id = $_GET['urun_id'];
    $kullanici_id = $kullanicicek['kullanici_id'];
    $islem = isset($_GET['islem']) ? $_GET['islem'] : '';
    
    if($islem == 'ekle') {
        // Ekle
        $favoriyeEkle = $db->prepare("INSERT IGNORE INTO favoriler SET kullanici_id = :kullanici_id, urun_id = :urun_id");
        $favoriyeEkle->execute([
            'kullanici_id' => $kullanici_id,
            'urun_id' => $urun_id
        ]);
    } else if($islem == 'cikar') {
        // Çıkar
        $favoridenCikar = $db->prepare("DELETE FROM favoriler WHERE kullanici_id = :kullanici_id AND urun_id = :urun_id");
        $favoridenCikar->execute([
            'kullanici_id' => $kullanici_id,
            'urun_id' => $urun_id
        ]);
    }
    
    // Referrer kontrolü - kullanıcıyı geldiği sayfaya geri gönder
    if(isset($_SERVER['HTTP_REFERER'])) {
        header("Location: ".$_SERVER['HTTP_REFERER']);
        exit;
    } else {
        // Referrer yoksa favoriler sayfasına yönlendir
        header("Location: favorilerim.php");
        exit;
    }
}

// Favori ürünleri getir (kullanıcı giriş yapmışsa)
$favoriler = [];
if($say > 0) {
    $favoriSor = $db->prepare("SELECT f.*, u.* FROM favoriler f 
                              INNER JOIN urun u ON f.urun_id = u.urun_id 
                              WHERE f.kullanici_id = :kullanici_id 
                              ORDER BY f.favori_tarih DESC");
    $favoriSor->execute(['kullanici_id' => $kullanicicek['kullanici_id']]);
    $favoriler = $favoriSor->fetchAll(PDO::FETCH_ASSOC);
}
?>

<div class="users_main_div" style="background-color: #fff; font-family: 'Poppins',sans-serif;">
    <div class="user_subpage_div">
        <div class="user_page_header_subpage" style="padding: 15px; background-color: #f8f9fa; border-bottom: 1px solid #e9ecef; margin-bottom: 20px;">
            <a href="index.php" style="color: #1f1f1f;">Anasayfa</a>
            <i class="las la-angle-double-right" style="color: #999;"></i>
            <a href="hesabim.php" style="color: #1f1f1f;">Hesabım</a>
            <i class="las la-angle-double-right" style="color: #999;"></i>
            <a href="favorilerim.php" style="color: #1f1f1f;">Favori Ürünler</a>
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
                                    <a class="nav-link" href="hesabim.php" style="color: #666;">
                                        <i class="fa fa-user mr-2"></i> Hesap Bilgilerim
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="siparislerim.php" style="color: #666;">
                                        <i class="fa fa-shopping-bag mr-2"></i> Siparişlerim
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link active" href="favorilerim.php" style="color: #1f1f1f; font-weight: bold;">
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
                
                <!-- Sağ içerik - Favoriler -->
                <div class="col-md-9">
                    <div class="card shadow-sm">
                        <div class="card-header bg-dark text-white" style="background-color: #1f1f1f !important; border-color: #1f1f1f;">
                            <h5 class="mb-0"><i class="fa fa-heart mr-2"></i> Favori Ürünlerim</h5>
                        </div>
                        <div class="card-body">
                            <?php if($say == 0): // Kullanıcı giriş yapmamış ?>
                            <div class="user_subpage_favorites_nologin text-center py-5">
                                <i class="ion-heart-broken fa-4x text-muted mb-3"></i>
                                <h4 class="mb-3">Favori Ürünler (0)</h4>
                                <p class="text-muted mb-4">Sadece üyeler ürünleri favorilerine ekleyebilir. Hemen üye girişi yaparak ürünleri favorilerinize eklemeye başlayabilirsiniz.</p>
                                <div class="user_subpage_favorites_nologin_buttons">
                                    <a href="uye-giris.php" class="btn button-grey-out button-2x m-2" style="border-radius: 30px; padding: 10px 30px;">GİRİŞ YAP</a>
                                    <a href="uye-kayit.php" class="btn button-black button-2x m-2" style="border-radius: 30px; padding: 10px 30px;">HEMEN ÜYE OL</a>
                                </div>
                            </div>
                            <?php elseif(count($favoriler) == 0): // Kullanıcı giriş yapmış ama favorisi yok ?>
                            <div class="text-center py-5">
                                <i class="fa fa-heart-o fa-4x mb-3" style="color: #1f1f1f;"></i>
                                <h4 class="mb-3">Henüz favori ürününüz bulunmuyor</h4>
                                <p class="text-muted mb-4">Ürün sayfalarındaki kalp ikonuna tıklayarak favori ürünlerinizi ekleyebilirsiniz.</p>
                                <a href="index.php" class="btn button-black button-2x" style="border-radius: 30px; padding: 10px 30px;">
                                    <i class="fa fa-shopping-cart mr-2"></i> Alışverişe Başla
                                </a>
                            </div>
                            <?php else: // Kullanıcının favorileri var ?>
                            <div class="row">
                                <?php foreach($favoriler as $urun): ?>
                                <div class="col-md-4 mb-4">
                                    <div class="card h-100 product-card shadow-sm" style="border-radius: 10px; border: 1px solid #eee; transition: all 0.3s ease;">
                                        <div style="position: relative;">
                                            <a href="urun-<?=seo($urun["urun_adi"]).'-'.$urun["urun_id"]?>">
                                                <img src="<?php echo $urun['urun_resim1'] ?>" 
                                                     alt="<?php echo $urun['urun_adi'] ?>" 
                                                     class="card-img-top p-3" 
                                                     style="height: 200px; object-fit: contain;">
                                            </a>
                                            <a href="favorilerim.php?urun_id=<?php echo $urun['urun_id'] ?>&islem=cikar" 
                                               class="btn btn-sm button-black-out" 
                                               style="position: absolute; top: 10px; right: 10px; border-radius: 50%; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center;" 
                                               title="Favorilerden Çıkar">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                            <?php if($urun['urun_piyasafiyati'] > 0): ?>
                                            <div class="product-badge" style="position: absolute; top: 10px; left: 10px; background-color: #1f1f1f; color: white; padding: 5px 10px; border-radius: 20px; font-size: 12px; font-weight: bold;">
                                                %<?php echo round(100-($urun['urun_satisfiyati']/$urun['urun_piyasafiyati'])*100); ?> İndirim
                                            </div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="card-body d-flex flex-column">
                                            <div class="mb-2">
                                                <span class="text-muted small"><?php echo $urun['urun_marka'] ?></span>
                                            </div>
                                            <h6 class="card-title mb-3" style="height: 40px; overflow: hidden;">
                                                <a href="urun-<?=seo($urun["urun_adi"]).'-'.$urun["urun_id"]?>" class="text-dark" style="text-decoration: none; font-weight: 600;">
                                                    <?php echo $urun['urun_adi'] ?>
                                                </a>
                                            </h6>
                                            <div class="mt-auto">
                                                <?php if($urun['urun_stok'] > 0): ?>
                                                <div class="d-flex justify-content-between align-items-center mb-2">
                                                    <?php if($urun['urun_piyasafiyati'] > 0): ?>
                                                    <span class="text-muted text-decoration-line-through"><?php echo number_format($urun['urun_piyasafiyati'], 2, ',', '.') . ' ' . $urun['urun_doviz']; ?></span>
                                                    <?php endif; ?>
                                                    <span class="font-weight-bold" style="color: #1f1f1f; font-size: 18px;">
                                                        <?php echo number_format($urun['urun_satisfiyati'], 2, ',', '.') . ' ' . $urun['urun_doviz']; ?>
                                                    </span>
                                                </div>
                                                <form action="settings/islem.php" method="post" class="mt-3">
                                                    <input name="urun_id" type="hidden" value="<?php echo $urun['urun_id'] ?>">
                                                    <input name="kullanici_id" type="hidden" value="<?php echo $kullanicicek['kullanici_id'] ?>">
                                                    <input name="quantity" type="hidden" value="1">
                                                    <button name="sepetekle" class="btn button-black button-2x btn-block" style="border-radius: 30px;">
                                                        <i class="fa fa-shopping-basket mr-2"></i> Sepete Ekle
                                                    </button>
                                                </form>
                                                <?php else: ?>
                                                <div class="mb-2 text-center">
                                                    <span class="font-weight-bold text-danger">Stokta Yok</span>
                                                </div>
                                                <button disabled class="btn button-grey button-2x btn-block" style="border-radius: 30px;">
                                                    <i class="fa fa-times mr-2"></i> Stokta Yok
                                                </button>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
}

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

.button-black-out:hover {
    color: #fff !important;
    background-color: #1f1f1f !important;
    border-color: #1f1f1f !important;
}
</style>

<?php include 'footer.php'; ?>
