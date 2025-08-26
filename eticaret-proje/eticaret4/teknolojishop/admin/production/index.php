<?php 
include 'header.php';

// İstatistik sorguları
// Toplam sipariş sayısı
$siparisSay = $db->prepare("SELECT COUNT(*) as toplam FROM siparis");
$siparisSay->execute();
$siparisCount = $siparisSay->fetch(PDO::FETCH_ASSOC)['toplam'];

// Bugünkü sipariş sayısı
$bugunSiparis = $db->prepare("SELECT COUNT(*) as toplam FROM siparis WHERE DATE(siparis_zaman) = CURDATE()");
$bugunSiparis->execute();
$bugunSiparisCount = $bugunSiparis->fetch(PDO::FETCH_ASSOC)['toplam'];

// Toplam ürün sayısı
$urunSay = $db->prepare("SELECT COUNT(*) as toplam FROM urun WHERE urun_durum = '1'");
$urunSay->execute();
$urunCount = $urunSay->fetch(PDO::FETCH_ASSOC)['toplam'];

// Toplam kullanıcı sayısı
$kullaniciSay = $db->prepare("SELECT COUNT(*) as toplam FROM kullanicilar WHERE kullanici_yetki=1 AND kullanici_durum='1'");
$kullaniciSay->execute();
$kullaniciCount = $kullaniciSay->fetch(PDO::FETCH_ASSOC)['toplam'];

// Toplam ciro hesaplama
$ciroSay = $db->prepare("SELECT SUM(siparis_toplam) as toplam FROM siparis");
$ciroSay->execute();
$ciroTotal = $ciroSay->fetch(PDO::FETCH_ASSOC)['toplam'] ?: 0;

// Stok durumu kritik olan ürünler (10'dan az)
$kritikStok = $db->prepare("SELECT * FROM urun WHERE urun_stok < 10 AND urun_durum = '1' ORDER BY urun_stok ASC LIMIT 5");
$kritikStok->execute();

