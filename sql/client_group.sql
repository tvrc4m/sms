-- 客户的客户

create table lt_client_group(
	client_group_id int auto_increment primary key,
	name varchar(12) not null,
	customer_id int not null,
	remark varchar(100)
)ENGINE=MyISAM DEFAULT CHARSET=utf8;