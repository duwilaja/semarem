var indicarKey = [];
var arr_realtime_car = [];
var arr_instansi = [];
var arr_petugas = [];

var peng_lat = "-7.560908240809835";
var peng_lng = "110.8146920770371";

var url_satupeta = "../../satupeta";

$(document).ready(function () {
	realtime_car();
	petugas();
	instansi();
	list_assign();
	pengaduan();
	up_pengaduan();
});

function frame(url = "") {
	document.getElementById("frame").src = url;
}

function refresh() {
	list_assign();
	pengaduan();
	realtime_car();
	petugas();
}

function list_detail() {
	if ($("#list_detail").hasClass("d-none")) {
		$("#list_detail").removeClass("d-none");
	} else {
		$("#list_detail").addClass("d-none");
	}
}

function getDistanceFromLatLngInKm(lat1, lon1, lat2, lon2) {
	var R = 6371; // Radius of the earth in km
	var dLat = deg2rad(lat2 - lat1); // deg2rad below
	var dLon = deg2rad(lon2 - lon1);
	var a =
		Math.sin(dLat / 2) * Math.sin(dLat / 2) +
		Math.cos(deg2rad(lat1)) *
			Math.cos(deg2rad(lat2)) *
			Math.sin(dLon / 2) *
			Math.sin(dLon / 2);
	var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
	var d = R * c; // Distance in km
	return d;
}

function deg2rad(deg) {
	return deg * (Math.PI / 180);
}

async function getData(url = "", data = {}) {
	// Default options are marked with *
	const response = await fetch(url, {
		method: "GET", // *GET, POST, PUT, DELETE, etc.
		mode: "cors", // no-cors, *cors, same-origin
		cache: "no-cache", // *default, no-cache, reload, force-cache, only-if-cached
		credentials: "same-origin", // include, *same-origin, omit
		headers: {
			"Content-Type": "application/json",
			// 'Content-Type': 'application/x-www-form-urlencoded',
		},
		redirect: "follow", // manual, *follow, error
		referrerPolicy: "no-referrer", // no-referrer, *no-referrer-when-downgrade, origin, origin-when-cross-origin, same-origin, strict-origin, strict-origin-when-cross-origin, unsafe-url
	});
	return response.json(); // parses JSON response into native JavaScript objects
}

async function postData(url = "", data = {}, token = "") {
	// Default options are marked with *
	const response = await fetch(url, {
		method: "POST", // *GET, POST, PUT, DELETE, etc.
		mode: "cors", // no-cors, *cors, same-origin
		cache: "no-cache", // *default, no-cache, reload, force-cache, only-if-cached
		credentials: "same-origin", // include, *same-origin, omit
		headers: {
			"Content-Type": "application/json",
			Accept: "application/json",
			Authorization: "Bearer " + indicarKey.indicarToken,
			// 'Content-Type': 'application/x-www-form-urlencoded',
		},
		redirect: "follow", // manual, *follow, error
		referrerPolicy: "no-referrer", // no-referrer, *no-referrer-when-downgrade, origin, origin-when-cross-origin, same-origin, strict-origin, strict-origin-when-cross-origin, unsafe-url
		body: JSON.stringify(data), // body data type must match "Content-Type" header
	});
	return response.json(); // parses JSON response into native JavaScript objects
}

// Example POST method implementation:
async function post(
	url = "",
	data = {},
	headers = { "Content-Type": "application/json" }
) {
	// Default options are marked with *
	const response = await fetch(url, {
		method: "POST", // *GET, POST, PUT, DELETE, etc.
		mode: "cors", // no-cors, *cors, same-origin
		cache: "no-cache", // *default, no-cache, reload, force-cache, only-if-cached
		credentials: "same-origin", // include, *same-origin, omit
		headers: headers,
		redirect: "follow", // manual, *follow, error
		referrerPolicy: "no-referrer", // no-referrer, *no-referrer-when-downgrade, origin, origin-when-cross-origin, same-origin, strict-origin, strict-origin-when-cross-origin, unsafe-url
		body: data, // body data type must match "Content-Type" header
	});
	return response.json(); // parses JSON response into native JavaScript objects
}

