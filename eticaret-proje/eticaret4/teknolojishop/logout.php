<?php
ob_start();
session_start();

// Tüm session değişkenlerini sil
$_SESSION = array();

// Cookie'yi de sil
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time()-42000, '/');
}

// Session'ı sonlandır
session_destroy();

// Ana sayfaya yönlendir
header("Location: index.php");
exit;
?>
