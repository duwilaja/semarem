<!-- 
  Jika sudah ke eksekusi, maka tombol 
  eksekusi di list pengaduan akan berubah 
  menjadi detail. Jika di klik akan ke halaman ini.
 --> 
<!-- ==================== Untuk Pengaduan detail ================================== -->
  <input type="hidden" id="pengaduan_id" value="<?= $this->uri->segment(3)?>"></input>
<!-- ============================================================================== -->

<div class="container-fluid">
  <div class="row">
    <div class="col-sm-12">
      <div class="card">
        <div class="card-header">
          <!-- keterangan -->
          <h5>Keterangan</h5>
          <br>

          <div class="row">
            <div class="col">
              <label>Nama Pelapor :<p id="nama_pelapor"></p></label>
            </div>
            <div class="col">
              <label>Nomer telepon :<p id="telp"></p></label>
            </div>
            <div class="col">
              <label>Keterangan Pengaduan :<p id="keterangan"></p> </label>
            </div>
            <!-- <div class="col">
              <label>Mail :<p id="mail"></p></label>
            </div> -->
          </div>
          
        </div>
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
<!-- <div class="modal fade" id="detail" tabindex="-1" aria-labelledby="detailLabel" aria-hidden="true">
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
            <div class="row my-gallery gallery" id="bukti_foto_bertugas">
              
            </div>
          </div>
          <div class="col-6">
          </div>
        </div>
      </div>
    </div>
  </div>
</div> -->

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