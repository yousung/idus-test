# IDUS HOMEWORK

### SPEC 및 고려사항
 1. PHP 7.4
 2. Mysql 5.7.31
 3. Mysql 로컬 port 는 33060 입니다.
 4. 로컬 PC와 PORT충돌 방지를 위해 PHP Port는 연결하지 않았습니다. 
 5. 편의상 설정파일 (.env) 등을 gitignore 에 추가하지 않았습니다.
 6. DB replication 은 구성할 필요가 없다고하여서 구성은 하지 않고 설정 (.env) 파일에 설정을 남겨두었습니다. 
 (READ_DB_HOST 등등)
 7. 테스트 코드는 통합테스트 일부만 작성하였습니다. (유닛테스트 생략 / 회원가입만 테스트) 하였습니다.

### INSTALL
```shell script
# 1. docker-compose 시작
$ docker-compose up -d

#2. composer install
$ docker-compose run --rm composer install

#3. DB migration ( Dummy Data Insert)
$ docker-compose run --rm artisan migrate --seed 
# or docker-compose run --rm artisan migrate:refresh --seed

#4. 확인
# http://localhost:8080  

#5. TEST
$ docker-compose run --rm artisan test
```

### DATABASE SCHEMA
```sql
-- 회원속성
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '이름',
  `nickname` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '별명',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '비밀번호',
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '전화번호',
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '이메일',
  `gender` enum('M','F') COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '성별',
  `created_at` timestamp NULL DEFAULT NULL COMMENT '생성일',
  `updated_at` timestamp NULL DEFAULT NULL COMMENT '수정일',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '삭제일',
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=102 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

```sql
-- 주문 속성
-- user_id casade delete 를 하지 않은 이유는 회원의 경우 soft delete 를 하여서 관계를 해두기 위해서입니다.
-- 회원 삭제시 개인정보를 정책에 따른 변경 사항은 고려하지 않았습니다.
CREATE TABLE `orders` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL COMMENT '주문자 ID',
  `order_id` varchar(12) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '주문번호',
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '제품명',
  `settlement_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '결제일',
  `created_at` timestamp NULL DEFAULT NULL COMMENT '생성일',
  `updated_at` timestamp NULL DEFAULT NULL COMMENT '수정일',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '삭제일',
  PRIMARY KEY (`id`),
  KEY `orders_user_id_foreign` (`user_id`),
  CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1001 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

### FAQ
1. 도커 설정을 변경했을 경우.
``` shell script
  # docker-compose up -d build [변경한 도커] 
  $ docker-compose up -d build php
```

2. Dumy 데이터를 넣을 때 에러나는 경우
```shell script
 $ docker-compose run --rm artisan migrate:refresh --seed
```