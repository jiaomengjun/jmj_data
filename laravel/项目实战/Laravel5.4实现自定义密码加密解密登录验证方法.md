### Laravel5.4实现自定义密码加密解密登录验证方法
登录流程:  
##### 1. 注册路由开启用户认证  
在routes/web.php添加一下代码
```
  	auth::routes();
```
##### 2. 登录注册的路由  
其实是调用\vendor\laravel\framework\src\Illuminate\Routing\Router.php类中的auth()方法，可以看到这里是同时注册了登录、注册、密码相关的路由。
```php
  public function auth()
      {
          // Authentication Routes...
          $this->get('login', 'Auth\LoginController@showLoginForm')->name('login');
          $this->post('login', 'Auth\LoginController@login');
          $this->post('logout', 'Auth\LoginController@logout')->name('logout');

          $this->get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
          $this->post('register', 'Auth\RegisterController@register');

          $this->get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
          $this->post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
          $this->get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
          $this->post('password/reset', 'Auth\ResetPasswordController@reset');
  }
```
##### 3. 登录  
登录相关行为路由到`\app\Http\Controllers\Auth\LoginController.php`控制器，其实大部分是用了`\vendor\laravel\framework\src\Illuminate\Foundation\Auth\AuthenticatesUsers.php`的方法  
可以通过在`\app\Http\Controllers\Auth\LoginController.php`中重写或者定义一些方法来达到自定义的效果：

1. $redirectTo属性代表登录成功之后重定向的链接
2. redirectTo 方法在登录成功之后跳转到某个链接(和$redirectTo属性效果一样，二者有一即可，同时存在时优先级高于$redirectTo)
3. username 方法可以自定义设置认证的用户名字段(默认为username)
4. 在`\vendor\laravel\framework\src\Illuminate\Routing\Router.php`中:
    - showLoginForm 方法是get到的login路由调用此方法实现显示登录页面,路由和页面都可自定义
    - login方法是post过来的login请求调用此方法，实现用户登录认证，设置session等

##### 4. 实现登录的流程
`\vendor\laravel\framework\src\Illuminate\Foundation\Auth\AuthenticatesUsers.php`  
代码：
```php
public function login(Request $request)
    {
        $this->validateLogin($request);
        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            return $this->sendLoginResponse($request);
        }
        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
}
```

###### 第一步：进行一些基本验证(验证规则不做赘述)  
```laravel
$this->validateLogin($request);
protected function validateLogin(Request $request)
    {
        $this->validate($request, [
            $this->username() => 'required|string',
            'password' => 'required|string',
//可进行添加多个
        ]);
    }
```
此方法中的'password' 是密码的字段，自己数据库的密码字段不为password的话要改为对应的  
最后通过调用\vendor\laravel\framework\src\Illuminate\Foundation\Validation\ValidatesRequests.php中的validate方法进行登录信息的基本验证

###### 第二步：多用户登录验证
```laravel
if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }
```
请看后续。。。
###### 第三步：用户登录密码的验证
```laravel
if ($this->attemptLogin($request)) {
   return $this->sendLoginResponse($request);
}
```

`\vendor\laravel\framework\src\Illuminate\Foundation\Auth\AuthenticatesUsers.php`
```laravel
protected function attemptLogin(Request $request)
{
   return $this->guard()->attempt(
      $this->credentials($request), $request->has('remember')
   );
}
```
###### 第四步：查询用户信息进行验证登录
`\vendor\laravel\framework\src\Illuminate\Auth\SessionGuard.php`
```laravel
public function attempt(array $credentials = [], $remember = false)
{
    $this->fireAttemptEvent($credentials, $remember);
//查询用户信息  
    $this->lastAttempted = $user = $this->provider->retrieveByCredentials($credentials);
    //验证用户登录密码  成功的话执行登录动作
if ($this->hasValidCredentials($user, $credentials)) {
        $this->login($user, $remember);
        return true;
    }
    $this->fireFailedEvent($user, $credentials);
    return false;
}
```

#### 实现自定义登录验证方式
##### 1.设置用户信息表字段,\app\User.php设置对应值
##### 2.设置登录验证的用户名字段
```
app\Http\Controllers\Auth\LoginController.php 中username方法返回验证的用户名字段
```
##### 3.config\auth.php 中设置自定义的认证中间件
```laravel
'providers' => [
        'users' => [
            'driver' => 'custom',
            'model' => App\User::class,
        ],
],
```
##### 4.自定义认证中间件(可复制EloquentUserProvider.php  默认使用的是这个)
```
vendor\laravel\framework\src\Illuminate\Auth\CustomUserProvider.php
```
##### 5.设置密码验证使用自定义中间件
`vendor\laravel\framework\src\Illuminate\Auth\CreatesUserProviders.php`
createUserProvider()方法
```
public function createUserProvider($provider)
    {
        $config = $this->app['config']['auth.providers.'.$provider];

        if (isset($this->customProviderCreators[$config['driver']])) {
            return call_user_func(
                $this->customProviderCreators[$config['driver']], $this->app, $config
            );
        }
        switch ($config['driver']) {
            case 'database':
                return $this->createDatabaseProvider($config);
            case 'eloquent':
                return $this->createEloquentProvider($config);
            case 'custom':
                return $this->createCustomProvider($config);
            default:
                throw new InvalidArgumentException("Authentication user provider [{$config['driver']}] is not defined.");
        }
}
```
使用中间件
```
protected function createCustomProvider($config)
{
    return new CustomUserProvider($this->app['hash'], $config['model']);
}
```

##### 6.设置验证的密码字段名
1. vendor\laravel\framework\src\Illuminate\Foundation\Auth\AuthenticatesUsers.php中的credentials()方法
2. vendor\laravel\framework\src\Illuminate\Auth\CustomUserProvider.php中的retrieveByCredentials方法中验证的密码字段设置为自己的

##### 自定义密码加密及验证方法  
原密码的验证使用的是php的password_verify()方法，在
`vendor\laravel\framework\src\Illuminate\Hashing\BcryptHasher.php`中的check方法中调用的密码验证方法
现在改为自定义的密码加密及验证
1. 在\vendor\laravel\framework\src\Illuminate\Hashing\HashServiceProvider.php 的register方法中注册密码验证的类
```
public function register()
    {
        $this->app->singleton('hash', function () {
//            return new BcryptHasher;      //调用原有框架自带的密码加密解密方法
            return new CusTomBcryptHasher;      //自定义的加密密码及验证
        });
    }
```
2. 在`\vendor\laravel\framework\src\Illuminate\Hashing`目录下创建自定义加密验证类文件CusTomBcryptHasher.php 继承框架自带的BcryptHasher类并且重写make() 密码加密和check()密码验证方法





--- 
