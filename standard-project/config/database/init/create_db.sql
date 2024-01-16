set names 'utf8mb4';
set character_set_results = 'utf8mb4';
set character_set_database = 'utf8mb4';
set character_set_server = 'utf8mb4';

CREATE TABLE `LOCAL_DB`.`tb_user` (
    `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '고유번호',
    `name` VARCHAR(50) NOT NULL COMMENT '이름' COLLATE 'utf8mb4_unicode_ci',
    `reg_date` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '등록일',
    PRIMARY KEY (`id`) USING BTREE,
    INDEX `user_idx_01` (`name`) USING BTREE
)
COMMENT='서비스 고유 정보'
COLLATE='utf8mb4_unicode_ci'
ENGINE=InnoDB
;

INSERT INTO `LOCAL_DB`.`tb_user` (`name`) VALUES ('김남식');

-- 최초로 실행할떄만  -v옵션을 사용하면 전부다 지워짐