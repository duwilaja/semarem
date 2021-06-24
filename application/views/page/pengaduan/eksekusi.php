<style>
.activity-timeline .media .activity-line {
    margin: 0 auto;
    left: 21px;
}
</style>
<input type="hidden" name="pengaduan_id" id="pengaduan_id" value="<?=$this->input->get('id');?>">
<input type="hidden" name="task_id" id="task_id">
<div class="container-fluid">
    <div class="row">
        <div class="col call-chat-sidebar col-sm-12">
            <div class="card">
              <div class="card-body chat-body">
                <div class="chat-box">
                  <!-- Chat left side Start-->
                  <div class="chat-left-aside">
                    <div class="media"><img class="rounded-circle user-image" src="<?=$template;?>assets/images/user/12.png" alt="">
                      <div class="about">
                        <div class="name f-w-600"><?= $this->session->userdata('nama');?></div>
                        <div class="status"><?= $this->session->userdata('pangkat');?></div>
                      </div>
                    </div>
                    <div class="people-list" id="people-list">
                    <ul class="nav nav-pills" id="pills-icontab" role="tablist">
                      <li class="nav-item active"><a class="nav-link btn btn-success" id="pills-person-pill" data-bs-toggle="pill" href="#pills-person" role="tab" aria-controls="pills-person" aria-selected="true" style="padding: .5rem 1rem!important; margin-right:3px!important;"><i class="icofont icofont-users-alt-2" style="margin-right: 0px !important;"></i></a></li>
                      <li class="nav-item"><a class="nav-link btn btn-secondary" id="pills-instansi-pill" data-bs-toggle="pill" href="#pills-instansi" role="tab" aria-controls="pills-instansi" aria-selected="true" style="padding: .5rem 1rem!important; margin-right:3px!important;"><i class="icofont icofont-ui-home" style="margin-right: 0px !important;"></i></a></li>
                      <li class="nav-item"><a class="nav-link btn btn-primary" id="pills-kendaraan-tab" data-bs-toggle="pill" href="#pills-kendaraan" role="tab" aria-controls="pills-kendaraan" aria-selected="true" style="padding: .5rem 1rem!important; margin-right:3px!important;"><i class="icofont icofont-car-alt-4" style="margin-right: 0px !important;"></i></a></li>
                      <li class="nav-item"><a class="nav-link btn btn-warning" onclick="refresh()" data-bs-toggle="pill" href="#pills-kendaraans" role="tab" aria-controls="pills-kendaraans" aria-selected="true" style="padding: .5rem 1rem!important; margin-right:3px!important;"><i class="icofont icofont-refresh" style="margin-right: 0px !important;"></i></a></li>
                    </ul>
                    <div class="tab-content" id="pills-icontabContent" style="overflow:hidden;height:90%;">
                      <div class="tab-pane fade show active" id="pills-person" role="tabpanel" aria-labelledby="pills-person-tab">                       
                          <div class="search">
                            <form class="theme-form">
                              <div class="mb-3">
                                <input class="form-control" onkeyup="filter_petugas(this.value)" type="text" placeholder="Search"><i class="fa fa-search"></i>
                              </div>
                            </form>
                          </div>
                          <ul class="list" id="list_petugas" style="height:400px;">
                           
                          </ul>
                      </div>
                      <div class="tab-pane fade" id="pills-instansi" role="tabpanel" aria-labelledby="pills-instansi-tab">                       
                          <div class="search">
                            <form class="theme-form">
                              <div class="mb-3">
                                <input class="form-control" onkeyup="filter_instansi(this.value)" type="text" placeholder="Search"><i class="fa fa-search"></i>
                              </div>
                            </form>
                          </div>
                          <ul class="list" id="list_instansi" style="height:400px;">
                           
                          </ul>
                      </div>
                      <div class="tab-pane fade" id="pills-kendaraan" role="tabpanel" aria-labelledby="pills-kendaraan-tab">                       
                          <div class="search">
                            <form class="theme-form">
                              <div class="mb-3">
                                <input class="form-control" onkeyup="filter_realtime_car(this.value)" type="text" placeholder="Search"><i class="fa fa-search"></i>
                              </div>
                            </form>
                          </div>
                          <ul class="list" id="list_realtime_car" style="height:400px;">
                          </ul>
                      </div>
                    </div>
                    </div>
                  </div>
                  <!-- Chat left side Ends-->
                </div>
              </div>
            </div>
          </div>
        <div class="col call-chat-body">
            <div class="card">
                <div class="card-body p-0" style="overflow: hidden;">
                    <div class="row chat-box" >
                        <!-- Chat right side start-->
                        <div class="col pe-0 chat-right-aside" style="max-width :100%!important;flex: 0 0 100%!important;">
                            <!-- chat start-->
                            <div class="chat">
                                <!-- chat-header start-->
                                <div class="chat-header clearfix">
                                    <div class="about">
                                        <div class="name" id="judul">-</div>
                                        <div>
                                            <span class="badge badge-danger" id="kategori">-</span>
                                            <span class="badge badge-light text-secondary" id="status"></span>
                                        </div>
                                    </div>
                                    <ul class="list-inline float-start float-sm-end chat-menu-icons">
                                        <!-- <li class="list-inline-item"><a href="#"><i class="icon-search"></i></a></li>
                                        <li class="list-inline-item"><a href="#"><i class="icon-clip"></i></a></li>
                                        <li class="list-inline-item"><a href="#"><i class="icon-video-camera"></i></a></li> -->
                                        <li class="list-inline-item me-4"><a href="#" data-bs-toggle="modal" data-bs-target="#updateModal" class="btn btn-warning">Update</a></li>
                                        <li class="list-inline-item me-4"><a href="#" onclick="list_detail()"><i class="icon-menu"></i></a></li>
                                    </ul>
                                </div>
                                <!-- chat-header end-->
                                <div class="chat-history chat-msg-box custom-scrollbar p-0" style="overflow-y:hidden;height:548px;">
                                    <iframe src=""
                                    id="frame"
                                    frameborder="0" 
                                    marginheight="0" 
                                    marginwidth="0" 
                                    width="100%" 
                                    height="100%" 
                                    scrolling="auto">
                          </iframe>
                                </div>
                                <!-- end chat-history-->
                                <!-- <div class="chat-message clearfix">
                                    <div class="row">
                                        <div class="col-xl-12 d-flex">
                                            <div class="smiley-box bg-primary">
                                                <div class="picker"><img src="<?=$template;?>assets/images/smiley.png" alt=""></div>
                                            </div>
                                            <div class="input-group text-box">
                                                <input class="form-control input-txt-bx" id="message-to-send" type="text" name="message-to-send" placeholder="Type a message......">
                                                <button class="input-group-text btn btn-primary" type="button">SEND</button>
                                            </div>
                                        </div>
                                    </div>
                                </div> -->
                                <!-- end chat-message-->
                                <!-- chat end-->
                                <!-- Chat right side ends-->
                            </div>
                        </div>
                        <div class="col ps-0 chat-menu d-none" style="position: absolute;background: #FFF;right:0;top:13%;" id="list_detail">
                            <ul class="nav nav-tabs border-tab nav-primary" id="info-tab" role="tablist" style="margin-bottom:0px!important;">
                                <li class="nav-item"><a class="nav-link active" id="info-home-tab" data-bs-toggle="tab" href="#info-home" role="tab" aria-selected="true">ASSIGN</a>
                                    <div class="material-border"></div>
                                </li>
                                <li class="nav-item"><a class="nav-link" id="profile-info-tab" data-bs-toggle="tab" href="#info-profile" role="tab" aria-selected="false">STATUS</a>
                                    <div class="material-border"></div>
                                </li>
                                <li class="nav-item"><a class="nav-link" id="contact-info-tab" data-bs-toggle="tab" href="#info-contact" role="tab" aria-selected="false">DETAIL</a>
                                    <div class="material-border"></div>
                                </li>
                            </ul>
                            <div class="tab-content" id="info-tabContent">
                                <div class="tab-pane fade show active" id="info-home" role="tabpanel" aria-labelledby="info-home-tab">
                                    <div class="people-list">
                                        <ul class="list" id="list_assign">
                                            
                                        </ul>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="info-profile" role="tabpanel" aria-labelledby="profile-info-tab">
                                  <div class="timelines pt-4" style="height: 400px;overflow:auto;">
                                        <div class="activity-timeline" id="status_timeline">
                                           
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="info-contact" role="tabpanel" aria-labelledby="contact-info-tab">
                                    <div class="user-profile">
                                        <div class="image">
                                            <!-- <div class="avatar text-center"><img alt="" src="<?=$template;?>assets/images/user/2.png"></div>
                                            <div class="icon-wrapper"><i class="icofont icofont-pencil-alt-5"></i></div> -->
                                        </div>
                                        <div class="text-center mt-2">
                                            <h6 id="tanggal_pengaduan" style="font-size: 14px;">-</h6>
                                        </div>
                                        <div class="user-content text-center">
                                            <h5 class="text-uppercase"><span class="badge badge-secondary" id="kategori_pengaduan">-</span></h5>
                                            <h6 class="text-uppercase text-muted" id="nama_pelapor">-</h6>
                                            <hr>
                                            <div class="text-center" style="height: 10hv;height: 300px;overflow: auto;">
                                                <p id="keterangan_pengaduan" class="mb-4" style="font-size:14px;">-</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Container-fluid Ends-->

