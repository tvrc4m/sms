-- 短信类别

create table lt_sms_cat(
	sms_cat_id int auto_increment primary key,
	name varchar(50) not null,
	sms_operation_id int,
	description varchar(1000)
)ENGINE=MyISAM DEFAULT CHARSET=utf8;