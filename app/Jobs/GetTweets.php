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
    protected $sinceId;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    
    public function __construct($coin, $sinceId)
    {
        $this->coin = $coin;
        $this->sinceId = $sinceId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $settings = config('twitter');
        $getfield = "?q=#". $this->coin . " -filter:retweets&result_type=recent&lang=en&count=15&since_id=".$this->sinceId.'&tweet_mode=extended';
      
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
