 
DROP PROCEDURE IF EXISTS `sp_import_subjects`; 
DELIMITER ;;
 
CREATE  PROCEDURE `sp_import_subjects`()
    MODIFIES SQL DATA
BEGIN 
	
	
	DECLARE no_rows INT UNSIGNED DEFAULT 0; 
	DECLARE l_subject_id INT UNSIGNED DEFAULT 0; 
	DECLARE l_subject_username VARCHAR(64); 
	DECLARE l_subject_firstname VARCHAR(64); 
	DECLARE l_subject_lastname VARCHAR(64); 
	DECLARE l_subject_email VARCHAR(64);
	DECLARE l_subject_telephone VARCHAR(64);
	DECLARE l_dob DATE; 
	DECLARE l_gp_option INT UNSIGNED DEFAULT 0; 
	DECLARE l_email_option INT UNSIGNED DEFAULT 0; 
	DECLARE l_subject_hash VARCHAR(32); 

	DECLARE l_status_active INT UNSIGNED DEFAULT 2; 
	DECLARE l_count INT UNSIGNED DEFAULT 0; 

	DECLARE  subject_csr CURSOR FOR 
		SELECT s.SubjectID,s.SubjectUserName, 
		s.FirstName,s.LastName,s.Email, 
		s.Telephone,s.DateOfBirth,s.GPDetailsOptionID, 
		s.EmailOptInOptionID 
		FROM study.Subject s; 
	
	
	DECLARE CONTINUE HANDLER FOR NOT FOUND SET no_rows =1; 
	OPEN subject_csr; 
		subject_loop: REPEAT
			FETCH subject_csr INTO l_subject_id,l_subject_username,
			l_subject_firstname, l_subject_lastname,l_subject_email,
			l_subject_telephone, l_dob,l_gp_option,l_email_option;
			SET l_count = (SELECT COUNT(id) FROM subject WHERE old_id=l_subject_id);
			
			IF l_gp_option = 4 THEN 
				SET l_gp_option = 1; 
			END IF; 
			
			IF l_email_option = 4 THEN 
				SET l_email_option = 1; 
			END IF; 
			
			SET l_subject_hash = (SELECT(MD5(CONCAT(l_subject_firstname,l_subject_username)))); 
			IF l_count = 0 THEN 
					INSERT INTO subject
					(
						cubric_id,
						first_name,
						last_name,
						dob,
						email,
						hash, 
						telephone,
						address,
						gp_opt_id,
						email_opt_id,
						sex_id,
						old_id,
						status_id, 
						created_at,
						created_by 
					) VALUES (
						l_subject_username,
						l_subject_firstname,
						l_subject_lastname,
						l_dob,
						l_subject_email,
						l_subject_hash, 
						l_subject_telephone,
						'',
						l_gp_option,
						l_email_option, 
						1,
						l_subject_id,
						l_status_active, 
						unix_timestamp(),
						1 

					);
			END IF; 
		UNTIL no_rows
				
	END REPEAT subject_loop; 
	CLOSE subject_csr; 

	
	
	
	
END ;;
DELIMITER ;	








	

