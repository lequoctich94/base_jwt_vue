cai dat jwt
gài thăng "tymon/jwt-auth": "^1.0" vào require, composer update

//thêm vào app config/app.php
provider:  
       Tymon\JWTAuth\Providers\LaravelServiceProvider::class,
aliases:

        'JWTAuth' => Tymon\JWTAuth\Facades\JWTAuth::class,
        'JWTFactory' => Tymon\JWTAuth\Facades\JWTFactory::class,


public config jwt
php artisan vendor:publish --provider="Tymon\JWTAuth\Providers\LaravelServiceProvider"

tạo key

php artisan jwt:secret

ta sẽ tạo được key ngoài env JWT_SECRET

-----------------------------------------------
connect db
tạo bảng m_staff (user sẽ đăng nhập bảng này)
tạo modal cho m_staff,  App\Models\Staff;  implement thêm JWTSubject

ghi đè 2 phuong thức tại model staff
getJWTIdentifier()
getJWTCustomClaims() 
---------------------------------------------
thêm vào config auth
'defaults' => [
        'guard' => 'api',
        'passwords' => 'users',
],
	
 'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],
        'api' => [
            'driver' => 'jwt',
            'provider' => 'users',
        ],
    ],
	
-----------------------------------------------
tạo auth controller
$ php artisan make:controller API/AuthController

kiểm tra controller, tạo những model, repo cần thiết

//tạo app\Facades Authen, Regis
    ->đăng kí bào boot app service provider
	->sửa config: auth để chuyển qua table staff
//tạo app\Core Authen, Regis
//tạo app\http\request\api\auth
//tạo app\repositories\staff
  -> app\repositories\staff
  -> tạo provider:RepositoryServiceProvider
  -> gắn vào app/config
//tạo app\traits
//thên code vào  route api
//middleware
   TokenJWT.php
//tao app/Exception
   
//tạo helper ExceptionHelper để xử lí throw err
->autoload hepper, composer.json autoload files
->chạy:  composer dump-autoload
-> thêm config: exceptions.php

----------
điều tra ResponseServiceProvider, jsonToken

https://viblo.asia/p/laravel-su-dung-authentication-json-web-token-jwt-ByEZkjBYKQ0






































CREATE TABLE `m_staffs` (
	`id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
	`staff_cd` VARCHAR(50) NOT NULL COLLATE 'utf8mb4_unicode_ci',
	`name` VARCHAR(255) NULL DEFAULT NULL COLLATE 'utf8mb4_unicode_ci',
	`email` VARCHAR(255) NOT NULL COLLATE 'utf8mb4_unicode_ci',
	`tel` VARCHAR(20) NULL DEFAULT NULL COLLATE 'utf8mb4_unicode_ci',
	`role` ENUM('1','2','3','4','5','6','7','8','9') NOT NULL COMMENT '1: System admin, 2: Board member, 3: General manager, 4: Center manager,  5: Staff, 6: Saler, 7: Head office, 8: Director, 9: Deputy director' COLLATE 'utf8_general_ci',
	`title` VARCHAR(255) NULL DEFAULT NULL COLLATE 'utf8mb4_unicode_ci',
	`password` VARCHAR(255) NOT NULL COLLATE 'utf8mb4_unicode_ci',
	`service_type` ENUM('0','1','2','3','4') NOT NULL DEFAULT '0' COMMENT '0: Internal, 1: Google, 2: Facebook, 3: Apple, 4: Twitter' COLLATE 'utf8mb4_unicode_ci',
	`email_verified_at` TIMESTAMP NULL DEFAULT NULL,
	`remember_token` VARCHAR(100) NULL DEFAULT NULL COLLATE 'utf8mb4_unicode_ci',
	`created_at` TIMESTAMP NULL DEFAULT NULL,
	`updated_at` TIMESTAMP NULL DEFAULT NULL,
	`deleted_at` TIMESTAMP NULL DEFAULT NULL,
	PRIMARY KEY (`id`) USING BTREE,
	UNIQUE INDEX `m_staffs_staff_cd_unique` (`staff_cd`) USING BTREE,
	UNIQUE INDEX `m_staffs_email_unique` (`email`) USING BTREE,
	FULLTEXT INDEX `search` (`staff_cd`, `name`, `email`)
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB
AUTO_INCREMENT=55
;
