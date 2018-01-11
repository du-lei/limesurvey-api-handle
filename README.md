<p align="center">
<span style="font-size:16px">开发laravel扩展</span><br>
<span>用于请求 limesurvey api 获取后台数据</span><br><br>
<a href="https://github.com/du-lei/limesurvey-api-handle"><img src="https://travis-ci.org/du-lei/limesurvey-api-handle.svg?branch=master" alt="Build Status"></a>
<a href="https://github.com/du-lei/limesurvey-api-handle"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://github.com/du-lei/limesurvey-api-handle"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://github.com/du-lei/limesurvey-api-handle"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

### 用法
```
composer require laravel-limesurvey-api/handle
```
### 或者在你的```composer.json``` 的 require 部分添加
```
"laravel-limesurvey-api/handle": "~1.0"
```
### 下载完毕后，直接配置 ```app/config.php``` 的 ```providers```:
```
LaravelLimesurveyApi\Handle\LaravelLimesurveyApiProvider::class,
```
