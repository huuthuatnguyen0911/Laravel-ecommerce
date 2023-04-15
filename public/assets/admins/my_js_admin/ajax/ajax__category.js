$(document).ready(function () {
    $(".pagination a")
        .off("click")
        .on("click", function (e) {
            e.preventDefault();
            var page = $(this).attr("href").split("page=")[1];
            getPosts(page);
        });

});

function getPosts(page) {
    $.ajax({
        type: "GET",
        url: "?page=" + page,
        success: function (data) {
            // $("body").nextAll().remove();
            $("body").html(data);
        },
    });
}
