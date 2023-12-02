$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
});

getInfo();
function getInfo() {
    const path = location.pathname;
    const start = $("#time_start").val();
    const end = $("#time_end").val();
    const id = $("#id-room").val();

    let start_time = new Date(start);
    let end_time = new Date(end);
    let total_time = (
        Number(end_time) / (1000 * 60 * 60) -
        Number(start_time) / (1000 * 60 * 60)
    ).toFixed(0);

    console.log(total_time);
    console.log(id);

    $("#total_time").val(total_time);
    let first = Number($("#first").val());
    first = !Number.isNaN(first) ? first : 0;
    let next = Number($("#next").val());
    next = !Number.isNaN(next) ? next : 0;
    var total_money;
    if (total_time < 1) {
        total_money = first * total_time;
    } else {
        total_money = first + next * (total_time - 1);
    }
    $("#total").val(convertMoney(total_money));
    $("#tien-coc").val(convertMoney(total_money * 0.2));
    $("#deposit").val(total_money * 0.2);
    console.log(total_money);
}
function convertMoney(number) {
    let num = new Intl.NumberFormat("vi", {
        style: "currency",
        currency: "VND",
    }).format(number);
    return num;
}
$("#frm").on("submit", function (e) {
    e.preventDefault();
    var name = $("#name-cus").val();
    var identify = $("#identify").val();
    var time_start = $("#time_start").val();
    var time_end = $("#time_end").val();
    var id_room = $("#id-room").val();
    var deposit = $("#deposit").val();
    $("span.name_error").empty();
    $("span.identify_error").empty();

    if (name === "") {
        $("span.name_error").html("Chưa điền tên người nhận phòng.");
    }
    if (identify === "") {
        $("span.identify_error").html(
            "Chưa điền số CMT/CCCD người nhận phòng."
        );
    }
    if (identify.length < 12 || identify.length > 12) {
        $("span.identify_error").html("Độ dài số điện thoại phải là 12 chữ số");
    }
    if (name != "" && identify != "" && identify.length === 12) {
        $.ajax({
            url: "/api/create_booking",
            type: "post",
            data: {
                id_room: id_room,
                time_start: time_start,
                time_end: time_end,
                deposit: deposit,
                name: name,
                identify: identify,
            },
            dataType: "json",
            success: function (data) {
                // console.log(data);
                window.location = data;
            },
        });
    }
});
function onFinishWizard() {
    swal("Hoàn tất!", "Thành công", "success");
}
