$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
});

getInfo();
function getInfo() {
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
    var htmlStart = `
        <b>Thời gian nhận phòng</b>
        <div class="input-group">
            <span class="input-group-addon">
                <i class="fa fa-calendar"></i>
            </span>
            <input type="date" class="form-control" id="time_start" name="time_start" min="${currentTime}" oninput="choose()">
            <span class="text-danger error-text time_start_error" style="font-size:15px"></span>
        </div>
    `;
    $("#check-in").html(htmlStart);

    var htmlEnd = `
        <b>Thời gian trả phòng</b>
        <div class="input-group">
            <span class="input-group-addon">
                <i class="fa fa-calendar"></i>
            </span>
            <span id="set-min-time">
            <input type="date" class="form-control" id="time_end" name="time_end" min="${currentTime}">
            <span class="text-danger error-text time_end_error" style="font-size:15px"></span>
            </span>
        </div>
    `;
    $("#check-out").html(htmlEnd);
}

// tạo phiếu nhận phòng
function choose() {
    var time_start = $("#time_start").val();
    console.log(time_start);
    var html = `
        <input type="date" class="form-control" id="time_end" name="time_end" min="${time_start}">
        <span class="text-danger error-text time_end_error" style="font-size:15px"></span>
    `;
    $("#set-min-time").html(html);
}
function searchRoomNow() {
    var time_start = $("#time_start").val();
    var time_end = $("#time_end").val();
    console.log(time_start);
    console.log(time_end);
    $("span.time_end_error").empty();
    $("span.time_start_error").empty();
    if (time_start === "") {
        $("span.time_start_error").html("Chưa nhập thời gian nhận phòng.");
    }
    if (time_end === "") {
        $("span.time_end_error").html("Chưa nhập thời gian trả phòng.");
    }

    if (time_end != "" && time_start != "") {
        $.ajax({
            url: "/api/search-booking",
            type: "get",
            data: {
                start: time_start,
                end: time_end,
            },
            dataType: "json",
            success: function (data) {
                console.log(time_start);
                $("#room-content").empty();
                data.rooms.forEach((room) => {
                    var html = `
                    <div class="col-md-3">
                        <div class="card card-raised card-background"
                            style="background-image: url('https://hotlinedatphong.com/wp-content/uploads/2020/10/khach-san-muong-thanh-holiday-mui-ne-24-800x450-1.jpg')"
                        >
                            <div class="card-content">
                                <h6 class="category text-info">Room</h6>
                                <a href="/dat-phong/${room.id_room}">
                                    <h3 class="card-title">${room.name}</h3>
                                </a>
                                <p class="card-description">
                                Loại phòng: ${room.type_room.name}.
                                </p>
                                <p class="card-description">
                                Dành cho ${room.adults} người lớn,
                                </p>
                                <p class="card-description">
                                    và ${room.children} trẻ em.
                                </p>
                                <a href="/dat-phong/${room.id_room}/${time_start}/${time_end}" class="btn btn-danger btn-round">
                                    <i class="material-icons">format_align_left</i>
                                    Đặt phòng
                                </a>
                            </div>
                        </div>
                    </div>
                    `;
                    $("#room-content").append(html);
                });
            },
        });
    }
}
function onFinishWizard() {
    swal("Hoàn tất!", "Thành công", "success");
}
