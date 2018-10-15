<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Product extends Model
{    
    use Sortable;

    protected $fillable = [
        'name', 'type', 'desc', 
        'price', 'srp', 'source', 
        'contact', 'expired_at', 
        'stocks', 'procurement'
    ];

    public $sortable = [
        'name', 'type', 'desc', 
        'price', 'srp', 'source',
        'contact', 'expired_at', 'stocks', 
        'procurement', 'created_at', 'updated_at'
    ];
    
    // Table Name
    protected $table = 'products';

    // Primary Key
    public $primaryKey = 'id';

    // Timestamps
    public $timestamps = true;
    
}
