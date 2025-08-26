<?php
include '../../netting/baglan.php';

$sehir_id = $_GET["sehir_id"];
$secili_ilce = isset($_GET["secili_ilce"]) ? $_GET["secili_ilce"] : '';

$output = "<option value=''>İlçe Seçiniz</option>";

$ilcesor = $db->prepare("SELECT * FROM ilceler WHERE sehir_id = :sehir_id ORDER BY ilce_ad ASC");
$ilcesor->execute(['sehir_id' => $sehir_id]);

while($ilce = $ilcesor->fetch(PDO::FETCH_ASSOC)) {
    $selected = ($secili_ilce == $ilce['ilce_id']) ? 'selected' : '';
    $output .= "<option value='" . $ilce['ilce_id'] . "' $selected>" . $ilce['ilce_ad'] . "</option>";
}

echo $output;
?>
