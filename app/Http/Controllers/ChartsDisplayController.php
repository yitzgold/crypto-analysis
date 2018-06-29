<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DailyScore;
use Charts;

class ChartsDisplayController extends Controller
{
    protected $coins;

    public function displayChart()
    {
        $this->coins = config('twitter.coins');

        $daily = DailyScore::all();

        $chart = Charts::multi('line', 'highcharts')
            ->title("Crypto Sentiment Analysis")
            ->elementLabel('score')
            ->labels($daily->unique('created_at')->pluck('created_at'));
            foreach ($this->coins as $coin){
                $chart->dataset($coin, $daily->where('coin', 'like', $coin)->pluck('score'));
            };
            $chart->responsive(true);

        return view('chart',['chart' => $chart]);
    }
}
