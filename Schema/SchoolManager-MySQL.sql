DROP TABLE session;
CREATE TABLE session (
	id varchar(32) not null,
	uid varchar(25) not null,
	name varchar(255) not null,
	timestamp timestamp,
	primary key (id)
);

DROP TABLE user;
CREATE TABLE user (
	id integer auto_increment not null primary key,
	username varchar(32),
	realname varchar(255),
	password varchar(32)
);

DROP TABLE level;
CREATE TABLE level (
	id integer auto_increment not null primary key,
	name varchar(100),
	description text
);

DROP TABLE subject;
CREATE TABLE subject (
	id integer auto_increment not null primary key,
	name varchar(100),
	description text
);

DROP TABLE topic;
CREATE TABLE topic (
	id integer auto_increment not null primary key,
	name varchar(100),
	description text
);

DROP TABLE resource;
CREATE TABLE resource (
	id integer auto_increment not null primary key,
	name varchar(100),
	description text,
	type integer not null,
	path text,
	uid varchar(32),
	timestamp timestamp
);

DROP TABLE lstr;
CREATE TABLE lstr (
	levelid integer not null,
	subjectid integer not null,
	topicid integer not null,
	resourceid integer not null,
	timestamp timestamp,
	index (levelid),
	index (subjectid),
	index (topicid),
	index (resourceid)
);

ALTER TABLE resource add mimetype varchar(100),
                     add md5 varchar(32);