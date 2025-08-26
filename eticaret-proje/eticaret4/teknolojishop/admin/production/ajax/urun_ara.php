<?php
require_once '../../netting/baglan.php';

$searchTerm = $_GET['q'];

$query = $db->prepare("SELECT urun_id, urun_kodu, urun_adi 
                      FROM urun 
                      WHERE (urun_adi LIKE :search OR urun_kodu LIKE :search)
                      AND urun_durum = '1'
                      LIMIT 10");
$query->execute(['search' => '%'.$searchTerm.'%']);

$results = array();
while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
    $results[] = array(
        'id' => $row['urun_id'],
        'text' => $row['urun_kodu'] . ' - ' . $row['urun_adi']
    );
}

header('Content-Type: application/json');
echo json_encode($results);
