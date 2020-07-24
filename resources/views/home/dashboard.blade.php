@extends('home.master')
@section('slide-content')
<main>
    <div class="container-fluid mt-4">
        <div id="user-information">
            <h1>User information:</h1>
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
                    <th scope="col">Clone</th>
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
