CREATE TABLE session (
	id varchar(32) not null,
	uid varchar(25) not null,
	name varchar(255) not null,
	timestamp timestamp,
	primary key (id)
);

CREATE TABLE user (
	id integer auto_increment not null primary key,
	username varchar(32),
	realname varchar(255),
	password varchar(32)
);

CREATE TABLE level (
	id integer auto_increment not null primary key,
	name varchar(100),
	description varchar(255)
);

CREATE TABLE subject (
	id integer auto_increment not null primary key,
	name varchar(100),
	description varchar(255)
);

CREATE TABLE topic (
	id integer auto_increment not null primary key,
	name varchar(100),
	description varchar(255)
);

CREATE TABLE resource (
	id integer auto_increment not null primary key,
	name varchar(100),
	description varchar(255),
	type integer not null,
	path varchar(255)
);

CREATE TABLE lstr (
	levelid integer not null,
	subjectid integer not null,
	topicid integer not null,
	resourceid integer not null,
	index (levelid),
	index (subjectid),
	index (topicid),
	index (resourceid)
);