<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    /**
     * Table name
     *
     * @var string
     */
    protected $table = 'customer';

    protected $dates = [
        'created_at',
        'updated_at',
        'birthDate'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'birthDate' => 'date:d/m/Y',
    ];
}
