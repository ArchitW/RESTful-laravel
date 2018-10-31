<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'quantity', 'seller_id', 'buyer_id'
    ];

    public function buyer(){
        return $this->belongsTo(Buyer::Class);
    }
    public function seller(){
        return $this->belongsTo(Seller::Class);
    }
}
