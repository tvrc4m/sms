-- 生日短信息

create table lt_sms_birthday(
	sms_birthday_id int auto_increment primary key,
	sms_cat int not null,
	title varchar(50),
	content varchar(1000),
	clients text,
	groups text,
	timer datetime,
	status tinyint,
	start bool default 0
)ENGINE=MyISAM DEFAULT CHARSET=utf8;