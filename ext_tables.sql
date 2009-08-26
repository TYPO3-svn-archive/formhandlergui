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
	fe_group int(11) DEFAULT '0' NOT NULL,
	formname tinytext,
	config mediumtext,
	
	PRIMARY KEY (uid),
	KEY parent (pid)
);