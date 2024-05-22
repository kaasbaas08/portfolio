$(document).ready(function () {
    $("#form").submit(function (event) {

        event.preventDefault();
        var formData = $(this).serialize();

        $.ajax({
            type: "POST",
            url: "heads-or-tails.php",
            data: formData,
            success: function (response) {
                $("body").html(response);
            },
            error: function (error) {
                console.log("Error:", error);
            }
        });

    });
});