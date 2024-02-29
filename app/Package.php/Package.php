<?php

namespace App;


use App\CPU\Helpers;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Package extends Model
{
    use HasFactory;

    protected $appends = [
        'name',
        'desc',
        'features',
    ];

    public function translations()
    {
        return $this->morphMany('App\Model\Translation', 'translationable');
    }

    public function getFeaturesAttribute()
    {
        return services_packaging::whereIn('id',explode(',',$this->services))->select('id','name')->get();
    }

    public function getNameAttribute($name)
    {
        return Helpers::get_prop('App\Package',$this->id,'name','sa');
        if (strpos(url()->current(), '/admin') || strpos(url()->current(), '/seller')) {
        }

        return $this->translations[0]->value ?? $name;
    }

    public function getDescAttribute($name)
    {
        return Helpers::get_prop('App\Package',$this->id,'desc','sa');
        if (strpos(url()->current(), '/admin') || strpos(url()->current(), '/seller')) {
        }

        return $this->translations[0]->value ?? $name;
    }

    // protected static function boot()
    // {
    //     parent::boot();
    //     static::addGlobalScope('translate', function (Builder $builder) {
    //         $builder->with(['translations' => function ($query) {
    //             if (strpos(url()->current(), '/api')){
    //                 return $query->where('locale', App::getLocale());
    //             }else{
    //                 return $query->where('locale', Helpers::default_lang());
    //             }
    //         }]);
    //     });
    // }
}
