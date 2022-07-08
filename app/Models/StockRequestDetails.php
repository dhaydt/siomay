<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockRequestDetails extends Model
{
    use HasFactory;

    protected $fillable = [
        'request_id', 'cabang_id', 'item_id', 'qty',
    ];

    public function stockRequests()
    {
        return $this->belongsTo(StockRequest::class, 'request_id');
    }

    public function cabangs()
    {
        return $this->belongsTo(cabang::class, 'cabang_id');
    }

    public function products()
    {
        return $this->belongsTo(item::class, 'item_id');
    }
}
