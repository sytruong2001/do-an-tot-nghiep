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
    $("#btn-services").html("Thêm");
    $("#id-checkin-room").val(id);
    var button = document.querySelector('[id="btn-services"]');
    button.setAttribute("disabled", true);
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
                price = data.price / data.amount;
            });
            $("#insertForm-services").modal("show");
            $("#exampleModalLongTitle").html(
                "Cập nhật thông tin dịch vụ sử dụng"
            );
            $("#name-service").val(name);
            $("#amount-service").val(amount);
            $("#price-service").val(price);
            $("#id-service").val(id);
            $("#btn-services").html("Cập nhật");
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
function checkService() {
    var amountService = $("#amount-service").val();
    var priceService = $("#price-service").val();
    $("span.amount-service").empty();
    $("span.price-service").empty();
    var button = document.querySelector('[id="btn-services"]');

    var length1 = amountService.length;
    var length2 = priceService.length;
    if (amountService < 1) {
        $("span.amount-service").html("Số lượng phải lớn hơn 0 đồng.");
        button.setAttribute("disabled", true);
    }
    if (priceService < 1) {
        $("span.price-service").html("Giá tiền phải lớn hơn 0 đồng.");
        button.setAttribute("disabled", true);
    }
    if (amountService >= 0 && priceService >= 0) {
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
