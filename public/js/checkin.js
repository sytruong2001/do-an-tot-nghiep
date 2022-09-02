$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
});

getInfo();
function getInfo() {
    $.ajax({
        url: "/api/get_type_room/null",
        type: "get",
        dataType: "json",
        success: function (rs1) {
            var htmlTypeRoom = ``;
            htmlTypeRoom += `
            <select class="form-control" name="tim-loai-phong" id="tim-loai-phong" onchange="searchTypeRoom()">
                <option style="text-align: center">--Chọn loại phòng--
                </option>
            `;
            rs1.forEach((el1) => {
                htmlTypeRoom += `
                <option style="text-align: center" value="${el1.id_type_room}">${el1.name}
                </option>
                `;
            });
            htmlTypeRoom += `</select>`;
            $("#search-type-room").html(htmlTypeRoom);
        },
    });
    $.ajax({
        url: "/api/get_price_room/null",
        type: "get",
        dataType: "json",
        success: function (rs2) {
            var htmlPriceRoom = ``;
            htmlPriceRoom += `
            <select class="form-control" name="tim-gia-phong" id="tim-gia-phong" onchange="searchPriceRoom()">
                <option style="text-align: center">--Chọn giá phòng--
                </option>
            `;
            rs2.price.forEach((el2) => {
                var first_hour = convertMoney(el2.first_hour);
                var next_hour = convertMoney(el2.next_hour);
                htmlPriceRoom += `
                <option style="text-align: center" value="${el2.id_price_room}">${first_hour} -- ${next_hour}
                </option>
                `;
            });
            htmlPriceRoom += `</select>`;
            $("#search-price-room").html(htmlPriceRoom);
        },
    });
    // $.ajax({
    //     url: "/api/get_type_room/null",
    //     type: "get",
    //     dataType: "json",
    //     success: function (data) {
    //         console.log(data);
    //     },
    // });
}
// tìm kiếm theo loại phòng
function searchTypeRoom() {
    var e = document.getElementById("tim-loai-phong");
    var f = e.options[e.selectedIndex].value;
    $.ajax({
        url: "/api/admin/search-type-room/" + f,
        type: "post",
        dataType: "json",
        success: function (rs3) {
            console.log(rs3);
            $("#rooms-content").html("");
            rs3.room.forEach((el3) => {
                var htmlRoom = `
                <div class="col-md-3" onclick="create(${el3.id_room})">
                    <div class="card card-user" style="background-color: gray">
                        <div class="image">
                            <img src="https://hotlinedatphong.com/wp-content/uploads/2020/10/khach-san-muong-thanh-holiday-mui-ne-24-800x450-1.jpg"
                                alt="..." />
                        </div>
                        <h3 style="text-align: center;"><b>${el3.name}</b></h3>
                        <h3 style="text-align: center; padding-bottom:10px"><b>(${el3.type_room.name})</b></h3>

                    </div>
                </div>
                `;
                $("#rooms-content").append(htmlRoom);
            });
        },
    });
}

// tìm kiếm theo giá phòng
function searchPriceRoom() {
    var e = document.getElementById("tim-gia-phong");
    var f = e.options[e.selectedIndex].value;
    $.ajax({
        url: "/api/admin/search-price-room/" + f,
        type: "post",
        dataType: "json",
        success: function (rs3) {
            $("#rooms-content").html("");
            rs3.room.forEach((el3) => {
                var htmlRoom = `
                <div class="col-md-3" onclick="create(${el3.id_room})">
                    <div class="card card-user" style="background-color: gray">
                        <div class="image">
                            <img src="https://hotlinedatphong.com/wp-content/uploads/2020/10/khach-san-muong-thanh-holiday-mui-ne-24-800x450-1.jpg"
                                alt="..." />
                        </div>
                        <h3 style="text-align: center;"><b>${el3.name}</b></h3>
                        <h3 style="text-align: center; padding-bottom:10px"><b>(${el3.type_room.name})</b></h3>

                    </div>
                </div>
                `;
                $("#rooms-content").append(htmlRoom);
            });
        },
    });
}

// chuyển đổi đơn vị tiền tệ
function convertMoney(number) {
    let num = new Intl.NumberFormat("vi", {
        style: "currency",
        currency: "VND",
    }).format(number);
    return num;
}

