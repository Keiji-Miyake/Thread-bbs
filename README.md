# スレッド掲示板

- laravel 6
- laradock
  - mysql 8
  - node v16

## 起動

```Bash
cd laradock
docker-compose up -d nginx mysql phpmyadmin minio
docker-compose exec workspace bash

chown -R laradock:laradock /var/www
```

## minio

<http://localhost:9001>
laradock
laradock

create bucket 2ch

### .env

```txt
AWS_URL=http://localhost:9000
AWS_ENDPOINT=http://minio:9000
AWS_ACCESS_KEY_ID=laradock
AWS_SECRET_ACCESS_KEY=laradock
AWS_DEFAULT_REGION=ap-northeast-1
AWS_BUCKET=2ch
AWS_PATH_STYLE_ENDPOINT=true
```

### config/filesystems.php

```php
...
        's3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
            'url' => env('AWS_URL'),
            'endpoint' => env('AWS_ENDPOINT'),
            'use_path_style_endpoint' => env('AWS_PATH_STYLE_ENDPOINT', false),
        ],
...
```

### 署名付きURLのファイルがブラウザで表示できない

hosts設定をする

```txt
127.0.0.1 minio
```

## コンテナ接続

```Bash
docker-compose exec --user=laradock workspace bash
```
