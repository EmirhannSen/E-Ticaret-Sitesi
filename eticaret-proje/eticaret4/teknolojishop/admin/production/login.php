<!DOCTYPE html>
<html lang="tr">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>IGU Akademi CMS Yönetim Paneli</title>

  <!-- Bootstrap -->
  <link href="../vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link href="../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Poppins', sans-serif;
    }
    
    body {
      background: linear-gradient(135deg, #2A3F54 0%, #172D44 100%);
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    
    .login-container {
      display: flex;
      box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
      border-radius: 12px;
      overflow: hidden;
      width: 900px;
      max-width: 90%;
      background: #fff;
    }
    
    .login-image {
      flex: 1;
      background-image: url('../../images/logo/admin_login_bg.jpg');
      background-size: cover;
      background-position: center;
      position: relative;
      display: flex;
      align-items: flex-end;
      justify-content: center;
      padding: 30px;
      color: white;
    }
    
    .login-image::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: rgba(42, 63, 84, 0.75);
      z-index: 1;
    }
    
    .login-image-content {
      position: relative;
      z-index: 2;
      text-align: center;
    }
    
    .login-image-content h2 {
      font-size: 28px;
      font-weight: 600;
      margin-bottom: 10px;
      color: white;
    }
    
    .login-image-content p {
      font-size: 16px;
      opacity: 0.9;
    }
    
    .login-form {
      flex: 1;
      padding: 50px 40px;
      background: #fff;
    }
    
    .login-header {
      margin-bottom: 30px;
      text-align: center;
    }
    
    .login-header h2 {
      font-size: 24px;
      font-weight: 600;
      color: #2A3F54;
      margin-bottom: 10px;
    }
    
    .login-header p {
      color: #777;
      font-size: 14px;
    }
    
    .form-group {
      margin-bottom: 20px;
      position: relative;
    }
    
    .form-control {
      height: 50px;
      padding: 10px 20px;
      border-radius: 6px;
      border: 1px solid #e0e6ed;
      width: 100%;
      font-size: 14px;
      transition: all 0.3s ease;
      padding-left: 45px;
    }
    
    .form-control:focus {
      border-color: #3498DB;
      box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1);
      outline: none;
    }
    
    .form-group .icon {
      position: absolute;
      left: 15px;
      top: 17px;
      color: #2A3F54;
    }
    
    .btn-login {
      background: #2A3F54;
      border: none;
      color: white;
      padding: 12px 0;
      width: 100%;
      border-radius: 6px;
      font-weight: 500;
      font-size: 16px;
      cursor: pointer;
      transition: all 0.3s ease;
      margin-top: 10px;
    }
    
    .btn-login:hover, .btn-login:focus {
      background: #3498DB;
      box-shadow: 0 5px 15px rgba(52, 152, 219, 0.3);
    }
    
    .alert {
      padding: 12px 15px;
      border-radius: 6px;
      margin-bottom: 20px;
      font-size: 14px;
    }
    
    .alert-danger {
      background-color: #fdeaea;
      color: #E74C3C;
      border: 1px solid #f5c6cb;
    }
    
    .alert-success {
      background-color: #e8f4f8;
      color: #3498DB;
      border: 1px solid #bee5eb;
    }
    
    .login-footer {
      text-align: center;
      margin-top: 30px;
      color: #777;
      font-size: 13px;
    }
    
    .login-logo {
      text-align: center;
      margin-bottom: 20px;
    }
    
    .login-logo img {
      height: 60px;
    }
    
    @media (max-width: 768px) {
      .login-image {
        display: none;
      }
      
      .login-container {
        max-width: 95%;
      }
      
      .login-form {
        padding: 40px 30px;
      }
    }
  </style>
</head>

<body>
  <div class="login-container">
    <div class="login-image">
      <div class="login-image-content">
        <p>Yönetim paneliyle içeriklerinizi ve ürünlerinizi kolayca yönetin</p>
      </div>
    </div>
    
    <div class="login-form">
      <div class="login-logo">
        <img src="../../images/logo/igulogo.png" alt="IGU Akademi Logo">
      </div>
      
      <div class="login-header">
        <h2>Hoş Geldiniz</h2>
        <p>Lütfen giriş bilgilerinizi giriniz</p>
      </div>
      
      <?php if (isset($_GET['durum']) && $_GET['durum']=="no") { ?>
        <div class="alert alert-danger">
          <i class="fa fa-exclamation-circle"></i> Kullanıcı adı veya şifre hatalı!
        </div>
      <?php } elseif (isset($_GET['durum']) && $_GET['durum']=="exit") { ?>
        <div class="alert alert-success">
          <i class="fa fa-check-circle"></i> Başarıyla çıkış yaptınız.
        </div>
      <?php } elseif (isset($_GET['durum']) && $_GET['durum']=="izinsiz") { ?>
        <div class="alert alert-danger">
          <i class="fa fa-exclamation-triangle"></i> Bu sayfaya erişim izniniz bulunmuyor!
        </div>
      <?php } ?>
      
      <form action="../netting/islem.php" method="POST">
        <div class="form-group">
          <i class="fa fa-envelope icon"></i>
          <input type="email" name="kullanici_mail" class="form-control" placeholder="E-posta Adresiniz" required>
        </div>
        
        <div class="form-group">
          <i class="fa fa-lock icon"></i>
          <input type="password" name="kullanici_password" class="form-control" placeholder="Şifreniz" required>
        </div>
        
        <button type="submit" name="admingiris" class="btn-login">
          Giriş Yap
        </button>
      </form>
      
      <div class="login-footer">
        <p>&copy; <?php echo date('Y'); ?> IGU Akademi - Tüm Hakları Saklıdır</p>
      </div>
    </div>
  </div>
</body>
</html>
