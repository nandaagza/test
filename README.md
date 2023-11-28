# Survey Collector

### Installation

> Follow below instructions

```bash
git clone git@github.com:ZaInformationTechnology/survey-collector.git
```
```bash
composer install
```

-   Run `cp .env.example .env`
-   Configure database at `.env` file

```php
php artisan key:generate
```

```php
php artisan migrate
```

```php
php artisan db:seed
```

- These are login users form database seeders
```json

    {
        "email": "admin@gmail.com",
        "password": "secret",
        "role": "admin"
    },
    {
        "email": "supervisor@gmail.com",
        "password": "secret",
        "role": "supervisor"
    },
    {
        "email": "surveyor@gmail.com",
        "password": "secret",
        "role": "suveryor"
    },
```
## Explanation with user role

```
    * User ရဲ့ role ကို User Table ထဲမှာ role column နဲ့ဘဲသိမ်းထားပါတယ်။
    * User ရဲ့ role က အများကြီးမရှိနိုင်တာကြောင့် role သတ်မှတ်ဖို့ကိုတော့ 
        (role.php) config နဲ့ထားပြီး role ကို အပြာင်းအလဲလုပ်ဖို့စဥ်းစားထားပါတယ်။
    
    Note: UI မှာ ဆက်လုပ်ဖို့တာတွေက Login User ရဲ့ role အပေါ်မူတည်ပြီး
        permission ထိန်းဖို့တော့ကျန်ပါဦးမယ်၊
```
