@extends('home.master')
@section('slide-content')
<div class="container-fluid mt-3">
    @if (session('success'))
    <div class="alert alert-success">{{session('success')}}</div>
    @endif
    @if (session('fork'))
    <div class="alert alert-success">{{session('fork')}}</div>
    @endif
    <h3 class="text-primary">Saved repositories:</h3>
    <table class="table">
        <thead class="thead-light">
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Name</th>
                <th scope="col">Url</th>
                <th scope="col">Handle</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($repos as $repo)
            <tr>
                <th scope="row">{{$repo->id}}</th>
                <td>{{$repo->name}}</td>
                <td>{{$repo->url}}</td>
                {{-- @if ($repo->status == 'forked')
                <td><a></a></td>
                @endif --}}
                <td><a href="{{ route('repo.fork', $repo->id) }}" class="btn btn-primary">Fork</a></td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
