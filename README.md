# スレッド掲示板

- laravel 6
- laradock
  - mysql 8
  - node v16

## 起動

```Bash
cd laradock
docker-compose up -d nginx mysql phpmyadmin
docker-compose exec workspace bash

chown -R laradock:laradock /var/www
```

## コンテナ接続

```Bash
docker-compose exec --user=laradock workspace bash
```
