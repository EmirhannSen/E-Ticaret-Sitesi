<?php 
include 'header.php'; 

// Yorumları çekme işlemi
$yorumsor = $db->prepare("SELECT * FROM yorumlar ORDER BY yorum_id DESC");
$yorumsor->execute();
?>

<!-- page content -->
<div class="right_col" role="main">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>Yorum Listeleme</h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <table id="datatable-responsive" class="table table-hover table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
              <thead class="thead-dark">
                <tr>
                  <th>#</th>
                  <th>Tarih</th>
                  <th>Kullanıcı</th>
                  <th>Ürün ID</th>
                  <th>Yorum</th>
                  <th>Puan</th>
                  <th>Durum</th>
                  <th>İşlemler</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                $say = 0;
                while ($yorumcek = $yorumsor->fetch(PDO::FETCH_ASSOC)) { 
                  $say++;
                  $kullanici_id = $yorumcek['kullanici_id'];
                  $urun_id = $yorumcek['urun_id'];

                  // Kullanıcı bilgisi
                  $kullanicisor = $db->prepare("SELECT * FROM kullanicilar WHERE kullanici_id=:id");
                  $kullanicisor->execute(['id' => $kullanici_id]);
                  $kullanicicek = $kullanicisor->fetch(PDO::FETCH_ASSOC);
                ?>
                <tr>
                  <td><?php echo $say; ?></td>
                  <td><?php echo date("d.m.Y H:i:s", strtotime($yorumcek['yorum_zaman'])); ?></td>
                  <td><?php echo $kullanicicek ? $kullanicicek['kullanici_adsoyad'] : 'Kullanıcı bulunamadı'; ?></td>
                  <td><?php echo $urun_id; ?></td>
                  <td>
                    <?php 
                    $yorum_detay = $yorumcek['yorum_detay'];
                    $max_length = 50;
                    echo strlen($yorum_detay) > $max_length 
                      ? substr($yorum_detay, 0, $max_length) . '...'
                      : $yorum_detay;
                    ?>
                  </td>
                  <td><?php echo $yorumcek['yorum_puan']; ?></td>
                  <td>
                    <?php if ($yorumcek['yorum_onay'] == 0) { ?>
                      <a href="../netting/islem.php?yorum_id=<?php echo $yorumcek['yorum_id']; ?>&yorum_one=1&yorum_onay=ok" class="btn btn-success btn-xs">Onayla</a>
                    <?php } else { ?>
                      <a href="../netting/islem.php?yorum_id=<?php echo $yorumcek['yorum_id']; ?>&yorum_one=0&yorum_onay=ok" class="btn btn-warning btn-xs">Kaldır</a>
                    <?php } ?>
                  </td>
                  <td>
                    <button 
                      class="btn btn-primary btn-xs" 
                      data-toggle="modal" 
                      data-target="#editModal<?php echo $yorumcek['yorum_id']; ?>">
                      <i class="fa fa-pencil"></i> Düzenle
                    </button>
                    <a href="../netting/islem.php?yorum_id=<?php echo $yorumcek['yorum_id']; ?>&yorumsil=ok" class="btn btn-danger btn-xs" onclick="return confirm('Bu yorumu silmek istediğinizden emin misiniz?');">
                      <i class="fa fa-trash"></i> Sil
                    </a>
                  </td>
                </tr>

                <!-- Düzenleme Modalı -->
                <div class="modal fade" id="editModal<?php echo $yorumcek['yorum_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Yorum Düzenle</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <form action="../netting/islem.php" method="POST">
                        <div class="modal-body">
                          <div class="form-group">
                            <label for="yorum_detay">Yorum</label>
                            <textarea class="form-control" name="yorum_detay" rows="4"><?php echo $yorumcek['yorum_detay']; ?></textarea>
                          </div>
                          <div class="form-group">
                            <label for="yorum_puan">Puan</label>
                            <select class="form-control" name="yorum_puan">
                              <?php for ($i = 1; $i <= 5; $i++) { ?>
                                <option value="<?php echo $i; ?>" <?php echo $yorumcek['yorum_puan'] == $i ? 'selected' : ''; ?>><?php echo $i; ?></option>
                              <?php } ?>
                            </select>
                          </div>
                          <div class="form-group">
                            <label for="yorum_type">Yorum Türü</label>
                            <select id="yorum_type_<?php echo $yorumcek['yorum_id']; ?>" class="form-control" name="yorum_type" required>
                              <?php
                              $yorumTypeSor = $db->prepare("SELECT DISTINCT yorum_type FROM yorumlar");
                              $yorumTypeSor->execute();
                              while ($yorumTypeCek = $yorumTypeSor->fetch(PDO::FETCH_ASSOC)) { ?>
                                <option value="<?php echo $yorumTypeCek['yorum_type']; ?>" <?php echo $yorumcek['yorum_type'] == $yorumTypeCek['yorum_type'] ? 'selected' : ''; ?>>
                                  <?php echo $yorumTypeCek['yorum_type']; ?>
                                </option>
                              <?php } ?>
                              <option value="yeni">Yeni Tip Ekle</option>
                            </select>
                            <input type="text" id="yeni_yorum_type_<?php echo $yorumcek['yorum_id']; ?>" name="yeni_yorum_type" placeholder="Yeni yorum tipi giriniz" class="form-control" style="display:none; margin-top:10px;">
                          </div>
                          <script>
                            document.getElementById('yorum_type_<?php echo $yorumcek['yorum_id']; ?>').addEventListener('change', function () {
                              const yeniYorumType = document.getElementById('yeni_yorum_type_<?php echo $yorumcek['yorum_id']; ?>');
                              if (this.value === 'yeni') {
                                yeniYorumType.style.display = 'block';
                              } else {
                                yeniYorumType.style.display = 'none';
                              }
                            });
                          </script>
                          <div class="form-group">
                            <label for="yorum_onay">Durum</label>
                            <select class="form-control" name="yorum_onay">
                              <option value="1" <?php echo $yorumcek['yorum_onay'] == 1 ? 'selected' : ''; ?>>Onaylı</option>
                              <option value="0" <?php echo $yorumcek['yorum_onay'] == 0 ? 'selected' : ''; ?>>Onaysız</option>
                            </select>
                          </div>
                          <input type="hidden" name="yorum_id" value="<?php echo $yorumcek['yorum_id']; ?>">
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Kapat</button>
                          <button type="submit" name="yorumduzenle" class="btn btn-primary">Kaydet</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
                <!-- /Düzenleme Modalı -->

                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- /page content -->

<?php include 'footer.php'; ?>

<script>
  // Footer'daki DataTable başlatmasını özelleştir
  $(document).ready(function() {
    // DataTable zaten başlatılmış mı kontrol et
    if ($.fn.dataTable.isDataTable('#datatable-responsive')) {
      // Zaten başlatılmışsa, dil ayarını güncelle
      $('#datatable-responsive').DataTable().destroy();
    }
    
    // Yeni ayarlarla başlat
    $('#datatable-responsive').DataTable({
      "language": {
        "url": "//cdn.datatables.net/plug-ins/1.13.5/i18n/Turkish.json"
      }
    });
  });
</script>
