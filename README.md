## 开发基于laravel的用于请求 limesurvey api 获取后台数据的扩展

### 用法
```
composer require "laravel-limesurvey-api/handle: dev-master"
```
### 或者在你的```composer.json``` 的 require 部分添加
```
"laravel-limesurvey-api/handle": "dev-master"
```
### 创建配置文件
```
php artisan vendor:publish --provider="LaravelLimesurveyApi\Handle\LaravelLimesurveyApiProvider"
```
