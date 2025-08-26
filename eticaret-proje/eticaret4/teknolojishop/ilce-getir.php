<?php
include 'settings/baglan.php';

// AJAX isteği için CORS header'ları
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');

// Şehir ID'sini al
$sehir_id = isset($_GET['sehir_id']) ? intval($_GET['sehir_id']) : 0;

if ($sehir_id <= 0) {
    echo json_encode([]);
    exit;
}

try {
    // İlçeleri çek
    $ilcesor = $db->prepare("SELECT ilce_id, ilce_ad FROM ilceler WHERE sehir_id = :sehir_id ORDER BY ilce_ad ASC");
    $ilcesor->execute(['sehir_id' => $sehir_id]);
    $ilceler = $ilcesor->fetchAll(PDO::FETCH_ASSOC);
    
    // JSON olarak döndür
    echo json_encode($ilceler);
} catch (PDOException $e) {
    // Hata durumunda boş dizi döndür
    echo json_encode([]);
}
?>