// tìm kiếm phòng theo tên
function searchRoom() {
    var name = $("#search-room").val();
    $.ajax({
        url: "/api/admin/search-room",
        type: "post",
        dataType: "json",
        data: { name: name, status: 0 },
        success: function (rs3) {
            $("#rooms-content").html("");
            rs3.room.forEach((el3) => {
                var htmlRoom = `
                <div class="col-md-3" onclick="create(${el3.id_room})">
                    <div class="card card-user" style="background-color: gray">
                        <div class="image">
                            <img src="https://hotlinedatphong.com/wp-content/uploads/2020/10/khach-san-muong-thanh-holiday-mui-ne-24-800x450-1.jpg"
                                alt="..." />
                        </div>
                        <h3 style="text-align: center;"><b>${el3.name}</b></h3>
                        <h3 style="text-align: center; padding-bottom:10px"><b>(${el3.type_room.name})</b></h3>

                    </div>
                </div>
                `;
                $("#rooms-content").append(htmlRoom);
            });
        },
    });
}

// tìm kiếm đặt phòng theo số CMT/CCCD
function searchIdentify() {
    var identify_numb = $("#search-identify").val();
    $.ajax({
        url: "/api/admin/search-identify",
        type: "post",
        dataType: "json",
        data: { identify_numb: identify_numb, status: 2 },
        success: function (rsIdentify) {
            $("#rooms-content").html("");
            rsIdentify.room.forEach((elIdentify) => {
                console.log(elIdentify);
                var htmlRoom = `
                <div class="col-md-3" onclick="update(${elIdentify.id_checkin_room})">
                    <div class="card card-user" style="background-color: gray">
                        <div class="image">
                            <img src="https://hotlinedatphong.com/wp-content/uploads/2020/10/khach-san-muong-thanh-holiday-mui-ne-24-800x450-1.jpg"
                                alt="..." />
                        </div>
                        <h3 style="text-align: center; padding-bottom:10px"><b>${elIdentify.name}</b></h3>
                        <p style="text-align: center; padding-bottom:10px; color: blue">
                            Ngày nhận: <b>${elIdentify.time_start}</b>
                        </p>
                    </div>
                </div>
                `;
                $("#rooms-content").append(htmlRoom);
            });
        },
    });
}

