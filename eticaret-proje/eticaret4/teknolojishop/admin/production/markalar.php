<?php 
include 'header.php'; 

// Markalar listesini çek
$markasor = $db->prepare("SELECT * FROM marka ORDER BY marka_id DESC");
$markasor->execute();
?>

<div class="right_col" role="main">
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3>Marka Yönetimi</h3>
      </div>
    </div>

    <div class="clearfix"></div>

    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>Marka Listesi</h2>
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

            <!-- Yeni Marka Ekleme Butonu -->
            <div class="row" style="margin-bottom: 20px;">
              <div class="col-md-12 text-right">
                <a href="marka-ekle.php" class="btn btn-primary"><i class="fa fa-plus"></i> Yeni Marka Ekle</a>
              </div>
            </div>

            <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
              <thead>
                <tr>
                  <th>S.No</th>
                  <th>Marka Logosu</th>
                  <th>Marka Adı</th>
                  <th>Marka URL</th>
                  <th>İşlemler</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                $say = 0;
                while($markacek=$markasor->fetch(PDO::FETCH_ASSOC)) { 
                  $say++;
                ?>
                <tr>
                  <td><?php echo $say; ?></td>
                  <td>
                    <?php if (!empty($markacek['marka_resim'])): ?>
                      <img src="../../<?php echo $markacek['marka_resim']; ?>" width="100" alt="">
                    <?php else: ?>
                      <img src="../../images/no-image.jpg" width="100" alt="Resim Yok">
                    <?php endif; ?>
                  </td>
                  <td><?php echo $markacek['marka_adi']; ?></td>
                  <td><?php echo $markacek['marka_url']; ?></td>
                  <td width="120">
                    <a href="marka-duzenle.php?marka_id=<?php echo $markacek['marka_id']; ?>"><button class="btn btn-primary btn-xs">Düzenle</button></a>
                    <a href="../netting/islem.php?marka_id=<?php echo $markacek['marka_id']; ?>&markasil=ok" onclick="return confirm('Bu markayı silmek istediğinizden emin misiniz?');"><button class="btn btn-danger btn-xs">Sil</button></a>
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
