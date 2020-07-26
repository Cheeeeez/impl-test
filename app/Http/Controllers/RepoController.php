<?php

namespace App\Http\Controllers;

use App\Jobs\ForkRepo;
use App\Repo;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use function GuzzleHttp\json_decode;

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
        $token = Auth::user()->token;
        $repo = Repo::findOrFail($id);
        $job = (new ForkRepo($id, $token, $repo))->delay(60);
        $this->dispatch($job);
        return redirect()->route('repo.index');
    }
}