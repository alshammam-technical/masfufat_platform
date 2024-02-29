<?php

namespace App\Model;

use App\CPU\Helpers;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\User;
use Illuminate\Support\Str;

class Product extends Model
{
    protected $casts = [
        'user_id' => 'integer',
        'brand_id' => 'integer',
        'min_qty' => 'integer',
        'published' => 'integer',
        'tax' => 'float',
        'unit_price' => 'float',
        'status' => 'integer',
        'discount' => 'float',
        'current_stock' => 'integer',
        'free_shipping' => 'integer',
        'featured_status' => 'integer',
        'refundable' => 'integer',
        'featured' => 'integer',
        'flash_deal' => 'integer',
        'seller_id' => 'integer',
        'purchase_price' => 'float',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'shipping_cost' => 'float',
        'multiply_qty' => 'integer',
        'temp_shipping_cost' => 'float',
        'is_shipping_cost_updated' => 'integer',
        'props' => 'array',
        'options' => 'array',
        'pricing' => 'array',
        'serial_numbers' => 'array',
        'videos_indexing' => 'array',
        'images_indexing' => 'array',
        'video_url' => 'array',
        'linked_products_ids' => 'array',
    ];

    protected $appends = [
        'brand_image',
        'pricings',
        'in_wish_list',
        'synced',
        'image_url',
        'promo_title',
        'short_desc',
        'details',
        'order_count',
        'current_stock',
    ];

    protected $fillable = [
        "name",
        "tax",
        "has_tax",
        "code",
        "irreversible",
        "guarantee",
        "warranty_period",
        "attachment",
        "notable",
        "sold_separately",
        "purchase_note",
        "allow_pre_order",
        "hidden_with_pw",
        "product_pw",
        "selected_countries",
        "selected_areas",
        "selected_cities",
        "selected_provinces",
        "enable_serial_numbers",
        "multi_stores",
        "sendDContents",
        "main_category",
        "category",
        "brand",
        "item_number",
        "product_code",
        "gtin",
        "added_by",
        "user_id",
        "mpn",
        "length",
        "width",
        "height",
        "unit_price",
        "size",
        "space",
        "weight",
        "default_unit",
        "made_in",
        "color",
        "sell_price",
        "cost_price",
        "has_discount",
        "discount_price",
        "start_date",
        "start_time",
        "end_date",
        "end_time",
        "quantity",
        "unlimited",
        "min_quantity",
        "max_quantity",
        "min_quantity_alert",
        "email",
        "website_noti",
        "sms",
        "app_noti",
        "publish_on_market",
        "publish_on_app",
        "v_number",
        "linked_products",
        "shipping_options",
        "payment_options",
        "serial_number",
        "hs_code",
        "is_digital",
        "show_for_pricings",
        "publish_on_market_time",
        "publish_on_market_date",
        "publish_on_app_time",
        "publish_on_app_date",
        "enable_multimedia",
        "multimedia",
        "selling_order",
        "quantity_and_pricings",
        "upon_request",
        "send_using",
        "puplish_immediately",
        "enable_options",
        "send_usingCheck",
        "props",
        "options",
        "parent_id",
        "pricing",
        "purchase_price",
        "current_stock",
        "show_for_pricing_levels",
        "serial_numbers",
        "images_indexing",
        "videos_indexing",
        "suggested_price",
        "minimum_order_qty",
        "display_for",
        "linked_products_ids",
    ];

    public function translations()
    {
        return $this->morphMany('App\Model\Translation', 'translationable');
    }

    public function promo()
    {
        return $this->hasOne('App\Model\Translation', 'translationable_id')->where('translations.key','promo_title')
        ->where('locale', Helpers::default_lang() ?? 'sa')->select('translationable_id','value')
        ;
    }

