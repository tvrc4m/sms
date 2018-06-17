-- 用户短信充值记录

create table lt_customer_deposit(
	deposit_id int auto_increment primary key,
	customer_id int not null,
	realname varchar(12) not null,
	count int default 0,
	amount float (8,2),
	status tinyint, -- 充值状态
	ctime timestamp DEFAULT CURRENT_TIMESTAMP

)ENGINE=InnoDB DEFAULT CHARSET=utf8;