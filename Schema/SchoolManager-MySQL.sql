# Host: localhost
# Database: schoolmanager
# Table: 'lesson'
# 
CREATE TABLE `lesson` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(100) default NULL,
  `author` varchar(100) default NULL,
  `school` varchar(100) default NULL,
  `uid` varchar(32) default NULL,
  `timestamp` timestamp(14) NOT NULL,
  `description` text,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM; 

# Host: localhost
# Database: schoolmanager
# Table: 'lesson_resource'
# 
CREATE TABLE `lesson_resource` (
  `lessonid` int(11) NOT NULL default '0',
  `resourceid` int(11) NOT NULL default '0'
) TYPE=MyISAM; 

# Host: localhost
# Database: schoolmanager
# Table: 'lesson_testbank'
# 
CREATE TABLE `lesson_testbank` (
  `lessonid` int(11) NOT NULL default '0',
  `testbankid` int(11) NOT NULL default '0'
) TYPE=MyISAM; 

# Host: localhost
# Database: schoolmanager
# Table: 'level'
# 
CREATE TABLE `level` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(100) default NULL,
  `description` text,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM; 

# Host: localhost
# Database: schoolmanager
# Table: 'lstul'
# 
CREATE TABLE `lstul` (
  `levelid` int(11) NOT NULL default '0',
  `subjectid` int(11) NOT NULL default '0',
  `topicid` int(11) NOT NULL default '0',
  `unitid` int(11) NOT NULL default '0',
  `lessonid` int(11) NOT NULL default '0',
  `timestamp` timestamp(14) NOT NULL,
  KEY `levelid` (`levelid`),
  KEY `subjectid` (`subjectid`),
  KEY `topicid` (`topicid`),
  KEY `unitid` (`unitid`),
  KEY `lessonid` (`lessonid`)
) TYPE=MyISAM; 

# Host: localhost
# Database: schoolmanager
# Table: 'resource'
# 
CREATE TABLE `resource` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(100) default NULL,
  `description` text,
  `type` int(11) NOT NULL default '0',
  `path` text,
  `uid` varchar(32) default NULL,
  `mimetype` varchar(100) default NULL,
  `md5` varchar(32) default NULL,
  `timestamp` timestamp(14) NOT NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM; 

# Host: localhost
# Database: schoolmanager
# Table: 'session'
# 
CREATE TABLE `session` (
  `id` varchar(32) NOT NULL default '',
  `uid` varchar(25) NOT NULL default '',
  `name` varchar(255) NOT NULL default '',
  `timestamp` timestamp(14) NOT NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM; 

# Host: localhost
# Database: schoolmanager
# Table: 'subject'
# 
CREATE TABLE `subject` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(100) default NULL,
  `description` text,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM; 

# Host: localhost
# Database: schoolmanager
# Table: 'testbank'
# 
CREATE TABLE `testbank` (
  `id` int(11) NOT NULL auto_increment,
  `question` text,
  `answer` text,
  `timestamp` timestamp(14) NOT NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM; 

# Host: localhost
# Database: schoolmanager
# Table: 'topic'
# 
CREATE TABLE `topic` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(100) default NULL,
  `description` text,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM; 

# Host: localhost
# Database: schoolmanager
# Table: 'unit'
# 
CREATE TABLE `unit` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(100) default NULL,
  `description` text,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM; 

# Host: localhost
# Database: schoolmanager
# Table: 'user'
# 
CREATE TABLE `user` (
  `id` int(11) NOT NULL auto_increment,
  `uid` varchar(25) NOT NULL default '',
  `realname` varchar(100) default NULL,
  `password` varchar(32) default NULL,
  `email` varchar(100) default NULL,
  `school` varchar(255) default NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM; 


