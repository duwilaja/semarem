<div class="container-fluid">
  <div class="row">
    <!-- Individual column searching (text inputs) Starts-->
    <div class="col-sm-12">
      <div class="card">
        <!-- <div class="card-header">
        </div> -->
        <div class="card-body">
          <div class="text-end">
            <div class="mb-3">
              <a href="javascript:void(0)" class="btn btn-success" onclick="modal_add()"><i class="fa fa-plus"></i> Add New</a>
            </div>
          </div>
          <div class="table-responsive product-table">
            <table class="display" id="tabel">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Nama Petugas</th>
                  <th>HP</th>
                  <th>Instansi</th>
                  <th>Unit</th>
                  <th>Activity</th>
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
    <!-- Individual column searching (text inputs) Ends-->
  </div>
</div>

<!-- Modal add -->
<div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add New Petugas</h5>
        <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="" method="post" id="form_add">
            <div class="row">
                <div class="col-6 mb-3">
                  <label for="namaPetugas" class="form-label">Nama Petugas<sup class="text-danger">*</sup></label>
                  <input type="text" class="form-control" name="nama_petugas" placeholder="" required>
                </div>
                <div class="col-6 mb-3">
                  <label for="Email" class="form-label">Email<sup class="text-danger">*</sup></label>
                  <input type="email" class="form-control" name="email" placeholder="" required>
                </div>
            </div>
            <div class="row">
                <div class="col-4 mb-3">
                  <label for="handPhone" class="form-label">Handphone<sup class="text-danger">*</sup></label>
                  <input type="text" class="form-control" name="hp" placeholder="" required>
                </div>
                <div class="col-4 mb-3">
                  <label for="instansi" class="form-label">Instansi<sup class="text-danger">*</sup></label>
                  <select name="instansi_id" id="instansi_id" class="form-control" required>
                      <option value="">--Pilih Instansi--</option>
                  </select>
                </div>
                <div class="col-4 mb-3">
                  <label for="Unit" class="form-label">Unit<sup class="text-danger">*</sup></label>
                  <select name="unit_id" id="unit_id" class="form-control" required disabled>
                      <option value="">--Pilih Unit--</option>
                  </select>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-6 mb-3">
                  <label for="username" class="form-label">Username<sup class="text-danger">*</sup></label>
                  <input type="text" class="form-control" name="username" placeholder="" required>
                </div>
                <div class="col-6 mb-3">
                  <label for="password" class="form-label">Password<sup class="text-danger">*</sup></label>
                  <input type="password" class="form-control" name="password" placeholder="" required>
                </div>
            </div>
        </div>
        <div class="modal-footer">
          <button class="btn btn-primary" type="button" data-bs-dismiss="modal">Close</button>
          <button class="btn btn-secondary" type="submit" id="btnSave">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal edit -->
<div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit</h5>
        <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="" method="post" id="form_edit">
          <input type="hidden" name="id" id="id">
          <div class="row">
                <div class="col-6 mb-3">
                  <label for="namaPetugas" class="form-label">Nama Petugas<sup class="text-danger">*</sup></label>
                  <input type="text" class="form-control" name="nama_petugas" id="nama_petugas" placeholder="" required>
                </div>
                <div class="col-6 mb-3">
                  <label for="handPhone" class="form-label">Handphone<sup class="text-danger">*</sup></label>
                  <input type="text" class="form-control" name="hp" id="hp" placeholder="" required>
                </div>
            </div>
            <div class="row">
                <div class="col-6 mb-3">
                  <label for="instansi" class="form-label">Instansi<sup class="text-danger">*</sup></label>
                  <select name="instansi_id" id="e_instansi_id" onchange="get_unit(this.value,'','#e_unit_id')" class="form-control" required>
                      <option value="">--Pilih Instansi--</option>
                  </select>
                </div>
                <div class="col-6 mb-3">
                  <label for="Unit" class="form-label">Unit<sup class="text-danger">*</sup></label>
                  <select name="unit_id" id="e_unit_id" class="form-control" required>
                      <option value="">--Pilih Unit--</option>
                  </select>
                </div>
            </div>
            <div class="row">
              <div class="col-md-6 mb3">
                <label for="instansi" class="form-label">Activity<sup class="text-danger">*</sup></label>
                <select name="activity" id="activity" class="form-control" required>
                    <option value="">--Activity--</option>
                    <option value="0">Siap bertugas</option>                    
                    <option value="1">Istirahat</option>                    
                    <option value="2">Sedang menerima tugas</option>                    
                </select>
              </div>
            </div>
        </div>
        <div class="modal-footer">
          <button class="btn btn-primary" type="button" data-bs-dismiss="modal">Close</button>
          <button class="btn btn-secondary" type="submit" id="btnUbah">Edit</button>
        </div>
      </form>
    </div>
  </div>
</div>