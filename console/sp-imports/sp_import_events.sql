 
DROP PROCEDURE IF EXISTS `sp_import_events`; 
DELIMITER ;;
 
CREATE  PROCEDURE `sp_import_events`()
    MODIFIES SQL DATA
BEGIN 
	
	
	DECLARE no_rows INT UNSIGNED DEFAULT 0; 
	DECLARE l_status_active INT UNSIGNED DEFAULT 2; 
	DECLARE l_count INT UNSIGNED DEFAULT 0; 

	DECLARE l_boolean_true INT UNSIGNED DEFAULT 2; 
	DECLARE l_boolean_false INT UNSIGNED DEFAULT 3; 

	DECLARE l_event_id INT UNSIGNED DEFAULT 0; 
	DECLARE l_title VARCHAR(255); 
	DECLARE l_description VARCHAR(255); 
	DECLARE l_calendar_id INT UNSIGNED DEFAULT 0; 
	DECLARE l_created_by INT UNSIGNED DEFAULT 0; 
	DECLARE l_project_id INT UNSIGNED DEFAULT 0; 

	DECLARE l_all_day_option_id INT UNSIGNED DEFAULT 0; 

	DECLARE  event_csr CURSOR FOR 
		SELECT e.EventID, e.EventTitle,e.EventDescription, 
		e.CalendarID,e.CreatedBy, e.StudyID, 
		e.AllDayTF
		FROM study.Event e ; 
	
	
	DECLARE CONTINUE HANDLER FOR NOT FOUND SET no_rows =1; 
	OPEN event_csr; 
		event_loop: REPEAT
			FETCH event_csr INTO l_event_id, l_title,l_description,
			l_calendar_id, l_created_by, l_project_id, 
			l_all_day_option_id; 


			
			IF l_all_day_option_id = 1 THEN
			 	SET l_all_day_option_id = l_boolean_true; 
			ELSE 
			 	SET l_all_day_option_id = l_boolean_false; 
			END IF; 
			
			SET l_count = (SELECT COUNT(id) FROM projects.event WHERE old_id=l_event_id);
			IF l_count = 0 THEN 
					INSERT INTO projects.event 
					(
						title,
						description,
						calendar_id,
						project_id, 
						all_day_option_id, 
						old_id, 
						created_at,
						created_by 
					) VALUES (
						l_title,
						l_description,
						l_calendar_id,
						l_project_id, 
						l_all_day_option_id, 
						l_event_id, 
						unix_timestamp(),
						1
					);
			END IF; 
		UNTIL no_rows
				
	END REPEAT event_loop; 
	CLOSE event_csr; 

	
	

	
	
END ;;
DELIMITER ;	








	

