DROP DATABASE IF EXISTS `casino_db`;
CREATE DATABASE `casino_db`;
USE `casino_db`;
CREATE TABLE `users` (
    id int AUTO_INCREMENT PRIMARY KEY,
    username varchar(100),
    password varchar(100),
    credits bigint
);
INSERT INTO users (`username`, `password`, `credits`)
VALUES (
        'admin',
        '$2y$10$vXnbxTSyl6ESSlnDoEdydubJ87qkds05XHjhG2UEnatVWOcAtGWFK',
        7000
    ),
    (
        'henk',
        '$2y$10$vXnbxTSyl6ESSlnDoEdydubJ87qkds05XHjhG2UEnatVWOcAtGWFK',
        4000
    ),
    (
        'william',
        '$2y$10$vXnbxTSyl6ESSlnDoEdydubJ87qkds05XHjhG2UEnatVWOcAtGWFK',
        3500
    ),
    (
        'jan',
        '$2y$10$vXnbxTSyl6ESSlnDoEdydubJ87qkds05XHjhG2UEnatVWOcAtGWFK',
        6000
    );
-- password for every account: admin