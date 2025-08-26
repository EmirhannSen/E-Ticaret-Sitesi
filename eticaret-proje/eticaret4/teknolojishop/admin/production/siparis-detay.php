<?php 
include 'header.php';

// SQL sorgusunu düzenliyoruz
$siparisSor = $db->prepare("SELECT s.*, k.*, sd.durum_adi, sd.durum_renk, b.banka_logo 
                           FROM siparis s
                           INNER JOIN kullanicilar k ON s.kullanici_id = k.kullanici_id 
                           INNER JOIN siparis_durumlari sd ON s.siparis_durum_id = sd.durum_id
                           LEFT JOIN banka_hesaplari b ON s.siparis_banka = b.banka_ad
                           WHERE siparis_id=:id");
$siparisSor->execute(['id' => $_GET['siparis_id']]);
$siparisCek = $siparisSor->fetch(PDO::FETCH_ASSOC);

$siparisDetaySor = $db->prepare("SELECT sd.*, u.*
                                FROM siparis_detay sd 
                                INNER JOIN urun u ON sd.urun_id = u.urun_id
                                WHERE sd.siparis_id=:id");
$siparisDetaySor->execute(['id' => $_GET['siparis_id']]);
?>

<div class="right_col" role="main">
  <div class="x_panel">
    <!-- Üst Bilgi - Sipariş Başlık Tablosu (Başlıksız) -->
     <div class="col-md-12">
          <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title"><i class="fa fa-shopping-basket"></i> <?php echo $siparisCek['siparis_no']; ?></h3>
            </div>
            <div class="panel-body">
              <div class="table-responsive">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>Sipariş No</th>
                      <th>Sipariş Tarihi</th>
                      <th>Ödeme Tipi</th>
                      <th>Banka</th>
                      <th>Tutar</th>
                      <th>Durum</th>
                      <tbody>
                       <tr>
                        <td>
                          <div><?php echo $siparisCek['siparis_id'] ?></div>
                        </td> 
                        <td>
                          <div><?php echo date("d.m.Y H:i", strtotime($siparisCek['siparis_zaman'])); ?></div>
                        </td>       
                        <td>
                          <?php echo $siparisCek['siparis_tip']; ?>
                        </td>         

                        <td>
                          <?php if($siparisCek['banka_logo']){ ?>
                            <img src="../../images/banka/<?php echo $siparisCek['banka_logo']; ?>" width="50" style="margin-right:10px">
                             <?php } ?>
                            <?php echo $siparisCek['siparis_banka']; ?>
                        </td>
                        <td>
                          <?php echo number_format($siparisCek['siparis_toplam'], 2, ',', '.'); ?> TL
                        </td>
                        <td>
                          <span class="label label-<?php echo $siparisCek['durum_renk']; ?>">
                            <?php echo $siparisCek['durum_adi']; ?>
                          </span>
                        </td>
                      </tr>
                    </tr>
                  </tbody>
                </thead>    
                </table>
              </div>
            </div>
          </div>
        </div>
    <!-- Sipariş Bilgileri Tablosu -->


    
    <!-- İçerik -->
    <div class="x_content">
      <div class="row">
        <!-- Müşteri Bilgileri Paneli -->
        <div class="col-md-6">
          <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title"><i class="fa fa-user"></i> Müşteri Bilgileri</h3>
            </div>
            <div class="panel-body">
              <table class="table table-striped">
                <tr>
                  <td><strong>Ad Soyad:</strong></td>
                  <td><?php echo $siparisCek['kullanici_ad'] . ' ' . $siparisCek['kullanici_soyad']; ?></td>
                </tr>
                <tr>
                  <td><strong>E-posta:</strong></td>
                  <td><?php echo $siparisCek['kullanici_mail']; ?></td>
                </tr>
                <tr>
                  <td><strong>Telefon:</strong></td>
                  <td><?php echo $siparisCek['kullanici_gsm']; ?></td>
                </tr>
                <tr>
                  <td><strong>Şehir:</strong></td>
                  <td><?php echo $siparisCek['kullanici_il']; ?></td>
                </tr>
                <tr>
                  <td><strong>İlçe:</strong></td>
                  <td><?php echo $siparisCek['kullanici_ilce']; ?></td>
                </tr>
                <tr>
                  <td><strong>Adres:</strong></td>
                  <td>
                    <?php echo $siparisCek['kullanici_adres']; ?><br>
                  </td>
                </tr>
                <tr>
                  <td><strong>T.C. Kimlik No:</strong></td>
                  <td><?php echo $siparisCek['kullanici_tc']; ?></td>
                </tr>
              </table>
            </div>
          </div>
        </div>
        
        <!-- Sipariş Durum Güncelleme -->
        <div class="col-md-6">
          <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title"><i class="fa fa-tasks"></i> Sipariş Durumu</h3>
            </div>
            <div class="panel-body">
              <form action="../netting/islem.php" method="POST" class="form-horizontal">
              <input type="hidden" name="siparis_id" value="<?php echo $_GET['siparis_id']; ?>">
              
              <!-- Ödeme Durumu -->
              <div class="form-group">
                <label class="col-md-3 control-label">Ödeme Durumu:</label>
                <div class="col-md-9">
                <select name="siparis_odeme" class="form-control">
                  <option value="0" <?php echo $siparisCek['siparis_odeme'] == 0 ? 'selected' : ''; ?>>Ödenmedi</option>
                  <option value="1" <?php echo $siparisCek['siparis_odeme'] == 1 ? 'selected' : ''; ?>>Ödendi</option>
                </select>
                </div>
              </div>
              
              <!-- Sipariş Durumu -->
              <div class="form-group">
                <label class="col-md-3 control-label">Sipariş Durumu:</label>
                <div class="col-md-9">
                <select name="siparis_durum_id" class="form-control">
                  <?php 
                  $durumSor = $db->prepare("SELECT * FROM siparis_durumlari WHERE durum_aktif=1 ORDER BY durum_sira");
                  $durumSor->execute();
                  while($durumCek = $durumSor->fetch(PDO::FETCH_ASSOC)) { ?>
                  <option value="<?php echo $durumCek['durum_id']; ?>" 
                    <?php echo $durumCek['durum_id'] == $siparisCek['siparis_durum_id'] ? 'selected' : ''; ?>>
                    <?php echo $durumCek['durum_adi']; ?>
                  </option>
                  <?php } ?>
                </select>
                </div>
              </div>
              
              <!-- Güncelleme Butonu -->
              <div class="form-group">
                <div class="col-md-9 col-md-offset-3">
                <button type="submit" name="siparis_guncelle" value="1" class="btn btn-primary">
                  <i class="fa fa-save"></i> Tüm Durumları Güncelle
                </button>
                </div>
              </div>
              </form>
            </div>  
          </div>
        </div>
      </div>

      <!-- Sipariş Edilen Ürünler -->
      <div class="row">
        <div class="col-md-12">
          <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title"><i class="fa fa-shopping-basket"></i> Sipariş Edilen Ürünler</h3>
            </div>
            <div class="panel-body">
              <div class="table-responsive">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>Ürün</th>
                      <th>Ürün Kodu</th>
                      <th>Birim Fiyat</th>
                      <th>Adet</th>
                      <th class="text-right">Toplam</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php 
                    $toplam = 0;
                    while($urunCek = $siparisDetaySor->fetch(PDO::FETCH_ASSOC)) { 
                      $urunToplam = $urunCek['urun_fiyat'] * $urunCek['urun_adet'];
                      $toplam += $urunToplam;
                    ?>
                      <tr>
                        <td>
                          <img src="../../<?php echo $urunCek['urun_resim1']; ?>" width="50" style="margin-right:10px">
                          <?php echo $urunCek['urun_adi']; ?>
                        </td>
                        <td><?php echo $urunCek['urun_kodu']; ?></td>
                        <td><?php echo number_format($urunCek['urun_fiyat'], 2, ',', '.'); ?> TL</td>
                        <td><?php echo $urunCek['urun_adet']; ?></td>
                        <td class="text-right"><?php echo number_format($urunToplam, 2, ',', '.'); ?> TL</td>
                      </tr>
                    <?php } ?>
                    <tr>
                      <td colspan="4" class="text-right"><strong>Genel Toplam:</strong></td>
                      <td class="text-right"><strong><?php echo number_format($toplam, 2, ',', '.'); ?> TL</strong></td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include 'footer.php'; ?>
