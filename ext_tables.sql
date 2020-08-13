#
# Table structure for table 'tx_ratings_data'
#
CREATE TABLE tx_ratings_data (
  uid int(11) NOT NULL auto_increment,
  pid int(11) DEFAULT '0' NOT NULL,
  tstamp int(11) DEFAULT '0' NOT NULL,
  crdate int(11) DEFAULT '0' NOT NULL,
  cruser_id int(11) DEFAULT '0' NOT NULL,
  deleted tinyint(3) unsigned DEFAULT '0' NOT NULL,
  hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
  reference text,
  rating int(11) DEFAULT '0' NOT NULL, 
  vote_count int(11) DEFAULT '0' NOT NULL,

  PRIMARY KEY (uid),
  KEY parent (pid),
  KEY reference (reference(16))
) ENGINE = InnoDB;

#
# Table structure for table 'tx_ratings_iplog'
#
CREATE TABLE tx_ratings_iplog (
  uid int(11) NOT NULL auto_increment,
  pid int(11) DEFAULT '0' NOT NULL,
  tstamp int(11) DEFAULT '0' NOT NULL,
  crdate int(11) DEFAULT '0' NOT NULL,
  cruser_id int(11) DEFAULT '0' NOT NULL,
  deleted tinyint(3) unsigned DEFAULT '0' NOT NULL,
  hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
  reference text,
  ip varchar(255) DEFAULT '0' NOT NULL,

  PRIMARY KEY (uid),
  KEY parent (pid),
  KEY ip_check (reference(16),ip(16))
) ENGINE = InnoDB;

#
# Table structure for table 'tt_news'
#
CREATE TABLE tt_news (
  tx_ratings_enable int(1) DEFAULT '1' NOT NULL,
);
