<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Theme extends Model
{

    public $primaryKey = 'store';

    protected $fillable = [
        'store',
        'border',
        'border_color',
        'background_color',
        'text_color',
        'success_color',
        'danger_color'
    ];
}
