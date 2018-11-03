<?php

namespace App;

use App\Scopes\BuyerScope;

class Buyer extends User
{
 // 1st method gets executed during object creation
    protected static function boot()
{
    parent::boot();
    static::addGlobalScope(new BuyerScope());
}

   public function transctions(){
       return $this->hasMany(Transaction::Class);
   }

}
