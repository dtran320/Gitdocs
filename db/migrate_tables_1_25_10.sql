/*--Creates the Users, Documents, and Versions table*/
/*--use Gitdocs*/
ALTER TABLE Users
	ADD COLUMN `salt` VARCHAR(40);;
