<div class="container-fluid">
  <div class="row">
    <!-- Individual column searching (text inputs) Starts-->
    <div class="col-sm-12">
      <div class="card">
        <div class="card-header">
          <form action="javascript:void();" id="form-filter">
              <div class="row g-3 select2-drpdwn">
                  <div class="col-md-4">
                    <label class="form-label" for="f_date_interval">Rentan Waktu</label>
                    <input class="form-control" id="f_date_interval" type="text" name="f_date_interval" value="<?=date('Y/m/d').' - '.date('Y/m/d') ?>">
                  </div>
                  <div class="col-md-12">
                    <button type="reset" class="btn btn-light">Reset</button>
                    <button type="submit" class="btn btn-danger">Filter</button>
                  </div>
              </div>
          </form>
        </div>
        <div class="card-body">
          <div class="table-responsive product-table">
            <table class="display" id="tabel">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Pesan</th>
                  <th>Dari</th>
                  <th>Untuk</th>
                  <th>Tanggal</th>
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