// Kendaraan realtime
function realtime_car() {
	$("#list_realtime_car").html("");
	getData("../indicar/Api/get_token").then((key) => {
		indicarKey = key;
		postData(
			"https://www.indicar.id/platform/public/index.php/sysapi/vehicles/list",
			{}
		).then((data) => {
			arr_realtime_car = [];
			arr_realtime_car = data.dataset;
			data.dataset.forEach((e) => {
				$("#list_realtime_car").append(`
                <li class="clearfix"><img class="rounded-circle user-image" src="../template/cuba/assets/images/user/12.png" alt="">
                    <div class="status-circle ${
											e.speed > 0 ? "online" : "offline"
										}"></div>
                    <div class="row">
                        <a href="javascript:void(0)" class="col-8" style="color:black;" onclick="detail('car','${
													e.nopol
												}')">
                            <div class="name">${e.vehiclename}</div>
                            <div class="status">${e.vehiclegroup}</div>
                        </a>
                        <div class="col-2">
                            <a href="javascript:void(0);" onclick="assign()" class="btn btn-success" style="padding: .2rem .4rem!important;"><i class="fa fa-plus"></i></a>
                        </div>
                    </div>
                </li>`);
			});
		});
	});
}

function filter_realtime_car(v) {
	let arr = arr_realtime_car.filter(
		(x) => x.vehiclename.toLowerCase().indexOf(v.toLowerCase()) !== -1
	);
	$("#list_realtime_car").html("");
	arr.forEach((e) => {
		$("#list_realtime_car").append(`
        <li class="clearfix"><img class="rounded-circle user-image" src="../template/cuba/assets/images/user/12.png" alt="">
            <div class="status-circle ${
							e.speed > 0 ? "online" : "offline"
						}"></div>
            <div class="row">
                <a href="javascript:void(0)" class="col-8" style="color:black;" onclick="detail('car','${
									e.nopol
								}')">
                    <div class="name">${e.vehiclename}</div>
                    <div class="status">${e.vehiclegroup}</div>
                </a>
                <div class="col-2">
                    <a href="javascript:void(0);" onclick="assign()" class="btn btn-success" style="padding: .2rem .4rem!important;"><i class="fa fa-plus"></i></a>
                </div>
            </div>
        </li>`);
	});
}

// Petugas
function petugas() {
	$("#list_petugas").html("");
	getData(
		"../backend/Api_petugas/get?lokasi_pengaduan=" + peng_lat + "," + peng_lng
	).then((data) => {
		arr_petugas = [];
		data.sort((a, b) => a.jarak - b.jarak);
		arr_petugas = data;
		arr_petugas.forEach((e) => {
			$("#list_petugas").append(`
              <li class="clearfix"><img class="rounded-circle user-image" src="../template/cuba/assets/images/user/12.png" alt="">
                  <div class="status-circle ${
										e.activity == 0 ? "online" : "offline"
									}"></div>
                  <div class="row">
                      <a href="javascript:void(0)" style="color:black;" onclick="detail('petugas',${
												e.id
											})" class="${e.activity == 0 ? "col-8" : "col-12"}">
                          <div class="name">${e.nama_instansi} - ${
				e.nama_petugas
			}</div>
                          <div class="status">${e.jarak.toFixed(2)} Km</div>
                      </a>
                      ${
												e.activity == 0
													? `<div class="col-2">
                      <a href="#" class="btn btn-success" onclick="assign_petugas(${$(
												"#pengaduan_id"
											).val()},${
															e.id
													  })" style="padding: .2rem .4rem!important;"><i class="fa fa-plus"></i></a>
                  </div>`
													: ""
											} 
                  </div>
              </li>`);
		});
	});
}

function filter_petugas(v) {
	let arr = arr_petugas.filter(
		(x) => x.nama_instansi.toLowerCase().indexOf(v.toLowerCase()) !== -1
	);
	$("#list_petugas").html("");
	arr.forEach((e) => {
		$("#list_petugas").append(`
        <li class="clearfix"><img class="rounded-circle user-image" src="../template/cuba/assets/images/user/12.png" alt="">
        <div class="status-circle ${
					e.activity == 0 ? "online" : "offline"
				}"></div>
        <div class="row">
            <a href="javascript:void(0)" class="col-8" style="color:black;" onclick="detail('petugas',${
							e.id
						})">
                <div class="name">${e.nama_petugas}</div>
                <div class="status">${e.jarak.toFixed(2)} Km</div>
            </a>
            <div class="col-2">
                <a href="#" class="btn btn-success" onclick="assign_petugas(${
									e.id
								})" style="padding: .2rem .4rem!important;"><i class="fa fa-plus"></i></a>
            </div>
        </div>
      </li>`);
	});
}

