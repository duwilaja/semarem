<div class="container-fluid">
    <div class="row">
        <div class="col-sm-6 col-xl-3 col-lg-6">
        <a rel="stylesheet" href="<?= site_url('Pengaduan/list_pengaduan')?>">
          <div class="card o-hidden">
              <div class="bg-secondary b-r-4 card-body" data-toggle="tooltip" data-placement="top" title="Total Pengaduan Masuk">
              <div class="media static-top-widget">
                  <div class="align-self-center text-center"><i data-feather="inbox"></i></div>
                  <div class="media-body"><span class="m-0">Masuk</span>
                  <h4 class="mb-0 counter" id="masuk"></h4><i class="icon-bg" data-feather="inbox"></i>
                  </div>
              </div>
              </div>
          </div>
        </a>
        </div>
        <div class="col-sm-6 col-xl-3 col-lg-6">
        <div class="card o-hidden">
            <div class="bg-info b-r-4 card-body"  data-toggle="tooltip" data-placement="top" title="Total Pengaduan Menunggu Konfirmasi">
            <div class="media static-top-widget">
                <div class="align-self-center text-center"><i data-feather="info"></i></div>
                <div class="media-body"><span class="m-0">Konfirmasi</span>
                <h4 class="mb-0 counter" id="konfirmasi"></h4><i class="icon-bg" data-feather="info"></i>
                </div>
            </div>
            </div>
        </div>
        </div>
        <div class="col-sm-6 col-xl-3 col-lg-6">
        <div class="card o-hidden">
            <div class="bg-warning b-r-4 card-body"  data-toggle="tooltip" data-placement="top" title="Total Pengaduan Diproses">
            <div class="media static-top-widget">
                <div class="align-self-center text-center"><i data-feather="cpu"></i></div>
                <div class="media-body"><span class="m-0">Proses</span>
                <h4 class="mb-0 counter" id="proses"></h4><i class="icon-bg" data-feather="cpu"></i>
                </div>
            </div>
            </div>
        </div>
        </div>
        <div class="col-sm-6 col-xl-3 col-lg-6">
        <div class="card o-hidden">
            <div class="bg-success b-r-4 card-body"  data-toggle="tooltip" data-placement="top" title="Total Pengaduan Selesai">
            <div class="media static-top-widget">
                <div class="align-self-center text-center"><i data-feather="check-square"></i></div>
                <div class="media-body"><span class="m-0">Selesai</span>
                <h4 class="mb-0 counter" id="selesai"></h4><i class="icon-bg" data-feather="check-square"></i>
                </div>
            </div>
            </div>
        </div>
        </div>
        <div class="col-xl-8 xl-100 dashboard-sec box-col-12">
            <div class="card earning-card">
                <div class="card-header">
                <h5>Grafik Pengaduan</h5>
                    <div class="inner-top-right">
                      <ul class="d-flex list-unstyled justify-content-end">
                          <li><?php
                          $date = date('Y-m-d');
                          $date = strtotime($date);
                          $date = strtotime("-7 day", $date);
                          
                          echo date('Y-m-d',$date)." s.d. ".date('Y-m-d');?></li>
                      </ul>
                    </div>
                </div>
                  <div class="card-body p-0">
                    <div class="row m-0">
                      <div class="col-xl-3 earning-content p-0">
                        <div class="row m-0 chart-left" id="kategori">
                          <!-- <div class="col-xl-12 p-0 left_side_earning">
                            <h3><span class="badge badge-secondary">Kecelakaan</span></h3>
                            <p class="font-roboto">35 Info Pengaduan</p>
                            <hr>
                          </div>
                          <div class="col-xl-12 p-0 left_side_earning">
                          <h3><span class="badge badge-primary">Kemacetan</span></h3>
                            <p class="font-roboto"> 72 Info Pengaduan</p>
                            <hr>
                          </div>
                          <div class="col-xl-12 p-0 left_side_earning">
                          <h3><span class="badge badge-warning">Demonstrasi</span></h3>
                            <p class="font-roboto"> 2 Info Pengaduan</p>
                            <hr>
                          </div> -->
                          <!-- <div class="col-xl-12 p-0 left-btn"><a class="btn btn-gradient">View All</a></div> -->
                        </div>
                      </div>
                      <div class="col-xl-9 p-0">
                        <div class="chart-right">
                          <div class="row m-0 p-tb">
                            <div class="col-xl-8 col-md-8 col-sm-8 col-12 p-0">
                              <div class="inner-top-left">
                                <ul class="d-flex list-unstyled">
                                  <li class="active">Daily</li>
                                  <li>Weekly</li>
                                  <li>Monthly</li>
                                  <li>Yearly</li>
                                </ul>
                              </div>
                            </div>
                            <div class="col-xl-4 col-md-4 col-sm-4 col-12 p-0 justify-content-end">
                              <div class="inner-top-right">
                                <ul class="d-flex list-unstyled justify-content-end">
                                  <li>Realtime</li>
                                  <!-- <li>2021-06-11</li> -->
                                </ul>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-xl-12">
                              <div class="card-body p-0">
                                <div class="current-sale-container">
                                  <div id="grafik_pengaduan"></div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="row border-top m-0">
                          <div class="col-xl-4 ps-0 col-md-6 col-sm-6">
                            <div class="media p-0">
                              <a rel="stylesheet" href="<?= base_url('Pengaduan/list_pengaduan');?>"><div class="media-left"><i class="icofont icofont-crown"></i></div></a> 
                              <div class="media-body">
                                <h6>Solo Destination</h6>
                                <p id="vend_1"></p>
                              </div>
                            </div>
                          </div>
                          <div class="col-xl-5 col-md-6 col-sm-6">
                            <div class="media p-0">
                              <div class="media-left bg-secondary"><i class="icofont icofont-heart-alt"></i></div>
                              <div class="media-body">
                                <h6>Pengaduan Masyarakat</h6>
                                <p id="vend_2"></p>
                              </div>
                            </div>
                          </div>
                          <div class="col-xl-3 col-md-12 pe-0">
                            <div class="media p-0">
                              <a rel="stylesheet" href="<?= base_url('Form/form_pengaduan');?>"><div class="media-left"><i class="icofont icofont-ui-user"></i></div></a>
                              <div class="media-body">
                                <h6>Backoffice</h6>
                                <p id="vend_0"></p>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
        </div>
        <!-- <div class="col-sm-12 col-xl-4 box-col-4">
        <div class="card">
            <div class="card-header">
                <h5 class="text-uppercase">Recent Activity</h5>
                <div class="card-header-right">
                <ul class="list-unstyled card-option">
                    <li><i class="fa fa-spin fa-cog"></i></li>
                    <li><i class="view-html fa fa-code"></i></li>
                    <li><i class="icofont icofont-maximize full-card"></i></li>
                    <li><i class="icofont icofont-minus minimize-card"></i></li>
                    <li><i class="icofont icofont-refresh reload-card"></i></li>
                    <li><i class="icofont icofont-error close-card"></i></li>
                </ul>
                </div>
            </div>
            <div class="card-body">
            <ul class="crm-activity">
                        <li class="media"><span class="me-3 font-primary">A</span>
                          <div class="align-self-center media-body">
                            <h6 class="mt-0">Any desktop publishing packages and web page editors.</h6>
                            <ul class="dates">
                              <li>25 July 2017</li>
                              <li>20 hours ago</li>
                            </ul>
                          </div>
                        </li>
                        <li class="media"><span class="me-3 font-secondary">C</span>
                          <div class="align-self-center media-body">
                            <h6 class="mt-0">Contrary to popular belief, Lorem Ipsum is not simply. </h6>
                            <ul class="dates">
                              <li>25 July 2017</li>
                              <li>20 hours ago      </li>
                            </ul>
                          </div>
                        </li>
                        <li class="media"><span class="me-3 font-primary">E</span>
                          <div class="align-self-center media-body">
                            <h6 class="mt-0">Established fact that a reader will be distracted </h6>
                            <ul class="dates">
                              <li>25 July 2017</li>
                              <li>20 hours ago</li>
                            </ul>
                          </div>
                        </li>
                        <li class="media"><span class="me-3 font-secondary">H</span>
                          <div class="align-self-center media-body">
                            <h6 class="mt-0">H-Code - A premium portfolio template from ThemeZaa </h6>
                            <ul class="dates">
                              <li>25 July 2017</li>
                              <li>20 hours ago      </li>
                            </ul>
                          </div>
                        </li>
                        <li class="media"><span class="me-3 font-primary">T</span>
                          <div class="align-self-center media-body">
                            <h6 class="mt-0">There isn't anything embarrassing hidden.</h6>
                            <ul class="dates">
                              <li>25 July 2017</li>
                              <li>20 hours ago</li>
                            </ul>
                          </div>
                        </li>
                        <li class="media">
                          <div class="align-self-center media-body">
                            <ul class="dates">
                              <li>25 July 2017</li>
                              <li>20 hours ago</li>
                            </ul>
                          </div>
                        </li>
                      </ul>
            </div>
        </div>
        </div> -->
        <!-- <div class="col-sm-12 col-xl-8 box-col-8">
        <div class="card">
            <div class="card-header">
            <h5>Pie Chart </h5>
            </div>
            <div class="card-body apex-chart">
            <div id="piechart"></div>
            </div>
        </div>
        </div> -->

    </div>
</div>     