<!-- Modal Update-->
<div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="updateModalLabel">Update</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="" method="post" id="form_update">
        <input type="hidden" name="pengaduan_id" id="" value="<?=$this->input->get('id');?>">
            <div class="mb-3">
                <label for="Status" class="form-label">Status</label>
                <select name="status" class="form-control" id="ustatus" required>
                    <option value="">--Pilih Status--</option>
                    <option value="0">Menunggu Konfirmasi</option>
                    <option value="1">Sudah Dikonfirmasi</option>
                    <option value="2">Ditangani</option>
                    <option value="3">Selesai</option>
                    <option value="4">Batal</option>
                </select>
            </div>
            <!-- <div class="mb-3">
                <label for="Keterangan" class="form-label">Keterangan</label>
                <textarea name="ket" id="" cols="30" rows="5" class="form-control"></textarea>
            </div> -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Update</button>
      </div>
        </form>
    </div>
  </div>
</div>

<!-- Modal Detail-->
<div class="modal fade" id="detail" tabindex="-1" aria-labelledby="detailLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="detailLabel">Detail</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
          <div id="content-detail">
          </div>
      </div>
    </div>
  </div>
</div>

<div class="pswp" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="pswp__bg"></div>
  <div class="pswp__scroll-wrap">
    <div class="pswp__container">
      <div class="pswp__item"></div>
      <div class="pswp__item"></div>
      <div class="pswp__item"></div>
    </div>
    <div class="pswp__ui pswp__ui--hidden">
      <div class="pswp__top-bar">
        <div class="pswp__counter"></div>
        <button class="pswp__button pswp__button--close" title="Close (Esc)"></button>
        <button class="pswp__button pswp__button--share" title="Share"></button>
        <button class="pswp__button pswp__button--fs" title="Toggle fullscreen"></button>
        <button class="pswp__button pswp__button--zoom" title="Zoom in/out"></button>
        <div class="pswp__preloader">
          <div class="pswp__preloader__icn">
            <div class="pswp__preloader__cut">
              <div class="pswp__preloader__donut"></div>
            </div>
          </div>
        </div>
      </div>
      <div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
        <div class="pswp__share-tooltip"></div>
      </div>
      <button class="pswp__button pswp__button--arrow--left" title="Previous (arrow left)"></button>
      <button class="pswp__button pswp__button--arrow--right" title="Next (arrow right)"></button>
      <div class="pswp__caption">
        <div class="pswp__caption__center"></div>
      </div>
    </div>
  </div>
</div>

<script>var base_url = '<?= base_url() ?>';</script>