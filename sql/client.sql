-- 客户的客户

create table lt_client(
	client_id int auto_increment primary key,
	client_group_id int default 0,
	customer_id int not null,
	name varchar(12) not null,
	nick varchar(20),
	phone int,
	email varchar(50),
	sex enum('1','2') default '1',
	company varchar(50),
	remark varchar(255)
)ENGINE=MyISAM DEFAULT CHARSET=utf8;