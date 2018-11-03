<?php
/**
 * Created by PhpStorm.
 * User: Archit
 * Date: 11/3/2018
 * Time: 11:26 AM
 */
namespace App\Scopes;

use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class SellerScope implements Scope
{

    public function apply(Builder $builder, Model $model)
    {

        $builder->has('products');
    }
}