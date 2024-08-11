<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlayStation extends Model
{
    use HasFactory;

    protected $table = 'playstation';
    protected $fillable = [
        'ps_code', 'name', 'price_perjam', 'status',
    ];
}
