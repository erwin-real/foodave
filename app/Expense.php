<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $fillable = [
        'month', 'capital',
        'profit', 'clerk',
        'rental', 'water',
        'electric', 'service',
        'others', 'net_income',
    ];

    // Table Name
    protected $table = 'expenses';

    // Primary Key
    public $primaryKey = 'id';

    // Timestamps
    public $timestamps = true;

}
