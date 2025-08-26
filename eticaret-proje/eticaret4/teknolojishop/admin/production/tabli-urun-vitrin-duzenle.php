<?php include 'header.php';

// Tablı vitrin bilgilerini çek
$id = $_GET['id'];
$vitrinsor = $db->prepare("SELECT * FROM tabli_vitrin WHERE id = :id");
$vitrinsor->execute(['id' => $id]);
$vitrincek = $vitrinsor->fetch(PDO::FETCH_ASSOC);

// Vitrin bulunamadıysa listeye geri gönder
if(!$vitrincek) {
  header("Location:tabli-urun-vitrinleri.php");
  exit;
}

// Bu tablı vitrine eklenmiş sekmeleri çek
$sekmesor = $db->prepare("SELECT s.*, v.vitrin_adi, v.vitrin_durum, v.vitrin_dizayn 
                        FROM tabli_vitrin_sekme s 
                        INNER JOIN vitrin v ON s.vitrin_id = v.vitrin_id
                        WHERE s.tabli_vitrin_id = :id 
                        ORDER BY s.sira ASC");
$sekmesor->execute(['id' => $id]);
?>

<div class="right_col" role="main">
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3>Tablı Ürün Vitrini Düzenle</h3>
      </div>
    </div>
    <div class="clearfix"></div>
    
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2><?php echo $vitrincek['ad']; ?> - Genel Ayarlar</h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <form action="../netting/islem.php" method="POST" class="form-horizontal">
              <input type="hidden" name="id" value="<?php echo $vitrincek['id']; ?>">
              
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Vitrin Adı <span class="required">*</span></label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" name="ad" value="<?php echo $vitrincek['ad']; ?>" required class="form-control">
                </div>
              </div>
              
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Sıralama</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="number" name="sira" value="<?php echo $vitrincek['sira']; ?>" class="form-control">
                </div>
              </div>
              
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Durum</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <select name="durum" class="form-control">
                    <option value="1" <?php echo $vitrincek['durum'] == 1 ? 'selected' : ''; ?>>Aktif</option>
                    <option value="0" <?php echo $vitrincek['durum'] == 0 ? 'selected' : ''; ?>>Pasif</option>
                  </select>
                </div>
              </div>
              
              <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                  <button type="submit" name="tabli_vitrin_duzenle" class="btn btn-success">Güncelle</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Sekme Ekleme Bölümü -->
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>Sekme Olarak Eklenecek Vitrinler</h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <form action="../netting/islem.php" method="POST" class="form-horizontal">
              <input type="hidden" name="tabli_vitrin_id" value="<?php echo $vitrincek['id']; ?>">
              
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Vitrin Seç</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <select name="vitrin_id" class="form-control select2" required>
                    <option value="">-- Vitrin Seçin --</option>
                    <?php
                    // Sekme olarak eklenebilecek vitrinleri çek (eklenememiş olanları)
                    $vitrinler = $db->prepare("SELECT * FROM vitrin 
                                              WHERE vitrin_id NOT IN (
                                                SELECT vitrin_id FROM tabli_vitrin_sekme WHERE tabli_vitrin_id = :id
                                              )
                                              ORDER BY vitrin_adi ASC");
                    $vitrinler->execute(['id' => $id]);
                    
                    while($vitrin = $vitrinler->fetch(PDO::FETCH_ASSOC)) { ?>
                      <option value="<?php echo $vitrin['vitrin_id']; ?>">
                        <?php echo $vitrin['vitrin_adi']; ?> 
                        (<?php echo $vitrin['vitrin_dizayn']; ?>)
                      </option>
                    <?php } ?>
                  </select>
                </div>
                <div class="col-md-3 col-sm-3 col-xs-12">
                  <button type="submit" name="tabli_vitrin_sekme_ekle" class="btn btn-primary">
                    <i class="fa fa-plus"></i> Sekme Ekle
                  </button>
                </div>
              </div>
            </form>
            
            <!-- Sekme Listesi -->
            <div class="ln_solid"></div>
            <div class="table-responsive">
              <table class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th width="50">Sıra</th>
                    <th>Vitrin Adı</th>
                    <th>Dizayn Tipi</th>
                    <th width="100">Durum</th>
                    <th width="200">İşlemler</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                  while($sekme = $sekmesor->fetch(PDO::FETCH_ASSOC)) { ?>
                    <tr>
                      <td class="text-center">
                        <?php echo $sekme['sira']; ?>
                      </td>
                      <td><?php echo $sekme['vitrin_adi']; ?></td>
                      <td><?php echo $sekme['vitrin_dizayn']; ?></td>
                      <td>
                        <?php if ($sekme['vitrin_durum'] == 1) { ?>
                          <span class="label label-success">Aktif</span>
                        <?php } else { ?>
                          <span class="label label-danger">Pasif</span>
                        <?php } ?>
                      </td>
                      <td>
                        <a href="urun-vitrin-duzenle.php?vitrin_id=<?php echo $sekme['vitrin_id']; ?>" 
                           class="btn btn-default btn-xs">
                           <i class="fa fa-pencil"></i> Vitrini Düzenle
                        </a>
                        <a href="../netting/islem.php?tabli_vitrin_sekme_sil=ok&id=<?php echo $sekme['id']; ?>&tabli_vitrin_id=<?php echo $id; ?>" 
                           class="btn btn-danger btn-xs" onclick="return confirm('Bu sekmeyi silmek istediğinize emin misiniz?')">
                           <i class="fa fa-trash"></i> Sil
                        </a>
                      </td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
            
            <?php if ($sekmesor->rowCount() == 0) { ?>
            <div class="alert alert-warning">
              <i class="fa fa-warning"></i> Henüz hiç sekme eklenmemiş. Lütfen yukarıdaki formdan sekme ekleyin.
            </div>
            <?php } ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include 'footer.php'; ?>
