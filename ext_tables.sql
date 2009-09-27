#
# Table structure for table 'tx_formhandlergui_forms'
#
CREATE TABLE tx_formhandlergui_forms (
	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	tstamp int(11) DEFAULT '0' NOT NULL,
	crdate int(11) DEFAULT '0' NOT NULL,
	cruser_id int(11) DEFAULT '0' NOT NULL,
	deleted tinyint(4) DEFAULT '0' NOT NULL,
	hidden tinyint(4) DEFAULT '0' NOT NULL,
	title tinytext,
	type int(11) DEFAULT '0' NOT NULL,
	method tinytext,
	prefix tinytext,
	enable_email tinyint(3) DEFAULT '0' NOT NULL,
	enable_db tinyint(3) DEFAULT '0' NOT NULL,
	debug tinyint(3) DEFAULT '0' NOT NULL,
	fields text,
	multistep_forms text,
	tables varchar(40) DEFAULT '' NOT NULL,
	auto_mapping tinyint(3) DEFAULT '0' NOT NULL,
	mapping tinytext,
	email_conf mediumtext,
	
	PRIMARY KEY (uid),
	KEY parent (pid)
);

#
# Table structure for table 'tx_formhandlergui_fields'
#
CREATE TABLE tx_formhandlergui_fields (
	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	tstamp int(11) DEFAULT '0' NOT NULL,
	crdate int(11) DEFAULT '0' NOT NULL,
	cruser_id int(11) DEFAULT '0' NOT NULL,
	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource mediumtext,
	deleted tinyint(4) DEFAULT '0' NOT NULL,
	hidden tinyint(4) DEFAULT '0' NOT NULL,
	fe_group int(11) DEFAULT '0' NOT NULL,
	field_type tinytext,
	field_title tinytext,
	field_name tinytext,
	lang_conf mediumtext,
	field_conf mediumtext,
	validators varchar(80) DEFAULT '' NOT NULL,
	
	PRIMARY KEY (uid),
	KEY parent (pid)
);