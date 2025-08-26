<?php
include 'baglan.php';

$searchTerm = $_GET['q'];

$sql = "SELECT urun_id, urun_kodu, urun_adi, urun_satisfiyati 
        FROM urun 
        WHERE (urun_adi LIKE :search OR urun_kodu LIKE :search)
        AND urun_durum = '1'
        LIMIT 10";

$stmt = $db->prepare($sql);
$stmt->execute(['search' => '%'.$searchTerm.'%']);

$items = [];
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $items[] = [
        'id' => $row['urun_id'],
        'text' => $row['urun_kodu'] . ' - ' . $row['urun_adi'] . ' (' . number_format($row['urun_satisfiyati'], 2) . ' TL)'
    ];
}

header('Content-Type: application/json');
echo json_encode(['items' => $items]);
?>
