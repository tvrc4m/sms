-- 用户所拥有的短信类别

create table lt_customer_sms_cat(
	customer_sms_cat int auto_increment primary key,
	customer_id int not null,
	sms_cat_id int not null,
	count int default 0
)