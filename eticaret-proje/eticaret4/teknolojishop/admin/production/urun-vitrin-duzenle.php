<?php include 'header.php'; ?>

<?php
$vitrinsor = $db->prepare("SELECT * FROM vitrin WHERE vitrin_id=:id");
$vitrinsor->execute(['id' => $_GET['vitrin_id']]);
$vitrincek = $vitrinsor->fetch(PDO::FETCH_ASSOC);
?>

<div class="right_col" role="main">
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3>Vitrini Düzenle</h3>
      </div>
    </div>
    <div class="clearfix"></div>

    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_content">
            <ul class="nav nav-tabs">
              <li class="active"><a data-toggle="tab" href="#genel">Genel Ayarlar</a></li>
              <li><a data-toggle="tab" href="#urunler">Vitrine Ürün Ekleme</a></li>
              <li><a data-toggle="tab" href="#resimler">Vitrin Resimleri</a></li>
              <li><a data-toggle="tab" href="#tasarim">Vitrin Tasarımı</a></li>
            </ul>

            <div class="tab-content">
              <!-- Genel Ayarlar -->
              <div id="genel" class="tab-pane fade in active">
                <form action="../netting/islem.php" method="POST">
                  <div class="form-group">
                    <label>Vitrin Adı</label>
                    <input type="text" name="vitrin_adi" value="<?php echo $vitrincek['vitrin_adi']; ?>" class="form-control">
                  </div>
                  <div class="form-group">
                    <label>Vitrin Durumu</label>
                    <select name="vitrin_durum" class="form-control">
                      <option value="1" <?php echo $vitrincek['vitrin_durum'] == 1 ? 'selected' : ''; ?>>Aktif</option>
                      <option value="0" <?php echo $vitrincek['vitrin_durum'] == 0 ? 'selected' : ''; ?>>Pasif</option>
                    </select>
                  </div>
                  <button type="submit" name="vitrinduzenle" class="btn btn-success">Kaydet</button>
                </form>
              </div>

              <!-- Vitrine Ürün Ekleme -->
              <div id="urunler" class="tab-pane fade">
                <form action="../netting/islem.php" method="POST" class="form-horizontal">
                  <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Ürün Seç</label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <select name="urun_id" class="form-control select2-urun" style="width: 100%;" required>
                        <option value="">Ürün Ara...</option>
                        <?php
                        $urunsor = $db->prepare("SELECT * FROM urun ORDER BY urun_adi ASC");
                        $urunsor->execute();
                        while($uruncek = $urunsor->fetch(PDO::FETCH_ASSOC)) {
                            echo '<option value="'.$uruncek["urun_id"].'">'.$uruncek["urun_adi"].'</option>';
                        }
                        ?>
                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-md-6 col-md-offset-3">
                      <input type="hidden" name="vitrin_id" value="<?php echo $vitrincek['vitrin_id']; ?>">
                      <button type="submit" name="vitrineurunekle" class="btn btn-primary">Ekle</button>
                    </div>
                  </div>
                </form>

                <div class="clearfix"></div>
                <hr>

                <h4>Vitrindeki Ürünler</h4>
                <div class="table-responsive">
                  <table class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th width="50">#</th>
                        <th>Ürün Adı</th>
                        <th width="100">İşlemler</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $vitrinurunler = $db->prepare("SELECT * FROM vitrin_urun INNER JOIN urun ON vitrin_urun.urun_id=urun.urun_id WHERE vitrin_id=:vitrin_id ORDER BY urun.urun_adi ASC");
                      $vitrinurunler->execute(['vitrin_id' => $vitrincek['vitrin_id']]);
                      $say = 0;
                      while ($urun = $vitrinurunler->fetch(PDO::FETCH_ASSOC)) { 
                        $say++; ?>
                        <tr>
                          <td><?php echo $say; ?></td>
                          <td><?php echo $urun['urun_adi']; ?></td>
                          <td>
                            <a href="../netting/islem.php?vitrindenurunkaldir=ok&vitrin_id=<?php echo $vitrincek['vitrin_id']; ?>&urun_id=<?php echo $urun['urun_id']; ?>" class="btn btn-danger btn-xs" onclick="return confirm('Bu ürünü vitrinten kaldırmak istediğinize emin misiniz?')"><i class="fa fa-trash"></i> Kaldır</a>
                          </td>
                        </tr>
                      <?php } 
                      if($say == 0) { ?>
                        <tr>
                          <td colspan="3" class="text-center">Vitrine henüz ürün eklenmemiş</td>
                        </tr>
                      <?php } ?>
                    </tbody>
                  </table>
                </div>
              </div>

              <!-- Vitrin Resimleri -->
              <div id="resimler" class="tab-pane fade">
                <form action="../netting/islem.php" method="POST" enctype="multipart/form-data">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Vitrin Resmi</label>
                        <input type="file" name="vitrin_resim" class="form-control" required>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Resim Sırası</label>
                        <input type="number" name="sira" class="form-control" min="0" value="0" required>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Resim Başlığı</label>
                        <input type="text" name="baslik" class="form-control" placeholder="Resim başlığı" required>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>URL (href)</label>
                        <input type="text" name="href" class="form-control" placeholder="https://..." required>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label>Açıklama</label>
                    <textarea name="aciklama" class="form-control" rows="3" placeholder="Resim açıklaması" required></textarea>
                  </div>
                  <input type="hidden" name="vitrin_id" value="<?php echo $vitrincek['vitrin_id']; ?>">
                  <button type="submit" name="vitrinresimekle" class="btn btn-success">Ekle</button>
                </form>

                <h4>Vitrin Resimleri</h4>
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th>Resim</th>
                      <th>İşlemler</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $vitrinresimler = $db->prepare("SELECT * FROM vitrin_resimleri WHERE vitrin_id=:vitrin_id");
                    $vitrinresimler->execute(['vitrin_id' => $vitrincek['vitrin_id']]);
                    while ($resim = $vitrinresimler->fetch(PDO::FETCH_ASSOC)) { ?>
                      <tr>
                        <td><img src="../../<?php echo $resim['vitrin_resim']; ?>" width="100"></td>
                        <td>
                          <a href="../netting/islem.php?vitrinresimsil=ok&vitrin_resim_id=<?php echo $resim['vitrin_resim_id']; ?>" class="btn btn-danger btn-xs">Sil</a>
                        </td>
                      </tr>
                    <?php } ?>
                  </tbody>
                </table>
              </div>

              <!-- Vitrin Tasarımı -->
              <div id="tasarim" class="tab-pane fade">
                <form action="../netting/islem.php" method="POST">
                  <div class="form-group">
                    <label>Vitrin Tasarımı</label>
                    <select name="vitrin_dizayn" class="form-control" required>
                      <option value="">Tasarım Seçiniz</option>
                      <?php
                      $dizaynlar = $db->query("SELECT DISTINCT vitrin_dizayn FROM vitrin WHERE vitrin_dizayn IS NOT NULL AND vitrin_dizayn != ''");
                      while ($dizayn = $dizaynlar->fetch(PDO::FETCH_ASSOC)) {
                        echo '<option value="' . $dizayn['vitrin_dizayn'] . '">' . $dizayn['vitrin_dizayn'] . '</option>';
                      }
                      ?>
                    </select>
                  </div>
                  <input type="hidden" name="vitrin_id" value="<?php echo $vitrincek['vitrin_id']; ?>">
                  <button type="submit" name="vitrindizaynduzenle" class="btn btn-success">Kaydet</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- jQuery, Select2 ve diğer kütüphaneleri head içine taşıyalım -->
