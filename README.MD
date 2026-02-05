# Laravel Activity Log 📊

ماژول **Activity Log** یک پکیج مستقل برای لاراول است که عملیات CRUD روی مدل‌ها را ثبت می‌کند و امکان تحلیل داده‌ها، جستجو و فیلتر پیشرفته را فراهم می‌سازد.
این پکیج به شما کمک می‌کند تا رفتار کاربران و تغییرات داده‌ها را به صورت دقیق ردیابی کنید.

---

## ✨ ویژگی‌ها
- ثبت عملیات `create`, `update`, `delete` روی مدل‌ها
- ذخیره اطلاعات کاربر، IP، User Agent و URL درخواست
- ذخیره تغییرات قبل و بعد (before/after values)
- امکان افزودن داده‌های اضافی در ستون `meta`
- Facade برای دسترسی ساده به داده‌ها
- جستجو و فیلتر پیشرفته روی لاگ‌ها
- API آماده برای دریافت لاگ‌ها و آمار

---

## 📦 نصب
```bash
composer require hosseinesteki/activity-log
```

---

## ⚙️ پیکربندی
پکیج به صورت خودکار ServiceProvider و Facade را رجیستر می‌کند.
اگر نیاز به تنظیمات خاص دارید، می‌توانید فایل‌های migration را publish کنید:

```bash
php artisan vendor:publish --provider="Vendor\ActivityLog\ActivityLogServiceProvider" --tag=migrations
php artisan migrate
```

---

## 🛠 استفاده
### افزودن Trait به مدل‌ها
```php
use ActivityLog\Traits\HasActivityLog;

class Post extends Model
{
    use HasActivityLog;

    protected $fillable = ['title', 'content'];
}
```

### ذخیره لاگ دستی
```php
use ActivityLog;

ActivityLog::log([
    'user_id' => auth()->id(),
    'model'   => 'App\Models\Post',
    'action'  => 'update',
    'model_id'=> 12,
    'changes' => ['title' => ['old' => 'A', 'new' => 'B']],
]);
```

### دریافت لاگ‌ها با فیلتر
```php
$logs = ActivityLog::all([
    'user_id' => 1,
    'action'  => 'update',
    'date_from' => '2026-02-01',
    'date_to'   => '2026-02-05',
]);
```

### جستجو
```php
$results = ActivityLog::search('Post', [
    'user_id' => 2,
]);
```

### آمار
```php
$stats = ActivityLog::stats();
```

---

## 🌐 API Endpoints
پکیج دارای API آماده است:

- `GET /api/activity-log` → دریافت همه لاگ‌ها با فیلتر
- `GET /api/activity-log/search?q=keyword` → جستجو
- `GET /api/activity-log/stats` → دریافت آمار

نمونه:
```
GET /api/activity-log?user_id=1&action=update&date_from=2026-02-01&date_to=2026-02-05
```

---

## 📊 تحلیل داده‌ها
- بیشترین کاربر فعال
- بیشترین مدل تغییر یافته
- فیلدهایی که بیشتر تغییر کرده‌اند
- امکان اتصال به ابزارهای گزارش‌گیری مثل Chart.js یا PowerBI

---

## 📝 License
این پکیج تحت مجوز MIT منتشر شده است.
