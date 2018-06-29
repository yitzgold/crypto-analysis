<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DailyScore;
use Charts;


class ChartsDisplayController extends Controller
{
    public function displayChart()
    {
        $daily = DailyScore::all();

        $chart = Charts::multi('line', 'fusioncharts')
            ->title("Crypto Sentiment Analysis")
            ->elementLabel('score')
            ->labels($daily->unique('created_at')->pluck('created_at'))
            ->dataset('BTC',$daily->where('coin', 'like' ,'BTC')->pluck('score'))
            ->dataset('LTC',$daily->where('coin', 'like' ,'LTC')->pluck('score'))
            ->dataset('ETH',$daily->where('coin', 'like' ,'ETH')->pluck('score'))
            ->responsive(true);

        return view('chart',['chart' => $chart]);
    }
}
