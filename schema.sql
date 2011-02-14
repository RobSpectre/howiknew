CREATE TABLE vignettes (
	id int not null primary key auto_increment,
	timestamp timestamp default current_timestamp not null,
	publishtimestamp timestamp,
	status int(3) default 0,
	email varchar(128),
	body varchar(1024),
	tweet varchar(160),
	geolocation varchar(1024),
	ip varchar(39),
	submitter varchar(128),
	sex int(3)
);

CREATE TABLE hearts (
	id int not null primary key auto_increment,
	timestamp timestamp default current_timestamp not null,
	vid int,
	status int(3) default 0,
	ip varchar(39)
);

CREATE TABLE tags (
	id int not null primary key auto_increment,
	timestamp timestamp default current_timestamp not null,
	vid int,
	tag int,
	ip varchar(39),
	submitter varchar(128)
);

CREATE TABLE IF NOT EXISTS  `sessions` (
    session_id varchar(40) DEFAULT '0' NOT NULL,
    ip_address varchar(16) DEFAULT '0' NOT NULL,
    user_agent varchar(50) NOT NULL,
    last_activity int(10) unsigned DEFAULT 0 NOT NULL,
    user_data text NOT NULL,
    PRIMARY KEY (session_id)
);


