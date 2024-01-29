<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLog extends Model
{
    use HasFactory;

    protected $table = 'user_logs';

    protected $fillable =  ['user_id', 'email', 'ip_address', 'log_user_agent', 'activity', 'status', 'date_time'];
    // time log parse format
    public function getDateTimeAttribute($value)
    {
        return Carbon::parse($value)->diffForHumans();
    }
}
