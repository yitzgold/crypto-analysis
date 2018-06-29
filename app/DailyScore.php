<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class DailyScore extends Model
{
    public function getcreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('M d');
    }
}
