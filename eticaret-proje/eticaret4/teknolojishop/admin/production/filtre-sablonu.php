<?php 
include 'header.php'; 

//Belirli veriyi seçme işlemi
$filtresor=$db->prepare("SELECT * FROM filtre_sablonu ORDER BY filtre_id DESC");
$filtresor->execute();
?>

<!-- page content -->
<div class="right_col" role="main">
  <div class="">
    <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_title">
            <h2>Filtre Şablonu Listesi 
              <small>
                <?php 
                if (isset($_GET['durum'])) {
                  if ($_GET['durum']=="ok") { ?>
                    <b style="color:green;">İşlem Başarılı...</b>
                  <?php } else if ($_GET['durum']=="no") { ?>
                    <b style="color:red;">İşlem Başarısız...</b>
                  <?php }
                }
                ?>
              </small>
            </h2>
            <div class="clearfix"></div>
            <div align="right">
              <a href="filtre-sablonu-ekle.php"><button class="btn btn-success btn-xs"> Yeni Ekle</button></a>
            </div>
          </div>
          <div class="x_content">
            <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
              <thead>
                <tr>
                  <th>S.No</th>
                  <th>Filtre Adı</th>
                  <th>Filtre Kodu</th>
                  <th>Durum</th>
                  <th></th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <?php 
                $say=0;
                while($filtrecek=$filtresor->fetch(PDO::FETCH_ASSOC)) { $say++?>
                <tr>
                  <td width="20"><?php echo $say ?></td>
                  <td><?php echo $filtrecek['filtre_adi'] ?></td>
                  <td><?php echo $filtrecek['filtre_code'] ?></td>
                  <td>
                    <?php 
                    if ($filtrecek['filtre_durum']==1) { ?>
                      <button class="btn btn-success btn-xs">Aktif</button>
                    <?php } else { ?>
                      <button class="btn btn-danger btn-xs">Pasif</button>
                    <?php } ?>
                  </td>
                  <td><center><a href="filtre-sablonu-duzenle.php?filtre_id=<?php echo $filtrecek['filtre_id']; ?>"><button class="btn btn-primary btn-xs">Düzenle</button></a></center></td>
                  <td><center><a href="../netting/islem.php?filtre_id=<?php echo $filtrecek['filtre_id']; ?>&filtresil=ok"><button class="btn btn-danger btn-xs">Sil</button></a></center></td>
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
