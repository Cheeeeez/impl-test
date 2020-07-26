<?php

namespace App\Jobs;

use App\Repo;
use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\Request;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class ForkRepo implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    protected $repo;

    public function __construct(Repo $repo)
    {
        $this->repo = $repo;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(Request $request)
    {
        $response = Http::get('https://api.github.com/repositories/' . $request->id);
        $forksUrl = $response->json()['forks_url'];
        $client = new Client();
        $forkResponse = $client->request('POST', $forksUrl, ['headers' => ['Authorization' => "token " . $request->token]]);
        $results = (json_decode($forkResponse->getBody()->getContents()));
        $forkedUrl = $results->html_url;
        $this->repo->status = "forked";
        $this->repo->forked_url = $forkedUrl;
        $this->repo->save();
    }
}
