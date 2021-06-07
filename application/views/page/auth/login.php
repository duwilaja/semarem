<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Cuba admin is super flexible, powerful, clean &amp; modern responsive bootstrap 5 admin template with unlimited possibilities.">
    <meta name="keywords" content="admin template, Cuba admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="pixelstrap">
    <link rel="icon" href="<?=base_url();?>template/cuba/assets/images/favicon.png" type="image/x-icon">
    <link rel="shortcut icon" href="<?=base_url();?>template/cuba/assets/images/favicon.png" type="image/x-icon">
    <title>Login Intan</title>
    <!-- Google font-->
    <link href="https://fonts.googleapis.com/css?family=Rubik:400,400i,500,500i,700,700i&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i,900&amp;display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?=base_url();?>template/cuba/assets/css/font-awesome.css">
    <!-- ico-font-->
    <link rel="stylesheet" type="text/css" href="<?=base_url();?>template/cuba/assets/css/vendors/icofont.css">
    <!-- Themify icon-->
    <link rel="stylesheet" type="text/css" href="<?=base_url();?>template/cuba/assets/css/vendors/themify.css">
    <!-- Flag icon-->
    <link rel="stylesheet" type="text/css" href="<?=base_url();?>template/cuba/assets/css/vendors/flag-icon.css">
    <!-- Feather icon-->
    <link rel="stylesheet" type="text/css" href="<?=base_url();?>template/cuba/assets/css/vendors/feather-icon.css">
    <!-- Plugins css start-->
    <!-- Plugins css Ends-->
    <!-- Bootstrap css-->
    <link rel="stylesheet" type="text/css" href="<?=base_url();?>template/cuba/assets/css/vendors/bootstrap.css">
    <!-- App css-->
    <link rel="stylesheet" type="text/css" href="<?=base_url();?>template/cuba/assets/css/style.css">
    <link id="color" rel="stylesheet" href="<?=base_url();?>template/cuba/assets/css/color-1.css" media="screen">
    <!-- Responsive css-->
    <link rel="stylesheet" type="text/css" href="<?=base_url();?>template/cuba/assets/css/responsive.css">
  </head>
  <body>
    <!-- login page start-->
    <div class="container-fluid">
      <div class="row">
        <div class="col-xl-7"><img class="bg-img-cover bg-center" src="<?=base_url();?>template/cuba/assets/images/login/2.jpg" alt="looginpage"></div>
        <div class="col-xl-5 p-0">
          <div class="login-card">
            <div>
              <div><a class="logo text-start" href="#"><img class="img-fluid for-light" src="<?=base_url();?>template/cuba/assets/images/logo/login.png" alt="looginpage"><img class="img-fluid for-dark" src="<?=base_url();?>template/cuba/assets/images/logo/logo_dark.png" alt="looginpage"></a></div>
              <div class="login-main"> 
                <form class="theme-form" action="<?=site_url('Auth/proses_login');?>" method="post">
                  <h4>Sign in to account</h4>
                  <p>Enter your username & password to login</p>
                  <div class="form-group">
                    <label class="col-form-label">Username</label>
                    <input class="form-control" type="text" name="username" required="" placeholder="Username">
                  </div>
                  <div class="form-group">
                    <label class="col-form-label">Password</label>
                    <div class="form-input position-relative">
                      <input class="form-control" type="password" name="password" required="" placeholder="*********">
                      <div class="show-hide"><span class="show" style="color:var(--bs-success)!important;"></span></div>
                    </div>
                  </div>
                  <div class="form-group mb-0">
                    <!-- <div class="checkbox p-0">
                      <input id="checkbox1" type="checkbox">
                      <label class="text-muted" for="checkbox1">Remember password</label>
                    </div> -->
                    <button class="btn btn-warning btn-block w-100" type="submit">Sign in</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- latest jquery-->
      <script src="<?=base_url();?>template/cuba/assets/js/jquery-3.5.1.min.js"></script>
      <!-- Bootstrap js-->
      <script src="<?=base_url();?>template/cuba/assets/js/bootstrap/bootstrap.bundle.min.js"></script>
      <!-- feather icon js-->
      <script src="<?=base_url();?>template/cuba/assets/js/icons/feather-icon/feather.min.js"></script>
      <script src="<?=base_url();?>template/cuba/assets/js/icons/feather-icon/feather-icon.js"></script>
      <!-- scrollbar js-->
      <!-- Sidebar jquery-->
      <script src="<?=base_url();?>template/cuba/assets/js/config.js"></script>
      <!-- Plugins JS start-->
      <!-- Plugins JS Ends-->
      <!-- Theme js-->
      <script src="<?=base_url();?>template/cuba/assets/js/script.js"></script>
      <!-- login js-->
      <!-- Plugin used-->
    </div>
    <script src="<?=base_url();?>template/cuba/assets/js/sweet-alert/sweetalert.min.js"></script>

    <script>
        <?php if($this->session->flashdata('gagal')){ ?>
        swal(
            'Error!',
            '<?=$this->session->flashdata('gagal');?>',
            'error'
        );
        <?php }?>
    </script>
  </body>
</html>