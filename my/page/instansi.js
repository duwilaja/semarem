$(document).ready(function() {
    dt();
    add();
    up();
});


function modal_add() {
    $('#form_add')[0].reset(); // reset form on modals
    $('#add').modal('show'); // show bootstrap modal

    $('#btnSave').text('Simpan'); //change button text
    $('#btnSave').attr('disabled',false); //set button disable 
}

function add() { 
    var link = '../backend/Api_instansi/in'; 
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
                    $('#add').modal('hide');
                    swal({
                        title:'Gagal',
                        text: r.msg,
                        icon:'error'
                      });
                    dt();
                }
                
            }
        });
     });
   
 }

 function modal_edit(id)
{
    $('#form_edit')[0].reset(); // reset form on modals
    $('#edit').modal('show'); // show bootstrap modal

    $('#id').val(id);
    $.ajax({
        type: "GET",
        url: "../backend/Api_instansi/get?id="+id,
        dataType: "json",
        success: function (v) {
            $('#instansi').val(v[0].nama_instansi);
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
            url: "../backend/Api_instansi/up",
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
            var link = '../backend/Api_instansi/del'; 
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
            "url": '../backend/Api_instansi/dt',
            "type": "POST",
        },
        //Set column definition initialisation properties
        "columnDefs": [{
            "targets": [0,2],
            "orderable": false
        }]
    });
  }