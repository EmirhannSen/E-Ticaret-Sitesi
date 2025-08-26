<?php
include 'header.php';

if (isset($_GET['yorum_id'])) {
    $yorum_id = $_GET['yorum_id'];
    $yorumsor = $db->prepare("SELECT * FROM yorumlar WHERE yorum_id=:id");
    $yorumsor->execute(array('id' => $yorum_id));
    $yorumcek = $yorumsor->fetch(PDO::FETCH_ASSOC);

    if ($yorumcek) {
        echo '<h2>Yorum Detayı</h2>';
        echo '<p>' . htmlspecialchars($yorumcek['yorum_detay']) . '</p>';
    } else {
        echo '<p>Yorum bulunamadı.</p>';
    }
} else {
    echo '<p>Geçersiz istek.</p>';
}

include 'footer.php';
?>
