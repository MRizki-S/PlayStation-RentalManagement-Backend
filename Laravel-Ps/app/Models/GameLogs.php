<?php

namespace App\Models;

use App\Models\PlayStation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GameLogs extends Model
{
    use HasFactory;
    protected $table = 'game_logs';
    protected $fillable = [
        'ps_id', 'start_time', 'time_ends', 'total_price', 'status_permainan'
    ];

    // relasi kedalam table PlayStation
    public function playStation()
    {
        return $this->belongsTo(PlayStation::class, 'ps_id', 'id');
    }
}
