<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Route;
use Illuminate\Database\Eloquent\Builder;
use App\CPU\Helpers;
class areas extends Model
{
    use HasFactory;

    public function translations()
    {
        return $this->morphMany('App\Model\Translation', 'translationable');
    }

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope('translate', function (Builder $builder) {
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
