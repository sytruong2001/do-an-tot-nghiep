$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
});

function addAdditionalFee(id) {
    $("#frm-additional-fee")[0].reset();
    $("#insertForm-additional-fee").modal("show");
    $("#exampleModalLongTitle-additional-fee").html("Thêm phụ phí tổn thất");
    $("#btn-additional-fee").html("Thêm");
    $("#id-checkin-room").val(id);
    var button = document.querySelector('[id="btn-additional-fee"]');
    button.setAttribute("disabled", true);
}
function editAdditionalFee(id) {
    $.ajax({
        url: "/api/admin/get_additional_fee/" + id,
        type: "get",
        dataType: "json",
        success: function (rs) {
            var name, amount, price;
            rs.forEach((data) => {
                name = data.name;
                amount = data.amount;
                price = data.price / data.amount;
            });
            $("#insertForm-additional-fee").modal("show");
            $("#exampleModalLongTitle-additional-fee").html(
                "Cập nhật thông tin phụ phí"
            );
            $("#name-prod").val(name);
            $("#amount-prod").val(amount);
            $("#price-prod").val(price);
            $("#id-additional-fee").val(id);
            $("#btn-additional-fee").html("Cập nhật");
        },
    });
}

function saveAdditionalFee() {
    var nameAdditionalFee = $("#name-prod").val();
    var amountAdditionalFee = $("#amount-prod").val();
    var priceAdditionalFee = $("#price-prod").val();
    var idAdditionalFee = $("#id-additional-fee").val();
    var idCheckinRoom = $("#id-checkin-room").val();
    if (idAdditionalFee == "") {
        $.ajax({
            url: "/api/admin/create_additional_fee",
            type: "post",
            dataType: "json",
            data: {
                nameAdditionalFee: nameAdditionalFee,
                amountAdditionalFee: amountAdditionalFee,
                priceAdditionalFee: priceAdditionalFee,
                idCheckinRoom: idCheckinRoom,
            },
            success: function (data) {
                if (data === 200) {
                    $("#frm-additional-fee")[0].reset();
                    onFinishWizard();
                }
            },
        });
    } else {
        $.ajax({
            url: "/api/admin/update_additional_fee",
            type: "post",
            dataType: "json",
            data: {
                nameAdditionalFee: nameAdditionalFee,
                amountAdditionalFee: amountAdditionalFee,
                priceAdditionalFee: priceAdditionalFee,
                idCheckinRoom: idCheckinRoom,
                id: idAdditionalFee,
            },
            success: function (data) {
                if (data === 200) {
                    $("#frm-additional-fee")[0].reset();
                    onFinishWizard();
                }
            },
        });
    }
}
function checkAdditional() {
    var amountAdditional = $("#amount-prod").val();
    var priceProd = $("#price-prod").val();
    $("span.amount-prod").empty();
    $("span.price-prod").empty();
    var button = document.querySelector('[id="btn-additional-fee"]');
    var length1 = amountAdditional.length;
    var length2 = priceProd.length;
    if (amountAdditional < 1) {
        $("span.amount-prod").html("Số lượng phải lớn hơn 0 đồng.");
        button.setAttribute("disabled", true);
    }
    if (priceProd < 1) {
        $("span.price-prod").html("Giá tiền phải lớn hơn 0 đồng.");
        button.setAttribute("disabled", true);
    }
    if (amountAdditional >= 0 && priceProd >= 0) {
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

function deleteAdditionalFee(id) {
    $("#insertForm-additional-fee").modal("show");
    $("#exampleModalLongTitle-additional-fee").html("Xác nhận");
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
            url: "/api/admin/delete_additional_fee/" + id,
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
