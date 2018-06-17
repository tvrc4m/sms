-- 发送的短信

create table lt_sms(
	sms_id int auto_increment primary key, 
	customer_id int not null, -- 用户ID
	sms_cat int not null, -- 短信类别
	total int default 0, -- 短信总数
	update_time datetime, --最近充值时间
)ENGINE=MyISAM DEFAULT CHARSET=utf8;