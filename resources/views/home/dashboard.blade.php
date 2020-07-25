@extends('home.master')
@section('search')
<form class="d-none d-md-inline-block form-inline ml-2 mr-auto mr-md-3 my-2 my-md-0">
    <div class="input-group">
        <input class="form-control" type="text" id="keyword" placeholder="Search for..." aria-label="Search"
            aria-describedby="basic-addon2" />
        <div class="input-group-append">
            <button class="btn btn-primary" id="search" type="button"><i class="fas fa-search"></i></button>
        </div>
    </div>
</form>
@endsection
@section('slide-content')
<main>
    <div class="container-fluid mt-4">
        <div id="user-information">
            <h1 class="text-primary">User information:</h1>
            <ul>
                <li>Name: {{Auth::user()->name}}</li>
                <li>Email: {{Auth::user()->email}}</li>
            </ul>
        </div>
        <table class="table" id="table">
            <thead class="thead-light">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Repository name</th>
                    <th scope="col">Url</th>
                    <th scope="col">Handle</th>
                </tr>
            </thead>
            <tbody id="table-content"></tbody>
        </table>
        <div class="row">
            <div class="col-md-1 mr-0 ml-auto text-right">
                <span id="repo"></span>
            </div>
        </div>
        <div class="row justify-content-center">
            <button class="btn btn-primary" id="load-more">Load more</button>
        </div>
    </div>
</main>
@endsection
