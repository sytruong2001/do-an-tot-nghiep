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
    $("#exampleModalLongTitle").html("Thêm nhân viên");
    $("#button").html("Thêm");
}
// function edit(id) {
//     $.ajax({
//         url: "/api/superadmin/get_account/" + id,
//         type: "get",
//         dataType: "json",
//         success: function (rs) {
//             var name, email, phone, dob, gender, address;
//             rs.forEach((data) => {
//                 name = data.name;
//                 email = data.email;
//                 phone = data.info_user.phone;
//                 gender = data.info_user.gender;
//                 address = data.info_user.address;
//                 dob = data.info_user.date_of_birth;
//             });
//             $("#insertForm").modal("show");
//             $("#exampleModalLongTitle").html(
//                 "Cập nhật thông tin loại nhân viên"
//             );
//             $("#name").val(name);
//             $("#email").val(email);
//             $("#address").val(address);
//             $("#phone").val(phone);
//             $("#birth_of_date").val(dob);
//             $("#id").val(id);
//             $("#button").html("Cập nhật");
//         },
//     });
// }

function save() {
    var name = $("#name").val();
    var email = $("#email").val();
    var password = $("#password").val();
    var phone = $("#phone").val();
    var birth_of_date = $("#birth_of_date").val();
    var address = $("#address").val();
    var id = $("#id").val();
    var gender = $('input[type="radio"]:checked').val();

    if (id == "") {
        $.ajax({
            url: "/api/superadmin/create_account",
            type: "post",
            dataType: "json",
            data: {
                name: name,
                email: email,
                password: password,
                phone: phone,
                birth_of_date: birth_of_date,
                address: address,
                gender: gender,
            },
            success: function (data) {
                if (data === 200) {
                    $("#frm")[0].reset();
                    onFinishWizard();
                } else {
                    $("#email_error").html("Địa chỉ email đã tồn tại");
                }
            },
        });
    } else {
        $.ajax({
            url: "/api/superadmin/update_account",
            type: "post",
            dataType: "json",
            data: {
                name: name,
                email: email,
                password: password,
                phone: phone,
                birth_of_date: birth_of_date,
                address: address,
                gender: gender,
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
    $(".modal-body").html("Bạn có chắc chắn muốn khóa nhân viên này không?");
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
