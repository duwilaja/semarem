// A $( document ).ready() block.
$( document ).ready(function() {
    modal_pengaduan();
});




function modal_pengaduan() {
    $(".btn-pengaduan").click(function(){
        $('.modal_pengaduan').modal('show');
    });
}