<?php

namespace App;

use App\Model\Order;
use App\Model\ShippingAddress;
use App\Model\Subscription;
use App\Model\Wishlist;
use App\Model\DelegatedStore;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;


class User extends Authenticatable
{
    use Notifiable, HasApiTokens;
    protected static $applyOrderPermissionsScope = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'f_name', 'l_name', 'name', 'email', 'phone',  'login_medium','is_active','social_id','is_phone_verified','temporary_token' , 'manager_id','activity'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_active' => 'integer',
        'is_phone_verified'=>'integer',
        'is_email_verified' => 'integer',
        'wallet_balance'=>'float',
        'loyalty_point'=>'float',
        "linked_products"=>'array',
        "ext_accounts"=>'array',
        "store_informations"=>'array',
        "pending_products"=>'array',
        "fav_menu"=>'object',
        "payment_methods"=>'array',
    ];

    public function wish_list()
    {
        return $this->hasMany(Wishlist::class, 'customer_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'customer_id');
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class, 'user_id', 'id');
    }

    public function activeSubscription()
    {
        return Subscription::where(['user_id'=>$this->id,'package_id'=>$this->subscription])->whereIn('status',['paid','active'])->orderBy('id','desc')->first();
    }

    public function shipping()
    {
        return $this->belongsTo(ShippingAddress::class, 'shipping_address');
    }

    public function delegates()
    {
        return $this->hasMany(DelegatedStore::class, 'store_id');
    }

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(function(Builder $builder){
            if(Str::contains(request()->url(), 'admin')){
                if (auth('admin')->check()) {
                    $adminUser = auth('admin')->user();

                    if ($adminUser->admin_role_id == 1) {

                    } else {
                    $user_role = auth('admin')->user()->role ?? null;
                        if ($user_role) {
                            $inputPermissions = json_decode($user_role->input_permissions, true);
                            if (static::$applyOrderPermissionsScope) {

                            }else{
                                if (isset($inputPermissions['E-store powers'])) {
                                    $storeIds = explode(',', $inputPermissions['E-store powers'][0]);
                                    if (!empty($storeIds)) {
                                        $builder->where(function($query) use ($storeIds) {
                                            $query->whereIn('id', $storeIds)
                                                  ->orWhere('is_store', 0);
                                        });
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
