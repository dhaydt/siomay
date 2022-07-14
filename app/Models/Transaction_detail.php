<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction_detail extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_id', 'item_id', 'price', 'qty', 'sub_total',
    ];

    public function products()
    {
        return $this->belongsTo(item::class, 'item_id');
    }
}
