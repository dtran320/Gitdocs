ALTER TABLE Versions
	ADD COLUMN `v_name` VARCHAR(128);
	
ALTER TABLE Versions
	ADD COLUMN `last_saved_time` INTEGER; --easier than datetime
	

	
