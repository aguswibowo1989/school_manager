# Connection: Local MySQL Server
# Host: localhost
# Saved: 2004-05-04 23:00:38
# 
# Connection: Local MySQL Server
# Host: localhost
# Saved: 2004-05-04 22:22:16
# 
DROP TABLE if exists session;
CREATE TABLE session (
	id varchar(32) not null,
	uid varchar(25) not null,
	name varchar(255) not null,
	timestamp timestamp,
	primary key (id)
);

DROP TABLE if exists level;
CREATE TABLE level (
	id integer auto_increment not null primary key,
	name varchar(100),
	description text
);

DROP TABLE if exists subject;
CREATE TABLE subject (
	id integer auto_increment not null primary key,
	name varchar(100),
	description text
);

DROP TABLE if exists topic;
CREATE TABLE topic (
	id integer auto_increment not null primary key,
	name varchar(100),
	description text
);

DROP TABLE if exists resource;
CREATE TABLE resource (
	id integer auto_increment not null primary key,
	name varchar(100),
	description text,
	type integer not null,
	path text,
	uid varchar(32),
	mimetype varchar(100),
    md5 varchar(32),
    timestamp timestamp
);

DROP TABLE if exists unit;
CREATE TABLE unit (
	id integer auto_increment not null primary key,
	name varchar(100),
	description text
);

DROP TABLE if exists lesson;
CREATE TABLE lesson (
	id integer auto_increment not null primary key,
	name varchar(100),
	description text
);

DROP TABLE if exists lstul;
CREATE TABLE lstul (
	levelid integer not null,
	subjectid integer not null,
	topicid integer not null,
	unitid integer not null,
	lessonid integer not null,
	timestamp timestamp,
	index (levelid),
	index (subjectid),
	index (topicid),
	index (unitid),
	index (lessonid)
);

DROP TABLE if exists lesson_resource;
CREATE TABLE lesson_resource (
	lessonid integer not null,
	resourceid integer not null
);

DROP TABLE if exists user;
CREATE TABLE user (
	id integer not null auto_increment primary key,
	uid varchar(25) not null,
	realname varchar(100),
	password varchar(32),
	email varchar(100),
    school varchar(255)
);