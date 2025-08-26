<?php 
include 'settings/baglan.php';

// vitrin tablosundan kayıt çekiliyor
$vitrinSor = $db->prepare("SELECT * FROM vitrin WHERE vitrin_dizayn = :vitrin_dizayn AND vitrin_durum = 1");
$vitrinSor->execute(['vitrin_dizayn' => 'uclu_banner']);
$vitrinCek = $vitrinSor->fetch(PDO::FETCH_ASSOC);

if ($vitrinCek) { // Eğer vitrin bulunursa

    // vitrin_resimleri tablosundan kayıtlar çekiliyor
    $vitrinResimSor = $db->prepare("SELECT * FROM vitrin_resimleri WHERE vitrin_id = :vitrin_id ORDER BY vitrin_resim_sira ASC");
    $vitrinResimSor->execute(['vitrin_id' => $vitrinCek['vitrin_id']]);

    ?>

 <div class="product-categories-main-div-vitrin2">
   <div class="product-categories-inside-vitrin2">
     <div class="product-categories-inside-vitrin2-boxarea">
       <!-- Box !-->
       <?php while ($vitrinResimCek = $vitrinResimSor->fetch(PDO::FETCH_ASSOC)) { ?>
        
       <a class="col-md-4 form-group  vitrin2-box" href="<?php echo $vitrinResimCek['vitrin_resim_url'] ?>" style="color: #000000 !important; text-decoration: none;">
         <div class="vitrin2-box-img ">
           <img src="<?php echo $vitrinResimCek['vitrin_resim'] ?>" alt="<?php echo $vitrinResimCek['vitrin_resim_aciklama'] ?>">
         </div>
       </a>
       
<?php } ?>
     </div>
   </div>
 </div>
 <?php } ?>