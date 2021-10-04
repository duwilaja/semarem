<!-- 
  Jika sudah ke eksekusi, maka tombol 
  eksekusi di list pengaduan akan berubah 
  menjadi detail. Jika di klik akan ke halaman ini.
 --> 
<div class="container-fluid">
  <div class="row">
    <div class="col-sm-12">
      <div class="card">
        <!-- <div class="card-header">
          <form action="javascript:void();" id="form-filter">
              <div class="row g-3 select2-drpdwn">
                  <div class="col-md-4">
                      <label class="form-label" for="f_kategori_peng">Kategori</label>
                      <select class="js-example-placeholder-multiple col-sm-12" id="f_kategori_peng" multiple="multiple">
                      </select>
                  </div>
                  <div class="col-md-4">
                    <label class="form-label" for="f_date_interval">Rentan Waktu</label>
                    <input class="form-control" id="f_date_interval" type="text" name="f_date_interval" value="<?=date('Y/m/d').' - '.date('Y/m/d') ?>">
                  </div>
                  <div class="col-md-4">
                      <label class="form-label" for="f_status">Status</label>
                      <select class="js-example-placeholder-multiple col-sm-12" id="f_status" multiple="multiple">
                        <option value="AL">Alabama</option>
                        <option value="WY">Wyoming</option>
                        <option value="WY">Coming</option>
                        <option value="WY">Hanry Die</option>
                        <option value="WY">John Doe</option>
                      </select>
                  </div>
                  <div class="col-md-12">
                    <button type="reset" class="btn btn-light">Reset</button>
                    <button type="submit" class="btn btn-danger">Filter</button>
                  </div>
              </div>
          </form>
        </div> -->
        <div class="card-body">
          <div class="table-responsive product-table">
            <table class="display" id="tabel">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Nama Petugas</th>
                  <th>Status</th>
                  <th>Di tugaskan oleh</th>
                  <th>Waktu</th>
                  <th>Bertugas</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- <div class="container-fluid">
  <div class="row">
    <div class="col-sm-12">
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col-md">
              <h5>Petugas</h5>
              <hr>
              <div class="row">
                <div class="col-md">
                  <p>Nama Petugas :</p>
                  <p>Status :</p>
                  <p>Di tugaskan oleh :</p>
                </div>
                <div class="col-md">
                  <p>Waktu bertugas :</p>
                  <p>Bukti foto :</p>
                </div>
              </div>
            </div>
            <div class="col-md">
              <h5>Operator</h5>
              <hr>
              <p>Nama Operator :</p>
              <p>Waktu selesai :</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div> -->

<!-- Modal Detail petugas dari laporan yang di eksekusi operator(gambar bukti petugas yang menangani) -->
<div class="modal fade" id="detail" tabindex="-1" aria-labelledby="detailLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="detailLabel">Detail</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-5">
            <p>Nama Petugas</p>
          </div>
          <div class="col-1">
            :
          </div>
          <div class="col-6">
            <p id="nama_petugas"></p>
          </div>
        </div>
        <div class="row">
          <div class="col-5">
            <p>Status</p>
          </div>
          <div class="col-1">
            :
          </div>
          <div class="col-6">
            <p id="status"></p>
            <!-- <p>Selesai</p> -->
          </div>
        </div>
        <div class="row">
          <div class="col-5">
            <p>Bukti foto bertugas</p>
          </div>
          <div class="col-1">
            :
          </div>
          <div class="col-1">
            <!-- bukti foto bertugas/ pengaduan/detail -->
            <div class="row my-gallery gallery" id="bukti_foto_bertugas">
              
            </div>
          </div>
          <div class="col-6">
            <!-- <p id="id"></p> -->
            <!-- <img src="" alt=""> -->
          </div>
        </div>
      </div>
    </div>
  </div>
</div>