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
    let currentTime = convertTime(currentDate);

    $("#frm-checkout")[0].reset();
    $("#insertForm-checkout").modal("show");
    $("#exampleModalLongTitle").html("Xác nhận thanh toán trả phòng");
    $("#id-checkin-room").val(id);
    $.ajax({
        url: "/api/admin/get_checkin/" + id,
        type: "get",
        dataType: "json",
        success: function (rs) {
            console.log(rs);
            let total = 0;

            let time_start;
            rs.checkin.forEach((data_checkin) => {
                let startT = data_checkin.time_start.substring(0, 10);
                $("#name-room").val(data_checkin.name);
                $("#time-start").val(startT);
                $("#time-end").val(currentTime);
                time_start = data_checkin.time_start;
            });
            // 2022-07-25 20:20:00
            let time = new Date(time_start);
            let total_time = (
                Number(currentDate) / (1000 * 60 * 60) -
                Number(time) / (1000 * 60 * 60)
            ).toFixed(0);
            console.log(total_time);
            // số tiền thuê phòng
            rs.price_hour.forEach((data_price_hour) => {
                var first_hour, next_hour;
                if (total_time <= 1) {
                    first_hour = convertMoney(
                        data_price_hour.first_hour * total_time
                    );
                    var html_price_room = `
                    <label>Giá phòng:</label>
                    <input type="text" class="form-control" id="price-room" name="price-room"
                        style="text-align:right"
                        value="${first_hour}" disabled>`;
                    $("#all-price-room").html(html_price_room);
                    total += Number(data_price_hour.first_hour * total_time);
                    console.log(total);
                } else {
                    first_hour = convertMoney(data_price_hour.first_hour);
                    next_hour = convertMoney(
                        data_price_hour.next_hour * (total_time - 1)
                    );
                    var html_price_room = `
                    <label>Giá phòng:</label>
                    <input type="text" class="form-control" id="price-room" name="price-room"
                        style="text-align:right"
                        value="Giờ đầu:${first_hour} ---- ${
                        total_time - 1
                    } giờ tiếp theo: ${next_hour}" disabled>`;
                    $("#all-price-room").html(html_price_room);
                    total += Number(
                        data_price_hour.first_hour +
                            data_price_hour.next_hour * (total_time - 1)
                    );
                }
            });
            // số tiền phụ phí
            rs.price_additional_fee.forEach((data_additional_fee) => {
                var price_additional_fee = convertMoney(
                    data_additional_fee.price_additional_fee
                );
                var html_additional_fee = `
                    <label>Phí tổn thất:</label>
                    <input type="text" class="form-control" id="price-all-additional-fee" name="price-all-additional-fee"
                        style="text-align:right"
                        value="${price_additional_fee}" disabled>`;
                $("#all-additional-fee").html(html_additional_fee);
                total += Number(data_additional_fee.price_additional_fee);
            });
            // số tiền dịch vụ
            rs.price_services.forEach((data_services) => {
                var price_services = convertMoney(data_services.price_services);
                var html_services = `
                    <label>Phí dịch vụ:</label>
                    <input type="text" class="form-control" id="price-all-services" name="price-all-services"
                        style="text-align:right"
                        value="${price_services}" disabled>
                    </input>`;
                $("#all-services").html(html_services);
                total += Number(data_services.price_services);
            });
            // tiền cọc
            rs.checkin.forEach((data_deposit) => {
                var deposit = convertMoney(data_deposit.deposit);
                var html_deposit = `
                    <label>Tổng đã đặt cọc:</label>
                    <input type="text" class="form-control" id="deposit" name="deposit" style="color:green; text-align:right" value="${deposit}" disabled>
                    </input>`;
                $("#deposit").html(html_deposit);
                total -= Number(data_deposit.deposit);
            });
            // tổng số tiền thanh toán
            var total_price;
            if (total < 0) {
                total_price = 0;
            } else {
                total_price = convertMoney(total);
            }

            var html_total_price = `
                    <label>Tổng tiền:</label>
                    <input type="text" class="form-control" id="total-price" name="total-price" style="color:green; text-align:right" value="${total_price}" disabled>
                    </input>`;
            $("#total-price").html(html_total_price);

            // xác nhận
            $(".modal-footer").empty();
            var btn = `
            <button type="button" class="btn btn-secondary" id="close-additional-fee"
                        data-dismiss="modal">Đóng</button>
            <button type="submit" class="btn btn-primary" id="btn-checkout">Xác nhận</button>
            `;
            $(".modal-footer").append(btn);
            $("button#btn-checkout").on("click", function (e) {
                e.preventDefault();
                $.ajax({
                    url: "/api/admin/create_checkout",
                    type: "post",
                    dataType: "json",
                    data: {
                        id_checkin_room: id,
                        time_start: time_start,
                        time_end: currentTime,
                        sum_price: Number(total),
                    },
                    success: function (rs) {
                        if (rs == 201) {
                            console.log("Phiếu phòng đã được trả");
                        } else {
                            onFinishWizard();
                            setTimeout(
                                (window.location =
                                    "http://127.0.0.1:8000/admin/checkout"),
                                1000
                            );
                        }
                    },
                });
            });
        },
    });
}
// tìm kiếm phòng theo tên
function searchRoom() {
    var name = $("#search-room").val();
    $.ajax({
        url: "/api/admin/search-checkin",
        type: "post",
        dataType: "json",
        data: { name: name, status: 0 },
        success: function (rs3) {
            $("#rooms-content").html("");
            console.log(rs3);
            rs3.room.forEach((el3) => {
                var htmlRoom = `
                <a href="/admin/detail-checkout/${el3.id_checkin_room}">
                    <div class="col-md-3">
                        <div class="card card-user" style="background-color: lightgreen">
                            <div class="image">
                                <img src="https://khachsandanang.info/wp-content/uploads/2016/08/avatar-room.jpg"
                                    alt="..." />
                            </div>
                            <h3 style="text-align: center; padding-bottom:10px"><b>${el3.name}</b></h3>
                            <b>Thời gian trả phòng:</b>
                            <h5 style="text-align: center; padding-bottom:10px">${el3.time_end}</h5>
                        </div>
                    </div>
                </a>
                `;
                $("#rooms-content").append(htmlRoom);
            });
        },
    });
}

