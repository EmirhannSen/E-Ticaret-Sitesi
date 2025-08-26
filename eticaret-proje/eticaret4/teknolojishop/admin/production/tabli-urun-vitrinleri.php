<?php include 'header.php'; ?>

<div class="right_col" role="main">
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3>Tablı Ürün Vitrinleri</h3>
      </div>
    </div>
    <div class="clearfix"></div>

    <?php 
    // Durum mesajları
    if(isset($_GET['durum'])) {
      if($_GET['durum'] == "ok") { ?>
        <div class="alert alert-success alert-dismissible">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
          <h4><i class="icon fa fa-check"></i> İşlem Başarılı!</h4>
          İşlem başarıyla tamamlandı.
        </div>
      <?php } else if($_GET['durum'] == "no") { ?>
        <div class="alert alert-danger alert-dismissible">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
          <h4><i class="icon fa fa-ban"></i> Hata!</h4>
          İşlem sırasında bir hata oluştu.
        </div>
      <?php }
    } ?>
    
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>Tablı Ürün Vitrinleri</h2>
            <div class="clearfix"></div>
            <div align="right">
              <a href="tabli-urun-vitrin-ekle.php" class="btn btn-success btn-xs"><i class="fa fa-plus"></i> Yeni Ekle</a>
            </div>
          </div>
          <div class="x_content">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th style="width: 50px">ID</th>
                  <th>Vitrin Adı</th>
                  <th style="width: 100px">Sekme Sayısı</th>
                  <th style="width: 100px">Durum</th>
                  <th style="width: 200px">İşlemler</th>
                </tr>
              </thead>
              <tbody>
                <?php
                // Tablı vitrinleri listele
                $vitrinsor = $db->prepare("SELECT * FROM tabli_vitrin ORDER BY sira ASC");
                $vitrinsor->execute();
                
                while ($vitrincek = $vitrinsor->fetch(PDO::FETCH_ASSOC)) { 
                  // Sekme sayısını bul
                  $sekmesor = $db->prepare("SELECT COUNT(*) as toplam FROM tabli_vitrin_sekme WHERE tabli_vitrin_id = :id");
                  $sekmesor->execute(['id' => $vitrincek['id']]);
                  $sekmecek = $sekmesor->fetch(PDO::FETCH_ASSOC);
                ?>
                  <tr>
                    <td><?php echo $vitrincek['id']; ?></td>
                    <td><?php echo $vitrincek['ad']; ?></td>
                    <td>
                      <span class="badge bg-green"><?php echo $sekmecek['toplam']; ?> Sekme</span>
                    </td>
                    <td>
                      <?php if ($vitrincek['durum'] == 1) { ?>
                        <span class="label label-success">Aktif</span>
                      <?php } else { ?>
                        <span class="label label-danger">Pasif</span>
                      <?php } ?>
                    </td>
                    <td>
                      <a href="tabli-urun-vitrin-duzenle.php?id=<?php echo $vitrincek['id']; ?>" 
                         class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i> Düzenle</a>
                      <a href="../netting/islem.php?tabli_vitrin_sil=ok&id=<?php echo $vitrincek['id']; ?>" 
                         class="btn btn-danger btn-xs" onclick="return confirm('Bu tablı vitrini silmek istediğinize emin misiniz?')">
                         <i class="fa fa-trash"></i> Sil</a>
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
