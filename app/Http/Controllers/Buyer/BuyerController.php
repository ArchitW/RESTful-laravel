<?php

namespace App\Http\Controllers\Buyer;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Buyer;
use Illuminate\Support\Facades\DB;

class BuyerController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       // DB::enableQueryLog();
       $buyers =  Buyer::has('transctions')->get();
   // dd(DB::getQueryLog());
       return $this->showAll($buyers);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $buyer = Buyer::has('transctions')->findOrFail($id);

        return $this->showOne($buyer);
    }


}