function convertMoney(number) {
    let num = new Intl.NumberFormat("vi", {
        style: "currency",
        currency: "VND",
    }).format(number);
    return num;
}

function convertTime(time) {
    let cDay = time.getDate();
    if (cDay >= 10) {
        cDay = cDay;
    } else {
        cDay = "0" + cDay;
    }
    let cMonth = time.getMonth() + 1;
    let cYear = time.getFullYear();
    let cHour = time.getHours();
    if (cHour >= 10) {
        cHour = cHour;
    } else {
        cHour = "0" + cHour;
    }
    let cMinute = time.getMinutes();
    if (cMinute >= 10) {
        cMinute = cMinute;
    } else {
        cMinute = "0" + cMinute;
    }
    let cTime = cHour + ":" + cMinute;
    let currentTime;
    if (cMonth < 10) {
        currentTime = cYear + "-0" + cMonth + "-" + cDay;
    } else {
        currentTime = cYear + "-" + cMonth + "-" + cDay;
    }
    return currentTime;
}

// function saveCheckout() {
// var name = $("#name").val();
// var email = $("#email").val();
// var password = $("#password").val();
// var phone = $("#phone").val();
// var birth_of_date = $("#birth_of_date").val();
// var address = $("#address").val();
// var gender = $("#gender").val();
// var id = $("#id").val();
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
// }

function onFinishWizard() {
    swal("Hoàn tất!", "Thành công", "success");
}
