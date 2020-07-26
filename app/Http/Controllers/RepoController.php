<?php

namespace App\Http\Controllers;

use App\Jobs\ForkRepo;
use App\Repo;
use Carbon\Carbon;
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
        $repo = Repo::findOrFail($id);
        $job = (new ForkRepo($repo))->delay(60);
        $this->dispatch($job);
        session()->flash('success', "Fork repository with ID $id successfully");
        return redirect()->route('repo.index');
    }
}
