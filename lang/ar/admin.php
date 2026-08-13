<?php

return [
    // Navigation Groups
    'nav' => [
        'admin_management' => 'إدارة المشرفين',
        'access_control' => 'إدارة الوصول',
        'user_management' => 'إدارة المستخدمين',
        'settings' => 'الإعدادات',
    ],

    // Navigation Labels
    'nav_labels' => [
        'dashboard' => 'لوحة التحكم',
        'admins' => 'المشرفين',
        'users' => 'المستخدمين',
        'roles' => 'الأدوار',
        'languages' => 'اللغات',
    ],

    // Dashboard
    'dashboard' => [
        'title' => 'لوحة التحكم',
        'welcome' => 'مرحباً بعودتك، :name',
        'subtitle' => 'إليك نظرة عامة على تطبيقك.',
    ],

    // Common Labels
    'fields' => [
        'name' => 'الاسم',
        'email' => 'البريد الإلكتروني',
        'phone' => 'الهاتف',
        'password' => 'كلمة المرور',
        'password_confirmation' => 'تأكيد كلمة المرور',
        'roles' => 'الأدوار',
        'is_active' => 'نشط',
        'status' => 'الحالة',
        'created_at' => 'تاريخ الإنشاء',
        'updated_at' => 'تاريخ التحديث',
        'registered' => 'تاريخ التسجيل',
        'verified' => 'التحقق',
        'id' => 'المعرف',
        'sort_order' => 'الترتيب',
    ],

    // Admin Resource
    'admin' => [
        'label' => 'مشرف',
        'plural' => 'المشرفين',
    ],

    // User Resource
    'user' => [
        'label' => 'مستخدم',
        'plural' => 'المستخدمين',
        'section_info' => 'معلومات المستخدم',
        'section_info_desc' => 'إدارة البيانات الشخصية للمستخدم.',
        'section_security' => 'الأمان',
        'section_security_desc' => 'تعيين أو تحديث كلمة المرور.',
        'placeholder_name' => 'أدخل الاسم الكامل',
        'placeholder_email' => 'user@example.com',
        'placeholder_phone' => '+966 50 000 0000',
        'helper_inactive' => 'المستخدمون غير النشطين لا يمكنهم الوصول للتطبيق.',
        'placeholder_password' => '8 أحرف على الأقل',
        'placeholder_password_confirm' => 'تأكيد كلمة المرور',
        'email_copied' => 'تم نسخ البريد الإلكتروني',
        'not_verified' => 'غير محقق',
        'activate' => 'تفعيل',
        'deactivate' => 'إلغاء التفعيل',
        'user_activated' => 'تم تفعيل المستخدم',
        'user_deactivated' => 'تم إلغاء تفعيل المستخدم',
        'activate_selected' => 'تفعيل المحدد',
        'deactivate_selected' => 'إلغاء تفعيل المحدد',
        'filter_status' => 'الحالة',
        'filter_active' => 'نشط',
        'filter_inactive' => 'غير نشط',
        'filter_verified' => 'بريد محقق',
        'filter_unverified' => 'بريد غير محقق',
    ],

    // Language Resource
    'language' => [
        'label' => 'لغة',
        'plural' => 'اللغات',
        'section_details' => 'تفاصيل اللغة',
        'section_status' => 'الحالة',
        'code' => 'الرمز',
        'code_placeholder' => 'en, ar, fr...',
        'code_helper' => 'رمز اللغة ISO 639',
        'name' => 'الاسم',
        'name_placeholder' => 'English',
        'native_name' => 'الاسم المحلي',
        'native_name_placeholder' => 'العربية',
        'direction' => 'الاتجاه',
        'direction_ltr' => 'من اليسار لليمين (LTR)',
        'direction_rtl' => 'من اليمين لليسار (RTL)',
        'flag' => 'العلم',
        'flag_placeholder' => '🇺🇸',
        'flag_helper' => 'علم إيموجي',
        'active' => 'نشط',
        'active_helper' => 'اللغات النشطة تظهر في محوّل اللغة',
        'default' => 'اللغة الافتراضية',
        'default_helper' => 'يمكن تعيين لغة افتراضية واحدة فقط. تعيين هذه سيلغي الافتراضية السابقة.',
        'set_default' => 'تعيين كافتراضية',
        'default_set' => ':name هي الآن اللغة الافتراضية',
        'cannot_deactivate_default' => 'لا يمكن إلغاء تفعيل اللغة الافتراضية',
        'active_status' => 'حالة التفعيل',
        'activate_selected' => 'تفعيل المحدد',
        'deactivate_selected' => 'إلغاء تفعيل المحدد',
    ],

    // Widgets
    'widgets' => [
        'total_admins' => 'إجمالي المشرفين',
        'system_administrators' => 'مشرفو النظام',
        'total_users' => 'إجمالي المستخدمين',
        'registered_users' => 'المستخدمون المسجلون',
        'active_users' => 'المستخدمون النشطون',
        'currently_active' => 'نشطون حالياً',
        'inactive_users' => 'المستخدمون غير النشطين',
        'deactivated_accounts' => 'حسابات معطلة',
        'recent_users' => 'أحدث المستخدمين',
        'user_registrations' => 'تسجيلات المستخدمين',
        'user_registrations_desc' => 'اتجاهات التسجيل عبر الزمن',
        'registrations' => 'التسجيلات',
        'new_today' => 'جدد اليوم',
        'registered_today' => 'تسجلوا اليوم',
        'of_total' => 'من الإجمالي',
        'growth_up' => 'زيادة :percent% عن الأسبوع الماضي',
        'growth_down' => 'انخفاض :percent% عن الأسبوع الماضي',
        'filter_7days' => 'آخر 7 أيام',
        'filter_30days' => 'آخر 30 يوم',
        'filter_6months' => 'آخر 6 أشهر',
        'filter_12months' => 'آخر 12 شهر',
        'user_status_breakdown' => 'حالة المستخدمين',
        'user_status_desc' => 'توزيع حالات حسابات المستخدمين',
        'verified_users' => 'محققون',
        'unverified_users' => 'غير محققين',
        'system_overview' => 'نظرة عامة على النظام',
        'total_roles' => 'الأدوار',
        'active_languages' => 'اللغات النشطة',
        'active_sessions' => 'الجلسات النشطة',
    ],

    // Profile
    'profile' => [
        'name' => 'الاسم',
        'email' => 'البريد الإلكتروني',
    ],
];
