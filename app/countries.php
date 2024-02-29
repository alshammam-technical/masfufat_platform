<?php

namespace App;

use Illuminate\Support\Facades\App;
use App\CPU\Helpers;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Route;

class countries extends Model
{
    use HasFactory;

    protected $appends = [
        'name',
    ];

    public function translations()
    {
        return $this->morphMany('App\Model\Translation', 'translationable');
    }

    public function getNameAttribute($name)
    {
        if (strpos(url()->current(), '/admin') || strpos(url()->current(), '/seller')) {
            return $name;
        }

        return $this->translations[0]->value??$name;
    }

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope('translations', function (Builder $builder) {
            if(!str_starts_with(Route::currentRouteName(), 'admin.')){
                $builder = $builder->where('enabled',1);
            }
            $builder->with(['translations' => function ($query) {
                if (strpos(url()->current(), '/api')){
                    return $query->select('translationable_id','value')->where('locale', 'sa');
                }else{
                    return $query->where('locale', Helpers::default_lang());
                }
            }]);
        });
    }
}