// Instansi
function instansi() {
	getData(
		"../backend/Api_lokasi/get_priority?lokasi_pengaduan=" +
			peng_lat +
			"," +
			peng_lng
	).then((data) => {
		arr_instansi = [];
		data.sort((a, b) => a.jarak - b.jarak);
		arr_instansi = data;
		data.forEach((e) => {
			$("#list_instansi").append(`
              <li class="clearfix"><img class="rounded-circle user-image" src="../template/cuba/assets/images/user/12.png" alt="">
              <div class="status-circle online"></div>
              <div class="row">
                  <div class="col-8">
                      <div class="name">${e.nama_lokasi}</div>
                      <div class="status">${e.jarak.toFixed(2)} Km</div>
                  </div>
                  <div class="col-2">
                      <a href="#" class="btn btn-success" style="padding: .2rem .4rem!important;"><i class="fa fa-plus"></i></a>
                  </div>
              </div>
            </li>`);
		});
	});
}

function filter_instansi(v) {
	let arr = arr_instansi.filter(
		(x) => x.nama_instansi.toLowerCase().indexOf(v.toLowerCase()) !== -1
	);
	$("#list_instansi").html("");
	arr.forEach((e) => {
		$("#list_instansi").append(`
        <li class="clearfix"><img class="rounded-circle user-image" src="../template/cuba/assets/images/user/12.png" alt="">
        <div class="status-circle online></div>
        <div class="row">
            <div class="col-8">
                <div class="name">${e.nama_lokasi}</div>
                <div class="status">${getDistanceFromLatLngInKm(
									e.lat,
									e.lng,
									peng_lat,
									peng_lng
								).toFixed(2)} Km</div>
            </div>
            <div class="col-2">
                <a href="#" class="btn btn-success" style="padding: .2rem .4rem!important;"><i class="fa fa-plus"></i></a>
            </div>
        </div>
      </li>`);
	});
}

  //Detail detail
  function detail(type,task_assign_id,petugas_id) {
    $('#detail').modal('show'); // show modal
    $('#content-detail').html('');
    if (type == 'petugas') {
      $.ajax({
        type: "GET",
        url: "../backend/Api_petugas/get?id="+task_assign_id,
        dataType: "json",
        success: function (r) {
            r.forEach(v => {
              $('#content-detail').append(`
                <div class ="row">
                  <div class="col-5">
                    <p>Nama Petugas</p>
                  </div>
                  <div class="col-1">
                    <p>:</p>
                  </div>
                  <div class="col-6">
                    <p>${v.nama_petugas}</p>
                  </div>
                </div>
                <div class ="row">
                  <div class="col-5">
                    <p>Nama Instansi</p>
                  </div>
                  <div class="col-1">
                    <p>:</p>
                  </div>
                  <div class="col-6">
                    <p>${v.nama_instansi}</p>
                  </div>
                </div>
                <div class ="row">
                  <div class="col-5">
                    <p>Status</p>
                  </div>
                  <div class="col-1">
                    <p>:</p>
                  </div>
                  <div class="col-6">
                    <p>${
											v.activity == 0
												? "Siap Bertugas"
												: v.activity == 1
												? "Istirahat"
												: "Sedang Menerima Tugas"
										}</p>
                  </div>
                </div>
              `);
				});
			},
		});
	}
	if (type == "car") {
		console.log(task_assign_id);
		getData("../indicar/Api/get_token").then((key) => {
			indicarKey = key;
			data = `nopols=${task_assign_id}`;
			postData(
				"https://www.indicar.id/platform/public/index.php/sysapi/vehicles/detailbynopol",
				{ nopols: task_assign_id }
			).then((data) => {
				arr_realtime_car = [];
				arr_realtime_car = data.dataset;
				data.dataset.forEach((e) => {
					frame(
						url_satupeta +
							"?lokasi=" +
							peng_lat +
							"," +
							peng_lng +
							"&nopol=" +
							e.nopol
					);
					$("#content-detail").append(`
                  <div class ="row">
                    <div class="col-5">
                      <p>Nama Kendaraan</p>
                    </div>
                    <div class="col-1">
                      <p>:</p>
                    </div>
                    <div class="col-6">
                      <p>${e.vehiclename}</p>
                    </div>
                  </div>
                  <div class ="row">
                    <div class="col-5">
                      <p>No Polisi</p>
                    </div>
                    <div class="col-1">
                      <p>:</p>
                    </div>
                    <div class="col-6">
                      <p>${e.nopol}</p>
                    </div>
                  </div>
                  <div class ="row">
                    <div class="col-5">
                      <p>Nama Instansi</p>
                    </div>
                    <div class="col-1">
                      <p>:</p>
                    </div>
                    <div class="col-6">
                      <p>${e.vehiclegroup}</p>
                    </div>
                  </div>
                  <div class ="row">
                    <div class="col-5">
                      <p>Merk Kendaraan</p>
                    </div>
                    <div class="col-1">
                      <p>:</p>
                    </div>
                    <div class="col-6">
                      <p>${e.merkname}</p>
                    </div>
                  </div>
                  <div class ="row">
                    <div class="col-5">
                      <p>Status</p>
                    </div>
                    <div class="col-1">
                      <p>:</p>
                    </div>
                    <div class="col-6">
                      <p>${
												e.activity == 0
													? '<span class="badge badge-success">online</span>'
													: '<span class="badge badge-danger">offline</span>'
											}</p>
                    </div>
                  </div>
                `);
				});
			});
		});
	}
	if (type == "assign") {
		$.ajax({
			type: "GET",
			url: "../backend/Api_pengaduan/peng_assign_where?id=" + task_assign_id,
			dataType: "json",
			success: function (r) {
				r.data.forEach((v) => {
					$("#content-detail").append(`
                <div class ="row">
                  <div class="col-5">
                    <p>Nama Petugas</p>
                  </div>
                  <div class="col-1">
                    <p>:</p>
                  </div>
                  <div class="col-6">
                    <p>${v.nama_petugas}</p>
                  </div>
                </div>
                <div class ="row">
                  <div class="col-5">
                    <p>Nama Instansi</p>
                  </div>
                  <div class="col-1">
                    <p>:</p>
                  </div>
                  <div class="col-6">
                    <p>${v.nama_instansi}</p>
                  </div>
                </div>
                <div class ="row">
                  <div class="col-5">
                    <p>Status</p>
                  </div>
                  <div class="col-1">
                    <p>:</p>
                  </div>
                  <div class="col-6">
                    <p>${v.status_static}</p>
                  </div>
                </div>
              `);
            });
        }
    });
    }
    if (type == "peng_assign_log") {
      $.ajax({
        type: "POST",
        url: "../Api/detail_task_history_petugas",
        headers: {"token": "5b3dac76aaee24d14185cbc3d010fd20"},
        data : {
          petugas_id : petugas_id,
          task_assign_id : task_assign_id
        },
        dataType: "json",
        success: function (r) {
            $('#content-detail').append(`
              <div class="row">
                <div class="col-5">
                  <span>Kategori</span>
                </div>
                <div class="col-1">
                  <p>:</p>
                </div>
                <div class="col-6">
                  <p class="badge badge-secondary">${r.data.judul}</p>
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
                <div class="p-2" style="background-color:#E0EE92;">
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
                <div style="padding:10px;border: solid 2px #EEE;color: #555;font-size: 12px;border-radius: 20px;">
                ${!r.data.task_done ? '' : r.data.task_done.penyebab}
                </div>
              </div>
              <div class="mb-3">
                <label for="Tindakan" class="form-label">Tindakan</label>
                <div style="padding:10px;border: solid 2px #EEE;color: #555;font-size: 12px;border-radius: 20px;">
                ${!r.data.task_done ? '' : r.data.task_done.tindakan}
                </div>
              </div>
              <div class="mb-3">
                <label for="Keterangan" class="form-label">Keterangan</label>
                <div style="padding:10px;border: solid 2px #EEE;color: #555;font-size: 12px;border-radius: 20px;">
                ${!r.data.task_done ? '' :  r.data.task_done.keterangan}
                </div>
              </div>
            `);

            setTimeout(() => {
              create_show_img(r.data.img_task_done);
              create_show_img(r.data.img_pengaduan,false);
            }, 300);

          }
      });
      let imported = document.createElement('script');
      imported.src = `${base_url}template/cuba/assets/js/photoswipe/photoswipe.js`;
      document.head.appendChild(imported);
    }
  }

  function  create_show_img(data,done=true) {
    if (done) {
      $('#list_img_pengaduan').html('');
        data.forEach(e => {
          $('#list_img_pengaduan').append(`<figure class="col-md-3 col-6 img-hover hover-1" ><a href="${e.full_file}" data-size="1600x950">
              <div><img src="${e.full_file}" alt="Gambar Penanganan"></div></a>
            <figcaption>Foto Bukti Penanganan</figcaption>
          </figure>`);
        }); 
    }else{
      $('#list_img_pelapor').html('');
      if (data.length > 0 ) {
        data.forEach(e => {
          $('#list_img_pelapor').append(`<figure class="col-md-3 col-6 img-hover hover-1" ><a href="${e.full_file}" data-size="1600x950">
              <div><img src="${e.full_file}" alt="Gambar Penanganan"></div></a>
            <figcaption>Foto Bukti Penanganan</figcaption>
          </figure>`);
        }); 
      }else{
        $('#list_img_pelapor').html(`<figure class="col-md-3 col-6 img-hover hover-1" ><a href="${base_url}template/cuba/assets/images/big-lightgallry/08.jpg" data-size="1600x950">
                <div><img src="${base_url}template/cuba/assets/images/lightgallry/08.jpg" alt="Image description"></div></a>
              <figcaption>Image caption  1</figcaption>
            </figure>`);
      }
      
    }

   }

  // Update pengaduan
  function up_pengaduan() {
    $('#form_update').submit(function (e) { 
      e.preventDefault();
      $.ajax({
        type: "post",
        url: "../backend/Api_pengaduan/upsts_peng",
        data : $(this).serialize(),
        dataType: "json",
        success: function (r) {
              if(r.status == 1){
                  $('#updateModal').modal('hide');
                  swal({
                      title:'Berhasil',
                      text:r.msg,
                      icon:'success'
                    });
                    pengaduan();
              }else{
                  $('#updateModal').modal('hide');
                  swal({
                      title:'Gagal',
                      text:r.msg,
                      icon:'error'
                    });
                    pengaduan();
              }
          }
      }); 
  });
  }