    public function getPromoAttribute($value)
    {
        return ucfirst($value);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function getSyncedAttribute($value)
    {
        return Helpers::productChoosen($this->id,request()->user()->id ?? null);
    }

    public function desc()
    {
        return $this->hasOne('App\Model\Translation', 'translationable_id')->where('translations.key','description')
        ->where('locale', Helpers::default_lang() ?? 'sa')->select('translationable_id','value')
        ;
    }



    public function scopeActive($query)
    {
        $brand_setting = BusinessSetting::where('type', 'product_brand')->first()->value;
        $digital_product_setting = BusinessSetting::where('type', 'digital_product')->first()->value;
        $category_setting = BusinessSetting::where('type','show_main_category')->first()->value ?? '';
        if (!$digital_product_setting) {
            $product_type = ['physical'];
        } else {
            $product_type = ['digital', 'physical'];
        }
        return $query->when($brand_setting, function ($q) {
            $q->whereHas('brand', function ($query) {
                $query->where(['status' => 1]);
            });
        })->when(!str_starts_with(Route::currentRouteName(), 'admin.') && !str_starts_with(Route::currentRouteName(), 'seller.') && (auth('customer')->check() || auth('delegatestore')->check()) && $category_setting, function ($q) {
            $q->whereHas('category', function ($query) {
                $query->whereNotNull('slug');
            });
        })->when(!$brand_setting, function ($q) {
            $q->whereNull('brand_id');
        })->where(['status' => 1])->orWhere(function ($query) {
            $query->whereNull('brand_id')->where('status', 1);
        })->SellerApproved()->whereIn('product_type', $product_type);
    }

    public function scopeSellerApproved($query)
    {
        $query->whereHas('seller', function ($query) {
            $query->where(['status' => 'approved']);
        })->orWhere(function ($query) {
            $query->where(['added_by' => 'admin', 'status' => 1]);
        });

    }

    public function stocks()
    {
        return $this->hasMany(ProductStock::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'product_id');
    }

    public function reviews_one()
    {
        return $this->hasMany(Review::class, 'product_id')->where('rating','1');
    }

    public function reviews_two()
    {
        return $this->hasMany(Review::class, 'product_id')->where('rating','2');
    }

    public function reviews_three()
    {
        return $this->hasMany(Review::class, 'product_id')->where('rating','3');
    }

    public function reviews_four()
    {
        return $this->hasMany(Review::class, 'product_id')->where('rating','4');
    }

    public function reviews_five()
    {
        return $this->hasMany(Review::class, 'product_id')->where('rating','5');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function brand_details()
    {
        if (strpos(url()->current(), '/api')) {
            return $this->hasOne(Brand::class, 'id', 'brand_id')->select('id','name','status')->with('translations');
        }
        return $this->belongsTo(Brand::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class,'main_category','id');
    }

    public function scopeStatus($query)
    {
        return $query->where('featured_status', 1);
    }

    public function shop()
    {
        return $this->belongsTo(Shop::class, 'seller_id');
    }

    public function seller()
    {
        return $this->belongsTo(Seller::class, 'user_id');
    }

    public function rating()
    {
        return $this->hasMany(Review::class)
        ->select(DB::raw('avg(rating) average, product_id'))
            ->whereNull('delivery_man_id')
            ->groupBy('product_id');
    }

    public function order_details()
    {
        return $this->hasMany(OrderDetail::class, 'product_id');
    }

    public function getOrderCountAttribute()
    {
        return OrderDetail::where('product_id',$this->id)->count();
    }


    public function order_delivered()
    {
        return $this->hasMany(OrderDetail::class, 'product_id')
            ->where('delivery_status', 'delivered');

    }

    public function wish_list()
    {
        return $this->hasMany(Wishlist::class, 'product_id');
    }

    public function getInWishListAttribute($name)
    {
        return $this->wish_list !== null;
    }

    public function getNameAttribute($name)
    {
        return Helpers::get_prop('App\Model\Product',$this->id,'name',session('local') ?? 'sa') ?? $name;
        return $this->translations[0]->value ?? $name;
        if (strpos(url()->current(), '/admin') || strpos(url()->current(), '/seller')) {
            return $name;
        }
        return $this->translations[0]->value ?? $name;
    }

    public function getCurrentStockAttribute($name)
    {
        $c = DB::table('products')->where('id',$this->id)->first()->current_stock ?? 0;
        return ($c <= 0) ? 0 : $c;
    }

    public function getPromoTitleAttribute($name)
    {
        return Helpers::get_prop('App\Model\Product',$this->id,'promo_title',session('local') ?? 'sa') ?? null;
    }

    public function getShortDescAttribute($name)
    {
        return Helpers::get_prop('App\Model\Product',$this->id,'short_desc',session('local') ?? 'sa') ?? null;
    }

    public function short_desc()
    {
        return $this->hasOne('App\Model\Translation', 'translationable_id')->where('translations.key','short_desc')
        ->where('locale', Helpers::default_lang() ?? 'sa')->select('translationable_id','value')
        ;
    }

    public function getDetailsAttribute($detail)
    {
        if (strpos(url()->current(), '/api')) {
            $detail['short_desc'] = $this->short_desc;
            $detail['promo_title'] = $this->promo_title;
            return $detail;
        }
        // $detail['short_desc'] = $this->short_desc;
        // $detail['promo_title'] = $this->promo_title;
        // return $detail;
        return $this->translations[1]->value ?? $detail;
    }

    public function getBrandImageAttribute()
    {
        if (strpos(url()->current(), '/api')) {
            if($this->brand_details){
                return asset("storage/app/public/brand").'/'.(Helpers::get_prop('App\Model\Brand',$this->brand_details->id,'image') ?? $this->brand_details->image ?? null);
            }
            return null;
        }
        return null;
    }

    public function getImageUrlAttribute()
    {
        // التحقق مما إذا كان الرابط يحتوي على '/api' قبل المتابعة في العمليات.
        if (strpos(url()->current(), '/api')) {
            $images = is_string($this->images) ? json_decode($this->images) : $this->images;

            // التأكد من أن $images هو مصفوفة ولديها على الأقل صورة واحدة قبل محاولة بناء الرابط.
            if (is_array($images) && count($images) > 0) {
                // إرجاع الرابط URL لأول صورة في المصفوفة.
                $img = reset($images); // الحصول على أول عنصر في المصفوفة.
                return asset("storage/app/public/product/sa") . '/' . $img;
            }
        }
        return null;
    }

    public function getDiscountAttribute()
    {
        $storeId = session('user_type') == 'delegate' ? session('original_store_id') : auth('customer')->id() ;
        $user = User::find($storeId);
        if(strpos(url()->current(), '/api')){
            return Helpers::getProductPrice_pl($this->id,null)['discount'] ?? 0;
        }
        return Helpers::getProductPrice_pl($this->id,$user)['discount'] ?? 0;
    }

    public function getTheDiscountAttribute()
    {
        return DB::table('products')->where('id',$this->id)->first()->discount ?? 0;
    }



    public function getpricingsAttribute()
    {
        if(strpos(url()->current(), '/api/v1/salla/webhook')){
            return [];
        }
        return Helpers::getProductPrice_pl($this->id,request()->user());
    }

    public function getReviewsCountAttribute()
    {
        return Review::where("product_id",$this->id)->count() ?? 0;
    }


    protected static function boot()
    {
        $storeId = session('user_type') == 'delegate' ? session('original_store_id') : auth('customer')->id() ?? auth('delegatestore')->user()->store_id ?? null;
        $user = User::find($storeId);
        parent::boot();
        static::addGlobalScope('translate', function (Builder $builder)use($user) {
            $builder = $builder
            ->where('products.deleted',0)
            ;
            if (!str_starts_with(Route::currentRouteName(), 'admin.') && !str_starts_with(Route::currentRouteName(), 'seller.') && !str_starts_with(Route::currentRouteName(), 'linked-products') && (auth('customer')->check() || auth('delegatestore')->check()) && (\App\Model\BusinessSetting::where('type','pricing_levels')->first()->value ?? false)){
                // for markets
                $builder = $builder
                ->select([
                    "id"
                    ,"added_by"
                    ,"user_id"
                    ,"name"
                    ,"slug"
                    ,"deleted"
                    ,"parent_id"
                    ,"product_type"
                    ,"category_ids"
                    ,"brand_id"
                    ,"min_qty"
                    ,"refundable"
                    ,"digital_product_type"
                    ,"digital_file_ready"
                    ,"images"
                    ,"featured"
                    ,"flash_deal"
                    ,"video_provider"
                    ,"video_url"
                    ,"variant_product"
                    ,"attributes"
                    ,"variation"
                    ,"published"
                    ,"unit_price"
                    ,"purchase_price"
                    ,"tax"
                    ,"tax_type"
                    ,"discount"
                    ,"discount_type"
                    ,"current_stock"
                    ,"minimum_order_qty"
                    ,"free_shipping"
                    ,"attachment"
                    ,"created_at"
                    ,"updated_at"
                    ,"status"
                    ,"featured_status"
                    ,"meta_title"
                    ,"meta_description"
                    ,"meta_image"
                    ,"request_status"
                    ,"publish_on_app"
                    ,"shipping_cost"
                    ,"multiply_qty"
                    ,"temp_shipping_cost"
                    ,"is_shipping_cost_updated"
                    ,"code"
                    ,"has_tax"
                    ,"unit"
                    ,"sell_price"
                    ,"show_for_pricing_levels"
                    ,"has_discount"
                    ,"linked_products"
                    ,"shipping_options"
                    ,"linked_products_ids"
                    ,"payment_options"
                    ,"is_sub"
                    ,"options_ids"
                    ,"hs_code"
                    ,"is_digital"
                    ,"purchase_note"
                    ,"show_for_pricings"
                    ,"enable_multimedia"
                    ,"multimedia"
                    ,"selling_order"
                    ,"quantity_and_pricings"
                    ,"upon_request"
                    ,"send_using"
                    ,"rank"
                    ,"quantity"
                    ,"enable_options"
                    ,"start_time"
                    ,"send_usingCheck"
                    ,"item_number"
                    ,"gtin"
                    ,"props"
                    ,"mpn"
                    ,"height"
                    ,"width"
                    ,"weight"
                    ,"space"
                    ,"size"
                    ,"made_in"
                    ,"color"
                    ,"irreversible"
                    ,"Warranty_period"
                    ,"sold_separately"
                    ,"allow_pre_order"
                    ,"selected_countries"
                    ,"designated_areas"
                    ,"selected_cities"
                    ,"selected_provinces"
                    ,"length"
                    ,"default_unit"
                    ,"cost_price"
                    ,"discount_price"
                    ,"start_date"
                    ,"unlimited"
                    ,"multi_stores"
                    ,"min_quantity"
                    ,"max_quantity"
                    ,"email"
                    ,"is_option"
                    ,"sendDContents"
                    ,"notable"
                    ,"end_date"
                    ,"end_time"
                    ,"selected_areas"
                    ,"type"
                    ,"enabled"
                    ,"options"
                    ,"serial_numbers"
                    ,"images_indexing"
                    ,"suggested_price"
                    ,"main_category"
                    ,"display_for"
                    ,"publish_market_at"
                    ,"colors"
                    ,"choice_options"
                    ,"pricing"
                    ,"publish_on_market"
                ])


                ->addSelect("pricing->".($user->store_informations['pricing_level'] ?? null)."->value AS my_unit_price")





                ->where('show_for_pricing_levels','LIKE','%'.($user->store_informations['pricing_level'] ?? null).'%')
                ->where('is_shipping_cost_updated','1')
                ->where(function($q){
                    $q->where('publish_on_market','1')
                    ->orWhere('status','1');
                })
                ->whereHas('category', function ($query) {
                    $query->whereNotNull('slug');
                })
                ->whereHas('brand', function ($query) {
                    $query->where(['status' => 1]);
                })
                ->where('request_status',1)
                ->where(function($q){
                    $q->where("publish_market_at", '<=', Carbon::now())
                    ->orWhere('publish_on_market_date',"")
                    ->orWhere('publish_on_market_date',null)
                    ;
                })
                ->with(['translations' => function ($query) {
                    $query
                    ->select('translationable_id',"value")
                    ->where([
                        'locale' => App::getLocale(),
                        'key' => 'name',
                    ]);
                }])
                ;
            }else{
                $builder
                ->where('products.deleted','!=',1)
                ->with(['translations' => function ($query) {
                    if (strpos(url()->current(), '/api')) {
                        return $query->where('key', 'name');
                    } else {
                        return $query->where('locale', Helpers::default_lang());
                    }
                }, 'reviews'=>function($query){
                    $query->whereNull('delivery_man_id');
                }])
                ;
                if(!strpos(url()->current(), '/api/v3') && !strpos(url()->current(), '/api/v1')){
                    $builder = $builder
                    ->with('promo','short_desc','desc','shop','seller.shop')
                    ;
                }
                if (auth('admin')->check() && Str::contains(request()->url(), 'admin')) {
                    $adminUser = auth('admin')->user();
                    if ($adminUser->admin_role_id != 1) { // فقط إذا كان المستخدم ليس بمدير
                        $user_role = $adminUser->role ?? null;
                        if ($user_role) {
                            $inputPermissions = json_decode($user_role->input_permissions, true);
                            if (isset($inputPermissions['Products by Seller'])) {
                                $sellerIds = explode(',', $inputPermissions['Products by Seller'][0]);
                                if (!empty($sellerIds)) {
                                    $builder->where(function($query) use ($sellerIds) {
                                        $query->whereIn('user_id', $sellerIds)
                                              ->Where('added_by', 'seller')
                                              ->orWhere('added_by', 'admin');
                                    });
                                }
                            }
                        }
                    }
                }
                // for mobile app
                // v1, v2
                if ((strpos(url()->current(), '/api/v1') || strpos(url()->current(), '/api/v2')) && (!strpos(url()->current(), '/api/v1/salla/webhook')) && (!strpos(url()->current(), '/api/v2/seller/seller-info')) && (!strpos(url()->current(), '/api/v3/seller/seller-info'))) {
                    if (!strpos(url()->current(), '/api/v1/products/detailszzzz')){
                        // products-lazy
                        if(strpos(url()->current(), '/api/v1/products/products-lazy')){
                            $builder = $builder->select([
                                'id','category_ids','brand_id','slug','name','display_for','product_type','images','discount','publish_on_market','deleted',
                            ])
                            ->addSelect("pricing->".request()->user()->store_informations['pricing_level']."->value AS my_unit_price")
                            ;
                        }else{
                            $builder = $builder->select([
                                "id",
                                "name",
                                "deleted",
                                "slug",
                                "name",
                                "item_number",
                                "gtin",
                                "added_by",
                                "user_id",
                                "props",
                                "mpn",
                                "hs_code",
                                "height",
                                "width",
                                "weight",
                                "space",
                                "size",
                                "unit",
                                "made_in",
                                "color",
                                "category_ids",
                                "brand_id",
                                "display_for",
                                "product_type",
                                "images",
                                "pricing",
                                "videos",
                                "shipping_cost",
                                "linked_products_ids",
                                "has_tax",
                                "status",
                                "is_shipping_cost_updated",
                                "request_status",
                                "publish_app_at",
                                "publish_on_app_date",
                                "current_stock",
                                "end_date",
                                "code",
                                "meta_title",
                                "meta_description",
                                "publish_on_market",
                            ]);
                        }
                    }else{
                        $builder = $builder->select([
                            "id"
                            ,"added_by"
                            ,"user_id"
                            ,"deleted"
                            ,"name"
                            ,"slug"
                            ,"parent_id"
                            ,"product_type"
                            ,"category_ids"
                            ,"brand_id"
                            ,"min_qty"
                            ,"refundable"
                            ,"digital_product_type"
                            ,"digital_file_ready"
                            ,"linked_products_ids"
                            ,"images"
                            ,"featured"
                            ,"flash_deal"
                            ,"video_provider"
                            ,"video_url"
                            ,"variant_product"
                            ,"attributes"
                            ,"variation"
                            ,"published"
                            ,"unit_price"
                            ,"purchase_price"
                            ,"tax"
                            ,"tax_type"
                            ,"discount"
                            ,"discount_type"
                            ,"current_stock"
                            ,"minimum_order_qty"
                            ,"free_shipping"
                            ,"attachment"
                            ,"created_at"
                            ,"updated_at"
                            ,"status"
                            ,"featured_status"
                            ,"meta_title"
                            ,"meta_description"
                            ,"meta_image"
                            ,"request_status"
                            ,"shipping_cost"
                            ,"multiply_qty"
                            ,"temp_shipping_cost"
                            ,"is_shipping_cost_updated"
                            ,"code"
                            ,"has_tax"
                            ,"unit"
                            ,"sell_price"
                            ,"show_for_pricing_levels"
                            ,"has_discount"
                            ,"linked_products"
                            ,"shipping_options"
                            ,"payment_options"
                            ,"is_sub"
                            ,"options_ids"
                            ,"hs_code"
                            ,"is_digital"
                            ,"purchase_note"
                            ,"show_for_pricings"
                            ,"enable_multimedia"
                            ,"multimedia"
                            ,"selling_order"
                            ,"quantity_and_pricings"
                            ,"upon_request"
                            ,"send_using"
                            ,"rank"
                            ,"quantity"
                            ,"enable_options"
                            ,"start_time"
                            ,"send_usingCheck"
                            ,"item_number"
                            ,"gtin"
                            ,"props"
                            ,"mpn"
                            ,"height"
                            ,"width"
                            ,"weight"
                            ,"space"
                            ,"size"
                            ,"made_in"
                            ,"color"
                            ,"irreversible"
                            ,"Warranty_period"
                            ,"sold_separately"
                            ,"allow_pre_order"
                            ,"selected_countries"
                            ,"designated_areas"
                            ,"selected_cities"
                            ,"selected_provinces"
                            ,"length"
                            ,"default_unit"
                            ,"cost_price"
                            ,"discount_price"
                            ,"start_date"
                            ,"unlimited"
                            ,"multi_stores"
                            ,"min_quantity"
                            ,"max_quantity"
                            ,"email"
                            ,"is_option"
                            ,"sendDContents"
                            ,"notable"
                            ,"end_date"
                            ,"end_time"
                            ,"selected_areas"
                            ,"type"
                            ,"enabled"
                            ,"options"
                            ,"serial_numbers"
                            ,"images_indexing"
                            ,"suggested_price"
                            ,"main_category"
                            ,"display_for"
                            ,"publish_market_at"
                            ,"colors"
                            ,"choice_options"
                            ,"pricing"
                            ,"publish_on_market"
                        ]);
                    }
                    $builder = $builder
                    ->addSelect(DB::raw('concat("'.route('home').'/product/", products.slug) as link'))
                    ->withCount(['reviews'=>function($query){$query->whereNull('delivery_man_id');}])
                    ->withCount(['reviews_one'=>function($query){$query->whereNull('delivery_man_id');}])
                    ->withAvg(['reviews_one'=>function($query){$query->whereNull('delivery_man_id');}],'status')
                    ->withCount(['reviews_two'=>function($query){$query->whereNull('delivery_man_id');}])
                    ->withAvg(['reviews_two'=>function($query){$query->whereNull('delivery_man_id');}],'status')
                    ->withCount(['reviews_three'=>function($query){$query->whereNull('delivery_man_id');}])
                    ->withAvg(['reviews_three'=>function($query){$query->whereNull('delivery_man_id');}],'status')
                    ->withCount(['reviews_four'=>function($query){$query->whereNull('delivery_man_id');}])
                    ->withAvg(['reviews_four'=>function($query){$query->whereNull('delivery_man_id');}],'status')
                    ->withCount(['reviews_five'=>function($query){$query->whereNull('delivery_man_id');}])
                    ->withAvg(['reviews_five'=>function($query){$query->whereNull('delivery_man_id');}],'status');
                    $builder = $builder
                    ->where('is_shipping_cost_updated','1')
                    ->addSelect('images->sa as images')
                    ->where('publish_on_app','1')
                    ->where(function($q){
                        $q->where("publish_app_at", '<=', Carbon::now())
                        ->orWhere('publish_on_app_date',"")
                        ->orWhere('publish_on_app_date',null)
                        ;
                    })
                    ->whereHas('category', function ($query) {
                        $query->whereNotNull('slug');
                    })
                    ->whereHas('brand', function ($query) {
                        $query->where(['status' => 1]);
                    })
                    ;
                }

                // v3
                if((strpos(url()->current(), '/api/v3') || strpos(url()->current(), '/api/v1')) && (!strpos(url()->current(), '/api/v3/seller/seller-info'))){
                    if (!strpos(url()->current(), '/api/v3/products/details') && !strpos(url()->current(), '/api/v1/products/products-lazy')){
                        $builder = $builder->select([
                            "id",
                            "name",
                            "deleted",
                            "slug",
                            "name",
                            "category_ids",
                            "brand_id",
                            "has_tax",
                            "unit",
                            "display_for",
                            "product_type",
                            "item_number",
                            "gtin",
                            "added_by",
                            "user_id",
                            "props",
                            "mpn",
                            "hs_code",
                            "height",
                            "width",
                            "weight",
                            "space",
                            "size",
                            "made_in",
                            "color",
                            "images",
                            "videos",
                            "linked_products_ids",
                            "pricing",
                            "shipping_cost",
                            "status",
                            "is_shipping_cost_updated",
                            "request_status",
                            "publish_app_at",
                            "publish_on_app_date",
                            "current_stock",
                            "publish_on_market",
                            "code",
                        ])
                        ;

                    }else{
                        if(!strpos(url()->current(), '/api/v1/products/products-lazy')){
                            $builder = $builder->select([
                                "id"
                                ,"deleted"
                                ,"added_by"
                                ,"user_id"
                                ,"name"
                                ,"slug"
                                ,"parent_id"
                                ,"product_type"
                                ,"category_ids"
                                ,"brand_id"
                                ,"min_qty"
                                ,"refundable"
                                ,"digital_product_type"
                                ,"digital_file_ready"
                                ,"images"
                                ,"featured"
                                ,"flash_deal"
                                ,"video_provider"
                                ,"video_url"
                                ,"variant_product"
                                ,"attributes"
                                ,"variation"
                                ,"published"
                                ,"unit_price"
                                ,"linked_products_ids"
                                ,"purchase_price"
                                ,"tax"
                                ,"tax_type"
                                ,"discount"
                                ,"discount_type"
                                ,"current_stock"
                                ,"minimum_order_qty"
                                ,"free_shipping"
                                ,"attachment"
                                ,"created_at"
                                ,"updated_at"
                                ,"status"
                                ,"featured_status"
                                ,"meta_title"
                                ,"meta_description"
                                ,"meta_image"
                                ,"request_status"
                                ,"shipping_cost"
                                ,"multiply_qty"
                                ,"temp_shipping_cost"
                                ,"is_shipping_cost_updated"
                                ,"code"
                                ,"has_tax"
                                ,"unit"
                                ,"sell_price"
                                ,"show_for_pricing_levels"
                                ,"has_discount"
                                ,"linked_products"
                                ,"shipping_options"
                                ,"payment_options"
                                ,"is_sub"
                                ,"options_ids"
                                ,"hs_code"
                                ,"is_digital"
                                ,"purchase_note"
                                ,"show_for_pricings"
                                ,"enable_multimedia"
                                ,"multimedia"
                                ,"selling_order"
                                ,"quantity_and_pricings"
                                ,"upon_request"
                                ,"send_using"
                                ,"rank"
                                ,"quantity"
                                ,"enable_options"
                                ,"start_time"
                                ,"send_usingCheck"
                                ,"item_number"
                                ,"gtin"
                                ,"props"
                                ,"mpn"
                                ,"height"
                                ,"width"
                                ,"weight"
                                ,"space"
                                ,"size"
                                ,"made_in"
                                ,"color"
                                ,"irreversible"
                                ,"Warranty_period"
                                ,"sold_separately"
                                ,"allow_pre_order"
                                ,"selected_countries"
                                ,"designated_areas"
                                ,"selected_cities"
                                ,"selected_provinces"
                                ,"length"
                                ,"default_unit"
                                ,"cost_price"
                                ,"discount_price"
                                ,"start_date"
                                ,"unlimited"
                                ,"multi_stores"
                                ,"min_quantity"
                                ,"max_quantity"
                                ,"email"
                                ,"is_option"
                                ,"sendDContents"
                                ,"notable"
                                ,"end_date"
                                ,"end_time"
                                ,"selected_areas"
                                ,"type"
                                ,"enabled"
                                ,"options"
                                ,"serial_numbers"
                                ,"images_indexing"
                                ,"suggested_price"
                                ,"main_category"
                                ,"display_for"
                                ,"publish_market_at"
                                ,"colors"
                                ,"choice_options"
                                ,"publish_on_market"
                                ,"pricing"
                            ])
                            ;
                        }
                    }
                    $builder = $builder
                    ->where('is_shipping_cost_updated','1')
                    ->addSelect(DB::raw('concat("'.route('home').'/product/", products.slug) as link'))
                    ->withCount(['reviews'=>function($query){$query->whereNull('delivery_man_id');}])
                    ->withCount(['reviews_one'=>function($query){$query->whereNull('delivery_man_id');}])
                    ->withAvg(['reviews_one'=>function($query){$query->whereNull('delivery_man_id');}],'status')
                    ->withCount(['reviews_two'=>function($query){$query->whereNull('delivery_man_id');}])
                    ->withAvg(['reviews_two'=>function($query){$query->whereNull('delivery_man_id');}],'status')
                    ->withCount(['reviews_three'=>function($query){$query->whereNull('delivery_man_id');}])
                    ->withAvg(['reviews_three'=>function($query){$query->whereNull('delivery_man_id');}],'status')
                    ->withCount(['reviews_four'=>function($query){$query->whereNull('delivery_man_id');}])
                    ->withAvg(['reviews_four'=>function($query){$query->whereNull('delivery_man_id');}],'status')
                    ->withCount(['reviews_five'=>function($query){$query->whereNull('delivery_man_id');}])
                    ->withAvg(['reviews_five'=>function($query){$query->whereNull('delivery_man_id');}],'status')
                    ->addSelect('images->sa as images')
                    ->where('publish_on_app','1')
                    ->where(function($q){
                        $q->where("publish_app_at", '<=', Carbon::now())
                        ->orWhere('publish_on_app_date',"");
                    })
                    ;
                }
                // end mobile app
            }
        });
    }
}
