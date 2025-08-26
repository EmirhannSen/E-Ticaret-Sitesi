<?php 
include 'header.php';
?>

<!-- page content -->
<div class="right_col" role="main">
  <div class="">
    <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>Ürün Ekleme <small>
              <?php 
              if (isset($_GET['durum']) && $_GET['durum']=="ok") {?>
                <b style="color:green;">İşlem Başarılı...</b>
              <?php } elseif (isset($_GET['durum']) && $_GET['durum']=="no") {?>
                <b style="color:red;">İşlem Başarısız...</b>
              <?php }
              ?>
            </small></h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <br />

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

            <!-- / => en kök dizine çık ... ../ bir üst dizine çık -->
            <form action="../netting/islem.php" method="POST" enctype="multipart/form-data" class="form-horizontal form-label-left">

              <!-- Kategori seçme başlangıç -->
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Kategori Seç<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-6">
                  <?php  
                  $kategorisor=$db->prepare("select * from kategori where kategori_ust=:kategori_ust order by kategori_sira");
                  $kategorisor->execute(array(
                    'kategori_ust' => 0
                  ));
                  ?>
                  <select class="select2_multiple form-control" required="" name="kategori_id" >
                    <?php 
                    while($kategoricek=$kategorisor->fetch(PDO::FETCH_ASSOC)) {
                      $kategori_id=$kategoricek['kategori_id'];
                    ?>
                    <option value="<?php echo $kategoricek['kategori_id']; ?>"><?php echo $kategoricek['kategori_ad']; ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <!-- kategori seçme bitiş -->

              <!-- Ürün Durum -->
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Ürün Durum<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <select id="heard" class="form-control" name="urun_durum" required>
                    <option value="1">Aktif</option>
                    <option value="0">Pasif</option>
                  </select>
                </div>
              </div>

              <!-- Marka Seçimi -->
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Marka</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <select class="form-control" name="urun_marka">
                    <?php
                    $markasor = $db->prepare("SELECT * FROM marka ORDER BY marka_adi ASC");
                    $markasor->execute();
                    while ($markacek = $markasor->fetch(PDO::FETCH_ASSOC)) { ?>
                      <option value="<?php echo $markacek['marka_id']; ?>"><?php echo $markacek['marka_adi']; ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>



              <!-- Ürün Adı -->
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Ürün Ad <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" id="first-name" name="urun_adi" placeholder="Ürün adını giriniz" required="required" class="form-control col-md-7 col-xs-12">
                </div>
              </div>

              <!-- Ürün Kodu -->
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Ürün Kodu</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" name="urun_kodu" class="form-control">
                </div>
              </div>

              <!-- Ürün Barkodu -->
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Ürün Barkodu</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" name="urun_barkodu" class="form-control">
                </div>
              </div>

              <!-- Ck Editör Başlangıç -->
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Açıklama</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <textarea id="editor1" name="urun_aciklama" class="form-control"></textarea>
                </div>
              </div>

              <script src="https://cdn.ckeditor.com/4.25.1/standard/ckeditor.js"></script>
              <script>
                CKEDITOR.replace('editor1', {
                  filebrowserBrowseUrl: '/ckfinder/ckfinder.html',
                  filebrowserImageBrowseUrl: '/ckfinder/ckfinder.html?type=Images',
                  filebrowserUploadUrl: '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
                  filebrowserImageUploadUrl: '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images'
                });
              </script>
              <!-- Ck Editör Bitiş -->

              <!-- Ürün Stok -->
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Ürün Stok <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" id="first-name" name="urun_stok" placeholder="Ürün stok giriniz" required="required" class="form-control col-md-7 col-xs-12">
                </div>
              </div>

              <!-- Satış Fiyatı -->
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Satış Fiyatı <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" id="first-name" name="urun_satisfiyati" placeholder="Ürün fiyat giriniz" required="required" class="form-control col-md-7 col-xs-12">
                </div>
              </div>

              <!-- Piyasa Fiyatı -->
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Piyasa Fiyatı</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" name="urun_piyasafiyati" class="form-control">
                </div>
              </div>

              <!-- KDV Oranı -->
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">KDV Oranı</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <select class="form-control" name="urun_kdvorani">
                    <option value="0">0</option>
                    <option value="1">1</option>
                    <option value="10">10</option>
                    <option value="20">20</option>
                  </select>
                </div>
              </div>

              <!-- KDV Dahil mi -->
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">KDV Dahil mi?</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <select class="form-control" name="urun_kdvdahil">
                    <option value="1">Evet</option>
                    <option value="0">Hayır</option>
                  </select>
                </div>
              </div>

              <!-- Döviz -->
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Döviz</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <select class="form-control" name="urun_doviz">
                    <option value="TL">TL</option>
                    <option value="USD">USD</option>
                    <option value="EURO">EURO</option>
                  </select>
                </div>
              </div>

              <!-- Keyword -->
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Keyword</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" name="urun_keyword" class="form-control">
                </div>
              </div>

              <!-- Öne Çıkar -->
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12">Öne Çıkar</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <select class="form-control" name="urun_onecikar">
                    <option value="0" selected>Hayır</option>
                    <option value="1">Evet</option>
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
                        
                        // Filtreleri listele
                        while ($filtrecek = $filtresor->fetch(PDO::FETCH_ASSOC)) { 
                        ?>
                          <div class="col-md-4 col-sm-6 col-xs-12">
                            <div class="checkbox">
                              <label>
                                <input type="checkbox" class="flat" name="filtre_id[]" value="<?php echo $filtrecek['filtre_id']; ?>"> 
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
                  </div>
                </div>
              <?php } ?>

              <div class="ln_solid"></div>
              <div class="form-group">
                <div align="right" class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                  <button type="submit" name="urunekle" class="btn btn-success">Kaydet</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- /page content -->

<?php include 'footer.php'; ?>
