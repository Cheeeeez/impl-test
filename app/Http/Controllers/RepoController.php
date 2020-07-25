<?php

namespace App\Http\Controllers;

use App\Repo;
use Illuminate\Http\Request;

class RepoController extends Controller
{
    public function create(Request $request)
    {
        $id = $request->id;
        return view('home.clone', compact('id'));
    }

    public function store(Request $request)
    {
        $repo = Repo::create($request->all());
        $id = $repo->id;
        session()->flash('success', "Clone repository with ID $id successfully");
        return redirect()->route('repo.index');
    }

    public function index()
    {
        $repos = Repo::all();
        return view('repo.list', compact('repos'));
    }

    public function fork(Request $request)
    {
        $id = $request->id;
        return view('repo.fork', compact('id'));
    }
}