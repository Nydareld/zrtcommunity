create database if not exists zrtcommunity character set utf8 collate utf8_unicode_ci;
use zrtcommunity;

grant all privileges on zrtcommunity.* to 'zrtcomm_user'@'localhost' identified by 'secret';
