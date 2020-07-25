## Các bước khởi chạy
### Tạo Oauth App
```https://github.com/```

```Login```

```Settings->Developer settings```

```OAuth Apps->New OAuth Apps```

```Homepage URL: http://localhost:8000/```

```Authorization callback URL: http://localhost:8000/callback/github```
### Update composer
```composer update```
### Tạo file .env và kết nối database 
```cp .env.example .env```
### Thêm vào file .env
```GITHUB_CLIENT_ID="client id vừa tạo"```

```GITHUB_CLIENT_SECRET="client secret vừa tạo"```

```GITHUB_CALLBACK_URL=http://localhost:8000/callback/github```
### Tạo migrate
```php artisan migrate```
### Tạo key  
```php artisan key:generate```
### Chạy laravel 
```php artisan serve```
