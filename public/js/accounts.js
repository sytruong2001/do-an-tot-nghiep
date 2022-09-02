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
    }
}

function checkNumber() {
    var phone = $("#phone").val();
    $("span.phone").empty();
    if (phone.length < 10 || phone.length > 10) {
        $("span.phone").html("Số điện thoại phải đủ 10 chữ số.");
    }
    if (phone < 0) {
        $("span.phone").html("Số điện thoại không thể là số âm.");
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
            url: "/api/superadmin/lock_account/" + id,
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

function onFinishWizard() {
    swal("Hoàn tất!", "Thành công", "success");
}
