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