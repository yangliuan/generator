# Laravel 8.x Scaffold Generator

# 基于summerblue/generator项目进行的适合自己编程风格的改造,目前只兼容laravel8，交互式命令操作,可以根据需要选择想要生成的文件

Laravel Scaffold Generator, for Laravel.

## Install

### Step 1: Install Through Composer

8.x:

```
composer require "yangliuan/generator:8.*" --dev
```

### Step 2: Add the Service Provider

Open `/app/Providers/AppServiceProvider.php` and, to your **register** function, add:

```
public function register()
{
     if (app()->environment() == 'local' || app()->environment() == 'testing') {

        $this->app->register(\Yangliuan\Generator\GeneratorsServiceProvider::class);

    }
}
```

### Step 3: Run Artisan!

You're all set. Run `php artisan` from the console, and you'll see the new commands `make:scaffold`.

## Examples

```
$ php artisan make:scaffold GoodsCommentPic --schema="goods_comment_id:integer(false,true):default(0):comment('商品评价id'):index('goods_comment_id','goods_comment_id'),url:string(255):default(''):comment('文件url')" --comment="商品评价图组表"

----------- scaffolding: GoodsCommentPic -----------

 Do you want to make [migration,seed,model,filter,controller,request] [admin]:
  [0] admin
  [1] api
  [2] no
 > 2

 Do you want to make migration? (yes/no) [no]:
 > 

 Do you want to make form request? [AdminRequest]:
  [0] AdminRequest
  [1] ApiRequest
  [2] FormRequest
  [3] No
 > 3

 Do you want to make seed? (yes/no) [no]:
 > 

 Do you want to make model? (yes/no) [no]:
 > 

 Do you want to make model filter? [Admin]:
  [0] Admin
  [1] Api
  [2] No
 > 2

 Do you want to make controller? [Admin]:
  [0] Admin
  [1] Api
  [2] No
 > 2

 Do you want to make model observer? (yes/no) [no]:
 > 

 Do you want to make policy? (yes/no) [no]:
 > 

 Do you want to run migrate? (yes/no) [no]:
 > 

----------- ---------------------------- -----------
-----------       >DUMP AUTOLOAD<        -----------

```

## Thanks to
- [laralib/l5scaffold](https://github.com/laralib/l5scaffold)

## Thanks to
- [summerblue/generator](https://github.com/summerblue/generator)