// tạo phiếu nhận phòng
function create(id) {
    var x;
    let currentDate = new Date();
    let cDay = currentDate.getDate();
    if (cDay >= 10) {
        cDay = cDay;
    } else {
        cDay = "0" + cDay;
    }
    let cMonth = currentDate.getMonth() + 1;
    let cYear = currentDate.getFullYear();
    // let cHour = currentDate.getHours();
    // if (cHour >= 10) {
    //     cHour = cHour;
    // } else {
    //     cHour = "0" + cHour;
    // }
    // let cMinute = currentDate.getMinutes();
    // if (cMinute >= 10) {
    //     cMinute = cMinute;
    // } else {
    //     cMinute = "0" + cMinute;
    // }
    // let cTime = cHour + ":" + cMinute;
    let currentTime;
    if (cMonth < 10) {
        currentTime = cYear + "-0" + cMonth + "-" + cDay;
    } else {
        currentTime = cYear + "-" + cMonth + "-" + cDay;
    }

    $.ajax({
        url: "/api/admin/get_room/" + id,
        type: "get",
        dataType: "json",
        success: function (rs) {
            var html = ``;
            html += `<div class="row">
                <div class="col-md-8">
                    <div class="card">
                    <form id="frm">
                        <div class="content content-full-width">
                            <ul role="tablist" class="nav nav-tabs">
                                <li role="presentation" class="active">
                                    <a href="#icon-info" data-toggle="tab"><i class="fa fa-info"></i> Thông tin thời gian thuê phòng</a>
                                </li>

                            </ul>

                            <div class="tab-content">
                                <div id="icon-info" class="tab-pane active">
                                    <div class="card">
                                        <div class="content">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Thời gian bắt đầu</label>
                                                    <input type="date" class="form-control" id="time_start"
                                                        name="time_start" min="${currentTime}" value="${currentTime}" oninput="choose()">
                                                    <span class="text-danger error-text time_start_error"></span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group" id="location-time-end">
                                                    <label>Thời gian kết thúc</label>
                                                    <input type="date" class="form-control" id="time_end"
                                                        name="time_end" min="${currentTime}">
                                                    <span class="text-danger error-text time_end_error"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <span class="text-danger error-text time_error"></span>
                                            </div>
                                        </div>

                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="content content-full-width">
                            <ul role="tablist" class="nav nav-tabs">
                                <li role="presentation" class="active">
                                    <a href="#icon-info" data-toggle="tab"><i class="fa fa-user"></i> Thông tin khách hàng</a>
                                </li>

                            </ul>

                            <div class="tab-content">
                                <div id="icon-info" class="tab-pane active">
                                    <div class="card">
                                        <div class="content">`;
            rs.room.forEach((data) => {
                html += `
                <input type="hidden" class="form-control" id="id_room" name="id_room" value="${data.id_room}"></input>
                <input type="hidden" class="form-control" id="numb_adult" name="numb_adult" value="${data.adults}"></input>`;
                for (x = 1; x <= data.adults; x++) {
                    html += `
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Họ và Tên</label>
                                <input type="text" class="form-control" id="name${x}" name="name${x}"
                                    value="">
                                <span class="text-danger error-text name_error_${x}"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Số CMT/CCCD</label>
                                <input type="number" class="form-control" id="identify${x}" name="identify${x}"
                                    value="">
                                <span class="text-danger error-text identify_error_${x}"></span>
                            </div>
                        </div>
                    </div>`;
                }
            });
            html += `</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-primary" id="btn-submit">Xác nhận</button>
                        </div>
                    </form>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-user">
                        <div class="image">
                            <img src="../img/bg10.jpg" alt="..." />
                        </div>`;
            rs.room.forEach((data1) => {
                console.log(data1);
                html += `
                    <div class="content" style="background:lightblue">
                        <h3 style="text-align:center"><b>Số phòng: ${data1.name}</b></h3>
                        <h3 style="text-align:center"><b>(${data1.type_room.name})</b></h3>
                        <b>Số lượng khách sử dụng:</b><br>
                        <b>- Người lớn: ${data1.adults} <i class="fa fa-user"></i> </b><br>
                        <b>- Trẻ nhỏ: ${data1.children} <i class="fa fa-user"></i> </b><br>
                    </div>`;
            });

            html += `</div>
                </div>
            </div>
    `;
            $(".content").html(html);

            $("#frm").on("submit", function (e) {
                e.preventDefault();
                var time_start = $("#time_start").val();
                var time_end = $("#time_end").val();
                var name_1 = $("#name1").val();
                var identify_1 = $("#identify1").val();
                $("span.time_end_error").empty();
                $("span.time_error").empty();
                $("span.name_error_1").empty();
                $("span.identify_error_1").empty();
                if (time_end === "") {
                    $("span.time_end_error").html(
                        "Chưa nhập thời gian trả phòng."
                    );
                }
                if (name_1 === "") {
                    $("span.name_error_1").html(
                        "Chưa điền tên người nhận phòng."
                    );
                }
                if (identify_1 === "") {
                    $("span.identify_error_1").html(
                        "Chưa điền số CMT/CCCD người nhận phòng."
                    );
                }
                if (identify_1.length > 12 || identify_1.length < 12) {
                    $("span.identify_error_1").html(
                        "Số CMT/CCCD phải đầy đủ 12 chữ số."
                    );
                }
                console.log(time_start);
                console.log(time_end);

                if (
                    time_end != "" &&
                    name_1 != "" &&
                    identify_1 != "" &&
                    identify_1.length === 12
                ) {
                    $.ajax({
                        url: "/api/admin/create_checkin",
                        type: "post",
                        data: new FormData(this),
                        processData: false,
                        dataType: "json",
                        contentType: false,
                        beforeSend: function () {
                            $(document).find("span.error-text").text("");
                        },
                        success: function (data) {
                            if (data.code == 201) {
                                console.log(data);
                                var htmlError = `
                                    Trong khoảng thời gian từ <i>${time_start}</i> đến <i>${time_end}</i> đã có khách đặt phòng này hoặc phòng đang được sử dụng.
                                    Vui lòng chọn thời gian khác.
                                `;
                                $("span.time_error").html(htmlError);
                            }
                            if (data.code == 200) {
                                onFinishWizard();
                                setTimeout("location.reload(true);", 500);
                            } else if (data.code == 500) {
                                $("#insertForm").modal("show");
                                $("#exampleModalLongTitle").html("Xảy ra lỗi");
                                $(".modal-body").html(data.error);
                            }
                        },
                    });
                }
            });
        },
    });
}

