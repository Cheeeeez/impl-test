<?php

namespace App\Jobs;

use App\Repo;
use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class ForkRepo implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $id;
    protected $token;
    protected $repo;

    public function __construct($id, $token, Repo $repo)
    {
        $this->id = $id;
        $this->token = $token;
        $this->repo = $repo;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $response = Http::get('https://api.github.com/repositories/' . $this->id);
        $forksUrl = $response->json()['forks_url'];
        $client = new Client();
        $forkResponse = $client->request('POST', $forksUrl, ['headers' => ['Authorization' => "token " . $this->token]]);
        $results = (json_decode($forkResponse->getBody()->getContents()));
        $forkedUrl = $results->html_url;
        $this->repo->status = "forked";
        $this->repo->forked_url = $forkedUrl;
        $this->repo->save();
    }
}
