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
    $("#exampleModalLongTitle").html("Thêm mới phòng");
    $("#button").html("Thêm");
    var id = null;
    $.ajax({
        url: "/api/superadmin/get_room/" + id,
        type: "get",
        dataType: "json",
        success: function (rs) {
            console.log(rs);
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
        url: "/api/superadmin/get_room/" + id,
        type: "get",
        dataType: "json",
        success: function (rs) {
            console.log(rs);
            var id_type_room, type_room, name, adults, children;
            rs.room.forEach((data) => {
                id_room = data.id_room;
                name = data.name;
                adults = data.adults;
                children = data.children;
                id_type_room = data.id_type_room;
            });
            $("#insertForm").modal("show");
            $("#exampleModalLongTitle").html("Cập nhật thông tin phòng");
            $("#name").val(name);
            $("#adults").val(adults);
            $("#children").val(children);
            $("#id_room").val(id);
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
    var name = $("#name").val();
    var adults = $("#adults").val();
    var children = $("#children").val();
    var id = $("#id_room").val();
    // console.log(id);
    // debugger;
    if (id == "") {
        $.ajax({
            url: "/api/superadmin/create_room",
            type: "post",
            dataType: "json",
            data: {
                id_type_room: id_type_room,
                name: name,
                adults: adults,
                children: children,
            },
            success: function (data) {
                if (data === 200) {
                    $("#frm")[0].reset();
                    onFinishWizard();
                } else {
                    $("#name_error").html("Phòng bạn thêm đã có từ trước");
                }
            },
        });
    } else {
        $.ajax({
            url: "/api/superadmin/update_room",
            type: "post",
            dataType: "json",
            data: {
                id_type_room: id_type_room,
                name: name,
                adults: adults,
                children: children,
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
            url: "/api/superadmin/lock_room/" + id,
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
            url: "/api/superadmin/lock_room/" + id,
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
