<?php

namespace App\Model;

use App\CPU\Helpers;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\User;
use Illuminate\Support\Str;


class Brand extends Model
{

    protected $casts = [
        'status' => 'integer',
        'brand_products_count' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function scopeActive(){
        return $this->where('status',1);
    }

    public function brandProducts()
    {
        return $this->hasMany(Product::class)->active();
    }

    public function brandAllProducts(){
        return $this->hasMany(Product::class);
    }

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

    public function getbrandProductsCountAttribute()
    {
        return Helpers::getbrandProductsCount($this->id);
    }

    protected static function boot()
    {
        $storeId = session('user_type') == 'delegate' ? session('original_store_id') : auth('customer')->id() ?? auth('delegatestore')->user()->store_id ?? null;
        $user = User::find($storeId) ?? DelegatedStore::find($storeId);
        parent::boot();
        static::addGlobalScope('translate', function (Builder $builder)use($user) {
            if (!str_starts_with(Route::currentRouteName(), 'admin.') && !str_starts_with(Route::currentRouteName(), 'seller.') && (auth('customer')->check() || auth('delegatestore')->check()) && (\App\Model\BusinessSetting::where('type','pricing_levels')->first()->value ?? false)){
                $builder = $builder->where('show_for_pricing_levels','LIKE','%'.($user->store_informations['pricing_level'] ?? null).'%');
            }
            if(!str_starts_with(Route::currentRouteName(), 'admin.')){
                $builder = $builder->where('status',1);
            }
            $builder->where('deleted',false)->orderBy('priority')->with(['translations' => function ($query) {
                if (strpos(url()->current(), '/api')){
                    return $query->where('locale', App::getLocale());
                }else{
                    return $query->where('locale', Helpers::default_lang());
                }
            }]);
            if(Str::contains(request()->url(), 'admin')){
                if (auth('admin')->check()) {
                    $adminUser = auth('admin')->user();

                    if ($adminUser->admin_role_id == 1) {

                    } else {
                        $user_role = $adminUser->role ?? null;
                        if ($user_role) {
                            $inputPermissions = json_decode($user_role->input_permissions, true);
                            if (isset($inputPermissions['Brand powers'])) {
                                $brandIds = explode(',', $inputPermissions['Brand powers'][0]);
                                if (!empty($brandIds)) {
                                    $builder->whereIn('id', $brandIds);
                                }
                            }
                        }
                    }
                }
            }
        });
    }
}
