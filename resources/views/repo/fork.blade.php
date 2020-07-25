@extends('home.master')
@section('slide-content')
<input type="hidden" value="{{$id}}">
@endsection
@section('script')
<script>
    $(document).ready(function() {
        $.ajax({
            type: "GET",
            url: "url",
            data: "data",
            dataType: "dataType",
            success: function (response) {

            }
        });
    })
</script>
@endsection
