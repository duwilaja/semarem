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
                  <th>Instansi</th>
                  <th class="w-25">Action</th>
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
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add New</h5>
        <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="" method="post" id="form_add">
          <div class="mb-3">
            <label for="Instansi" class="form-label">Instansi</label>
            <input type="text" class="form-control" name="nama_instansi" placeholder="">
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
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit</h5>
        <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="" method="post" id="form_edit">
          <input type="hidden" name="id" id="id">
          <div class="mb-3">
            <label for="Instansi" class="form-label">Instansi</label>
            <input type="text" class="form-control" id="instansi" name="nama_instansi" placeholder="">
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