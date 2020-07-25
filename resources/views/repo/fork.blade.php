@extends('home.master')
@section('slide-content')
<input type="hidden" value="{{$id}}" id="id">
<input type="hidden" value="{{Auth::user()->token}}" id="token">
@endsection
@section('script')
<script>
    let token1 = $("#token").val();
    $(document).ready(function() {
        $.ajax({
            type: "GET",
            url: "https://api.github.com/repositories/" + $("#id").val(),
            dataType: "JSON",
            success: function (response) {
                console.log(response)
                $.ajax({
                    type: "GET",
                    url: "https://github.com/login/oauth/authorize",
                    dataType: "JSON",
                    success: function (result) {
                        console.log(result)
                    }
                });
            }
        });
    })
</script>
@endsection
