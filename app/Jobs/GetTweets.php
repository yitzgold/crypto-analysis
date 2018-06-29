<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use TwitterAPIExchange;
use App\Jobs\ProcessTweet;
//use Illuminate\Support\Carbon;
use DB;

class GetTweets implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $coin;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    
    public function __construct($coin)
    {
        $this->coin = $coin;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $sinceId = DB::table('tweets')->max('tweet_id');
        $settings = config('twitter');
        $getfield = "?q=#". $this->coin . " -filter:retweets&result_type=recent&lang=en&count=15&since_id=".$sinceId;
      
        $twitter = new TwitterAPIExchange($settings['auth']);
        $tweets = $twitter->setGetfield($getfield)
            ->buildOauth($settings['url'], $settings['requestMethod'])
            ->performRequest();
        
        $tweetArr = json_decode($tweets, true);
        foreach($tweetArr['statuses'] as $tweet){  
            ProcessTweet::dispatch($tweet, $this->coin);
        }
    }
}
