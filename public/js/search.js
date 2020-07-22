const MAX_REPO = 30;
const FIRST_PAGE = 1;
var page = FIRST_PAGE;
var remainPage = 0;
$("#table").hide();
$("#load-more").hide();
let html = document.getElementById("table-content");
$(document).ready(function () {
    $("form").submit(function (e) {
        e.preventDefault();
    });
    $("#search").click(function () {
        page = FIRST_PAGE;
        remainPage = 0;
        $.ajax({
            type: "GET",
            url:
                "https://api.github.com/users/" +
                $("#keyword").val() +
                "/repos?sort=created&direction=asc;per_page=100",
            dataType: "JSON",
            success: function (response) {
                html.innerHTML = "";
                remainPage = response.length - MAX_REPO;
                console.log(response);
                $("#user-information").hide();
                $("#table").show();
                for (let i = 0; i < MAX_REPO; i++) {
                    html.innerHTML += `<tr>
                        <td>${i + 1}</td>
                        <td>${response[i].name}</td>
                        <td><a target="_blank" href="${response[i].html_url}">${
                        response[i].html_url
                    }</a></td>
                    </tr>`;
                }
                if (response.length > MAX_REPO) {
                    $("#load-more").show();
                } else {
                    $("#load-more").hide();
                }
            },
        });
    });

    $("#load-more").click(function () {
        page++;
        $.ajax({
            type: "GET",
            url:
                "https://api.github.com/users/" +
                $("#keyword").val() +
                "/repos?sort=created&direction=asc;page=" +
                page +
                "&per_page=" +
                MAX_REPO,
            dataType: "JSON",
            success: function (response) {
                for (let i = 0; i < response.length; i++) {
                    html.innerHTML += `<tr>
                        <td>${(page - 1) * MAX_REPO + i + 1}</td>
                        <td>${response[i].name}</td>
                        <td><a target="_blank" href="${response[i].html_url}">${
                        response[i].html_url
                    }</a></td>
                    </tr>`;
                }
                if (response.length < remainPage) {
                    $("#load-more").show();
                } else {
                    $("#load-more").hide();
                }
                remainPage -= response.length;
            },
        });
    });
});
