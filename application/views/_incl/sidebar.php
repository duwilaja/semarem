<div class="sidebar-wrapper">
          <div>
            <div class="logo-wrapper"><a href="index.html"><img class="img-fluid for-light" src="<?=base_url();?>/my/img/intan.png" alt="" style="width: 100px; margin: -20px 10px 100px 50px;"><img class="img-fluid for-dark" src="<?=$template;?>assets/images/logo/intan.png" alt=""></a>
              <div class="back-btn"><i class="fa fa-angle-left"></i></div>
                </div>
            <div class="logo-icon-wrapper"><a href="#"><img class="img-fluid" src="<?=$template;?>assets/images/logo/logo-icon.png" alt=""></a></div>
            <nav class="sidebar-main">
              <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
              <div id="sidebar-menu">
                <ul class="sidebar-links" id="simple-bar">
                  <li class="back-btn"><a href="#"><img class="img-fluid" src="<?=$template;?>assets/images/logo/logo-icon.png" alt=""></a>
                    <div class="mobile-back text-end"><span>Back</span><i class="fa fa-angle-right ps-2" aria-hidden="true"></i></div>
                  </li>
                  <li class="mb-4 mt-3 d-flex justify-content-center">
                    <div>
                      <!-- <h6 class="lan-1">General</h6>
                      <p class="lan-2">Dashboards,widgets & layout.</p> -->
                      <a href="<?php echo base_url('Form/form_pengaduan');?>">
                        <button  class="btn btn-pengaduan btn-pill btn-danger btn-air-danger"><i class="icon-plus icon-white" ></i> Input Pengaduan</button>
                      </a>
                    </div>
                  </li> 
                  <li class="sidebar-list"><a class="sidebar-link sidebar-title link-nav" href="<?= site_url('Dashboard')?>"><i data-feather="airplay"> </i><span>Dashboard</span></a></li>
                  <li class="sidebar-list">
                    <label class="badge badge-danger">4</label><a class="sidebar-link sidebar-title" href="javascript:void(0)"><i data-feather="layers"></i><span class="">Data Master</span></a>
                    <ul class="sidebar-submenu">
                      <li><a class="" href="<?=site_url('Data_master/instansi');?>">Instansi</a></li>
                      <li><a class="" href="<?=site_url('Data_master/unit');?>">Unit</a></li>
                      <li><a class="" href="<?=site_url('Data_master/pengaduan_kategori');?>">Pengaduan Kategori</a></li>
                      <li><a class="" href="<?=site_url('Data_master/task_kategori');?>">Task Kategori</a></li>
                    </ul>
                  </li>
                  
                  <li class="sidebar-list">
                    <label class="badge badge-danger">2</label><a class="sidebar-link sidebar-title" href="javascript:void(0)"><i data-feather="alert-circle"></i><span class="">Pengaduan</span></a>
                    <ul class="sidebar-submenu">
                      <li><a href="<?=site_url('Pengaduan/list_pengaduan');?>">All</a></li>
                      <li><a href="<?= site_url('Pengaduan/list_pengaduan?my=ya')?>">My Task</a></li>
                    </ul>
                  </li>
                  <li class="sidebar-list"><a class="sidebar-link sidebar-title link-nav" href="<?= site_url('Petugas')?>"><i data-feather="users"> </i><span>Petugas</span></a></li>
                </ul>
              </div>
              <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
            </nav>
          </div>
        </div>