-- 银行帐户

create table lt_user_bank_account(
	bank_account_id int auto_increment primary key,
	realname varchar(15) not null,
	card_number varchar(30) not null,
	bank_name varchar(30) not null,
	phone int(11) not null,
	email varchar(30),
	`default` bool default 0,
	status bool default 1
)ENGINE=InnoDB DEFAULT CHARSET=utf8;;