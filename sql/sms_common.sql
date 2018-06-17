-- 常用短信信息

create table lt_sms_common(
	sms_common_id int auto_increment primary key,
	content varchar(1000),
	customer_id int not null,
	status tinyint default 1,  -- 1正常 -1删除 
)ENGINE=MyISAM DEFAULT CHARSET=utf8;