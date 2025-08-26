<?php include 'header.php'; 

// Sadece admin yetkisine sahip kullanıcıları çek (kullanici_yetki=5)
$kullanicisor = $db->prepare("SELECT k.*, s.sehir_ad, i.ilce_ad 
                             FROM kullanicilar k
                             LEFT JOIN sehir s ON k.kullanici_il = s.sehir_id
                             LEFT JOIN ilceler i ON k.kullanici_ilce = i.ilce_id
                             WHERE k.kullanici_yetki = :yetki 
                             ORDER BY k.kullanici_id DESC");
$kullanicisor->execute(['yetki' => 5]);
?>

<div class="right_col" role="main">
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3>Yönetici Yönetimi</h3>
      </div>
    </div>

    <div class="clearfix"></div>

    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>Yönetici Listesi</h2>
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
            <?php } else if (isset($_GET['durum']) && $_GET['durum'] == 'kendisilme') { ?>
              <div class="alert alert-warning alert-dismissible fade in" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                <strong>Uyarı!</strong> Kendi hesabınızı silemezsiniz.
              </div>
            <?php } ?>

            <!-- Yeni Yönetici Ekleme Butonu -->
            <div class="row" style="margin-bottom: 20px;">
              <div class="col-md-12 text-right">
                <a href="admin-ekle.php" class="btn btn-primary"><i class="fa fa-plus"></i> Yeni Yönetici Ekle</a>
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
                while($admincek=$kullanicisor->fetch(PDO::FETCH_ASSOC)) { 
                  $say++;
                ?>
                <tr>
                  <td><?php echo $say; ?></td>
                  <td><?php echo date('d.m.Y', strtotime($admincek['kullanici_zaman'])); ?></td>
                  <td><?php echo $admincek['kullanici_adsoyad']; ?></td>
                  <td><?php echo $admincek['kullanici_mail']; ?></td>
                  <td><?php echo $admincek['kullanici_gsm']; ?></td>
                  <td>
                    <?php if ($admincek['kullanici_durum'] == 1) { ?>
                      <button class="btn btn-success btn-xs">Aktif</button>
                    <?php } else { ?>
                      <button class="btn btn-danger btn-xs">Pasif</button>
                    <?php } ?>
                  </td>
                  <td width="120">
                    <a href="admin-duzenle.php?kullanici_id=<?php echo $admincek['kullanici_id']; ?>"><button class="btn btn-primary btn-xs">Düzenle</button></a>
                    <a href="../netting/islem.php?kullanici_id=<?php echo $admincek['kullanici_id']; ?>&kullanicisil=ok" onclick="return confirm('Bu admin kullanıcıyı silmek istediğinizden emin misiniz?');"><button class="btn btn-danger btn-xs">Sil</button></a>
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