// Assign Petugas
function assign_petugas(pengaduan_id = "", petugas_id = "") {
	swal({
		title: "Konfirmasi",
		text: "Apakah anda yakin ingin menugaskan?",
		icon: "warning",
		buttons: {
			cancel: true,
			confirmButtonText: "Ya",
		},
	}).then((isConfirm) => {
		if (isConfirm) {
			// Post data assign petugas
			let data = `pengaduan_id=${pengaduan_id}&petugas_id=${petugas_id}`;
			post("../backend/Api_pengaduan/assign_to", data, {
				"Content-Type": "application/x-www-form-urlencoded",
			}).then((data) => {
				list_assign();
				list_detail();
			});
		}
	});
}

// List assign
function list_assign() {
	$("#list_assign").html("");
	post(
		"../backend/Api_pengaduan/peng_assign_list",
		"pengaduan_id=" + $("#pengaduan_id").val(),
		{ "Content-Type": "application/x-www-form-urlencoded" }
	).then((d) => {
		d.data.forEach((e) => {
			$("#list_assign")
				.append(`<li class="clearfix mt-2 mb-2"><img class="rounded-circle user-image" src="../template/cuba/assets/images/user/12.png" alt="">
              <a href="javascript:void(0);" class="about" onclick="detail('assign','${e.tid}')">
                  <div class="name">${e.nama_instansi} - ${e.nama_petugas}</div>
                  <div class="status"><i class="fa fa-share font-success"></i>  ${e.status_static}</div>
              </a>
          </li>`);
		});
	});
}

