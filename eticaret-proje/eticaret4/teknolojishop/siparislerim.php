<?php 
include 'header.php';

// Kullanıcı giriş kontrolü
if(!isset($_SESSION['kullanici_mail'])) {
    header("Location:uye-giris.php?durum=girisyap");
    exit;
}

// Sipariş ID'si var mı kontrol et
$siparis_id = isset($_GET['siparis_id']) ? intval($_GET['siparis_id']) : null;

// Siparişleri getir
if ($siparis_id) {
    // Tek bir siparişin detayını getir
    $siparissor = $db->prepare("SELECT s.*, sd.* FROM siparis s 
                              INNER JOIN siparis_durumlari sd ON s.siparis_durum_id = sd.durum_id
                              WHERE s.siparis_id = :siparis_id AND s.kullanici_id = :kullanici_id");
    $siparissor->execute([
        'siparis_id' => $siparis_id,
        'kullanici_id' => $kullanicicek['kullanici_id']
    ]);
    $siparis = $siparissor->fetch(PDO::FETCH_ASSOC);
    
    // Sipariş detayını getir
    $siparis_detaysor = $db->prepare("SELECT sd.*, u.urun_adi, u.urun_resim1 
                                    FROM siparis_detay sd 
                                    INNER JOIN urun u ON sd.urun_id = u.urun_id 
                                    WHERE sd.siparis_id = :siparis_id");
    $siparis_detaysor->execute(['siparis_id' => $siparis_id]);
    $siparis_detaylari = $siparis_detaysor->fetchAll(PDO::FETCH_ASSOC);
} else {
    // Tüm siparişleri getir
    $siparissor = $db->prepare("SELECT s.*, sd.durum_adi, sd.durum_renk FROM siparis s 
                              INNER JOIN siparis_durumlari sd ON s.siparis_durum_id = sd.durum_id
                              WHERE s.kullanici_id = :kullanici_id 
                              ORDER BY s.siparis_zaman DESC");
    $siparissor->execute(['kullanici_id' => $kullanicicek['kullanici_id']]);
    $siparisler = $siparissor->fetchAll(PDO::FETCH_ASSOC);
}
?>

<div class="users_main_div" style="background-color: #fff; font-family: 'Poppins',sans-serif;">
    <div class="user_subpage_div">
        <div class="user_page_header_subpage" style="padding: 15px; background-color: #f8f9fa; border-bottom: 1px solid #e9ecef; margin-bottom: 20px;">
            <i class="las la-angle-double-right" style="color: #999;"></i>
            <a href="index.php" style="color: #1f1f1f;">Anasayfa</a>
            <i class="las la-angle-double-right" style="color: #999;"></i>
            <a href="siparislerim.php" style="color: #1f1f1f;">Siparişlerim</a>
            <?php if($siparis_id): ?>
            <i class="las la-angle-double-right" style="color: #999;"></i>
            <a href="siparislerim.php?siparis_id=<?php echo $siparis_id; ?>" style="color: #1f1f1f;">Sipariş #<?php echo $siparis_id; ?></a>
            <?php endif; ?>
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
                                        <i class="fa fa-user mr-2"></i> Profilim
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link active" href="siparislerim.php" style="color: #1f1f1f; font-weight: bold;">
                                        <i class="fa fa-shopping-bag mr-2"></i> Siparişlerim
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="favorilerim.php" style="color: #666;">
                                        <i class="fa fa-heart-o mr-2"></i> Favorilerim
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="adreslerim.php" style="color: #666;">
                                        <i class="fa fa-map-marker mr-2"></i> Adreslerim
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="cikis.php" style="color: #666;">
                                        <i class="fa fa-sign-out mr-2"></i> Çıkış Yap
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <!-- Sağ içerik - Sipariş listesi veya detayı -->
                <div class="col-md-9">
                    <?php if($siparis_id && isset($siparis)): // Sipariş detay görünümü ?>
                    
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-dark text-white" style="background-color: #1f1f1f !important; border-color: #1f1f1f;">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="mb-0"><i class="fa fa-file-text-o mr-2"></i> Sipariş #<?php echo $siparis_id; ?> Detayı</h5>
                                <span class="badge badge-<?php echo $siparis['durum_renk']; ?>"><?php echo $siparis['durum_adi']; ?></span>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <h6 class="text-muted">Sipariş Bilgileri</h6>
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-sm">
                                            <tr>
                                                <th style="width: 40%;">Sipariş Tarihi</th>
                                                <td><?php echo date("d.m.Y H:i", strtotime($siparis['siparis_zaman'])); ?></td>
                                            </tr>
                                            <tr>
                                                <th>Sipariş No</th>
                                                <td><?php echo $siparis['siparis_no']; ?></td>
                                            </tr>
                                            <tr>
                                                <th>Ödeme Türü</th>
                                                <td><?php echo $siparis['siparis_tip']; ?></td>
                                            </tr>
                                            <tr>
                                                <th>Ödeme Durumu</th>
                                                <td>
                                                    <?php if($siparis['siparis_odeme'] == '1'): ?>
                                                    <span class="badge badge-success">Ödendi</span>
                                                    <?php else: ?>
                                                    <span class="badge badge-warning">Ödenmedi</span>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Toplam Tutar</th>
                                                <td class="font-weight-bold"><?php echo number_format($siparis['siparis_toplam'], 2, ',', '.'); ?> TL</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <h6 class="text-muted">Teslimat Bilgileri</h6>
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-sm">
                                            <tr>
                                                <th style="width: 40%;">Ad Soyad</th>
                                                <td><?php echo $kullanicicek['kullanici_adsoyad']; ?></td>
                                            </tr>
                                            <tr>
                                                <th>Telefon</th>
                                                <td><?php echo $kullanicicek['kullanici_gsm']; ?></td>
                                            </tr>
                                            <tr>
                                                <th>Adres</th>
                                                <td><?php echo $kullanicicek['kullanici_adres']; ?></td>
                                            </tr>
                                            <tr>
                                                <th>İl / İlçe</th>
                                                <td><?php echo $kullanicicek['kullanici_il'].' / '.$kullanicicek['kullanici_ilce']; ?></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            
                            <h6 class="text-muted mb-3">Sipariş Ürünleri</h6>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="thead-light">
                                        <tr>
                                            <th style="width: 80px;">Görsel</th>
                                            <th>Ürün</th>
                                            <th style="width: 100px;" class="text-center">Adet</th>
                                            <th style="width: 140px;" class="text-right">Birim Fiyat</th>
                                            <th style="width: 140px;" class="text-right">Toplam</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($siparis_detaylari as $urun): ?>
                                        <tr>
                                            <td>
                                                <img src="<?php echo $urun['urun_resim1']; ?>" alt="<?php echo $urun['urun_adi']; ?>" class="img-thumbnail" style="width: 60px;">
                                            </td>
                                            <td class="align-middle"><?php echo $urun['urun_adi']; ?></td>
                                            <td class="text-center align-middle"><?php echo $urun['urun_adet']; ?></td>
                                            <td class="text-right align-middle"><?php echo number_format($urun['urun_fiyat'], 2, ',', '.'); ?> TL</td>
                                            <td class="text-right align-middle font-weight-bold"><?php echo number_format($urun['urun_fiyat'] * $urun['urun_adet'], 2, ',', '.'); ?> TL</td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="4" class="text-right"><strong>Toplam Tutar:</strong></td>
                                            <td class="text-right font-weight-bold"><?php echo number_format($siparis['siparis_toplam'], 2, ',', '.'); ?> TL</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            
                            <div class="text-right mt-3">
                                <a href="siparislerim.php" class="btn btn-secondary">
                                    <i class="fa fa-arrow-left mr-1"></i> Siparişlerime Dön
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <?php else: // Sipariş listesi görünümü ?>
                    
                    <div class="card shadow-sm">
                        <div class="card-header bg-dark text-white" style="background-color: #1f1f1f !important; border-color: #1f1f1f;">
                            <h5 class="mb-0"><i class="fa fa-shopping-bag mr-2"></i> Siparişlerim</h5>
                        </div>
                        <div class="card-body">
                            <?php if(count($siparisler) > 0): ?>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Sipariş No</th>
                                            <th>Tarih</th>
                                            <th>Tutar</th>
                                            <th>Ödeme Türü</th>
                                            <th>Durum</th>
                                            <th class="text-center">İşlemler</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($siparisler as $siparis): ?>
                                        <tr>
                                            <td class="align-middle">#<?php echo $siparis['siparis_no']; ?></td>
                                            <td class="align-middle"><?php echo date("d.m.Y", strtotime($siparis['siparis_zaman'])); ?></td>
                                            <td class="align-middle"><?php echo number_format($siparis['siparis_toplam'], 2, ',', '.'); ?> TL</td>
                                            <td class="align-middle"><?php echo $siparis['siparis_tip']; ?></td>
                                            <td class="align-middle">
                                                <span class="badge badge-<?php echo $siparis['durum_renk']; ?>"><?php echo $siparis['durum_adi']; ?></span>
                                            </td>
                                            <td class="text-center align-middle">
                                                <a href="siparislerim.php?siparis_id=<?php echo $siparis['siparis_id']; ?>" class="btn btn-sm btn-info">
                                                    <i class="fa fa-eye"></i> Detay
                                                </a>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                            <?php else: ?>
                            <div class="text-center py-5">
                                <i class="fa fa-shopping-basket fa-4x mb-3 text-muted"></i>
                                <h4 class="mb-3">Henüz Siparişiniz Bulunmuyor</h4>
                                <p class="text-muted mb-4">Siparişleriniz burada listelenecektir.</p>
                                <a href="index.php" class="btn btn-dark">
                                    <i class="fa fa-shopping-basket mr-2"></i> Alışverişe Başla
                                </a>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
