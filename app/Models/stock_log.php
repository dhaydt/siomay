<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class stock_log extends Model
{
    use HasFactory;

    protected $fillable = [
        'cabang_id', 'item_id', 'qty_before', 'qty', 'added_value', 'status', 'log_id', 'added_by',
    ];
}
