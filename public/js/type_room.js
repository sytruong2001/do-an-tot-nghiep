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
    $("#exampleModalLongTitle").html("Thêm loại phòng");
    $("#button").html("Thêm");
}
function edit(id) {
    $.ajax({
        url: "/api/superadmin/get_type_room/" + id,
        type: "get",
        dataType: "json",
        success: function (rs) {
            var name;
            rs.forEach((data) => {
                name = data.name;
            });
            $("#insertForm").modal("show");
            $("#exampleModalLongTitle").html("Cập nhật thông tin loại phòng");
            $("#type_room").val(name);
            $("#id_type_room").val(id);
            $("#button").html("Cập nhật");
        },
    });
}

function save() {
    var name = $("#type_room").val();
    var id = $("#id_type_room").val();
    // console.log(id);
    // debugger;
    if (id == "") {
        $.ajax({
            url: "/api/superadmin/create_type_room",
            type: "post",
            dataType: "json",
            data: {
                name: name,
            },
            success: function (data) {
                if (data === 200) {
                    $("#frm")[0].reset();
                    onFinishWizard();
                } else {
                    swal(
                        "Đã xảy ra lỗi!",
                        "Loại phòng bạn thêm đã có từ trước",
                        "warning"
                    );
                }
            },
        });
    } else {
        $.ajax({
            url: "/api/superadmin/update_type_room",
            type: "post",
            dataType: "json",
            data: {
                name: name,
                id: id,
            },
            success: function (data) {
                if (data.code === 200) {
                    $("#frm")[0].reset();
                    onFinishWizard();
                } else if (data.code === 501) {
                    swal("Đã xảy ra lỗi!", data.errorr, "warning");
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
            url: "/api/superadmin/lock_type_room/" + id,
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
            url: "/api/superadmin/lock_type_room/" + id,
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
