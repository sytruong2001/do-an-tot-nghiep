$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
});

function addService(id) {
    $("#frm-services")[0].reset();
    $("#insertForm-services").modal("show");
    $("#exampleModalLongTitle").html("Thêm dịch vụ");
    $("#button").html("Thêm");
    $("#id-checkin-room").val(id);
}
function editService(id) {
    $.ajax({
        url: "/api/admin/get_service/" + id,
        type: "get",
        dataType: "json",
        success: function (rs) {
            var name, amount, price;
            rs.forEach((data) => {
                name = data.name;
                amount = data.amount;
                price = data.price;
            });
            $("#insertForm-services").modal("show");
            $("#exampleModalLongTitle").html(
                "Cập nhật thông tin dịch vụ sử dụng"
            );
            $("#name-service").val(name);
            $("#amount-service").val(amount);
            $("#price-service").val(price);
            $("#id-service").val(id);
            $("#button").html("Cập nhật");
        },
    });
}

function saveService() {
    var nameService = $("#name-service").val();
    var amountService = $("#amount-service").val();
    var priceService = $("#price-service").val();
    var idService = $("#id-service").val();
    var idCheckinRoom = $("#id-checkin-room").val();
    if (idService == "") {
        $.ajax({
            url: "/api/admin/create_service",
            type: "post",
            dataType: "json",
            data: {
                nameService: nameService,
                amountService: amountService,
                priceService: priceService,
                idCheckinRoom: idCheckinRoom,
            },
            success: function (data) {
                if (data === 200) {
                    $("#frm-services")[0].reset();
                    onFinishWizard();
                }
            },
        });
    } else {
        $.ajax({
            url: "/api/admin/update_service",
            type: "post",
            dataType: "json",
            data: {
                nameService: nameService,
                amountService: amountService,
                priceService: priceService,
                idCheckinRoom: idCheckinRoom,
                id: idService,
            },
            success: function (data) {
                if (data === 200) {
                    $("#frm-services")[0].reset();
                    onFinishWizard();
                }
            },
        });
    }
}

function deleteService(id) {
    $("#insertForm-services").modal("show");
    $("#exampleModalLongTitle").html("Xác nhận");
    $(".modal-body").html("Bạn có chắc chắn muốn xóa không?");
    $(".modal-footer").empty();
    var btn = `
            <button type="button" class="btn btn-secondary" id="close-additional-fee"
                        data-dismiss="modal">Đóng</button>
            <button type="submit" class="btn btn-primary" id="confirm">Đồng ý</button>
            `;
    $(".modal-footer").append(btn);
    $("button#confirm").on("click", function () {
        $.ajax({
            url: "/api/admin/delete_service/" + id,
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
