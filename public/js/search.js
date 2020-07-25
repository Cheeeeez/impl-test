const MAX_REPO_PER_PAGE = 30;
const FIRST_PAGE = 1;
let page = FIRST_PAGE;
var loadedRepo = 0;
let totalRepo = 0;
$("#table").hide();
$("#load-more").hide();
let table = document.getElementById("table-content");
$(document).ready(function () {
    $("#search-form").submit(function (e) {
        e.preventDefault();
    });
    // Search user
    $("#search").click(function () {
        page = FIRST_PAGE;
        loadedRepo = 0;
        $.ajax({
            type: "GET",
            url:
                "https://api.github.com/users/" +
                $("#keyword").val() +
                "/repos?sort=created&direction=asc;per_page=100",
            dataType: "JSON",
            success: function (response, textStatus, xhr) {
                totalRepo = response.length;
                table.innerHTML = "";
                $("#user-information").hide();
                $("#table").show();
                if (xhr.getResponseHeader("link")) {
                    let linkHeader = xhr.getResponseHeader("link");
                    let newLinkHeader = linkHeader.replace(/<|>/g, "");
                    let array = newLinkHeader.split(",");
                    let lastPageUrl = array[array.length - 1];
                    for (let i = 0; i < lastPageUrl.length; i++) {
                        if (lastPageUrl[i] == ";") {
                            lastPage = lastPageUrl[i - 1];
                            break;
                        }
                    }
                    $.ajax({
                        type: "GET",
                        url: lastPageUrl,
                        dataType: "JSON",
                        success: function (result) {
                            totalRepo = 100 * (lastPage - 1) + result.length;
                            localStorage.setItem("repo", totalRepo);
                        },
                    });
                    totalRepo = localStorage.getItem("repo");
                    localStorage.clear();
                    loadedRepo = MAX_REPO_PER_PAGE;
                    for (let i = 0; i < MAX_REPO_PER_PAGE; i++) {
                        table.innerHTML += `<tr>
                        <td>${i + 1}</td>
                        <td>${response[i].name} (${
                            response[i].stargazers_count
                        }<i class="fas fa-star"></i>)</td>
                        <td><a target="_blank" href="${response[i].html_url}">${
                            response[i].html_url
                        }</a></td>
                        <td><a href="/${
                            response[i].id
                        }/details" class="btn btn-success">Clone</a></td>
                        </tr>`;
                    }
                    showLoadedReposAndTotalRepos(loadedRepo, totalRepo);
                } else {
                    if (response.length <= MAX_REPO_PER_PAGE) {
                        loadedRepo = response.length;
                        for (let i = 0; i < response.length; i++) {
                            table.innerHTML += `<tr>
                            <td>${i + 1}</td>
                            <td>${response[i].name} (${
                                response[i].stargazers_count
                            }<i class="fas fa-star"></i>)</td>
                            <td><a target="_blank" href="${
                                response[i].html_url
                            }">${response[i].html_url}</a></td>
                            <td><a href="/${
                                response[i].id
                            }/details" class="btn btn-success">Clone</a></td>
                            </tr>`;
                        }
                        showLoadedReposAndTotalRepos(loadedRepo, totalRepo);
                    } else {
                        totalRepo = response.length;
                        loadedRepo = MAX_REPO_PER_PAGE;
                        for (let i = 0; i < MAX_REPO_PER_PAGE; i++) {
                            table.innerHTML += `<tr>
                            <td>${i + 1}</td>
                            <td>${response[i].name} (${
                                response[i].stargazers_count
                            }<i class="fas fa-star"></i>)</td>
                            <td><a target="_blank" href="${
                                response[i].html_url
                            }">${response[i].html_url}</a></td>
                            <td><a href="/${response[i].id}/details
                            " class="btn btn-success">Clone</a></td>
                            </tr>`;
                        }
                        showLoadedReposAndTotalRepos(loadedRepo, totalRepo);
                    }
                }
                showOrHideLoadMoreButton(loadedRepo, totalRepo);
            },
        });
    });
    //Load more
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
                MAX_REPO_PER_PAGE,
            dataType: "JSON",
            success: function (response) {
                for (let i = 0; i < response.length; i++) {
                    table.innerHTML += `<tr>
                        <td>${loadedRepo + i + 1}</td>
                        <td>${response[i].name} (${
                        response[i].stargazers_count
                    }<i class="fas fa-star"></i>)</td>
                        <td><a target="_blank" href="${response[i].html_url}">${
                        response[i].html_url
                    }</a></td>
                    <td><a href="/${response[i].id}/details
                    " class="btn btn-success">Clone</a></td>
                    </tr>`;
                }
                loadedRepo += response.length;
                showLoadedReposAndTotalRepos(loadedRepo, totalRepo);
                showOrHideLoadMoreButton(loadedRepo, totalRepo);
            },
        });
    });
});

function showOrHideLoadMoreButton(a, b) {
    if (a < b) {
        $("#load-more").show();
    } else {
        $("#load-more").hide();
    }
}

function showLoadedReposAndTotalRepos(loadedRepo, totalRepo) {
    $("#repo").html(function () {
        return loadedRepo + "/" + totalRepo;
    });
}
