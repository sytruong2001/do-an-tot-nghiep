$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
});

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
    let cHour = currentDate.getHours();
    if (cHour >= 10) {
        cHour = cHour;
    } else {
        cHour = "0" + cHour;
    }
    let cMinute = currentDate.getMinutes();
    if (cMinute >= 10) {
        cMinute = cMinute;
    } else {
        cMinute = "0" + cMinute;
    }
    let cTime = cHour + ":" + cMinute;
    let currentTime;
    if (cMonth < 10) {
        currentTime = cYear + "-0" + cMonth + "-" + cDay + "T" + cTime;
    } else {
        currentTime = cYear + "-" + cMonth + "-" + cDay + "T" + cTime;
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
                                                    <input type="datetime-local" class="form-control" id="time_start"
                                                        name="time_start" value="${currentTime}" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Thời gian kết thúc</label>
                                                    <input type="datetime-local" class="form-control" id="time_end"
                                                        name="time_end" min="${currentTime}">
                                                    <span class="text-danger error-text time_end_error"></span>
                                                </div>
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
                var time_end = $("#time_end").val();
                var name_1 = $("#name1").val();
                var identify_1 = $("#identify1").val();
                $("span.time_end_error").empty();
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
                if (time_end != "" && name_1 != "" && identify_1 != "") {
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
                            if (data.code == 200) {
                                onFinishWizard();
                            } else {
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

function onFinishWizard() {
    swal("Hoàn tất!", "Thành công", "success");
}
