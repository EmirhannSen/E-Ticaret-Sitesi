<?php include 'header.php'; 

// Sadece normal kullanıcıları çek (müşteriler - yetki=1) - şehir ve ilçe adlarını da getir
$kullanicisor = $db->prepare("SELECT k.*, s.sehir_ad, i.ilce_ad 
                             FROM kullanicilar k
                             LEFT JOIN sehir s ON k.kullanici_il = s.sehir_id
                             LEFT JOIN ilceler i ON k.kullanici_ilce = i.ilce_id
                             WHERE k.kullanici_yetki = :yetki 
                             ORDER BY k.kullanici_id DESC");
$kullanicisor->execute(['yetki' => 1]);
?>

<div class="right_col" role="main">
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3>Müşteri Yönetimi</h3>
      </div>
    </div>

    <div class="clearfix"></div>

    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>Müşteri Listesi</h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <!-- Durum mesajları -->
            <?php if (isset($_GET['durum']) && $_GET['durum'] == 'ok') { ?>
              <div class="alert alert-success alert-dismissible fade in" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                <strong>Başarılı!</strong> İşlem başarıyla tamamlandı.
              </div>
            <?php } else if (isset($_GET['durum']) && $_GET['durum'] == 'no') { ?>
              <div class="alert alert-danger alert-dismissible fade in" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                <strong>Hata!</strong> İşlem sırasında bir sorun oluştu.
              </div>
            <?php } ?>

            <!-- Yeni Kullanıcı Ekleme Butonu -->
            <div class="row" style="margin-bottom: 20px;">
              <div class="col-md-12 text-right">
                <a href="kullanici-ekle.php" class="btn btn-primary"><i class="fa fa-plus"></i> Yeni Müşteri Ekle</a>
              </div>
            </div>

            <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
              <thead>
                <tr>
                  <th>S.No</th>
                  <th>Kayıt Tarihi</th>
                  <th>Ad Soyad</th>
                  <th>Mail Adresi</th>
                  <th>Telefon</th>
                  <th>Durum</th>
                  <th>İşlemler</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                $say = 0;
                while($kullanicicek=$kullanicisor->fetch(PDO::FETCH_ASSOC)) { 
                  $say++;
                ?>
                <tr>
                  <td><?php echo $say; ?></td>
                  <td><?php echo date('d.m.Y', strtotime($kullanicicek['kullanici_zaman'])); ?></td>
                  <td><?php echo $kullanicicek['kullanici_adsoyad']; ?></td>
                  <td><?php echo $kullanicicek['kullanici_mail']; ?></td>
                  <td><?php echo $kullanicicek['kullanici_gsm']; ?></td>
                  <td>
                    <?php if ($kullanicicek['kullanici_durum'] == 1) { ?>
                      <button class="btn btn-success btn-xs">Aktif</button>
                    <?php } else { ?>
                      <button class="btn btn-danger btn-xs">Pasif</button>
                    <?php } ?>
                  </td>
                  <td width="120">
                    <a href="kullanici-duzenle.php?kullanici_id=<?php echo $kullanicicek['kullanici_id']; ?>"><button class="btn btn-primary btn-xs">Düzenle</button></a>
                    <a href="../netting/islem.php?kullanici_id=<?php echo $kullanicicek['kullanici_id']; ?>&kullanicisil=ok" onclick="return confirm('Bu kullanıcıyı silmek istediğinizden emin misiniz?');"><button class="btn btn-danger btn-xs">Sil</button></a>
                  </td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include 'footer.php'; ?>
