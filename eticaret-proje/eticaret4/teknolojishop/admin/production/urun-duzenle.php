<?php 
include 'header.php'; 

$urunsor = $db->prepare("SELECT * FROM urun WHERE urun_id=:id");
$urunsor->execute(['id' => $_GET['urun_id']]);
$uruncek = $urunsor->fetch(PDO::FETCH_ASSOC);

?>

<!-- Form CSS Stilleri -->
<style>
  .filter-checkboxes {
    max-height: 250px;
    overflow-y: auto;
    padding: 10px 0;
  }
  
  .filter-checkboxes .checkbox {
    margin-bottom: 10px;
    background-color: #f9f9f9;
    padding: 8px 12px;
    border-radius: 4px;
    transition: all 0.2s ease;
  }
  
  .filter-checkboxes .checkbox:hover {
    background-color: #f5f5f5;
  }
  
  .filter-checkboxes .icheckbox_flat-green {
    margin-right: 8px;
  }
  
  .x_panel {
    box-shadow: none;
    border: 1px solid #e6e9ed;
    padding: 0;
  }
</style>

<!-- page content -->
<div class="right_col" role="main">
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3>Ürün Düzenleme</h3>
      </div>
    </div>

    <div class="clearfix"></div>

    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>Ürün Bilgileri</h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">

            <form action="../netting/islem.php" method="POST" enctype="multipart/form-data" class="form-horizontal form-label-left">

              <!-- Kategori -->
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Kategori</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <select class="form-control" name="kategori_id" required>
                    <?php 
                    $kategorisor = $db->prepare("SELECT * FROM kategori ORDER BY kategori_ad ASC");
                    $kategorisor->execute();
                    while ($kategoricek = $kategorisor->fetch(PDO::FETCH_ASSOC)) { ?>
                      <option value="<?php echo $kategoricek['kategori_id']; ?>" 
                        <?php echo $kategoricek['kategori_id'] == $uruncek['kategori_id'] ? 'selected' : ''; ?>>
                        <?php echo $kategoricek['kategori_ad']; ?>
                      </option>
                    <?php } ?>
                  </select>
                </div>
              </div>

              <!-- Durum -->
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Ürün Durum</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <select class="form-control" name="urun_durum">
                    <option value="1" <?php echo $uruncek['urun_durum'] == '1' ? 'selected' : ''; ?>>Aktif</option>
                    <option value="0" <?php echo $uruncek['urun_durum'] == '0' ? 'selected' : ''; ?>>Pasif</option>
                  </select>
                </div>
              </div>

              <!-- Marka -->
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Marka</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <select class="form-control" name="urun_marka">
                    <?php
                    $markasor = $db->prepare("SELECT * FROM marka ORDER BY marka_adi ASC");
                    $markasor->execute();
                    while ($markacek = $markasor->fetch(PDO::FETCH_ASSOC)) { ?>
                      <option value="<?php echo $markacek['marka_id']; ?>" <?php echo $markacek['marka_id'] == $uruncek['urun_marka'] ? 'selected' : ''; ?>>
                        <?php echo $markacek['marka_adi']; ?>
                      </option>
                    <?php } ?>
                  </select>
                </div>
              </div>

              <!-- Ürün Adı -->
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Ürün Adı</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" name="urun_adi" value="<?php echo $uruncek['urun_adi']; ?>" class="form-control" required>
                </div>
              </div>

              <!-- Ürün Kodu -->
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Ürün Kodu</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" name="urun_kodu" value="<?php echo $uruncek['urun_kodu']; ?>" class="form-control">
                </div>
              </div>

              <!-- Ürün Barkodu -->
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Ürün Barkodu</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" name="urun_barkodu" value="<?php echo $uruncek['urun_barkodu']; ?>" class="form-control">
                </div>
              </div>

              <!-- Açıklama -->
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Açıklama</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <textarea id="editor1" name="urun_aciklama" class="form-control"><?php echo $uruncek['urun_aciklama']; ?></textarea>
                </div>
              </div>

              <!-- Ürün Stok -->
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Ürün Stok</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" name="urun_stok" value="<?php echo $uruncek['urun_stok']; ?>" class="form-control" required>
                </div>
              </div>

              <!-- Ürün Fiyatı -->
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Satış Fiyatı</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" name="urun_satisfiyati" value="<?php echo $uruncek['urun_satisfiyati']; ?>" class="form-control" required>
                </div>
              </div>

              <!-- Ürün Piyasa Fiyatı -->
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Piyasa Fiyatı</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" name="urun_piyasafiyati" value="<?php echo $uruncek['urun_piyasafiyati']; ?>" class="form-control">
                </div>
              </div>

              <!-- KDV Oranı -->
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">KDV Oranı</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <select class="form-control" name="urun_kdvorani">
                    <option value="0" <?php echo $uruncek['urun_kdvorani'] == '0' ? 'selected' : ''; ?>>0</option>
                    <option value="1" <?php echo $uruncek['urun_kdvorani'] == '1' ? 'selected' : ''; ?>>1</option>
                    <option value="10" <?php echo $uruncek['urun_kdvorani'] == '10' ? 'selected' : ''; ?>>10</option>
                    <option value="20" <?php echo $uruncek['urun_kdvorani'] == '20' ? 'selected' : ''; ?>>20</option>
                  </select>
                </div>
              </div>

              <!-- KDV Dahil mi? -->
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">KDV Dahil mi?</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <select class="form-control" name="urun_kdvdahil">
                    <option value="1" <?php echo $uruncek['urun_kdvdahil'] == '1' ? 'selected' : ''; ?>>Evet</option>
                    <option value="0" <?php echo $uruncek['urun_kdvdahil'] == '0' ? 'selected' : ''; ?>>Hayır</option>
                  </select>
                </div>
              </div>

              <!-- Döviz -->
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Döviz</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <select class="form-control" name="urun_doviz">
                    <option value="TL" <?php echo $uruncek['urun_doviz'] == 'TL' ? 'selected' : ''; ?>>TL</option>
                    <option value="USD" <?php echo $uruncek['urun_doviz'] == 'USD' ? 'selected' : ''; ?>>USD</option>
                    <option value="EURO" <?php echo $uruncek['urun_doviz'] == 'EURO' ? 'selected' : ''; ?>>EURO</option>
                  </select>
                </div>
              </div>

              <!-- Keyword -->
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Keyword</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" name="urun_keyword" value="<?php echo $uruncek['urun_keyword']; ?>" class="form-control">
                </div>
              </div>

              <!-- Ürün Öne Çıkar -->
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Öne Çıkar</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <select class="form-control" name="urun_onecikar">
                    <option value="1" <?php echo $uruncek['urun_onecikar'] == '1' ? 'selected' : ''; ?>>Evet</option>
                    <option value="0" <?php echo $uruncek['urun_onecikar'] == '0' ? 'selected' : ''; ?>>Hayır</option>
                  </select>
                </div>
              </div>

              <!-- Filtre Seçenekleri (Checkbox olarak) -->
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Filtre Seçenekleri</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <div class="x_panel">
                    <div class="x_content">
                      <div class="row filter-checkboxes">
                        <?php
                        // Tüm filtre şablonlarını getir
                        $filtresor = $db->prepare("SELECT * FROM filtre_sablonu WHERE filtre_durum = '1' ORDER BY filtre_adi ASC");
                        $filtresor->execute();
                        
                        // Ürünün mevcut filtrelerini getir
                        $urunfiltresor = $db->prepare("SELECT filtre_id FROM urun_filtreleri WHERE urun_id = :urun_id");
                        $urunfiltresor->execute(['urun_id' => $_GET['urun_id']]);
                        
                        // Ürünün filtrelerini bir diziye al
                        $urunfiltreleri = [];
                        while ($ufiltre = $urunfiltresor->fetch(PDO::FETCH_ASSOC)) {
                          $urunfiltreleri[] = $ufiltre['filtre_id'];
                        }
                        
                        // Filtreleri listele ve ürüne atanmış olanları seçili yap
                        while ($filtrecek = $filtresor->fetch(PDO::FETCH_ASSOC)) { 
                          $checked = in_array($filtrecek['filtre_id'], $urunfiltreleri) ? 'checked' : '';
                        ?>
                          <div class="col-md-4 col-sm-6 col-xs-12">
                            <div class="checkbox">
                              <label>
                                <input type="checkbox" class="flat" name="filtre_id[]" value="<?php echo $filtrecek['filtre_id']; ?>" <?php echo $checked; ?>> 
                                <?php echo $filtrecek['filtre_adi']; ?>
                              </label>
                            </div>
                          </div>
                        <?php } ?>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Ürün Resimleri -->
              <?php for ($i = 1; $i <= 6; $i++) { ?>
                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-3 col-xs-12">Resim <?php echo $i; ?></label>
                  <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="file" name="urun_resim<?php echo $i; ?>" class="form-control">
                    <?php if (!empty($uruncek["urun_resim$i"])) { ?>
                      <img src="../../<?php echo $uruncek["urun_resim$i"]; ?>" width="100">
                      <input type="hidden" name="existing_urun_resim<?php echo $i; ?>" value="<?php echo $uruncek["urun_resim$i"]; ?>">
                    <?php } ?>
                  </div>
                </div>
              <?php } ?>

              <input type="hidden" name="urun_id" value="<?php echo $uruncek['urun_id']; ?>">

              <div class="ln_solid"></div>
              <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                  <button type="submit" name="urunduzenle" class="btn btn-success">Güncelle</button>
                </div>
              </div>

            </form>

            <script src="https://cdn.ckeditor.com/4.25.1/standard/ckeditor.js"></script>
            <script>
              CKEDITOR.replace('editor1', {
                filebrowserBrowseUrl: '/ckfinder/ckfinder.html',
                filebrowserImageBrowseUrl: '/ckfinder/ckfinder.html?type=Images',
                filebrowserUploadUrl: '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
                filebrowserImageUploadUrl: '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images'
              });
            </script>

          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- /page content -->

<?php include 'footer.php'; ?>
