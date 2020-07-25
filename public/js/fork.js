let id = $("#id").val();
    let accessToken = $("#token").val();
    $(document).ready(function() {
        $.ajax({
            type: "GET",
            url: "https://api.github.com/repositories/" + id,
            dataType: "JSON",
            success: function (response) {
                $.ajax({
                    type: "POST",
                    url: response.forks_url,
                    dataType: "JSON",
                    headers: {Authorization : "token " + accessToken},
                    success: function (result) {
                        $.ajax({
                            type: "POST",
                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                            url: "/" + id + "/update",
                            data: {forkedUrl: result.html_url},
                            success: function (outcome) {
                                window.location.href = "/repo-list";
                            }
                        });
                    }
                });
            }
        });
    })
