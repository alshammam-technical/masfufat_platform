<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\CPU\Helpers;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class services_packaging extends Model
{
    use HasFactory;

    public function translations()
    {
        return $this->morphMany('App\Model\Translation', 'translationable');
    }

    public function getNameAttribute($name)
    {
        return Helpers::get_prop('App\services_packaging',$this->id,'name','sa');
        if (strpos(url()->current(), '/admin') || strpos(url()->current(), '/seller')) {
            return $name;
        }

        return $this->id;
    }

    // protected static function boot()
    // {
    //     // parent::boot();
    //     // static::addGlobalScope('translate', function (Builder $builder) {
    //     //     $builder->with(['translations' => function ($query) {
    //     //         if (strpos(url()->current(), '/api')){
    //     //             return $query->where('locale', App::getLocale());
    //     //         }else{
    //     //             return $query->where('locale', Helpers::default_lang());
    //     //         }
    //     //     }]);
    //     // });
    // }
}
