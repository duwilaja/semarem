// A $( document ).ready() block.
const pengaduan_id = $('#pengaduan_id').val()
$( document ).ready(function() {
  // $('#f_status').select2({
  //     placeholder: "Select Status",
  // });
  
  // $('#f_kategori_peng').select2({
  //     placeholder: "Select Kategori",
  // });

  // $('#f_date_interval').daterangepicker({
  //     locale: {
  //         format: 'Y/MM/DD'
  //       }
  // });
  // get_kategori_pengaduan();
  // get_status_pengaduan();
  set_detail();
  dt();
});

function get_kategori_pengaduan() {
  $('#f_kategori_peng').html('');
  get('../backend/Api_kategori/get')
  .then(data => {
      data.forEach(e => {
          // $('#f_kategori_peng').append('<option selected="selected">Kecelakaan</option>');
          $('#f_kategori_peng').append('<option '+(e.priority == '1' ? 'selected' : '')+'  value="'+e.id+'">'+e.peng_kategori+'</option>');
      });
  })
}

function get_status_pengaduan() {
  $('#f_status').html('');
  get('../backend/Api_pengaduan/get_status')
  .then(data => {
      data.forEach(e => {
          $('#f_status').append('<option value="'+e.id+'">'+e.status+'</option>');
      });
  })
}

// Example POST method implementation:
// async function get(url = '') {
//   // Default options are marked with *
//   const response = await fetch(url, {
//     method: 'POST', // *GET, POST, PUT, DELETE, etc.
//     mode: 'cors', // no-cors, *cors, same-origin
//     cache: 'no-cache', // *default, no-cache, reload, force-cache, only-if-cached
//     credentials: 'same-origin', // include, *same-origin, omit
//     headers: {
//       'Content-Type': 'application/json'
//       // 'Content-Type': 'application/x-www-form-urlencoded',
//     },
//     redirect: 'follow', // manual, *follow, error
//     referrerPolicy: 'no-referrer', // no-referrer, *no-referrer-when-downgrade, origin, origin-when-cross-origin, same-origin, strict-origin, strict-origin-when-cross-origin, unsafe-url
//   });
//   return response.json(); // parses JSON response into native JavaScript objects
// }


// Example POST method implementation:
async function postData(url = '', data = {},headers = {  'Content-Type': 'application/json'}) {
  // Default options are marked with *
  const response = await fetch(url, {
    method: 'POST', // *GET, POST, PUT, DELETE, etc.
    mode: 'cors', // no-cors, *cors, same-origin
    cache: 'no-cache', // *default, no-cache, reload, force-cache, only-if-cached
    credentials: 'same-origin', // include, *same-origin, omit
    headers:headers,
    redirect: 'follow', // manual, *follow, error
    referrerPolicy: 'no-referrer', // no-referrer, *no-referrer-when-downgrade, origin, origin-when-cross-origin, same-origin, strict-origin, strict-origin-when-cross-origin, unsafe-url
    body: data // body data type must match "Content-Type" header
  });
  return response.json(); // parses JSON response into native JavaScript objects
}

$('#form-filter').submit(function (e) { 
  e.preventDefault();
  dt();
});


// ====== detail keterangan pengaduan (Pengaduan/detail/ ) ini data tablenya =======
function dt() {
  $('#tabel').DataTable({
      // Processing indicator
      "bAutoWidth": false,
      "destroy": true,
      "searching": true,
      "processing": true,
      // DataTables server-side processing mode
      "serverSide": true,
      "scrollX": true,
      // Initial no order.
      "order": [],
      // Load data from an Ajax source
      "ajax": {
          "url": '../dt_detail_peng',
          "type": "POST",
          "data" : {
              'f_status' : $('#f_status').val(),
              'f_kategori_peng' : $('#f_kategori_peng').val(),
              'pengaduan_id' : pengaduan_id,
              'f_date_interval' : $('#f_date_interval').val(),
              'operator' : $('#operator').val()
          }
      },
      //Set column definition initialisation properties
      "columnDefs": [{
          "targets": [0,2,6],
          "orderable": false
      }]
  });
}
// ===================================================================================


// function eksekusi(id='') {
//   swal({
//       title: "Konfirmasi",
//       text: "Apakah anda yakin ingin menindak lanjuti pengaduan ini ?",
//       icon: "warning",
//       buttons: {
//           cancel:true,
//           confirmButtonText: "Ya",
//       },
//     }).then((isConfirm) => {
//       if (isConfirm) {         
//           let data = "pengaduan_id="+id
//           postData('../backend/Api_pengaduan/eksekusi',data,{'Content-Type': 'application/x-www-form-urlencoded'}).then(data => window.location.assign('../Pengaduan/eksekusi?id='+id)); 
//       }
//     })
// }

