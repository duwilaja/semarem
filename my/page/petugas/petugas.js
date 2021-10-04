$(document).ready(function() {
    dt();
    add();
    up();
    get_instansi();
    $('#instansi_id').select2({
        dropdownParent: $('#add')
    });
});


function modal_add() {
    $('#form_add')[0].reset(); // reset form on modals
    $('#add').modal('show'); // show bootstrap modal

    $('#btnSave').text('Simpan'); //change button text
    $('#btnSave').attr('disabled',false); //set button disable 
}

function add() { 
    var link = './backend/Api_petugas/in'; 
    $('#form_add').submit(function (e) { 
         $('#btnSave').text('Menyimpan...'); //change button text
         $('#btnSave').attr('disabled',true); //set button disable 
         e.preventDefault();
         $.ajax({
            type: "POST",
            url: link,
            data : $(this).serialize(),
            dataType: "json",
            success: function (r) {
                if (r.status) {
                    $('#add').modal('hide');
                    swal({
                        title:'Berhasil',
                        text:r.msg,
                        icon:'success'
                      });
                      dt();
                }else{
                    // $('#add').modal('hide');
                    swal({
                        title:'Gagal',
                        text: r.msg,
                        icon:'error'
                      });
                      $('#btnSave').text('Simpan'); //change button text
                      $('#btnSave').attr('disabled',false); //set button disable 
                    dt();
                }
                
            }
        });
     });
   
 }

 function modal_edit(id)
{
    // $('#form_edit')[0].reset(); // reset form on modals
    $('#edit').modal('show'); // show bootstrap modal

    $('#id').val(id);
    $.ajax({
        type: "GET",
        url: "./backend/Api_petugas/get?id="+id,
        dataType: "json",
        success: function (r) {
            r.forEach(v => {
                $('#nama_petugas').val(v.nama_petugas);
                $('#hp').val(v.hp);
                $('#activity').val(v.activity);
                get_instansi(v.instansi_id,'#e_instansi_id');
                get_unit(v.instansi_id,v.unit_id,'#e_unit_id');
            });
            $('#e_instansi_id').select2({
                dropdownParent: $('#edit')
            });
            $('#e_unit_id').select2({
                dropdownParent: $('#edit')
            });
            $('#activity').select2({
                // status petugas
                dropdownParent: $('#edit')
            });
        }
    });

    $('#btnUbah').text('Edit'); //change button text
    $('#btnUbah').attr('disabled',false); //set button disable 
}

function up() { 
    $('#form_edit').submit(function (e) { 
        $('#btnUbah').text('Editing...'); //change button text
        $('#btnUbah').attr('disabled',true); //set button disable 
        e.preventDefault();
        $.ajax({
            type: "post",
            url: "./backend/Api_petugas/up",
            data : $(this).serialize(),
            dataType: "json",
            success: function (r) {
                if(r.status == 1){
                    $('#edit').modal('hide');
                    swal({
                        title:'Berhasil',
                        text:r.msg,
                        icon:'success'
                      });
                    dt();
                }else{
                    $('#edit').modal('hide');
                    swal({
                        title:'Gagal',
                        text:r.msg,
                        icon:'error'
                      });
                }
            }
        }); 
    });
}

 function del(id)
 {
    swal({
        title: "Apakah anda yakin ?",
        text: "Anda tidak akan dapat mengembalikan ini!",
        icon: "warning",
        buttons: {
            cancel:true,
            confirmButtonText: "Ya, hapus!",
            },
      }).then((isConfirm) => {
        if (isConfirm) {         
            var link = './backend/Api_petugas/non'; 
            $.ajax({
                type: "POST",
                url: link,
                data : {'id' : id},
                dataType: "json",
                success: function (r) {
                    if (r.status) {
                        swal({
                            title:'Berhasil',
                            text:r.msg,
                            icon:'success'
                          });
                        dt();
                    }else{
                        swal({
                            title:'Gagal',
                            text:r.msg,
                            icon:'error'
                          });
                    }
                    
                }
            });
        }
      })
 }

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
            "url": './backend/Api_petugas/dt',
            "type": "POST",
        },
        //Set column definition initialisation properties
        "columnDefs": [{
            "targets": [0,2,6],
            "orderable": false
        }]
    });
  }

function get_instansi(id='',dom="#instansi_id") {
    $(dom).html('<option value="">--Pilih Instansi--</option>');
    $.ajax({
        type: "GET",
        url: "./backend/Api_instansi/get",
        dataType: "json",
        success: function (r) {
            r.forEach(v => {
                $(dom).append(`<option ${id == v.id ? "selected" : ""} value="${v.id}" >${v.nama_instansi}</option>`);
            });
        }
    });
}

function get_unit(id_i,unit_id='',dom='#unit_id') {
    $(dom).html('');
    $.ajax({
        type: "GET",
        url: "./backend/Api_unit/get?instansi_id="+id_i,
        dataType: "json",
        success: function (r) {
            r.forEach(v => {
                $(dom).append(`<option ${unit_id == v.id ? "selected" : ""} value="${v.id}" >${v.unit}</option>`);
            });
        }
    });
  }

$( "#instansi_id" ).change(function() {
    let id_i = $('#instansi_id').val();
    if ($('#instansi_id').val() != "") {
      get_unit(id_i);
      $('#unit_id').select2({
          dropdownParent: $('#add')
      });
      $('#unit_id').html('<option value="">--Pilih Unit--</option>');
      $('#unit_id').attr('disabled',false);
    }else {
      $('#unit_id').html('<option value="">--Pilih Unit--</option>');
      $('#unit_id').attr('disabled',true);
    }
});