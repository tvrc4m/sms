-- MySQL dump 10.13  Distrib 5.6.14, for osx10.7 (x86_64)
--
-- Host: 210.209.123.206    Database: sq_hx10086
-- ------------------------------------------------------
-- Server version	5.0.95

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Not dumping tablespaces as no INFORMATION_SCHEMA.FILES table on this server
--

--
-- Table structure for table lt_client
--
-- test  deploy
DROP TABLE IF EXISTS lt_client;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE lt_client (
  client_id int(11) NOT NULL auto_increment,
  client_group_id int(11) default '0',
  name varchar(12) NOT NULL,
  nick varchar(20) default NULL,
  phone varchar(11) default NULL,
  email varchar(50) default NULL,
  sex enum('1','2') default '1',
  company varchar(50) default NULL,
  remark varchar(255) default NULL,
  customer_id int(11) NOT NULL,
  PRIMARY KEY  (client_id)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table lt_client_group
--

DROP TABLE IF EXISTS lt_client_group;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE lt_client_group (
  client_group_id int(11) NOT NULL auto_increment,
  name varchar(12) NOT NULL,
  remark varchar(100) default NULL,
  customer_id int(11) NOT NULL,
  PRIMARY KEY  (client_group_id)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table lt_custom_field
--

DROP TABLE IF EXISTS lt_custom_field;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE lt_custom_field (
  custom_field_id int(11) NOT NULL auto_increment,
  type varchar(32) NOT NULL,
  value text NOT NULL,
  required tinyint(1) NOT NULL,
  location varchar(32) NOT NULL,
  position int(3) NOT NULL,
  sort_order int(3) NOT NULL,
  PRIMARY KEY  (custom_field_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table lt_custom_field_description
--

DROP TABLE IF EXISTS lt_custom_field_description;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE lt_custom_field_description (
  custom_field_id int(11) NOT NULL,
  language_id int(11) NOT NULL,
  name varchar(128) NOT NULL,
  PRIMARY KEY  (custom_field_id,language_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table lt_custom_field_to_customer_group
--

DROP TABLE IF EXISTS lt_custom_field_to_customer_group;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE lt_custom_field_to_customer_group (
  custom_field_id int(11) NOT NULL,
  customer_group_id int(11) NOT NULL,
  PRIMARY KEY  (custom_field_id,customer_group_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table lt_custom_field_value
--

DROP TABLE IF EXISTS lt_custom_field_value;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE lt_custom_field_value (
  custom_field_value_id int(11) NOT NULL auto_increment,
  custom_field_id int(11) NOT NULL,
  sort_order int(3) NOT NULL,
  PRIMARY KEY  (custom_field_value_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table lt_custom_field_value_description
--

DROP TABLE IF EXISTS lt_custom_field_value_description;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE lt_custom_field_value_description (
  custom_field_value_id int(11) NOT NULL,
  language_id int(11) NOT NULL,
  custom_field_id int(11) NOT NULL,
  name varchar(128) NOT NULL,
  PRIMARY KEY  (custom_field_value_id,language_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table lt_customer
--

DROP TABLE IF EXISTS lt_customer;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE lt_customer (
  customer_id int(11) NOT NULL auto_increment,
  store_id int(11) NOT NULL default '0',
  name varchar(32) NOT NULL,
  lastname varchar(32) NOT NULL,
  email varchar(96) NOT NULL,
  telephone varchar(32) NOT NULL,
  fax varchar(32) NOT NULL,
  password varchar(40) NOT NULL,
  salt varchar(9) NOT NULL,
  cart text,
  wishlist text,
  newsletter tinyint(1) NOT NULL default '0',
  address_id int(11) NOT NULL default '0',
  customer_group_id int(11) NOT NULL,
  ip varchar(40) NOT NULL default '0',
  status tinyint(1) NOT NULL,
  approved tinyint(1) NOT NULL,
  token varchar(255) NOT NULL,
  date_added datetime NOT NULL default '0000-00-00 00:00:00',
  sms_count int(11) default '0',
  real_send boolean default 0,
  send_error varchar(64),
  PRIMARY KEY  (customer_id)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table lt_customer_ban_ip
--

DROP TABLE IF EXISTS lt_customer_ban_ip;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE lt_customer_ban_ip (
  customer_ban_ip_id int(11) NOT NULL auto_increment,
  ip varchar(40) NOT NULL,
  PRIMARY KEY  (customer_ban_ip_id),
  KEY ip (ip)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table lt_customer_deposit
--

DROP TABLE IF EXISTS lt_customer_deposit;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE lt_customer_deposit (
  deposit_id int(11) NOT NULL auto_increment,
  customer_id int(11) NOT NULL,
  realname varchar(12) NOT NULL,
  count int(11) default '0',
  amount float(8,2) default NULL,
  status tinyint(4) default NULL,
  PRIMARY KEY  (deposit_id)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table lt_customer_field
--

DROP TABLE IF EXISTS lt_customer_field;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE lt_customer_field (
  customer_id int(11) NOT NULL,
  custom_field_id int(11) NOT NULL,
  custom_field_value_id int(11) NOT NULL,
  name int(128) NOT NULL,
  value text NOT NULL,
  sort_order int(3) NOT NULL,
  PRIMARY KEY  (customer_id,custom_field_id,custom_field_value_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table lt_customer_group
--

DROP TABLE IF EXISTS lt_customer_group;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE lt_customer_group (
  customer_group_id int(11) NOT NULL auto_increment,
  approval int(1) NOT NULL,
  company_id_display int(1) NOT NULL,
  company_id_required int(1) NOT NULL,
  tax_id_display int(1) NOT NULL,
  tax_id_required int(1) NOT NULL,
  sort_order int(3) NOT NULL,
  PRIMARY KEY  (customer_group_id)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table lt_customer_group_description
--

DROP TABLE IF EXISTS lt_customer_group_description;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE lt_customer_group_description (
  customer_group_id int(11) NOT NULL,
  language_id int(11) NOT NULL,
  name varchar(32) NOT NULL,
  description text NOT NULL,
  PRIMARY KEY  (customer_group_id,language_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table lt_customer_ip
--

DROP TABLE IF EXISTS lt_customer_ip;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE lt_customer_ip (
  customer_ip_id int(11) NOT NULL auto_increment,
  customer_id int(11) NOT NULL,
  ip varchar(40) NOT NULL,
  date_added datetime NOT NULL,
  PRIMARY KEY  (customer_ip_id),
  KEY ip (ip)
) ENGINE=MyISAM AUTO_INCREMENT=39 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table lt_customer_online
--

DROP TABLE IF EXISTS lt_customer_online;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE lt_customer_online (
  ip varchar(40) NOT NULL,
  customer_id int(11) NOT NULL,
  url text NOT NULL,
  referer text NOT NULL,
  date_added datetime NOT NULL,
  PRIMARY KEY  (ip)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table lt_customer_sms_cat
--

DROP TABLE IF EXISTS lt_customer_sms_cat;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE lt_customer_sms_cat (
  customer_sms_cat int(11) NOT NULL auto_increment,
  customer_id int(11) NOT NULL,
  sms_cat_id int(11) NOT NULL,
  count int(11) default '0',
  PRIMARY KEY  (customer_sms_cat)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table lt_extension
--

DROP TABLE IF EXISTS lt_extension;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE lt_extension (
  extension_id int(11) NOT NULL auto_increment,
  type varchar(32) NOT NULL,
  code varchar(32) NOT NULL,
  PRIMARY KEY  (extension_id)
) ENGINE=MyISAM AUTO_INCREMENT=428 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table lt_language
--

DROP TABLE IF EXISTS lt_language;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE lt_language (
  language_id int(11) NOT NULL auto_increment,
  name varchar(32) NOT NULL,
  code varchar(5) NOT NULL,
  locale varchar(255) NOT NULL,
  image varchar(64) NOT NULL,
  directory varchar(32) NOT NULL,
  filename varchar(64) NOT NULL,
  sort_order int(3) NOT NULL default '0',
  status tinyint(1) NOT NULL,
  PRIMARY KEY  (language_id),
  KEY name (name)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table lt_setting
--

DROP TABLE IF EXISTS lt_setting;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE lt_setting (
  setting_id int(11) NOT NULL auto_increment,
  store_id int(11) NOT NULL default '0',
  group varchar(32) NOT NULL,
  key varchar(64) NOT NULL,
  value text NOT NULL,
  serialized tinyint(1) NOT NULL,
  PRIMARY KEY  (setting_id)
) ENGINE=MyISAM AUTO_INCREMENT=3879 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table lt_sms_cat
--

DROP TABLE IF EXISTS lt_sms_cat;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE lt_sms_cat (
  sms_cat_id int(11) NOT NULL auto_increment,
  name varchar(50) NOT NULL,
  sms_operation_id int(11) default NULL,
  description varchar(1000) default NULL,
  PRIMARY KEY  (sms_cat_id)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table lt_sms_interface
--

DROP TABLE IF EXISTS lt_sms_interface;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE lt_sms_interface (
  sms_interface_id int(11) NOT NULL auto_increment,
  name varchar(50) NOT NULL,
  account varchar(50) NOT NULL,
  password varchar(50) NOT NULL,
  status tinyint(1) default '1',
  is_default tinyint(1) default '1',
  url varchar(500) default NULL,
  PRIMARY KEY  (sms_interface_id)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table lt_sms_outbox
--

DROP TABLE IF EXISTS lt_sms_outbox;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE lt_sms_outbox (
  sms_id int(11) NOT NULL auto_increment,
  customer_id int(11) NOT NULL,
  clients text,
  groups text,
  message varchar(500) default NULL,
  phones longtext NOT NULL,
  count int(11) default '0',
  status tinyint(4) default NULL,
  send_time datetime default NULL,
  is_timer tinyint(1) default '0',
  timer int(11) default '0',
  update_time datetime default NULL,
  added_time timestamp NOT NULL default CURRENT_TIMESTAMP,
  params varchar(256),
  tempid int,
  PRIMARY KEY  (sms_id)
) ENGINE=MyISAM AUTO_INCREMENT=43 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table lt_store
--

DROP TABLE IF EXISTS lt_store;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE lt_store (
  store_id int(11) NOT NULL auto_increment,
  name varchar(64) NOT NULL,
  url varchar(255) NOT NULL,
  ssl varchar(255) NOT NULL,
  PRIMARY KEY  (store_id)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table lt_user
--

DROP TABLE IF EXISTS lt_user;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE lt_user (
  user_id int(11) NOT NULL auto_increment,
  user_group_id int(11) NOT NULL,
  username varchar(20) NOT NULL,
  password varchar(40) NOT NULL,
  salt varchar(9) NOT NULL,
  firstname varchar(32) NOT NULL,
  lastname varchar(32) NOT NULL,
  email varchar(96) NOT NULL,
  code varchar(40) NOT NULL,
  ip varchar(40) NOT NULL,
  status tinyint(1) NOT NULL,
  date_added datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (user_id)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table lt_user_bank_account
--

DROP TABLE IF EXISTS lt_user_bank_account;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE lt_user_bank_account (
  bank_account_id int(11) NOT NULL auto_increment,
  realname varchar(15) NOT NULL,
  card_number varchar(30) NOT NULL,
  bank_name varchar(30) NOT NULL,
  phone int(11) NOT NULL,
  email varchar(30) default NULL,
  default tinyint(1) default '0',
  status tinyint(1) default '1',
  PRIMARY KEY  (bank_account_id)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table lt_user_change_password
--

DROP TABLE IF EXISTS lt_user_change_password;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE lt_user_change_password (
  user_id int(11) NOT NULL,
  code char(4) NOT NULL,
  create_time int(11) NOT NULL,
  PRIMARY KEY  (user_id)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table lt_user_group
--

DROP TABLE IF EXISTS lt_user_group;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE lt_user_group (
  user_group_id int(11) NOT NULL auto_increment,
  name varchar(64) NOT NULL,
  permission text NOT NULL,
  PRIMARY KEY  (user_group_id)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table lt_vendor
--

DROP TABLE IF EXISTS lt_vendor;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE lt_vendor (
  vendor_id int(11) NOT NULL auto_increment,
  vendor_group_id int(11) NOT NULL,
  vendorname varchar(20) NOT NULL,
  store_id int(11) NOT NULL,
  password varchar(40) NOT NULL,
  salt varchar(9) NOT NULL,
  firstname varchar(32) NOT NULL,
  lastname varchar(32) NOT NULL,
  email varchar(96) NOT NULL,
  code varchar(40) NOT NULL,
  ip varchar(40) NOT NULL,
  status tinyint(1) NOT NULL,
  date_added datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (vendor_id)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table lt_vendor_group
--

DROP TABLE IF EXISTS lt_vendor_group;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE lt_vendor_group (
  vendor_group_id int(11) NOT NULL auto_increment,
  name varchar(64) NOT NULL,
  permission text NOT NULL,
  PRIMARY KEY  (vendor_group_id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;


DROP TABLE IF EXISTS lt_app;

CREATE TABLE lt_app(
	app_id int auto_increment PRIMARY key,
  name varchar(32) not null,
	token varchar(32) not null,
	customer_id int not null,
	create_date timestamp DEFAULT CURRENT_TIMESTAMP
)

-- Dump completed on 2015-02-05 22:37:34
