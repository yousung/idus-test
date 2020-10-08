```
CREATE TABLE `orders` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL COMMENT '주문자 ID',
  `order` varchar(12) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '주문번호',
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '제품명',
  `settlement_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '결제일',
  `created_at` timestamp NULL DEFAULT NULL COMMENT '생성일',
  `updated_at` timestamp NULL DEFAULT NULL COMMENT '수정일',
  `deleted_at` timestamp NULL DEFAULT NULL COMMENT '삭제일',
  PRIMARY KEY (`id`),
  KEY `orders_user_id_foreign` (`user_id`),
  CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

```
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```