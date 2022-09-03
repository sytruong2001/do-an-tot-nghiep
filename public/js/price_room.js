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
    var button = document.querySelector('[id="button"]');
    button.setAttribute("disabled", true);
    var id = null;
    $.ajax({
        url: "/api/superadmin/get_price_room/" + id,
        type: "get",
        dataType: "json",
        success: function (rs) {
            console.log(rs);
            $("#type_room").html("");
            rs.data.forEach((data) => {
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
                    swal(
                        "Đã xảy ra lỗi!",
                        "Loại phòng bạn thêm đã có giá tiền từ trước",
                        "warning"
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

function checkNumber() {
    var first = $("#first_hour").val();
    var next = $("#next_hour").val();
    $("span.first_hour").empty();
    $("span.next_hour").empty();
    var button = document.querySelector('[id="button"]');
    var length1 = first.length;
    var length2 = next.length;

    if (first < 0) {
        $("span.first_hour").html("Số tiền phải lớn hơn 0 đồng.");
        button.setAttribute("disabled", true);
    }
    if (next < 0) {
        $("span.next_hour").html("Số tiền phải lớn hơn 0 đồng.");
        button.setAttribute("disabled", true);
    }
    console.log(typeof first);
    console.log(first.length);
    if (first >= 0 && next >= 0) {
        button.removeAttribute("disabled");
        if (length1 == 0) {
            button.setAttribute("disabled", true);
        }
        if (length2 == 0) {
            button.setAttribute("disabled", true);
        }
        if (length1 > 0 && length2 > 0) {
            button.removeAttribute("disabled");
        }
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