// Son 5 sipariş
$sonSiparisler = $db->prepare("SELECT s.*, k.kullanici_adsoyad, sd.durum_adi, sd.durum_renk 
                               FROM siparis s 
                               LEFT JOIN kullanicilar k ON s.kullanici_id = k.kullanici_id 
                               LEFT JOIN siparis_durumlari sd ON s.siparis_durum_id = sd.durum_id 
                               ORDER BY s.siparis_zaman DESC LIMIT 5");
$sonSiparisler->execute();

// Son 5 kullanıcı
$sonKullanicilar = $db->prepare("SELECT * FROM kullanicilar WHERE kullanici_yetki=1 ORDER BY kullanici_zaman DESC LIMIT 5");
$sonKullanicilar->execute();

// Çok satılan ürünler (sipariş detaylarından)
$cokSatanlar = $db->prepare("SELECT u.urun_id, u.urun_adi, u.urun_resim1, COUNT(sd.urun_id) as satis_sayisi 
                            FROM siparis_detay sd
                            INNER JOIN urun u ON sd.urun_id = u.urun_id
                            GROUP BY sd.urun_id
                            ORDER BY satis_sayisi DESC
                            LIMIT 5");
$cokSatanlar->execute();

// Sipariş durumlarına göre analiz
$siparisDurumlari = $db->prepare("SELECT sd.durum_adi, sd.durum_renk, COUNT(s.siparis_id) as adet 
                                 FROM siparis s
                                 LEFT JOIN siparis_durumlari sd ON s.siparis_durum_id = sd.durum_id
                                 GROUP BY s.siparis_durum_id
                                 ORDER BY adet DESC");
$siparisDurumlari->execute();

// Toplam işlem sayısını hesapla (istatistik kartları için)
$toplamIslem = $siparisCount + $urunCount + $kullaniciCount;
?>

<!-- Dashboard Stili -->
<style>
  /* Dashboard Genel Stiller */
  .dash-stat-card {
    color: #fff;
    padding: 20px;
    border-radius: 5px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    margin-bottom: 20px;
    position: relative;
    overflow: hidden;
    transition: all 0.3s ease;
  }
  
  .dash-stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
  }
  
  .dash-stat-icon {
    position: absolute;
    right: 20px;
    top: 20px;
    font-size: 48px;
    opacity: 0.3;
  }
  
  .dash-stat-title {
    font-size: 14px;
    font-weight: 400;
    margin-bottom: 10px;
  }
  
  .dash-stat-count {
    font-size: 26px;
    font-weight: 600;
    margin-bottom: 10px;
  }
  
  .dash-stat-footer {
    font-size: 12px;
    opacity: 0.8;
  }
  
  .bg-primary-gradient {
    background: #2A3F54;
    background: linear-gradient(135deg, #2A3F54 0%, #47586f 100%);
  }
  
  .bg-success-gradient {
    background: #26B99A;
    background: linear-gradient(135deg, #26B99A 0%, #4ad3b8 100%);
  }
  
  .bg-info-gradient {
    background: #3498DB;
    background: linear-gradient(135deg, #3498DB 0%, #5faee3 100%);
  }
  
  .bg-warning-gradient {
    background: #F39C12;
    background: linear-gradient(135deg, #F39C12 0%, #f7b54a 100%);
  }
  
  .bg-danger-gradient {
    background: #E74C3C;
    background: linear-gradient(135deg, #E74C3C 0%, #ed7669 100%);
  }
  
  /* Panel Stilleri */
  .dash-panel {
    background: #fff;
    border-radius: 5px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    margin-bottom: 20px;
  }
  
  .dash-panel-header {
    padding: 15px 20px;
    border-bottom: 1px solid #f1f1f1;
    display: flex;
    justify-content: space-between;
    align-items: center;
  }
  
  .dash-panel-title {
    font-size: 16px;
    font-weight: 600;
    color: #2A3F54;
    margin: 0;
  }
  
  .dash-panel-body {
    padding: 20px;
  }
  
  .dash-panel-footer {
    padding: 10px 20px;
    border-top: 1px solid #f1f1f1;
    text-align: right;
  }
  
  /* Tablo Stilleri */
  .dash-table th {
    background: #f8f9fa;
    color: #2A3F54;
    font-weight: 600;
  }
  
  .dash-table td, .dash-table th {
    padding: 12px 15px;
    vertical-align: middle;
  }
  
  /* Durum Badge'leri */
  .dash-status {
    display: inline-block;
    padding: 5px 10px;
    border-radius: 50px;
    font-size: 12px;
    font-weight: 500;
    color: white;
  }
  
  /* Listeler */
  .dash-list {
    list-style: none;
    padding: 0;
    margin: 0;
  }
  
  .dash-list-item {
    padding: 12px 20px; /* Yatay padding artırıldı - kenarlara boşluk eklendi */
    border-bottom: 1px solid #f1f1f1;
    display: flex;
    align-items: center;
  }
  
  .dash-list-item:last-child {
    border-bottom: none;
  }
  
  .dash-list-icon {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: #f8f9fa;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 15px;
    overflow: hidden;
    flex-shrink: 0; /* İkon boyutunun küçülmemesi için */
  }
  
  .dash-list-content {
    flex: 1;
    min-width: 0; /* Taşma sorunlarını önlemek için */
  }
  
  .dash-list-title {
    font-weight: 500;
    margin-bottom: 3px;
    font-size: 14px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis; /* Uzun metinler için ... ile kısaltma */
  }
  
  .dash-list-subtitle {
    color: #7f8c8d;
    font-size: 12px;
  }
  
  .dash-list-action {
    margin-left: 10px;
    flex-shrink: 0; /* Butonun küçülmemesi için */
  }
  
  /* Boş Durum */
  .dash-empty {
    padding: 30px;
    text-align: center;
    color: #7f8c8d;
  }
  
  .dash-empty i {
    font-size: 42px;
    margin-bottom: 10px;
    color: #dfe6e9;
  }
  
  /* İlerleme Çubukları */
  .dash-progress {
    height: 8px;
    margin-top: 8px;
    margin-bottom: 10px;
    overflow: hidden;
    background-color: #f1f1f1;
    border-radius: 4px;
  }
  
  .dash-progress-bar {
    height: 100%;
    border-radius: 4px;
  }

  /* Sol menü düzeltmesi için ek stiller */
  .left_col, .nav_menu {
    /*position: fixed !important;
    z-index: 999;*/
  }
  
  .left_col {
    width: inherit;
    min-height: 100%;
    top: 0;
    bottom: 0;
  }
  
  .nav_menu {
   /* position: fixed;*/
    width: 100%;
   /* z-index: 998;*/
  }
  
  .main_container .top_nav {
    margin-left: 230px;
    z-index: 997;
  }
  
  body .container.body .right_col {
    margin-top: 60px;
    padding-top: 80px !important;
    min-height: calc(100vh - 60px) !important;
  }
  
  @media (max-width: 991px) {
    .nav-md .container.body .right_col, .nav-md .container.body .top_nav {
      width: 100%;
      margin: 0;
    }
    
    .nav-md .container.body .right_col {
      padding-top: 70px !important;
    }
  }
  
  /* Sipariş durumları görünüm düzenlemesi */
  .durum-progress-item {
    margin-bottom: 15px;
    padding: 0 10px;
  }
</style>

<!-- page content -->
<div class="right_col" role="main">
  <div class="page-title">
    <div class="title_left">
      <h3>Dashboard</h3>
    </div>
    <div class="title_right">
      <div class="pull-right">
        <span class="text-muted"><i class="fa fa-clock-o"></i> Son güncelleme: <?php echo date('d.m.Y H:i'); ?></span>
      </div>
    </div>
  </div>
  
  <div class="clearfix"></div>
  
  <!-- Üst İstatistik Kartları -->
  <div class="row">
    <div class="col-lg-3 col-md-6 col-sm-6">
      <div class="dash-stat-card bg-primary-gradient">
        <div class="dash-stat-icon"><i class="fa fa-shopping-cart"></i></div>
        <h5 class="dash-stat-title">TOPLAM SİPARİŞ</h5>
        <h2 class="dash-stat-count"><?php echo number_format($siparisCount); ?></h2>
        <div class="dash-stat-footer">
          <i class="fa fa-calendar"></i> Bugün: <?php echo $bugunSiparisCount; ?> yeni sipariş
        </div>
      </div>
    </div>
    
    <div class="col-lg-3 col-md-6 col-sm-6">
      <div class="dash-stat-card bg-success-gradient">
        <div class="dash-stat-icon"><i class="fa fa-users"></i></div>
        <h5 class="dash-stat-title">TOPLAM MÜŞTERİ</h5>
        <h2 class="dash-stat-count"><?php echo number_format($kullaniciCount); ?></h2>
        <div class="dash-stat-footer">
          <i class="fa fa-user-plus"></i> Aktif müşteri hesapları
        </div>
      </div>
    </div>
    
    <div class="col-lg-3 col-md-6 col-sm-6">
      <div class="dash-stat-card bg-info-gradient">
        <div class="dash-stat-icon"><i class="fa fa-cubes"></i></div>
        <h5 class="dash-stat-title">ÜRÜN SAYISI</h5>
        <h2 class="dash-stat-count"><?php echo number_format($urunCount); ?></h2>
        <div class="dash-stat-footer">
          <i class="fa fa-check-circle"></i> Aktif ürünler
        </div>
      </div>
    </div>
    
    <div class="col-lg-3 col-md-6 col-sm-6">
      <div class="dash-stat-card bg-warning-gradient">
        <div class="dash-stat-icon"><i class="fa fa-money"></i></div>
        <h5 class="dash-stat-title">TOPLAM SATIŞ</h5>
        <h2 class="dash-stat-count"><?php echo number_format($ciroTotal, 2, ',', '.'); ?> ₺</h2>
        <div class="dash-stat-footer">
          <i class="fa fa-bar-chart"></i> Toplam ciro
        </div>
      </div>
    </div>
  </div>
  
  <!-- Ana İçerik Bölümü -->
  <div class="row">
    <!-- Son Siparişler -->
    <div class="col-md-8">
      <div class="dash-panel">
        <div class="dash-panel-header">
          <h4 class="dash-panel-title"><i class="fa fa-shopping-cart"></i> Son Siparişler</h4>
          <div>
            <a href="siparisler.php" class="btn btn-default btn-sm">Tümünü Gör <i class="fa fa-arrow-right"></i></a>
          </div>
        </div>
        <div class="dash-panel-body" style="padding: 0;">
          <div class="table-responsive">
            <table class="table table-hover dash-table">
              <thead>
                <tr>
                  <th style="width: 50px">Sip. No</th>
                  <th>Müşteri</th>
                  <th>Tarih</th>
                  <th style="width: 120px">Tutar</th>
                  <th style="width: 120px">Durum</th>
                  <th style="width: 80px">İşlem</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                if($sonSiparisler->rowCount() == 0) { 
                  echo '<tr><td colspan="6"><div class="dash-empty"><i class="fa fa-info-circle"></i><p>Henüz sipariş bulunmamaktadır.</p></div></td></tr>';
                } else {
                  while($siparis = $sonSiparisler->fetch(PDO::FETCH_ASSOC)) { 
                    $durum_renk = !empty($siparis['durum_renk']) ? $siparis['durum_renk'] : '#999';
                    $durum_adi = !empty($siparis['durum_adi']) ? $siparis['durum_adi'] : 'Beklemede';
                ?>
                <tr>
                  <td><strong>#<?php echo $siparis['siparis_id']; ?></strong></td>
                  <td><?php echo $siparis['kullanici_adsoyad']; ?></td>
                  <td><?php echo date('d.m.Y H:i', strtotime($siparis['siparis_zaman'])); ?></td>
                  <td><strong><?php echo number_format($siparis['siparis_toplam'], 2, ',', '.'); ?> ₺</strong></td>
                  <td><span class="dash-status" style="background-color: <?php echo $durum_renk; ?>;"><?php echo $durum_adi; ?></span></td>
                  <td>
                    <a href="siparis-detay.php?siparis_id=<?php echo $siparis['siparis_id']; ?>" class="btn btn-primary btn-xs"><i class="fa fa-eye"></i></a>
                  </td>
                </tr>
                <?php 
                  }
                } 
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Sağ Sütun -->
    <div class="col-md-4">
      <!-- Kritik Stok Uyarıları -->
      <div class="dash-panel">
        <div class="dash-panel-header">
          <h4 class="dash-panel-title"><i class="fa fa-exclamation-triangle"></i> Kritik Stok</h4>
        </div>
        <div class="dash-panel-body" style="padding: 0;">
          <?php if($kritikStok->rowCount() == 0) { ?>
            <div class="dash-empty">
              <i class="fa fa-check-circle"></i>
              <p>Kritik stok seviyesinde ürün bulunmamaktadır.</p>
            </div>
          <?php } else { ?>
            <ul class="dash-list">
              <?php while($urun = $kritikStok->fetch(PDO::FETCH_ASSOC)) { ?>
                <li class="dash-list-item">
                  <div class="dash-list-content">
                    <div class="dash-list-title">
                      <a href="urun-duzenle.php?urun_id=<?php echo $urun['urun_id']; ?>"><?php echo $urun['urun_adi']; ?></a>
                    </div>
                    <div class="dash-list-subtitle">
                      Kalan Stok: 
                      <?php if($urun['urun_stok'] <= 3) { ?>
                        <span class="label label-danger"><?php echo $urun['urun_stok']; ?></span>
                      <?php } else { ?>
                        <span class="label label-warning"><?php echo $urun['urun_stok']; ?></span>
                      <?php } ?>
                    </div>
                  </div>
                  <div class="dash-list-action">
                    <a href="urun-duzenle.php?urun_id=<?php echo $urun['urun_id']; ?>" class="btn btn-default btn-xs">
                      <i class="fa fa-pencil"></i>
                    </a>
                  </div>
                </li>
              <?php } ?>
            </ul>
          <?php } ?>
        </div>
        <?php if($kritikStok->rowCount() > 0) { ?>
          <div class="dash-panel-footer">
            <a href="urun.php" class="btn btn-warning btn-sm">Stok Yönetimi</a>
          </div>
        <?php } ?>
      </div>
      
      <!-- Sipariş Durum Özeti -->
      <div class="dash-panel">
        <div class="dash-panel-header">
          <h4 class="dash-panel-title"><i class="fa fa-pie-chart"></i> Sipariş Durumları</h4>
        </div>
        <div class="dash-panel-body">
          <?php 
          if($siparisDurumlari->rowCount() == 0) { 
            echo '<div class="dash-empty"><i class="fa fa-info-circle"></i><p>Henüz sipariş verisi bulunmamaktadır.</p></div>';
          } else {
            // Toplam sipariş sayısını bul
            $toplamSiparis = 0;
            $durumlar = $siparisDurumlari->fetchAll(PDO::FETCH_ASSOC);
            foreach($durumlar as $d) {
              $toplamSiparis += $d['adet'];
            }
            
            // Her bir durumun yüzdesini hesapla
            foreach($durumlar as $durum) { 
              $durum_renk = !empty($durum['durum_renk']) ? $durum['durum_renk'] : '#999';
              $durum_adi = !empty($durum['durum_adi']) ? $durum['durum_adi'] : 'Belirsiz';
              $yuzde = $toplamSiparis > 0 ? round(($durum['adet'] / $toplamSiparis) * 100) : 0;
          ?>
            <div class="durum-progress-item">
              <div style="display: flex; justify-content: space-between; align-items: center;">
                <div style="display: flex; align-items: center;">
                  <span style="display: inline-block; width: 12px; height: 12px; border-radius: 50%; background-color: <?php echo $durum_renk; ?>; margin-right: 8px;"></span>
                  <span style="font-weight: 500;"><?php echo $durum_adi; ?></span>
                </div>
                <div>
                  <span style="font-weight: 600;"><?php echo $durum['adet']; ?></span>
                  <span class="text-muted">(<?php echo $yuzde; ?>%)</span>
                </div>
              </div>
              <div class="dash-progress">
                <div class="dash-progress-bar" style="width: <?php echo $yuzde; ?>%; background-color: <?php echo $durum_renk; ?>;"></div>
              </div>
            </div>
          <?php 
            }
          } 
          ?>
        </div>
      </div>
    </div>
  </div>
  
  <!-- Alt Bölüm: Çok Satan ve Son Kullanıcılar -->
  <div class="row">
    <!-- Çok Satan Ürünler -->
    <div class="col-md-6">
      <div class="dash-panel">
        <div class="dash-panel-header">
          <h4 class="dash-panel-title"><i class="fa fa-star"></i> Çok Satan Ürünler</h4>
        </div>
        <div class="dash-panel-body" style="padding: 0;">
          <?php if($cokSatanlar->rowCount() == 0) { ?>
            <div class="dash-empty">
              <i class="fa fa-info-circle"></i>
              <p>Henüz satış verisi bulunmamaktadır.</p>
            </div>
          <?php } else { ?>
            <ul class="dash-list">
              <?php while($urun = $cokSatanlar->fetch(PDO::FETCH_ASSOC)) { ?>
                <li class="dash-list-item">
                  <div class="dash-list-icon">
                    <?php if(!empty($urun['urun_resim1'])) { ?>
                      <img src="../../<?php echo $urun['urun_resim1']; ?>" alt="<?php echo $urun['urun_adi']; ?>" style="max-width: 100%; max-height: 100%;">
                    <?php } else { ?>
                      <i class="fa fa-cube"></i>
                    <?php } ?>
                  </div>
                  <div class="dash-list-content">
                    <div class="dash-list-title"><?php echo $urun['urun_adi']; ?></div>
                    <div class="dash-list-subtitle">
                      <span class="label label-info"><?php echo $urun['satis_sayisi']; ?> Satış</span>
                    </div>
                  </div>
                  <div class="dash-list-action">
                    <a href="urun-duzenle.php?urun_id=<?php echo $urun['urun_id']; ?>" class="btn btn-default btn-xs">
                      <i class="fa fa-pencil"></i>
                    </a>
                  </div>
                </li>
              <?php } ?>
            </ul>
          <?php } ?>
        </div>
      </div>
    </div>
    
    <!-- Son Müşteriler -->
    <div class="col-md-6">
      <div class="dash-panel">
        <div class="dash-panel-header">
          <h4 class="dash-panel-title"><i class="fa fa-user-plus"></i> Son Kayıt Olan Müşteriler</h4>
          <div>
            <a href="kullanici.php" class="btn btn-default btn-sm">Tümünü Gör <i class="fa fa-arrow-right"></i></a>
          </div>
        </div>
        <div class="dash-panel-body" style="padding: 0;">
          <?php if($sonKullanicilar->rowCount() == 0) { ?>
            <div class="dash-empty">
              <i class="fa fa-info-circle"></i>
              <p>Henüz müşteri kaydı bulunmamaktadır.</p>
            </div>
          <?php } else { ?>
            <ul class="dash-list">
              <?php while($kullanici = $sonKullanicilar->fetch(PDO::FETCH_ASSOC)) { ?>
                <li class="dash-list-item">
                  <div class="dash-list-icon">
                    <?php if(!empty($kullanici['kullanici_resim'])) { ?>
                      <img src="../../<?php echo $kullanici['kullanici_resim']; ?>" alt="Profil" style="max-width: 100%; max-height: 100%;">
                    <?php } else { ?>
                      <i class="fa fa-user"></i>
                    <?php } ?>
                  </div>
                  <div class="dash-list-content">
                    <div class="dash-list-title"><?php echo $kullanici['kullanici_adsoyad']; ?></div>
                    <div class="dash-list-subtitle"><?php echo $kullanici['kullanici_mail']; ?></div>
                  </div>
                  <div class="dash-list-action">
                    <a href="kullanici-duzenle.php?kullanici_id=<?php echo $kullanici['kullanici_id']; ?>" class="btn btn-default btn-xs">
                      <i class="fa fa-pencil"></i>
                    </a>
                  </div>
                </li>
              <?php } ?>
            </ul>
          <?php } ?>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- /page content -->

<?php include 'footer.php'; ?>