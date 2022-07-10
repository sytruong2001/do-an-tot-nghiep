$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
});

function add() {
    $("#frm")[0].reset();
    $("#insertForm").modal("show");
    $("#exampleModalLongTitle").html("Thêm mức giá phòng");
    $("#button").html("Thêm");
    var id = null;
    $.ajax({
        url: "/api/superadmin/get_type_room/" + id,
        type: "get",
        dataType: "json",
        success: function (rs) {
            $("#type_room").html("");
            rs.forEach((data) => {
                var html = `
                    <option value="${data.id_type_room}">${data.name}</option>
                `;
                $("#type_room").append(html);
            });
        },
    });
}
// function covertNumb(numb) {
//     let num = new Intl.NumberFormat("vi", {
//         style: "currency",
//         currency: "VND",
//     }).format(numb);
//     console.log(num);
// }
function edit(id) {
    $.ajax({
        url: "/api/superadmin/get_price_room/" + id,
        type: "get",
        dataType: "json",
        success: function (rs) {
            var id_type_room, type_room, first_hour, next_hour;
            rs.price.forEach((data) => {
                type_room = data.type_room.name;
                first_hour = data.first_hour;
                next_hour = data.next_hour;
                id_type_room = data.id_type_room;
            });
            $("#insertForm").modal("show");
            $("#exampleModalLongTitle").html("Cập nhật thông tin loại phòng");
            $("#first_hour").val(first_hour);
            $("#next_hour").val(next_hour);
            $("#id_price_room").val(id);
            $("#button").html("Cập nhật");
            $("#type_room").html("");
            rs.type.forEach((data1) => {
                console.log(data1.name);
                var html = ``;
                html += `
                    <option value="${data1.id_type_room}"
                    `;
                if (data1.id_type_room === id_type_room) {
                    html += `selected`;
                }
                html += `
                    >${data1.name}</option>
                    `;
                $("#type_room").append(html);
            });
        },
    });
}

function save() {
    var id_type_room = $("#type_room").val();
    var first_hour = $("#first_hour").val();
    var next_hour = $("#next_hour").val();
    var id = $("#id_price_room").val();
    // console.log(id);
    // debugger;
    if (id == "") {
        $.ajax({
            url: "/api/superadmin/create_price_room",
            type: "post",
            dataType: "json",
            data: {
                id_type_room: id_type_room,
                first_hour: first_hour,
                next_hour: next_hour,
            },
            success: function (data) {
                if (data === 200) {
                    $("#frm")[0].reset();
                    onFinishWizard();
                } else {
                    $("#name_error").html(
                        "Loại phòng bạn thêm đã có giá tiền từ trước"
                    );
                }
            },
        });
    } else {
        $.ajax({
            url: "/api/superadmin/update_price_room",
            type: "post",
            dataType: "json",
            data: {
                id_type_room: id_type_room,
                first_hour: first_hour,
                next_hour: next_hour,
                id: id,
            },
            success: function (data) {
                if (data === 200) {
                    $("#frm")[0].reset();
                    onFinishWizard();
                }
            },
        });
    }
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
                onFinishWizard();
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
                onFinishWizard();
            },
        });
    });
}
function onFinishWizard() {
    swal("Hoàn tất!", "Thành công", "success");
}
