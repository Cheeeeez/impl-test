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
        Repo::create($request->all());
        session()->flash('success', 'Clone successfully');
        return redirect()->route('home');
    }

    public function index()
    {
        $repos = Repo::all();
        return view('repo.list', compact('repos'));
    }
}
