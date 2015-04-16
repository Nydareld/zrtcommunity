create database if not exists pecheocoup character set utf8 collate utf8_unicode_ci;
use microcms;

grant all privileges on pecheocoup.* to 'pecheocoup_user'@'localhost' identified by 'secret';
