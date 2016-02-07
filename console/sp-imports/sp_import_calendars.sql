 
DROP PROCEDURE IF EXISTS `sp_import_calendars`; 
DELIMITER ;;
 
CREATE  PROCEDURE `sp_import_calendars`()
    MODIFIES SQL DATA
BEGIN 
	
	
	DECLARE no_rows INT UNSIGNED DEFAULT 0; 
	DECLARE l_status_active INT UNSIGNED DEFAULT 2; 
	DECLARE l_count INT UNSIGNED DEFAULT 0; 

	DECLARE l_boolean_true INT UNSIGNED DEFAULT 2; 
	DECLARE l_boolean_false INT UNSIGNED DEFAULT 3; 


	DECLARE l_calendar_id INT UNSIGNED DEFAULT 0; 
	DECLARE l_calendar_title VARCHAR(255); 
	DECLARE l_calendar_description VARCHAR(255); 
	DECLARE l_calendar_location VARCHAR(255) DEFAULT 'CUBRIC Park Place'; 
	

	DECLARE l_collection_park_place_id INT UNSIGNED DEFAULT 2;  
	DECLARE l_start_hour VARCHAR(8); 
	DECLARE l_start_min VARCHAR(8); 
	DECLARE l_end_hour VARCHAR(8); 
	DECLARE l_end_min VARCHAR(8); 
	DECLARE l_palette VARCHAR(16); 

	DECLARE l_project_option INT UNSIGNED; 
	DECLARE l_allow_overlap_option INT UNSIGNED; 
	DECLARE l_read_only_option INT UNSIGNED DEFAULT 2;
	DECLARE l_advance_limit INT UNSIGNED DEFAULT 0; 



	DECLARE l_palette_id INT UNSIGNED DEFAULT 0; 

	
	DECLARE  calendar_csr CURSOR FOR 
		SELECT rc.CalendarID,rc.CalendarTitle, 
		rc.CalendarDesc,cs.StartHour, cs.StartMin, 
		cs.EndHour,cs.EndMin,rp.HexDesc

		FROM study.RefCalendar rc 
		INNER JOIN  study.CalendarSetting cs 
		ON rc.CalendarID = cs.CalendarID
		INNER JOIN  study.RefPalette rp 
		ON rp.PaletteID = cs.PaletteID; 
	
	
	DECLARE CONTINUE HANDLER FOR NOT FOUND SET no_rows =1; 
	OPEN calendar_csr; 
		calendar_loop: REPEAT
			FETCH calendar_csr INTO l_calendar_id,l_calendar_title,
			l_calendar_description, l_start_hour, l_start_min, 
			l_end_hour, l_end_min, l_palette; 


			SET l_advance_limit = 0; 
			SET l_project_option = l_boolean_false; 
			SET l_allow_overlap_option = l_boolean_false; 

			SET l_count = (SELECT COUNT(id) FROM projects.calendar WHERE old_id=l_calendar_id);
			
			SET l_palette_id = (SELECT id FROM palette where code=l_palette); 

			IF l_palette_id IS NULL THEN 
				SET l_palette_id = 1; 
			END IF; 
			
			IF l_count = 0 THEN 
					INSERT INTO projects.calendar 
					(
						title,
						description,
						location,
						start_hour, 
						start_min, 
						end_hour, 
						end_min, 
						palette_id, 
						project_option_id, 
						allow_overlap_option_id, 
						read_only_option_id, 
						advance_limit,
						old_id,
						collection_id, 
						created_at,
						created_by 
					) VALUES (
						l_calendar_title,
						l_calendar_description,
						l_calendar_location,
						l_start_hour, 
						l_start_min, 
						l_end_hour, 
						l_end_min, 
						l_palette_id, 
						l_project_option, 
						l_allow_overlap_option, 
						l_boolean_true,
						l_advance_limit, 
						l_calendar_id,
						l_collection_park_place_id,
						unix_timestamp(),
						1
					);
			END IF; 
		UNTIL no_rows
				
	END REPEAT calendar_loop; 
	CLOSE calendar_csr; 

	
	

	
	
END ;;
DELIMITER ;	








	

