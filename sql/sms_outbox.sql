-- 发件箱

create table lt_sms_outbox(
	sms_id int auto_increment primary key,
	-- sms_cat_id int not null,
	customer_id int not null,
	clients text ,
	groups text ,
	message varchar(500),
	phones text not null,
	count int default 0,
	status tinyint,
	send_time timestamp default current_timestamp(),
	is_timer boolean default 0,
	timer int default 0,
	update_time datetime
)ENGINE=MyISAM DEFAULT CHARSET=utf8;