<?php include 'header.php'; 

// Sipariş sorgusu 
$siparisSor = $db->prepare("SELECT s.*, k.*, sd.durum_adi, sd.durum_renk 
                         FROM siparis s 
                         INNER JOIN kullanicilar k ON s.kullanici_id = k.kullanici_id
                         INNER JOIN siparis_durumlari sd ON s.siparis_durum_id = sd.durum_id  
                         ORDER BY s.siparis_zaman DESC");
$siparisSor->execute();
?>

<div class="right_col" role="main">
  <div class="x_panel">
    <div class="x_title">
      <div class="row">
        <div class="col-md-6">
          <h2>Siparişler</h2>
        </div>
        <div class="col-md-6">
          <div class="pull-right">
            <select id="durumFiltre" class="form-control">
              <option value="">Tüm Durumlar</option>
              <?php 
              $durumSor = $db->prepare("SELECT * FROM siparis_durumlari WHERE durum_aktif=1 ORDER BY durum_sira");
              $durumSor->execute();
              while($durumCek = $durumSor->fetch(PDO::FETCH_ASSOC)) { ?>
                <option value="<?php echo $durumCek['durum_adi']; ?>"><?php echo $durumCek['durum_adi']; ?></option>
              <?php } ?>
            </select>
          </div>
        </div>
      </div>
      <div class="clearfix"></div>
    </div>

    <div class="x_content">
      <table id="siparisTablosu" class="table table-striped table-bordered dt-responsive nowrap" width="100%">
        <thead>
          <tr>
            <th>Sipariş Kodu</th>
            <th>Tarih</th>
            <th>Müşteri</th>
            <th>İletişim</th>
            <th>Ödeme</th>
            <th>Tutar</th>
            <th>Durum</th>
            <th>İşlemler</th>
          </tr>
        </thead>
        <tbody>
          <?php while($siparisCek=$siparisSor->fetch(PDO::FETCH_ASSOC)) { ?>
            <tr>
              <td>
                <span class="text-primary" style="margin:0">
                  <?php echo $siparisCek['siparis_no'] ? $siparisCek['siparis_no'] : 'SIP-'.$siparisCek['siparis_id']; ?>
                </span>
              </td>
              <td>
                <?php echo date("d.m.Y H:i", strtotime($siparisCek['siparis_zaman'])); ?> 
              </td>
              <td>
                <span><?php echo $siparisCek['kullanici_ad'] . ' ' . $siparisCek['kullanici_soyad']; ?></span>
              </td>
              <td>
                <?php if($siparisCek['kullanici_gsm']) { ?>
                  <i class="fa fa-phone"></i> <?php echo $siparisCek['kullanici_gsm']; ?><br>
                <?php } ?>
                <small><i class="fa fa-envelope"></i> <?php echo $siparisCek['kullanici_mail']; ?></small>
              </td>
              <td>
                <?php if($siparisCek['siparis_odeme'] == '1') { ?>
                  <i class="fa fa-check-circle"></i> Ödeme Onaylandı<br>
                <?php } else { ?>
                  <i class="fa fa-clock-o"></i> Ödeme Bekliyor<br>
                <?php } ?>
                <small>
                  <i class="fa fa-<?php echo $siparisCek['siparis_tip'] == 'Banka Havalesi' ? 'bank' : 'credit-card'; ?>"></i> 
                  <?php echo $siparisCek['siparis_tip']; 
                  if($siparisCek['siparis_tip'] == 'Banka Havalesi') {
                    echo ' - ' . $siparisCek['siparis_banka'];
                  } ?>
                </small>
              </td>
              <td>
                <strong><?php echo number_format($siparisCek['siparis_toplam'], 2, ',', '.'); ?> TL</strong>
              </td>
              <td>
                <div class="btn-group">
                  <button type="button" class="btn btn-<?php echo $siparisCek['durum_renk']; ?> dropdown-toggle btn-sm" data-toggle="dropdown">
                    <?php echo $siparisCek['durum_adi']; ?> <span class="caret"></span>
                  </button>
                  <ul class="dropdown-menu" role="menu">
                    <?php 
                    $durumSor2 = $db->prepare("SELECT * FROM siparis_durumlari WHERE durum_aktif=1 ORDER BY durum_sira");
                    $durumSor2->execute();
                    while($durumCek2 = $durumSor2->fetch(PDO::FETCH_ASSOC)) { 
                      if($durumCek2['durum_id'] != $siparisCek['siparis_durum_id']) { ?>
                        <li>
                          <a href="javascript:void(0)" onclick="durumGuncelle(<?php echo $siparisCek['siparis_id']; ?>, <?php echo $durumCek2['durum_id']; ?>)">
                            <?php echo $durumCek2['durum_adi']; ?>
                          </a>
                        </li>
                      <?php }
                    } ?>
                  </ul>
                </div>
              </td>
              <td>
                <a href="siparis-detay.php?siparis_id=<?php echo $siparisCek['siparis_id']; ?>" 
                   class="btn btn-primary btn-sm btn-block">
                  <i class="fa fa-search"></i> Detay
                </a>
              </td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Durum güncelleme için form -->
<form id="durumGuncelleForm" action="../netting/islem.php" method="POST" style="display:none;">
  <input type="hidden" name="siparis_id" id="siparis_id">
  <input type="hidden" name="siparis_durum_id" id="siparis_durum_id">
  <input type="hidden" name="siparis_durum_guncelle" value="1">
</form>

<script>
$(document).ready(function() {
  var table = $('#siparisTablosu').DataTable({
    "language": {
      "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Turkish.json"
    },
    "order": [[1, "desc"]],
    responsive: true,
    pageLength: 25,
    columnDefs: [
      {targets: [7], orderable: false} // İşlemler sütunu için sıralama kapalı
    ]
  });

  $('#durumFiltre').on('change', function() {
    table.column(4).search(this.value).draw();
  });
});

function durumGuncelle(siparisId, durumId) {
  if(confirm('Sipariş durumunu güncellemek istediğinize emin misiniz?')) {
    $('#siparis_id').val(siparisId);
    $('#siparis_durum_id').val(durumId);
    $('#durumGuncelleForm').submit();
  }
}
</script>

<?php include 'footer.php'; ?>
