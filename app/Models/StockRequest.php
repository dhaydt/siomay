<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockRequest extends Model
{
    use HasFactory;
    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'id', 'cabang_id', 'status',
    ];

    public function cabangs()
    {
        return $this->belongsTo(cabang::class, 'cabang_id');
    }

    public function requestDetails()
    {
        return $this->hasMany(StockRequestDetails::class, 'request_id');
    }
}