<script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
<link href="../vendors/select2/dist/css/select2.min.css" rel="stylesheet">
<script src="../vendors/select2/dist/js/select2.full.min.js"></script>

<script>
$(function() {
    console.log("DOM Ready!");
    // jQuery'nin yüklendiğini kontrol et
    if (typeof jQuery != 'undefined') {
        console.log("jQuery versiyonu:", $.fn.jquery);
        
        // Select2'nin yüklendiğini kontrol et 
        if (typeof $.fn.select2 != 'undefined') {
            console.log("Select2 yüklendi");
            
            // Select2 init
            $('.select2').select2({
                placeholder: "Ürün ara",
                allowClear: true
            });
            
            $('.select2-urun').select2({
                ajax: {
                    url: 'ajax/urun-ara.php',
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            q: params.term
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: data
                        };
                    },
                    cache: true
                },
                placeholder: 'Ürün aramak için yazmaya başlayın...',
                minimumInputLength: 2,
                language: {
                    inputTooShort: function() {
                        return 'Lütfen en az 2 karakter girin';
                    },
                    searching: function() {
                        return 'Aranıyor...';  
                    },
                    noResults: function() {
                        return 'Sonuç bulunamadı';
                    }
                }
            });
        } else {
            console.error("Select2 kütüphanesi yüklenemedi");
        }
    } else {
        console.error("jQuery yüklenemedi"); 
    }
});
</script>

<!-- Sayfanın en altında footer'dan önce -->
<script>
$(document).ready(function() {
    $('.select2-urun').select2({
        placeholder: "Ürün seçiniz...",
        allowClear: true,
        width: '100%',
        language: {
            noResults: function() {
                return "Sonuç bulunamadı";
            },
            searching: function() {
                return "Aranıyor...";
            }
        }
    });
});
</script>

<?php include 'footer.php'; ?>
