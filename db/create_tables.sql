--Creates the Users, Documents, and Versions table
--use Gitdocs

CREATE TABLE IF NOT EXISTS `Users`(
	`u_id` INTEGER AUTO_INCREMENT,
	PRIMARY KEY(`u_id`),
	
	`username` VARCHAR(40) UNIQUE,
	
	`pwd_hash` varchar(40) NOT NULL, 
	`display_name` VARCHAR(40), 
	`icon_ptr` VARCHAR(40)
) ENGINE=INNODB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `Documents`(
	`doc_id` INTEGER AUTO_INCREMENT,
	PRIMARY KEY(`doc_id`),
	
	`name` VARCHAR(40)
)ENGINE=INNODB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `Versions`(
	`v_id` INTEGER AUTO_INCREMENT,
	PRIMARY KEY(`v_id`),
	
	`doc_fk` INTEGER,
	FOREIGN KEY(`doc_fk`) REFERENCES Documents(`doc_id`),
	
	`u_fk` INTEGER,
	FOREIGN KEY(`u_fk`) REFERENCES Users(`u_id`),
	
	`repo_ptr` VARCHAR(40)
)ENGINE=INNODB DEFAULT CHARSET=latin1;

