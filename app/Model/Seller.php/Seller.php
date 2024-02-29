<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;


class Seller extends Authenticatable
{
    use Notifiable;
    protected static $applyOrderPermissionsScope = false;
    protected $fillable = [
        'name',
        'f_name',
        'l_name',
        'email',
        'phone',
        'account_no',
        'vendor_account_number',
        'company_name',
        'license_owner_name',
        'license_owner_phone',
        'delegate_name',
        'delegate_phone',
        'commercial_registration_no',
        'tax_no',
        'country',
        'area',
        'city',
        'governorate',
        'address',
        'site_url',
        'lat',
        'lon',
        'manager_id',
        'zip',
        'activity',
    ];

    protected $casts = [
        'id' => 'integer',
        'orders_count' => 'integer',
        'product_count' => 'integer',
        'pos+status' => 'integer',
        'fav_menu' => 'array',
        'module_access' => 'array',
        'input_access' => 'array',
    ];

    public function scopeApproved($query)
    {
        return $query->where(['status'=>'approved']);
    }

    public function shop()
    {
        return $this->hasOne(Shop::class, 'seller_id');
    }

    public function shops()
    {
        return $this->hasMany(Shop::class, 'seller_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'seller_id');
    }

    public function product()
    {
        return $this->hasMany(Product::class, 'user_id')->where(['added_by'=>'seller']);
    }

    public function wallet()
    {
        return $this->hasOne(SellerWallet::class);
    }

    public function role(){
        return $this->module_access;
    }

    public function delegates()
    {
        return $this->hasMany(DelegatedSeller::class);
    }

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(function(Builder $builder){
            if(Str::contains(request()->url(), 'admin')){
                if (auth('admin')->check()) {
                    $adminUser = auth('admin')->user();

                    if ($adminUser->admin_role_id == 1) {
                        $builder->where('deleted', 0);
                    } else {
                        $user_role = $adminUser->role ?? null;
                        if (static::$applyOrderPermissionsScope) {
                            $builder->where('deleted', 0);
                        }else{
                            if ($user_role) {
                                $inputPermissions = json_decode($user_role->input_permissions, true);
                                if (isset($inputPermissions['Suppliers permissions'])) {
                                    $supplierIds = explode(',', $inputPermissions['Suppliers permissions'][0]);
                                    if (!empty($supplierIds)) {
                                        $builder->whereIn('id', $supplierIds);
                                    }
                                }
                            }
                        }
                    }
                }
            }

        });
    }

    public static function setApplyOrderPermissionsScope($apply)
    {
        static::$applyOrderPermissionsScope = $apply;
    }

}
