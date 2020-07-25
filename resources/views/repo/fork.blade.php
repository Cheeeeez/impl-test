@extends('home.master')
@section('slide-content')
<input type="hidden" value="{{$id}}" id="id">
<input type="hidden" value="{{Auth::user()->token}}" id="token">
@endsection
@section('script')
<script src="{{ asset('js/fork.js') }}"></script>
@endsection
