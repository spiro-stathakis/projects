 
DROP PROCEDURE IF EXISTS `sp_import_users`; 
DELIMITER ;;
 
CREATE  PROCEDURE `sp_import_users`()
    MODIFIES SQL DATA
BEGIN 
	
	
	DECLARE no_rows INT UNSIGNED DEFAULT 0; 
	DECLARE l_status_active INT UNSIGNED DEFAULT 2; 
	DECLARE l_count INT UNSIGNED DEFAULT 0; 


	DECLARE l_userid INT UNSIGNED DEFAULT 0; 
	DECLARE l_username VARCHAR(64); 
	DECLARE l_firstname VARCHAR(64); 
	DECLARE l_lastname VARCHAR(64); 
	DECLARE l_email VARCHAR(64);
	DECLARE l_telephone VARCHAR(64);
	DECLARE l_password VARCHAR(255);
	DECLARE l_regdate INT UNSIGNED ; 
	DECLARE l_auth_type_id INT UNSIGNED DEFAULT 2; 
	


	
	
	DECLARE  user_csr CURSOR FOR 
		SELECT l.UserID,l.UserName, 
		l.FirstName,l.LastName,l.EmailAddress, 
		l.Password, 
		l.Telephone,l.RegistrationDate
		FROM study.Logon l; 
	
	
	DECLARE CONTINUE HANDLER FOR NOT FOUND SET no_rows =1; 
	OPEN user_csr; 
		user_loop: REPEAT
			FETCH user_csr INTO l_userid,l_username,
			l_firstname, l_lastname,l_email,
			l_password,
			l_telephone, l_regdate;
			SET l_count = (SELECT COUNT(id) FROM user WHERE old_id=l_userid);
			
			
			
			IF l_count = 0 THEN 
					INSERT INTO user 
					(
						auth_type_id,
						user_name,
						email,
						first_name,
						last_name,
						auth_key,
						password_hash,
						password_reset_token,
						old_id,
						reg_date,
						status_id, 
						created_at,
						created_by 
					) VALUES (
						l_auth_type_id,
						l_username,
						l_email,
						l_firstname,
						l_lastname,
						'', 
						l_password,
						SHA2(concat(l_username , unix_timestamp()) , 224 ), 
						l_userid, 
						l_regdate, 
						l_status_active,
						unix_timestamp(),
						0 

					);
			END IF; 
		UNTIL no_rows
				
	END REPEAT user_loop; 
	CLOSE user_csr; 

	
	UPDATE user SET auth_type_id=3 WHERE CHAR_LENGTH(password_hash) > 0; 

	
	
END ;;
DELIMITER ;	








	

