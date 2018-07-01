<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

use App\Jobs\GetTweets;
use App\Jobs\ProcessDailyScore;
use DB;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];
    protected $coins;
    protected $sinceId;

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $this->coins = config('twitter.coins');


        $schedule->call(function () {
            $this->sinceId = DB::table('tweets')->max('tweet_id');

            foreach($this->coins as $coin){
                GetTweets::dispatch($coin, $this->sinceId);
            }
        //})->everyThirtyMinutes();
        })->everyMinute();

        $schedule->call(function () {
            foreach($this->coins as $coin){
                ProcessDailyScore::dispatch($coin);
            }
        })->dailyAt('23:45');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