function modal_pengaduan() {
  $(".btn-pengaduan").click(function(){
      $('.modal_pengaduan').modal('show');
  });
}

// ================== Modal Detail Pengaduan/detail/ =================================
function modal_detail(task_assign_id,petugas_id){
    $('#detail').modal('show'); // show bootstrap modal
    $('#content-detail').html('');
  $.ajax({
        type: "POST",
        url: "../../Api/detail_task_history_petugas/"+pengaduan_id,
        headers: {"token": "5b3dac76aaee24d14185cbc3d010fd20"},
        data : {
          petugas_id : petugas_id,
          task_assign_id : task_assign_id
        },
        dataType: "json",
        success: function (r) {
          // console.log(r)
          // document.getElementById("#judul_pengaduan").innerHTML = r.data.task_kategori;
           $('#content-detail').append(`
                  <div class="row">
                    <div class="col-5">
                      <span>Kategori</span>
                    </div>
                    <div class="col-1">
                      <p>:</p>
                    </div>
                    <div class="col-6">
                      <p class="badge badge-secondary">${r.data.task_kategori}</p>
                    </div>
                  </div>
                  <span class="text-muted">
                    <i class="fa fa-clock-o text-success"></i>&nbsp;&nbsp;${r.data.tanggal}
                  </span>
                  <br>
                  <span class="text-muted">
                    <i class="fa fa-map-marker text-success"></i>&nbsp;&nbsp;${r.data.alamat}
                  </span>
                  <br>
                  <br>
                  <div class="mb-3">
                    <label for="Pelapor" class="form-label">Pelapor</label>
                    <div class="p-2" style="background-color:#E0EE92;border-radius:10px;color:#000;">
                    ${r.data.nama_pelapor}
                      <br> ${r.data.telp}
                    </div>
                  </div>
                  <div class="mb-3">
                    <label for="buktiPelapor" class="form-label">Bukti Pelapor</label>
                    <div class="row my-gallery gallery" id="list_img_pelapor">
                 
                    </div>
                  </div>
                  <div class="mb-3">
                    <label for="Penanganan" class="form-label">Penanganan</label>
                    <div class="row">
                      <div class="col-5">
                        <span class="text-muted">Status</span>
                      </div>
                      <div class="col-1">
                        <p>:</p>
                      </div>
                      <div class="col-6">
                        <p class="badge badge-success">${r.data.status_name}</p>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-5">
                        <span class="text-muted">Lama Penanganan</span>
                      </div>
                      <div class="col-1">
                        <p>:</p>
                      </div>
                      <div class="col-6">
                        <p class="badge badge-warning">${r.data.penanganan.calc} menit</p>
                      </div>
                    </div>
                  </div>
                  <div class="mb-3">
                    <label for="buktiPenanganan" class="form-label">Bukti Penanganan</label>
                    <div class="row my-gallery gallery" id="list_img_pengaduan">
                    </div>
                  </div>
                  <div class="mb-3">
                    <label for="Penyebab" class="form-label">Penyebab</label>
                    <div style="padding:10px;border: solid 2px #EEE;color: #FFF;font-size: 12px;border-radius: 20px;">
                    ${!r.data.task_done ? '' : r.data.task_done.penyebab}
                    </div>
                  </div>
                  <div class="mb-3">
                    <label for="Tindakan" class="form-label">Tindakan</label>
                    <div style="padding:10px;border: solid 2px #EEE;color: #FFF;font-size: 12px;border-radius: 20px;">
                    ${!r.data.task_done ? '' : r.data.task_done.tindakan}
                    </div>
                  </div>
                  <div class="mb-3">
                    <label for="Keterangan" class="form-label">Keterangan</label>
                    <div style="padding:10px;border: solid 2px #EEE;color: #FFF;font-size: 12px;border-radius: 20px;">
                    ${!r.data.task_done ? '' :  r.data.task_done.keterangan}
                    </div>
                  </div>
            `);
        }
    });
}
// =======================================================================

// ============ Keterangan di Detail Pengaduan ===========================
function set_detail(){
  $.ajax({
    type: "GET",
    url: "../detail_pengaduan/"+pengaduan_id,
    headers: {"token": "5b3dac76aaee24d14185cbc3d010fd20"},
    dataType: "json",
      success: function (r) {
        console.log(r);
        $('#keterangan').text(r.keterangan);
        $('#nama_pelapor').text(r.nama_pelapor);
        // $('#mail').text(r.mail);
        $('#telp').text(r.telp);
      }
  });
}
// =========================================================================