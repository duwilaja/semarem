// A $( document ).ready() block.
$( document ).ready(function() {
    $('#f_status').select2({
        placeholder: "Select Status",
    });
    
    $('#f_kategori_peng').select2({
        placeholder: "Select Kategori",
    });

    $('#f_date_interval').daterangepicker({
        locale: {
            format: 'Y/MM/DD'
          }
    });
    get_kategori_pengaduan();
    get_status_pengaduan();
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
async function get(url = '') {
    // Default options are marked with *
    const response = await fetch(url, {
      method: 'POST', // *GET, POST, PUT, DELETE, etc.
      mode: 'cors', // no-cors, *cors, same-origin
      cache: 'no-cache', // *default, no-cache, reload, force-cache, only-if-cached
      credentials: 'same-origin', // include, *same-origin, omit
      headers: {
        'Content-Type': 'application/json'
        // 'Content-Type': 'application/x-www-form-urlencoded',
      },
      redirect: 'follow', // manual, *follow, error
      referrerPolicy: 'no-referrer', // no-referrer, *no-referrer-when-downgrade, origin, origin-when-cross-origin, same-origin, strict-origin, strict-origin-when-cross-origin, unsafe-url
    });
    return response.json(); // parses JSON response into native JavaScript objects
  }


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
            "url": '../backend/Api_pengaduan/dt',
            "type": "POST",
            "data" : {
                'f_status' : $('#f_status').val(),
                'f_kategori_peng' : $('#f_kategori_peng').val(),
                'i_peng' : $('#i_peng').val(),
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

function eksekusi(id='') {
    swal({
        title: "Konfirmasi",
        text: "Apakah anda yakin ingin menindak lanjuti pengaduan ini ?",
        icon: "warning",
        buttons: {
            cancel:true,
            confirmButtonText: "Ya",
        },
      }).then((isConfirm) => {
        if (isConfirm) {         
            let data = "pengaduan_id="+id
            postData('../backend/Api_pengaduan/eksekusi',data,{'Content-Type': 'application/x-www-form-urlencoded'}).then(data => window.location.assign('../Pengaduan/eksekusi?id='+id)); 
        }
      })
}
  
function modal_pengaduan() {
    $(".btn-pengaduan").click(function(){
        $('.modal_pengaduan').modal('show');
    });
}