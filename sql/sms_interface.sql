-- sms 接口

create table lt_sms_interface(
	sms_interface_id int auto_increment primary key,
	name varchar(50) not null,
	account varchar(50) not null,
	password varchar(50) not null,
	status bool default 1,
	is_default bool default 1,
	url varchar(500)
)ENGINE=MyISAM DEFAULT CHARSET=utf8;