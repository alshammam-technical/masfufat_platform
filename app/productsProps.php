<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class productsProps extends Model
{
    use HasFactory;
    protected $table = "products_props";
    protected $fillable = [
        'enabled'
    ];

    public function translations()
    {
        return $this->morphMany('App\Model\Translation', 'translationable');
    }
}