// Pengaduan
function pengaduan() {
	post("../backend/Api_pengaduan/pengaduan/" + $("#pengaduan_id").val()).then(
		(d) => {
			$("#judul").text(d.judul);
			$("#kategori").text("#" + d.peng_kategori);
			$("#status").html(d.status_static);
			$("#tanggal_pengaduan").html(d.tanggal + " " + d.ctdtime);
			$("#kategori_pengaduan").text(d.peng_kategori);
			$("#nama_pelapor").text(d.nama_pelapor);
			$("#task_id").text(d.task_id);
			$("#keterangan_pengaduan").html(d.keterangan);

      frame(
				url_satupeta +
					"?lokasi=" +
					peng_lat +
					"," +
					peng_lng +
					"&nama=" +
					d.peng_kategori +
					"&nopol="
			);
			task_assign_log(d.task_id);
			console.log(d);
		}
	);
}

// Task Assign Log
function task_assign_log(task_id = "") {
	$("#status_timeline").html("");

	post("../backend/Api_pengaduan/peng_assign_log", "task_id=" + task_id, {
		"Content-Type": "application/x-www-form-urlencoded",
	}).then((d) => {
		d.data.forEach((e) => {
			$("#status_timeline").append(`<div class="media">
              <div class="activity-line"></div>
              <div class="activity-dot-secondary"></div>
              <a href="javascript:void(0);" onclick="detail('peng_assign_log',${e.task_assign_id},${e.petugas_id})" class="media-body" style="color:black;"><span>${e.nama_instansi} - ${e.nama_petugas}</span>
                  <p class="font-roboto mb-0">${e.status_static}</p>
                  <p class="font-roboto">${e.tanggal} - ${e.ctdtime}</p>
              </a>
          </div>`);
		});
	});
}
