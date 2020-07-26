<?php

namespace App\Http\Controllers;

use App\Repo;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

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
        $response = Http::get('https://api.github.com/repositories/' . $id);
        $forksUrl = $response->json()['forks_url'];
        $client = new Client();
        $forkResponse = $client->request('POST', $forksUrl, ['headers' => ['Authorization' => "token $token"]]);
        $results = (json_decode($forkResponse->getBody()->getContents()));
        $forkedUrl = $results->html_url;
        $this->update($id, $forkedUrl);
    }

    public function update($id, $url)
    {
        $forkedUrl = $url;
        $repo = Repo::findOrFail($id);
        $repo->status = "forked";
        $repo->forked_url = $forkedUrl;
        $repo->save();
        session()->flash('fork', "Fork repository with ID $id successfully");
        return redirect()->route('repo.index');
    }
}