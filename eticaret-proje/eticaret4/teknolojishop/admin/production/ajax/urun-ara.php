<?php
include '../../../netting/baglan.php';

$q = $_GET['q'];

$urunler = $db->prepare("SELECT urun_id, urun_ad, urun_kod 
                         FROM urun 
                         WHERE urun_ad LIKE :term 
                         OR urun_kod LIKE :term 
                         LIMIT 10");
                         
$urunler->execute([
    'term' => '%'.$q.'%'
]);

$results = array();

while($urun = $urunler->fetch(PDO::FETCH_ASSOC)) {
    $results[] = array(
        'id' => $urun['urun_id'],
        'text' => $urun['urun_kod'] . ' - ' . $urun['urun_ad']
    );
}

header('Content-Type: application/json');
echo json_encode(['results' => $results]);
?>
