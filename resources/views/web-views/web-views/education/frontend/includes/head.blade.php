<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="ie=edge" />
<meta name="csrf-token" content="{{ csrf_token() }}" />
<meta name="theme-color" content="">
@include('web-views.education.frontend.configurations.metaTags')
<title>{{ config('app.name', 'Laravel') }}
</title>
<link rel="shortcut icon" href="{{asset('storage/app/public/company')}}/{{\App\Model\BusinessSetting::where(['type' => 'training_bag_tab_logo'])->pluck('value')[0] ?? ''}}">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Almarai:wght@300;400;700&display=swap">
<style>
    .sidebar-category {
    /* إضافة الأساليب اللازمة */
}

.sidebar-links {
    display: none; /* افتراضياً، الروابط مخفية */

}

.sidebar-category .active .sidebar-links {
    display: block; /* عند التنشيط، تظهر الروابط */
    margin-bottom: 30px;
    margin-top: -10px;
}

.toggle-icon {
    /* استخدم الخصائص لتنسيق إشارة الفتح/الإغلاق كما تريد */
    cursor: pointer;
    /* اضبط تنسيق السهم أو الأيقونة هنا */
}

/* يمكنك استخدام مكتبة الأيقونات لتدوير الأيقونة عند التنشيط */
.sidebar-category .active .toggle-icon::after {
    content: "\f107"; /* أو استخدم الأيقونة التي تفضلها */
    font-family: 'Font Awesome 5 Free'; /* تغييره إلى مكتبة الأيقونات التي تستخدمها */
    font-weight: 900;
    transform: rotate(180deg); /* قلب الأيقونة لأعلى عندما تكون الفئة مفتوحة */
}
.toggle-icon {
    cursor: pointer;
    margin-left: 10px;
    user-select: none;
    float: left;
}


</style>
