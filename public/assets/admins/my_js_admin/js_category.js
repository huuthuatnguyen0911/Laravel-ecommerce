$(document).ready(function () {
    let url = "";

    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    // xem thể loại
    $(".btn_seen_category").on("click", function (e) {
        e.preventDefault();

        $("#model_form").modal("toggle");
        $(".box_total_Category_product").show();
        $("#avatarCategory").show();
        $("#model_formLabel").text("Xem thể loại");

        let dataID = $(this).data("id");
        getInfToform(dataID);
        changeAttr();
    });

    // sửa thể loại
    $(".btn_edit_category").on("click", function (e) {
        e.preventDefault();

        url = $(this).attr("href");

        $("#model_form").modal("toggle");
        $("#form_category").find("[readonly]").removeAttr("readonly");
        $("#form_category").find("[hidden]").removeAttr("hidden");
        $("#totalPrCategory").prop("readonly", true);
        $("#idCategory").prop("readonly", true);
        $("#avatarCategory").hide();
        $(".btn_add_form").hide();
        $(".box_total_Category_product").show();
        $(".btn_edit_form").show();
        $("#model_formLabel").text("Sửa thể loại");

        let dataID = $(this).data("id");
        getInfToform(dataID);
    });

    // Thêm thể loại thể loại
    $(".btn_add_category").on("click", function (e) {
        e.preventDefault();

        $("#model_form").modal("toggle");
        $("#form_category").find("[readonly]").removeAttr("readonly");
        $("#form_category").find("[hidden]").removeAttr("hidden");
        $(".box_total_Category_product").hide();
        $(".btn_add_form").show();
        $(".btn_edit_form").hide();
        $("#avatarCategory").hide();
        $("#model_formLabel").text("Thêm thể loại");

        removeValue();

        $("#form_category").attr("action", $(this).attr("href"));
    });

    $("#form_category").on("click", ".btn_edit_form", function (e) {
        e.preventDefault();
        // var $inputData = $(this).serialize();
        // let url = $(".btn_edit_category").attr("href");
        var form_data = new FormData();
        // console.log(url);
        // Lấy ra files
        var file_data = $("#avatarCategoryform")[0].files[0];
        // console.log(file_data);
        if (file_data != null) {
            var type = file_data.type;
            var match = ["image/png", "image/jpg", "image/jpeg"];
            if (type == match[0] || type == match[1] || type == match[2]) {
                form_data.append("fileData", file_data);
            } else {
                showNotification(
                    "alert-warning",
                    `Chỉ nhận định dạng ${match[0]}, ${match[1]}, ${match[2]}`
                );
                // break;
            }
        }
        form_data.append("nameCategory", $("#nameCategory").val());
        form_data.append("dsCategory", $("#dsCategory").val());
        ajaxsubmitCategory(url, form_data);
    });

    // xóa thể loại
    $("#tableBodyCategory").on("click", ".btn_delete_category", function (e) {
        e.preventDefault();
        $url = $(this).attr("href");
        $name = $(this).attr("name");
        deleteCategory("Sẽ mất tất cả các sản phẩm thuộc thể loại này. Bạn có muốn xóa không ???", $url, $name);
    })
});

function removeValue() {
    $("#idCategory").val("");
    $("#nameCategory").val("");
    $("#dsCategory").val("");
    $("#totalPrCategory").val("");
}

function callConfirm($msg, callback, itemAction) {
    $(".btn_confirm .text_msg").text($msg);
    $(".btn_confirm").css({
        right: "30px",
        "z-index": "99999"
    });

    $(".btn_confirm .close").click(function () {
        $(".btn_confirm").css({
            right: "-999px"
        });
    });

    $(".btn_confirm .btn_ok").click(function () {
        // delete_category($(".btn_submit_form_delete"));
        callback(itemAction);
        $(".btn_confirm").css({
            right: "-999px"
        });
    });

    $(".btn_confirm .btn_cancel").click(function () {
        $(".btn_confirm").css({
            right: "-999px"
        });
    });
}

function deleteCategory($msg, $url, $name) {
    $(".btn_confirm .text_msg").text($msg);
    $(".btn_confirm").css({
        right: "30px",
        "z-index": "99999"
    });

    $(".btn_confirm .close").click(function () {
        $(".btn_confirm").css({
            right: "-999px"
        });
    });

    $(".btn_confirm .btn_ok").click(function () {
        // delete_category($(".btn_submit_form_delete"));
        $.ajax({
            url: $url,
            type: 'DELETE',
            data: $name,
            success: function (data) {
                if (data.status == "fail") {
                    $(".alert-danger .text_msg").text(data.message);
                    $(".alert-danger").css({
                        right: "30px",
                        "z-index": "99999"
                    });
                    $(".alert-danger .close").click(function () {
                        $(".alert-danger").css({
                            right: "-999px"
                        });
                    });

                    setTimeout(function () {
                        $(".alert-danger").css({
                            right: "-999px"
                        });
                    }, 3000);
                }
                location.reload();
            }
        })
        $(".btn_confirm").css({
            right: "-999px"
        });
    });

    $(".btn_confirm .btn_cancel").click(function () {
        $(".btn_confirm").css({
            right: "-999px"
        });
    });
}

function getInfToform($dataId) {
    let infIdCategory = $("#id_category_" + $dataId).text();
    let infAvtCategory = $("#avt_category_" + $dataId).attr("src");
    let infNameCategory = $("#name_category_" + $dataId).text();
    let infDsCategory = $("#ds_category_" + $dataId).text();
    let infITtPrCategory = $("#tt_pr_category_" + $dataId).text();

    $("#idCategory").val(infIdCategory);
    $("#avatarCategory img").attr("src", infAvtCategory);
    $("#nameCategory").val(infNameCategory);
    $("#dsCategory").val(infDsCategory);
    $("#totalPrCategory").val(infITtPrCategory);
}

function changeAttr() {
    $("#idCategory").prop("readonly", true);
    $("#nameCategory").prop("readonly", true);
    $("#dsCategory").prop("readonly", true);
    $("#totalPrCategory").prop("readonly", true);
    $('button[type="submit"]').prop("hidden", true);
    $("#avatarCategoryform").prop("hidden", true);
}

function showNotification(alertNotification, textMsg) {
    $(`.${alertNotification} .text_msg`).text(textMsg);
    $(`.${alertNotification}`).css({
        right: "30px",
        "z-index": "99999",
    });
    $(`.${alertNotification} .close`).click(function () {
        $(".alert-warning").css({
            right: "-999px",
        });
    });

    setTimeout(function () {
        $(`.${alertNotification}`).css({
            right: "-999px",
        });
    }, 3000);
}

function ajaxsubmitCategory($url, form_data) {
    $.ajax({
        type: "POST",
        url: $url,
        data: form_data,
        cache: false,
        contentType: false,
        mimeType: "multipart/form-data",
        processData: false,
        // dataType: 'text',
        success: (data) => {
            $("body").html(data);
        },
        error: function (data) { },
    });
}

function showNotification(alertNotification, textMsg) {
    $(`.${alertNotification} .text_msg`).text(textMsg);
    $(`.${alertNotification}`).css({
        right: "30px",
        "z-index": "99999",
    });
    $(`.${alertNotification} .close`).click(function () {
        $(".alert-warning").css({
            right: "-999px",
        });
    });

    setTimeout(function () {
        $(`.${alertNotification}`).css({
            right: "-999px",
        });
    }, 3000);
}
