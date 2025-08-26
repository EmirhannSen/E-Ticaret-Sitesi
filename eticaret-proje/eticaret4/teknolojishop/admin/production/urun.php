<?php 
include 'header.php';

// Ürünleri getir
$urunsor = $db->prepare("SELECT * FROM urun ORDER BY urun_id DESC");
$urunsor->execute();
?>

<!-- page content -->
<div class="right_col" role="main">
  <div class="">
    <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>Ürün Listesi 
              <small>
                <?php 
                if(isset($_GET['durum'])) {
                  if ($_GET['durum']=="ok") { ?>
                    <b style="color:green;">İşlem Başarılı...</b>
                  <?php } elseif ($_GET['durum']=="no") { ?>
                    <b style="color:red;">İşlem Başarısız...</b>
                  <?php }
                }
                ?>
              </small>
            </h2>
            <div align="right">
              <a href="urun-ekle.php"><button class="btn btn-success btn-xs">Ürün Ekle</button></a>
            </div>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
              <thead>
                <tr>
                  <th>S.No</th>
                  <th>Resim</th>
                  <th>Ürün Kodu</th>
                  <th>Ürün Ad</th>
                  <th>Marka</th>
                  <th>Kategori</th>
                  <th>Durum</th>
                  <th>İşlemler</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                $say = 0;
                while($uruncek=$urunsor->fetch(PDO::FETCH_ASSOC)) { 
                  $say++;
                  // Kategori bilgisini çek
                  $kategorisor = $db->prepare("SELECT * FROM kategori WHERE kategori_id=:id");
                  $kategorisor->execute(['id' => $uruncek['kategori_id']]);
                  $kategoricek = $kategorisor->fetch(PDO::FETCH_ASSOC);
                ?>
                <tr>
                  <td><?php echo $say; ?></td>
                  <td>
                    <?php if (!empty($uruncek['urun_resim1'])): ?>
                      <img src="../../<?php echo $uruncek['urun_resim1']; ?>" width="100" alt="">
                    <?php else: ?>
                      <img src="../../images/no-image.jpg" width="100" alt="Resim Yok">
                    <?php endif; ?>
                  </td>
                  <td><?php echo $uruncek['urun_kodu']; ?></td>
                  <td><?php echo $uruncek['urun_adi']; ?></td>
                  <td><?php echo $uruncek['urun_marka']; ?></td>
                  <td><?php echo isset($kategoricek['kategori_ad']) ? $kategoricek['kategori_ad'] : 'Kategori Bulunamadı'; ?></td>
                  <td>
                    <?php if ($uruncek['urun_durum']==1) { ?>
                      <button class="btn btn-success btn-xs">Aktif</button>
                    <?php } else { ?>
                      <button class="btn btn-danger btn-xs">Pasif</button>
                    <?php } ?>
                  </td>
                  <td width="120">
                    <a href="urun-duzenle.php?urun_id=<?php echo $uruncek['urun_id']; ?>"><button class="btn btn-primary btn-xs">Düzenle</button></a>
                    <a href="../netting/islem.php?urun_id=<?php echo $uruncek['urun_id']; ?>&urunsil=ok" onclick="return confirm('Bu ürünü silmek istediğinizden emin misiniz?');"><button class="btn btn-danger btn-xs">Sil</button></a>
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
<!-- /page content -->

<?php include 'footer.php'; ?>
