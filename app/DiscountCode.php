<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DiscountCode extends Model
{

    protected $fillable = [ 'store', 'code', 'type', 'value' ];
}
