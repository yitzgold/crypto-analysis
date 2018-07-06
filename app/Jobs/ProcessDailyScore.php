<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use DB;
use Illuminate\Support\Carbon;

class ProcessDailyScore implements ShouldQueue
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
        $avgScore = DB::table('tweets')
            ->where([
                ['coin', $this->coin],
                ['score', '!=', 0.00],
            ])
            ->wheredate('created_at', today())
            ->avg('score');

        DB::table('daily_scores')->insert(
            [
                'coin' => $this->coin,
                'score' => $avgScore, 
                'created_at' => now() 
            ]
        );
    }
}
