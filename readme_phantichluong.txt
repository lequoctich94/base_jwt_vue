- phân tich luồng login:
  -> authen login:
  use Authenticate;
  đăng kí aliases config/app lớp facades: App\Facades\AuthenticateFacade::class,
  
  -> facade sẽ luôn gọi tới static method getFacadeAccessor(), trong này chứa service container
     việc gọi tới đây giống như việc gọi tới magic method __callStatic
     tại liệu về magic method: https://www.php.net/manual/en/language.oop5.overloading.php#object.callstatic
     
     ->service container: AuthenticateInterface, sẽ được iplement bởi   \App\Core\Authentications\Authenticate;
     được đăng kí tại AppServiceProvider.php, hàm boot();
     
    => AuthController.login($param) -> \App\Core\Authentications\Authenticate.login($argm)
    
    $this->getAuthenticate()->login($this->info_data);
    
    ->gọi qua handle getAuthenticate(), tại đây nó instance App\Core\Authentications\Internal\Def\Authenticate, gọi qua hàm login tại đây

---------------------------------------------------------------------------------------------------
Luổng Xác thực login
 Sau khi login, lấy được token, ta tiến hành xác thực bằng middleware
 middleware: 'token', 'access'
 \App\Http\Middleware\TokenJWT::class -> xác thực token gửi lên: 
 
 'access' => \App\Http\Middleware\Access::class, -> kiểm tra quyền

-------------------------------------------------------------------------------------------------------
Luồng response

AuthController\Login -> response()->jsonToken($token);

//Response Macros
https://laravel.com/docs/8.x/responses
custom reponse
--------------------------------------------------------------------------------------------------------

Luồng exceptions


 All exceptions are handled by the App\Exceptions\Handler class
 
 Luồng throwErr:
 --------------------------------------------------------------------------------------------------------