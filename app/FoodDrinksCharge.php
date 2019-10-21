<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FoodDrinksCharge extends Model
{
    protected $table = "food_drinks_charges";
    protected $primaryKey = 'id';

    protected $fillable = [
        'customer_id',
        'consumed_on',
        'cost',
        'description',
    ];
}
