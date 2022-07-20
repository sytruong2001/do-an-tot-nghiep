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
        url: "/api/admin/get_checkin/" + id,
        type: "get",
        dataType: "json",
        success: function (rs) {
            console.log(rs.checkin);
            var html = ``;
            rs.checkin.forEach((data_checkin) => {
                html += `
            <div class="row">
                <div class="col-md-12">
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
                                                    <label>Số phòng:</label>
                                                    <input type="text" class="form-control" id="time_start"
                                                        name="time_start" value="${data_checkin.time_start}" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Thời gian bắt đầu</label>
                                                    <input type="datetime-local" class="form-control" id="time_start"
                                                        name="time_start" value="${data_checkin.time_start}" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Thời gian kết thúc</label>
                                                    <input type="datetime-local" class="form-control" id="time_end"
                                                        name="time_end" value="${currentTime}" readonly>
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
                                        <div class="content"></div>
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
            </div>
    `;
                $(".content").html(html);
            });

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
function edit(id) {
    $.ajax({
        url: "/api/superadmin/get_account/" + id,
        type: "get",
        dataType: "json",
        success: function (rs) {},
    });
}

function save() {
    var name = $("#name").val();
    var email = $("#email").val();
    var password = $("#password").val();
    var phone = $("#phone").val();
    var birth_of_date = $("#birth_of_date").val();
    var address = $("#address").val();
    var gender = $("#gender").val();
    var id = $("#id").val();
    // if (id == "") {
    //     $.ajax({
    //         url: "/api/superadmin/create_account",
    //         type: "post",
    //         dataType: "json",
    //         data: {
    //             name: name,
    //             email: email,
    //             password: password,
    //             phone: phone,
    //             birth_of_date: birth_of_date,
    //             address: address,
    //             gender: gender,
    //         },
    //         success: function (data) {
    //             if (data === 200) {
    //                 $("#frm")[0].reset();
    //                 onFinishWizard();
    //             } else {
    //                 $("#email_error").html("Địa chỉ email đã tồn tại");
    //             }
    //         },
    //     });
    // } else {
    //     $.ajax({
    //         url: "/api/superadmin/update_account",
    //         type: "post",
    //         dataType: "json",
    //         data: {
    //             name: name,
    //             email: email,
    //             password: password,
    //             phone: phone,
    //             birth_of_date: birth_of_date,
    //             address: address,
    //             gender: gender,
    //             id: id,
    //         },
    //         success: function (data) {
    //             if (data === 200) {
    //                 $("#frm")[0].reset();
    //                 onFinishWizard();
    //             }
    //         },
    //     });
    // }
}

function lock(id) {
    $("#insertForm").modal("show");
    $("#exampleModalLongTitle").html("Xác nhận");
    $(".modal-body").html("Bạn có chắc chắn muốn khóa?");
    $(".modal-footer").empty();
    var btn = `
            <button type="submit" class="btn btn-primary" id="confirm">Đồng ý</button>
            `;
    $(".modal-footer").append(btn);
    $("button#confirm").on("click", function () {
        $.ajax({
            url: "/api/superadmin/lock_price_room/" + id,
            type: "post",
            dataType: "json",
            success: function (rs) {
                if (rs.code === 200) {
                    onFinishWizard();
                } else if (rs.code === 201) {
                    console.log(rs.error);
                    // alert(rs.error);
                    debugger;
                }
            },
        });
    });
}
function unlock(id) {
    $("#insertForm").modal("show");
    $("#exampleModalLongTitle").html("Xác nhận");
    $(".modal-body").html("Bạn có chắc chắn muốn mở khóa?");
    $(".modal-footer").empty();
    var btn = `
            <button type="submit" class="btn btn-primary" id="confirm">Đồng ý</button>
            `;
    $(".modal-footer").append(btn);
    $("button#confirm").on("click", function () {
        $.ajax({
            url: "/api/superadmin/lock_price_room/" + id,
            type: "post",
            dataType: "json",
            success: function (rs) {
                if (rs.code === 200) {
                    onFinishWizard();
                } else if (rs.code === 201) {
                    $("#insertForm").modal("hide");
                    alertMessage(rs.error);
                }
            },
        });
    });
}

function alertMessage(message) {
    var html = `
        <div class="alert alert-danger">
            <button type="button" aria-hidden="true" class="close">×</button>
            <span>${message}</span>
        </div>
    `;
    $("#alerts").append(html);
}
function onFinishWizard() {
    swal("Hoàn tất!", "Thành công", "success");
}
