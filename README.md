## 开发laravel扩展
### 用于请求 limesurvey api 获取后台数据

### 用法
```
composer require laravel-limesurvey-api/handle
```
### 或者在你的```composer.json``` 的 require 部分添加
```
"laravel-limesurvey-api/handle": "dev-master"
```
### 下载完毕后，直接配置 ```app/config.php``` 的 ```providers```:
```
LaravelLimesurveyApi\Handle\LaravelLimesurveyApiProvider::class,
```
