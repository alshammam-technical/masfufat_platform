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


class Category extends Model
{
    protected $casts = [
        'parent_id' => 'integer',
        'position' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'home_status' => 'integer',
        'priority' => 'integer'
    ];

    protected $appends = [
        'icon',
        'icon_url',
        'image_url',
    ];

    public function translations()
    {
        return $this->morphMany('App\Model\Translation', 'translationable');
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id')->where('home_status',1)->orderBy('priority','desc');
    }

    public function childes()
    {
        return $this->hasMany(Category::class, 'parent_id')->where('home_status',1)->orderBy('priority','desc');
    }

    public function getNameAttribute($name)
    {
        if (strpos(url()->current(), '/admin') || strpos(url()->current(), '/seller')) {
            return $name;
        }

        return $this->translations[0]->value ?? $name;
    }
    public function scopePriority($query)
    {
        return $query->orderBy('priority','asc');
    }

    public function getIconAttribute()
    {
        return Helpers::get_prop('App\Model\Category',$this->id,'icon','sa');
    }

    public function getIconUrlAttribute()
    {
        return asset('storage/app/public/category').'/'.Helpers::get_prop('App\Model\Category',$this->id,'icon','sa');
    }

    public function getImageUrlAttribute()
    {
        return asset('storage/app/public/category').'/'.Helpers::get_prop('App\Model\Category',$this->id,'image','sa');
    }

    protected static function boot()
    {
        $storeId = session('user_type') == 'delegate' ? session('original_store_id') : auth('customer')->id() ?? auth('delegatestore')->user()->store_id ?? null;
        $user = User::find($storeId);
        parent::boot();
        static::addGlobalScope('translate', function (Builder $builder)use($user) {
            if (!str_starts_with(Route::currentRouteName(), 'admin.') && !str_starts_with(Route::currentRouteName(), 'seller.') && (auth('customer')->check() || auth('delegatestore')->check()) && (\App\Model\BusinessSetting::where('type','pricing_levels')->first()->value ?? false)){
                $builder = $builder->where('show_for_pricing_levels','LIKE','%'.($user->store_informations['pricing_level'] ?? null).'%');
            }
            $builder->where('deleted',false)->with(['translations' => function ($query) {
                if (strpos(url()->current(), '/api')){
                    return $query->where('key','name')->where('locale', App::getLocale() ?? 'sa');
                }else{
                    return $query->where('locale', Helpers::default_lang());
                }
            }]);
            if(Str::contains(request()->url(), 'admin'))
            {
                if (auth('admin')->check()) {
                    $adminUser = auth('admin')->user();

                    if ($adminUser->admin_role_id == 1) {

                    } else {
                        $user_role = $adminUser->role ?? null;
                        if ($user_role) {
                            $inputPermissions = json_decode($user_role->input_permissions, true);
                            if (isset($inputPermissions['Department powers'])) {
                                $categoryIds = explode(',', $inputPermissions['Department powers'][0]);
                                if (!empty($categoryIds)) {
                                    $builder->whereIn('id', $categoryIds);
                                }
                            }
                        }
                    }
                }
            }
        });
    }
}
