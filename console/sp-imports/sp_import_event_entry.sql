 
DROP PROCEDURE IF EXISTS `sp_import_event_entry`; 
DELIMITER ;;
 
CREATE  PROCEDURE `sp_import_event_entry`()
    MODIFIES SQL DATA
BEGIN 
	
	
	DECLARE no_rows INT UNSIGNED DEFAULT 0; 
	DECLARE l_status_active INT UNSIGNED DEFAULT 2; 
	DECLARE l_count INT UNSIGNED DEFAULT 0; 

	DECLARE l_boolean_true INT UNSIGNED DEFAULT 2; 
	DECLARE l_boolean_false INT UNSIGNED DEFAULT 3; 

	DECLARE l_event_id INT UNSIGNED DEFAULT 0; 
	DECLARE l_event_entry_id INT UNSIGNED DEFAULT 0; 
	DECLARE l_title VARCHAR(255); 
	DECLARE l_description VARCHAR(255); 
	DECLARE l_calendar_id INT UNSIGNED DEFAULT 0; 
	DECLARE l_created_by INT UNSIGNED DEFAULT 0; 
	DECLARE l_project_id INT UNSIGNED DEFAULT 0; 

	DECLARE l_all_day_option_id INT UNSIGNED DEFAULT 0; 
	DECLARE l_start_timestamp INT UNSIGNED DEFAULT 0; 
	DECLARE l_end_timestamp INT UNSIGNED DEFAULT 0; 

	DECLARE l_booking_status_id INT UNSIGNED DEFAULT 0; 

	DECLARE l_confirm_by INT UNSIGNED DEFAULT 0; 
	DECLARE l_confirm_date INT UNSIGNED DEFAULT 0; 





	DECLARE  event_csr CURSOR FOR 
		SELECT e.EventEntryID, e.EventID, e.EventEntryTitle,e.EventEntryDescription, 
		e.StartTimeStamp,e.EndTimeStamp, e.BookingStatusID, e.AllDayTF,e.ConfirmBy,e.ConfirmDate 
		FROM study.EventEntry e ; 
	
	
	DECLARE CONTINUE HANDLER FOR NOT FOUND SET no_rows =1; 
	OPEN event_csr; 
		event_loop: REPEAT
			FETCH event_csr INTO l_event_entry_id, l_event_id, l_title,l_description,
			l_start_timestamp, l_end_timestamp, l_booking_status_id, 
			l_all_day_option_id , l_confirm_by, l_confirm_date; 


			
			IF l_all_day_option_id = 1 THEN
			 	SET l_all_day_option_id = l_boolean_true; 
			ELSE 
			 	SET l_all_day_option_id = l_boolean_false; 
			END IF; 
			
			SET l_booking_status_id = l_booking_status_id + 1;  

			SET l_count = (SELECT COUNT(id) FROM projects.event_entry WHERE old_id=l_event_entry_id);
			IF l_count = 0 THEN 
					INSERT INTO projects.event_entry 
					(
						event_id, 
						title,
						description,
						booking_status_id, 
						start_timestamp, 
						end_timestamp, 
						all_day_option_id, 
						old_id, 
						confirm_by, 
						confirm_date, 
						created_at,
						created_by 
					) VALUES (
						l_event_id, 
						l_title,
						l_description,
						l_booking_status_id, 
						l_start_timestamp,
						l_end_timestamp,
						l_all_day_option_id, 
						l_event_entry_id,  
						l_confirm_by,
						l_confirm_date, 
						unix_timestamp(),
						1
					);
			END IF; 
		UNTIL no_rows
				
	END REPEAT event_loop; 
	CLOSE event_csr; 

	
	

	
	
END ;;
DELIMITER ;	








	

