<?php

namespace App;



class Buyer extends User
{
   public function transctions(){
       return $this->hasMany(Transaction::Class);
   }

}