function choose() {
    var id_room = $("#id_room").val();
    var time_start = $("#time_start").val();
    console.log(id_room);
    var html = `
        <label>Thời gian kết thúc</label>
        <input type="date" class="form-control" id="time_end"
            name="time_end" min="${time_start}">
        <span class="text-danger error-text time_end_error"></span>
    `;
    $("#location-time-end").html(html);
}
// tạo phiếu nhận phòng khi đã đặt phòng
function update(id) {
    $.ajax({
        url: "/api/admin/get_checkin/" + id,
        type: "get",
        dataType: "json",
        success: function (rs) {
            var html = ``;
            html += `
            <div class="row">
                        <div class="col-md-8">
                            <div class="card">
                                <div class="content content-full-width">
                                    <ul role="tablist" class="nav nav-tabs">
                                        <li role="presentation" class="active">
                                            <a href="#icon-info" data-toggle="tab"><i class="fa fa-info"></i> Thông tin thời gian thuê phòng</a>
                                        </li>

                                    </ul>`;
            rs.checkin.forEach((time) => {
                let startT = time.time_start.substring(0, 10);
                let endT = time.time_end.substring(0, 10);
                html += `
                <div class="tab-content">
                    <div id="icon-info" class="tab-pane active">
                        <div class="card">
                            <div class="content">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Thời gian bắt đầu</label>
                                            <input type="text" class="form-control" id="time_start"
                                                name="time_start" value="${startT}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Thời gian kết thúc</label>
                                            <input type="text" class="form-control" id="time_end"
                                                name="time_end" value="${endT}" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <span class="text-danger error-text time_error"></span>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                `;
            });
            html += `

                                </div>

                                <div class="content content-full-width">
                                    <ul role="tablist" class="nav nav-tabs">
                                        <li role="presentation" class="active">
                                            <a href="#icon-info" data-toggle="tab"><i class="fa fa-user"></i> Thông tin khách hàng</a>
                                        </li>

                                    </ul>

                                    <div class="tab-content">
                                        <div id="icon-info" class="tab-pane active">
                                            <div class="card">
                                                <div class="content">`;
            rs.customer.forEach((data) => {
                html += `
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Họ và Tên</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    value="${data.name}" readonly>
                                <span class="text-danger error-text name_error"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Số CMT/CCCD</label>
                                <input type="number" class="form-control" id="identify" name="identify"
                                    value="${data.identify_numb}" readonly>
                                <span class="text-danger error-text identify_error"></span>
                            </div>
                        </div>
                    </div>
                    </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-primary" id="btn-submit" onclick="submit(${data.id_checkin_room})">Nhận phòng</button>
                                    <button class="btn btn-danger" id="btn-cancel" onclick="cancel(${data.id_checkin_room})">Hủy đặt phòng</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card card-user">
                                <div class="image">
                                    <img src="../img/bg10.jpg" alt="..." />
                                </div>`;
            });
            rs.checkin.forEach((data1) => {
                html += `
                            <div class="content" style="background:lightblue">
                                <h3 style="text-align:center"><b>Số phòng: ${data1.name}</b></h3>
                                <b>Số lượng khách sử dụng:</b><br>
                                <b>- Người lớn: ${data1.adults} <i class="fa fa-user"></i> </b><br>
                                <b>- Trẻ nhỏ: ${data1.children} <i class="fa fa-user"></i> </b><br>
                            </div>`;
            });

            html += `</div>
                        </div>
                    </div>
            `;
            $(".content").html(html);
        },
    });
}
function submit(id) {
    $.ajax({
        url: "/api/admin/update_checkin/" + id,
        type: "post",
        dataType: "json",
        success: function (rs) {
            if (rs.code == 201) {
                var time = rs.time.substring(0, 10);
                var htmlError = `Hiện tại chưa đến ngày nhận phòng. Xin vui lòng thực hiện vào ngày ${time}. `;
                $("span.time_error").html(htmlError);
            } else {
                onFinishWizard();
                setTimeout("location.reload(true);", 500);
            }
        },
    });
}

function cancel(id) {
    $.ajax({
        url: "/api/admin/cancel_checkin/" + id,
        type: "post",
        dataType: "json",
        success: function (rs) {
            onFinishWizard();
            setTimeout("location.reload(true);", 500);
        },
    });
}
function onFinishWizard() {
    swal("Hoàn tất!", "Thành công", "success");
}
