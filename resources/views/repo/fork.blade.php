@extends('home.master')
@section('slide-content')
<input type="hidden" value="{{$id}}" id="id">
@endsection
@section('script')
<script>
    $(document).ready(function() {
        $.ajax({
            type: "GET",
            url: "https://api.github.com/repositories/" + $("#id").val(),
            dataType: "JSON",
            success: function (response) {
                console.log(response)
                $.ajax({
                    type: "POST",
                    url: response.forks_url,
                    // dataType: "dataType",
                    success: function (result) {
                        console.result
                    }
                });
            }
        });
    })
</script>
@endsection
