<?php $template = base_url('template/cuba/'); ?>
<!DOCTYPE html>
<html lang="id">
  <?php $this->load->view('_incl/head',['template' => $template]);?>
  <body class="dark-only">
    <!-- tap on top starts-->
    <div class="tap-top"><i data-feather="chevrons-up"></i></div>
    <!-- tap on tap ends-->
    <!-- page-wrapper Start-->
    <div class="page-wrapper compact-wrapper" id="pageWrapper">
      <!-- Page Header Start-->
      <?php $this->load->view('_incl/header');?>
      <!-- Page Header Ends                              -->
      <!-- Page Body Start-->
      <div class="page-body-wrapper">
        <!-- Page Sidebar Start-->
        <?php $this->load->view('_incl/sidebar');?>
        <!-- Page Sidebar Ends-->
        <div class="page-body">
          <div class="container-fluid">
            <div class="page-title">
              <div class="row">
                <div class="col-6">
                  <h3><?=$header;?></h3>
                </div>
                <!-- <div class="col-6">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html"><i data-feather="home"></i></a></li>
                    <li class="breadcrumb-item">ECommerce</li>
                    <li class="breadcrumb-item active">Product list</li>
                  </ol>
                </div> -->
              </div>
            </div>
          </div>
          <!-- Container-fluid starts-->
          <?php $this->load->view('page/'.$link_view);?>
          <!-- Container-fluid Ends-->
        </div>
        <!-- footer start-->
        <?php $this->load->view('_incl/footer');?>
      </div>
    </div>
    <?php $this->load->view('_incl/script',['template' => $template]);?>
  </body>
</html>