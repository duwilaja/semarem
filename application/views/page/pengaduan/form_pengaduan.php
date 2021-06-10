    <style>
        /* ukuran peta */
        th, td {
        border: 1px solid black;
        
        }
        #tblmap{
            overflow: scroll;
        }
        #mapid {
            height: 100%;
        }
        #mapSearchContainer{
        position:fixed;
        top:20px;
        right: 40px;
        height:30px;
        width:180px;
        z-index:110;
        font-size:10pt;
        color:#5d5d5d;
        border:solid 1px #bbb;
        background-color:#f8f8f8;
        }
        .form-builder
        .nav-danger
        .nav-link.active,
        .form-builder
        .nav-danger
        .nav-danger
        .show>.nav-link,
        .form-builder
        .nav-danger
        .nav-pills.nav-danger
        .nav-link.active,
        .form-builder
        .nav-danger
        .nav-pills.nav-danger
        .show>.nav-link {
         border-radius: 5px;
        }
        .leaflet-pane {
            z-index: 0;
        }
    </style>
<div class="form-builder">
    <div class="container-fluid">
        <div class="row">
        <div class="col-sm-12">
            <div class="card">
            <div class="card-header">
                <h5>Input Pengaduan</h5>
            </div>
            <div class="card-body form-builder">
                <div class="form-builder-column">
                    <div class="row">
                     <div class="col-sm-12">
                        <div class="form-builder-2-header">
                            <div>
                            <ul class="nav nav-danger" id="pills-tab" role="tablist">
                                <li class="nav-item"><a class="nav-link active" id="pills-input-tab" data-bs-toggle="pill" href="#pills-input" role="tab" aria-controls="pills-input" aria-selected="true">Form Lokasi</a></li>
                                <li class="nav-item"><a class="nav-link" id="pills-radcheck-tab" data-bs-toggle="pill" href="#pills-radcheck" role="tab" aria-controls="pills-radcheck" aria-selected="false">Form Pelapor</a></li>
                            </ul>
                            </div>
                            <div>
                                <nav class="navbar navbar-expand-md p-0">
                                    <form class="form-inline">
                                        <a href="<?php echo base_url('Main/pengaduan');?>" class="btn btn-danger copy-btn" id="copy-to-clipboard" type="submit" data-clipboard-text="testing">Data Pengaduan</a>
                                    </form>
                                </nav>
                            </div>
                        </div>
                        </div>
                        <div class="col-lg-5 col-xl-5 " style="background-color: #f7f7f7;">
                            <div class="tab-content" id="pills-tabContent">
                                <div class="tab-pane fade show active" id="pills-input" role="tabpanel" aria-labelledby="pills-input-tab">
                                <form class="theme-form" action="javascript:void(0);" method="post">
                                <div class="mb-3 draggable">
                                    <label for="select-1">Kategori Kasus</label>
                                    <select class="form-control btn-square" id="i_kasus" name="i_kasus">
                                        <option value="-Pilih-">-Pilih-</option>
                                    </select>
                                    <!-- <p class="help-block">Wajib Diisi (*)</p> -->
                                    </div>
                                    <hr>
                                    <div class="mb-3 draggable">
                                        <div class="row">
                                            <div class="col-md-6">
                                            <label for="i_lat">Lattitude (*)</label>
                                            <input class="form-control btn-square" type="text" id="i_lat" name="i_lat" placeholder="Lattitude" readonly>
                                            </div>
                                            <div class="col-md-6">
                                            <label for="i_lat">Longtitude(*)</label>
                                            <input class="form-control btn-square" type="text" id="i_lng" name="i_lng" placeholder="Longtitude" readonly>
                                            </div>
                                        </div>
                                        <!-- <p class="help-block">Wajib Diisi (*)</p>     -->
                                    <!-- <label for="i_lat">Lat & Long (*)</label>
                                    <input class="form-control btn-square" type="text" id="i_latlong" placeholder="Lattitude & Longtitude" readonly>
                                    <input class="form-control btn-square" type="hidden" id="i_lat" name="i_lat" placeholder="Lattitude">
                                    <input class="form-control btn-square" type="hidden" id="i_lng" name="i_lng" placeholder="Longtitude">
                                    <p class="help-block">Wajib Diisi (*)</p> -->
                                    </div>
                                    <hr>
                                    <div class="mb-3 draggable">
                                    <label for="i_alamat">Alamat/Jalan (*)</label>
                                    <textarea class="form-control" id="i_alamat" name="i_alamat" rows="6"></textarea>
                                    <!-- <p class="help-block">Wajib Diisi (*)</p> -->
                                    </div>
                                    <hr>
                                <!-- </form> -->
                                </div>
                                <div class="tab-pane fade" id="pills-radcheck" role="tabpanel" aria-labelledby="pills-radcheck-tab">
                                <!-- <form class="theme-form"> -->
                                    <div class="mb-3 draggable">
                                    <label for="i_pelapor">Nama Pelapor </label>
                                    <input class="form-control btn-square" id="i_pelapor" name="i_pelapor" type="text" placeholder="Nama Pelapor">
                                    <!-- <p class="help-block">Wajib Diisi (*)</p> -->
                                    </div>
                                    <hr>
                                    <div class="mb-3 draggable">
                                    <label for="i_nohp">No HP </label>
                                    <input class="form-control btn-square" id="i_nohp" name="i_nohp" type="text" placeholder="No HP">
                                    <!-- <p class="help-block">Wajib Diisi (*)</p> -->
                                    </div>
                                    <hr>
                                    <div class="mb-3 draggable">
                                    <label for="i_ket">Keterangan </label>
                                    <textarea class="form-control" id="i_ket" name="i_ket" rows="3"></textarea>
                                    <!-- <p class="help-block">Wajib Diisi (*)</p> -->
                                    </div>
                                    </hr>
                                </form>
                                <div class="card-body text-end">
                                    <button class="btn btn-inp-pengaduan btn-danger" type="submit" id="inp_pengaduan">Submit</button>
                                    <a class="btn btn-primary" href="<?php echo base_url('Main/pengaduan');?>">Cancel</a>
                                </div>
                              </div>
                            </div>
                        </div>
                        <div class="col-lg-7 col-xl-7 lg-mt">
                            <div id="mapid">
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Form builder column wise ends-->
                <!-- Container-fluid Ends-->
            </div>
            </div>
        </div>
        </div>
        </div>
    </div>