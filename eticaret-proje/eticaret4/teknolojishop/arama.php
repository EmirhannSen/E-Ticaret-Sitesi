<?php
include 'header.php';

// Arama parametrelerini al
$aranan = isset($_GET['q']) ? $_GET['q'] : '';
$aranan = strip_tags(trim($aranan));

// Boş arama sorgularını yönlendir
if (empty($aranan)) {
    header("Location: index.php");
    exit;
}

// Sayfalama değişkenleri
$sayfada = 12; // Her sayfada gösterilecek ürün sayısı
$sayfa = isset($_GET['sayfa']) ? (int)$_GET['sayfa'] : 1;
$from = ($sayfa - 1) * $sayfada;

// Toplam ürün sayısını öğren
$toplamSorgu = $db->prepare("SELECT COUNT(*) as toplam FROM urun 
                            WHERE urun_durum = '1' AND 
                            (urun_adi LIKE :aranan OR urun_aciklama LIKE :aranan OR urun_marka LIKE :aranan)");
$toplamSorgu->execute(['aranan' => '%' . $aranan . '%']);
$toplam_veri = $toplamSorgu->fetch(PDO::FETCH_ASSOC);
$toplam_urun = $toplam_veri['toplam'];
$toplam_sayfa = ceil($toplam_urun / $sayfada);

// Arama sorgusunu çalıştır
$urunsor = $db->prepare("SELECT * FROM urun 
                        WHERE urun_durum = '1' AND 
                        (urun_adi LIKE :aranan OR urun_aciklama LIKE :aranan OR urun_marka LIKE :aranan) 
                        ORDER BY urun_id DESC LIMIT :from, :sayfada");
$urunsor->bindValue(':aranan', '%' . $aranan . '%', PDO::PARAM_STR);
$urunsor->bindValue(':from', $from, PDO::PARAM_INT);
$urunsor->bindValue(':sayfada', $sayfada, PDO::PARAM_INT);
$urunsor->execute();
$urunler = $urunsor->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container my-5">
   <!-- <div class="row mb-4">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-light p-3">
                    <li class="breadcrumb-item"><a href="index.php">Anasayfa</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Arama Sonuçları: "<?php echo htmlspecialchars($aranan); ?>"</li>
                </ol>
            </nav>
        </div>
    </div> -->

    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-dark text-white">
                    <h4 class="mb-0">"<?php echo htmlspecialchars($aranan); ?>" için arama sonuçları</h4>
                </div>
                <div class="card-body">
                    <p>Toplam <?php echo $toplam_urun; ?> ürün bulundu.</p>
                </div>
            </div>
        </div>
    </div>

    <?php if ($toplam_urun > 0): ?>
    <!-- Ürünleri listele -->
    <div class="row">
        <?php foreach ($urunler as $urun): ?>
        <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
            <div class="card h-100 product-card">
                <div style="position: relative;">
                    <a href="urun-<?=seo($urun['urun_adi']).'-'.$urun['urun_id']?>">
                        <img src="<?php echo $urun['urun_resim1']; ?>" 
                             alt="<?php echo $urun['urun_adi']; ?>" 
                             class="card-img-top p-3" 
                             style="height: 200px; object-fit: contain;">
                    </a>
                    
                    <?php if($urun['urun_piyasafiyati'] > 0): ?>
                    <div style="position: absolute; top: 10px; left: 10px; background-color: #e74c3c; color: white; padding: 3px 8px; border-radius: 3px; font-size: 12px; font-weight: bold;">
                        %<?php echo round(100-($urun['urun_satisfiyati']/$urun['urun_piyasafiyati'])*100); ?> İndirim
                    </div>
                    <?php endif; ?>
                </div>
                <div class="card-body d-flex flex-column">
                    <div class="mb-2">
                        <span class="text-muted small"><?php echo $urun['urun_marka']; ?></span>
                    </div>
                    <h5 class="card-title mb-3" style="height: 48px; overflow: hidden;">
                        <a href="urun-<?=seo($urun['urun_adi']).'-'.$urun['urun_id']?>" class="text-dark" style="text-decoration: none; font-weight: 600; font-size: 16px;">
                            <?php echo $urun['urun_adi']; ?>
                        </a>
                    </h5>
                    <div class="mt-auto">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <?php if($urun['urun_piyasafiyati'] > 0): ?>
                            <span class="text-muted text-decoration-line-through"><?php echo number_format($urun['urun_piyasafiyati'], 2, ',', '.') . ' ' . $urun['urun_doviz']; ?></span>
                            <?php endif; ?>
                            <span class="font-weight-bold" style="color: #1f1f1f; font-size: 18px;">
                                <?php echo number_format($urun['urun_satisfiyati'], 2, ',', '.') . ' ' . $urun['urun_doviz']; ?>
                            </span>
                        </div>
                        <?php if($urun['urun_stok'] > 0): ?>
                        <form action="settings/islem.php" method="post" class="w-100">
                            <input name="urun_id" type="hidden" value="<?php echo $urun['urun_id']; ?>">
                            <input name="kullanici_id" type="hidden" value="<?php echo isset($kullanicicek['kullanici_id']) ? $kullanicicek['kullanici_id'] : ''; ?>">
                            <input name="quantity" type="hidden" value="1">
                            <button name="sepetekle" class="btn btn-dark btn-block" style="border-radius: 5px;">
                                <i class="fa fa-shopping-basket mr-2"></i> Sepete Ekle
                            </button>
                        </form>
                        <?php else: ?>
                        <button disabled class="btn btn-secondary btn-block">
                            <i class="fa fa-times mr-2"></i> Stokta Yok
                        </button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    
    <!-- Sayfalama -->
    <?php if($toplam_sayfa > 1): ?>
    <div class="row mt-4">
        <div class="col-12">
            <nav aria-label="Page navigation">
                <ul class="pagination justify-content-center">
                    <?php if($sayfa > 1): ?>
                    <li class="page-item">
                        <a class="page-link" href="arama.php?q=<?php echo urlencode($aranan); ?>&sayfa=1">
                            <i class="fa fa-angle-double-left"></i>
                        </a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="arama.php?q=<?php echo urlencode($aranan); ?>&sayfa=<?php echo $sayfa-1; ?>">
                            <i class="fa fa-angle-left"></i>
                        </a>
                    </li>
                    <?php endif; ?>
                    
                    <?php
                    $baslangic = max(1, $sayfa - 2);
                    $bitis = min($baslangic + 4, $toplam_sayfa);
                    
                    for($i = $baslangic; $i <= $bitis; $i++): ?>
                        <li class="page-item <?php echo $i == $sayfa ? 'active' : ''; ?>">
                            <a class="page-link" href="arama.php?q=<?php echo urlencode($aranan); ?>&sayfa=<?php echo $i; ?>"><?php echo $i; ?></a>
                        </li>
                    <?php endfor; ?>
                    
                    <?php if($sayfa < $toplam_sayfa): ?>
                    <li class="page-item">
                        <a class="page-link" href="arama.php?q=<?php echo urlencode($aranan); ?>&sayfa=<?php echo $sayfa+1; ?>">
                            <i class="fa fa-angle-right"></i>
                        </a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="arama.php?q=<?php echo urlencode($aranan); ?>&sayfa=<?php echo $toplam_sayfa; ?>">
                            <i class="fa fa-angle-double-right"></i>
                        </a>
                    </li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </div>
    <?php endif; ?>
    
    <?php else: ?>
    <!-- Sonuç bulunamadığında -->
    <div class="row">
        <div class="col-12">
            <div class="alert alert-info">
                <h4 class="alert-heading"><i class="fa fa-info-circle mr-2"></i> Sonuç bulunamadı</h4>
                <p>Arama kriterinize uygun ürün bulunamadı. Lütfen farklı bir arama terimi deneyin veya kategorilerimizi gözden geçirin.</p>
                <hr>
                <p class="mb-0">
                    <a href="index.php" class="btn btn-dark mt-2">
                        <i class="fa fa-home mr-2"></i> Anasayfa'ya Dön
                    </a>
                </p>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>

<style>
.product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
}

.page-link {
    color: #1f1f1f;
}

.page-item.active .page-link {
    background-color: #1f1f1f;
    border-color: #1f1f1f;
}

body {
     background-color: white !important; 
}

</style>

<?php include 'footer.php'; ?>
