@extends('home.master')
@section('slide-content')
<div class="col-md-4">
    <form action="">
        <h3>Repo information</h3>
        <div class="form-group">
            <label>ID</label>
            <input id="repo_id" type="text" class="form-control" value="{{$id}}" name="id" readonly>
        </div>
        <div class="form-group">
            <label>Name</label>
            <input id="name" type="text" class="form-control" name="name" readonly>
        </div>
        <div class="form-group">
            <label>Url</label>
            <input id="url" type="text" class="form-control" name="url" readonly>
        </div>
        <input type="hidden" value="{{Auth::user()->id}}" name="user_id">
        <button type="submit" class="btn btn-primary">Save</button>
    </form>
</div>
@endsection
