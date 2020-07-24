$(document).ready(function () {
    $.ajax({
        type: "GET",
        url: "https://api.github.com/repositories/" + $("#repo_id").val(),
        dataType: "JSON",
        success: function (response) {
            console.log(response);
            document.getElementById("name").value = response.name;
            document.getElementById("url").value = response.html_url;
        },
    });
});
