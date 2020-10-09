# IDUS HOMEWORK

### SPEC 및 고려사항
 1. PHP 7.4
 2. Mysql 5.7.31
 3. Mysql 로컬 port 는 33060 입니다.
 4. 로컬 PC와 PORT충돌 방지를 위해 PHP Port는 연결하지 않았습니다. 
 5. 편의상 설정파일 (.env) 등을 gitignore 에 추가하지 않았습니다.
 6. DB replication 은 구성할 필요가 없다고하여서 구성은 하지 않고 설정 (.env) 파일에 설정을 남겨두었습니다. (READ_DB_HOST)
 7. 테스트 코드는 통합테스트 일부만 작성하였습니다. (유닛테스트 생략 / 회원가입만 테스트) 하였습니다.
 8. 회원 가입시 이메일 인증 및 비밀번호 확인 작업은 생략하였습니다.

### INSTALL
```shell script
# 1. docker-compose 시작
$ docker-compose up -d

#2. composer install
$ docker-compose run --rm composer install

#3. DB migration ( Dummy Data Insert)
$ docker-compose run --rm artisan migrate --seed 
# or docker-compose run --rm artisan migrate:refresh --seed

#4. Setting Cache
$ docker-compose run --rm artisan route:cache
$ docker-compose run --rm artisan config:cache
# docker-compose run --rm artisan cache:reset 캐시 초기화

#5. 확인
# http://localhost:8080  

#6. TEST
$ docker-compose run --rm artisan test
```

### API ROUTE LIST
```shell script
# route list 확인
$ docker-compose run --rm artisan route:lsit
```

### API DOCUMENT
##### WEB
```php
// welcome page
GET : /

// php info page # 실무에서는 절대 노출해서는 안되는 페이지이지만 스펙 확인을 위해 노출
GET : /info
```
##### API
###### AUTH ( idus/source/routes/auth.php )
```javascript 1.8
HEADER COMMON : {
 'Accept' : 'application/json',
 'Content-Type' : 'application/json',
}

// 회원가입
POST : /auth/join
PARAM : {
    'name' : 'required',
    'nickname' : 'required',
    'password' : 'required',
    'phone' : 'required',
    'email' : 'required',
    'gender' : 'optinal' // (F, M, null) 성별
}
RESULT : {
  "id": 1,
  "name": "아이디어스",
  "nickname": "nickname",
  "phone": "01012341234",
  "email": "idus@gmail.com",
  "gender": "M",
  "updated_at": "2020-10-09 11:34:31",
  "created_at": "2020-10-09 11:34:31",
  "status": 201
}


// 로그인
POST : /auth/login
PARAM : {
  'email' : 'required',
  'password' : 'required'
}
RESULT : {
    "access_token": "eyJ0eXAiO..중략..Izevk7pWMSuVZ_6M",
    "token_type": "bearer",
    "expires_in": 3600,
    "status": 200
}

// 로그인 본인 정보 확인
GET : /auth/me
HEADER : {
   "Authorization" : `Bearer ${TOKEN}` 
}
RESULT : {
      "id": 1,
      "name": "아이디어스",
      "nickname": "nickname",
      "phone": "01012341234",
      "email": "idus@gmail.com",
      "gender": "M",
      "updated_at": "2020-10-09 11:34:31",
      "created_at": "2020-10-09 11:34:31",
      "status": 200
      "orders": []
}

// 로그아웃
POST : /auth/logout
HEADER : {
   "Authorization" : `Bearer ${TOKEN}` 
}
RESULT : {
   "message": "Successfully logged out",
   "status": 200
}
```


##### USERS ( idus/source/routes/auth.php )
```javascript 1.8
HEADER COMMON : {
 'Accept' : 'application/json',
 'Content-Type' : 'application/json',
 "Authorization" : `Bearer ${TOKEN}`
}

// 회원 리스트
GET : /api/users 
PARAM : {
    'limit' : 'optinal', // (integer or null)'  페이지당 표시할 인원 (기본 15)
    'page' : 'optinal', // (integer) 페이지
    'orderBy' : 'optinal', // (id, name, created_at 등등) 정렬 기준 ASC 고정 (기본 : name)
    'search' : 'optinal', // 이름 또는 이메일 검색 이름의 경우 한글자라도 겹치면 검색, 이메일은 완전 일치 검색 ( page 주의!!)
}
RESULT : [
{
    "id": 20,
    "name": "권유정",
    "phone": "05715923243",
    "email": "jimin.cho@example.com",
    "gender": null,
    "last_order": {  // 요구사항 각 회원의 마지막 주문정보
        "id": 188,
        "name": "DarkKhaki-slu",
        "user_id": 20,
        "order_id": "ndlQMOPbeztj",
        "settlement_at": "2020-10-08 04:21:32",
        "created_at": "2020-10-09 09:10:08",
        "updated_at": "2020-10-09 09:10:08"
    },
    "created_at": "2020-10-09 20:53:51",
    "updated_at": "2020-10-09 20:53:51"
},
...
]


// 단일 회원 상세 정보 조회
GET /api/user/[USER_ID]
RESULT : {
     "id": 20,
     "name": "권유정",
     "nickname": "darkgreen",
     "phone": "05715923243",
     "email": "jimin.cho@example.com",
     "gender": null,
     "created_at": "2020-10-09 09:10:08",
     "updated_at": "2020-10-09 09:10:08",
     "status": 200
}

// 단일 회원 주문 목록 조회 (요구사항에 없어서 페이지네이션 처리하지 않음)
GET /api/user/[USER_ID]/orders
RESULT : {
    "orders": [
    {
        "id": 185,
        "user_id": 20,
        "order_id": "cyaLgUuAiTWK",
        "name": "LightGoldenRodYellow-g0W",
        "settlement_at": "2020-07-13 03:38:54",
        "created_at": "2020-10-09 09:10:08",
        "updated_at": "2020-10-09 09:10:08",
    }
  ],
  "status": 200
}

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