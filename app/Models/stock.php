<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class stock extends Model
{
    use HasFactory;

    protected $fillable = [
        'cabang_id', 'item_id', 'qty', 'last_log_id',
    ];

    public function cabangs()
    {
        return $this->belongsTo(cabang::class, 'cabang_id');
    }

    public function items()
    {
        return $this->belongsTo(item::class, 'item_id');
    }

    public function logs()
    {
        return $this->belongsTo(stock_log::class, 'last_log_id');
    }
}
