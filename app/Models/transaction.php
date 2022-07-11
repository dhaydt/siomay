<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class transaction extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $keyType = 'string';
    protected $primaryKey = 'transaction_id';

    protected $fillable = [
        'order_items', 'order_amount', 'wa', 'transaction_id', 'name', 'cabang_id',
    ];

    public function cabangs()
    {
        return $this->belongsTo(cabang::class, 'cabang_id');
    }
}
