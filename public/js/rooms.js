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
    var button = document.querySelector('[id="button"]');
    button.setAttribute("disabled", true);
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
    $("span.adults").empty();
    $("span.children").empty();
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
                    swal(
                        "Đã xảy ra lỗi!",
                        "Phòng bạn thêm đã có từ trước",
                        "warning"
                    );
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
    var first = $("#adults").val();
    var next = $("#children").val();
    $("span.adults").empty();
    $("span.children").empty();
    var button = document.querySelector('[id="button"]');
    var length1 = first.length;
    var length2 = next.length;
    if (first < 1) {
        $("span.adults").html("Số người lớn phải lớn hơn 0 đồng.");
        button.setAttribute("disabled", true);
    }
    if (next < 0) {
        $("span.children").html("Số trẻ em phải lớn hơn hoặc bằng 0 đồng.");
        button.setAttribute("disabled", true);
    }
    if (first >= 0 && next >= 0) {
        // button.removeAttribute("disabled");
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

// tìm kiếm phòng theo tên
function searchRoom() {
    var name = $("#search-room").val();
    $.ajax({
        url: "/api/admin/search-room",
        type: "post",
        dataType: "json",
        data: { name: name, status: 2 },
        success: function (rs3) {
            $("#rooms-content").html("");
            rs3.room.forEach((el3) => {
                var htmlRoom = ``;
                if (el3.status == 2) {
                    htmlRoom += `
                    <div class="col-md-3" onclick="clean(${el3.id_room})">
                        <div class="card card-user" style="background-color: rgb(177, 91, 15)">
                            <div class="image">
                                <img src="https://th.bing.com/th/id/OIP.OpuZaJhOd0JGZgVuAPtcWwHaD3?pid=ImgDet&rs=1"
                                    alt="..." />

                            </div>
                            <h3 style="text-align: center; padding-bottom:10px"><b>${el3.name}</b>
                            </h3>
                        </div>
                    </div>
                    `;
                } else if (el3.status == 3) {
                    htmlRoom += `
                    <div class="col-md-3" onclick="fix(${el3.id_room})">
                        <div class="card card-user" style="background-color: rgb(243, 14, 14)">
                            <div class="image">
                                <img src="{{ asset('img/bg9.jpg') }}" alt="..." />
                            </div>
                            <h3 style="text-align: center; padding-bottom:10px"><b>${el3.name}</b>
                            </h3>
                        </div>
                    </div>
                    `;
                }
                $("#rooms-content").append(htmlRoom);
            });
        },
    });
}

function clean(id) {
    $("#insertForm").modal("show");
    $("#exampleModalLongTitle").html("Xác nhận");
    $(".modal-body").html("Đã dọn dẹp phòng");
    $(".modal-footer").empty();
    var btn = `
            <button type="button" class="btn btn-secondary" id="close-additional-fee"
                        data-dismiss="modal">Đóng</button>
            <button type="submit" class="btn btn-primary" id="confirm">Xác nhận</button>
            `;
    $(".modal-footer").append(btn);
    $("button#confirm").on("click", function () {
        $.ajax({
            url: "/api/admin/clean/" + id,
            type: "post",
            dataType: "json",
            success: function (rs) {
                onFinishWizard();
                setTimeout("location.reload(true);", 500);
            },
        });
    });
}

function fix(id) {
    $("#insertForm").modal("show");
    $("#exampleModalLongTitle").html("Xác nhận");
    $(".modal-body").html("Đã sửa chữa phòng");
    $(".modal-footer").empty();
    var btn = `
            <button type="button" class="btn btn-secondary" id="close-additional-fee"
                        data-dismiss="modal">Đóng</button>
            <button type="submit" class="btn btn-primary" id="confirm">Xác nhận</button>
            `;
    $(".modal-footer").append(btn);
    $("button#confirm").on("click", function () {
        $.ajax({
            url: "/api/admin/clean/" + id,
            type: "post",
            dataType: "json",
            success: function (rs) {
                onFinishWizard();
                setTimeout("location.reload(true);", 500);
                // location.reload(true);
            },
        });
    });
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
