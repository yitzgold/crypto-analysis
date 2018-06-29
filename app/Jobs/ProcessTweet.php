<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use Google\Cloud\Core\ServiceBuilder;
use DB;

class ProcessTweet implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $tweet;
    protected $coin;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($tweet, $coin)
    {
        $this->tweet = $tweet;
        $this->coin = $coin;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $cloud = new ServiceBuilder([
            'keyFile' => str_replace('\\n', "\n", config('google.key')),
            'projectId' => config('google.projectId')
        ]);
        $language = $cloud->language();
        $annotation = $language->analyzeSentiment($this->tweet['text']);
        $sentiment = $annotation->sentiment();
        $score = $sentiment['score'];  
        $date = strtotime($this->tweet['created_at']);
       
        DB::table('tweets')->insert(
            [
                'tweet_id' => $this->tweet['id'],
                'tweet_date' => $date,
                'text' => $this->tweet['text'],
                'score' => $score, 
                'coin' => $this->coin,
                'created_at' => now()  
            ]
        );
    }
}
