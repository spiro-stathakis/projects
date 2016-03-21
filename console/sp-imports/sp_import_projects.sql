 
DROP PROCEDURE IF EXISTS `sp_import_projects`; 
DELIMITER ;;
 
CREATE  PROCEDURE `sp_import_projects`()
    MODIFIES SQL DATA
BEGIN 
	
	
	DECLARE no_rows INT UNSIGNED DEFAULT 0; 
	DECLARE l_status_active INT UNSIGNED DEFAULT 2; 
	DECLARE l_count INT UNSIGNED DEFAULT 0; 


	DECLARE l_study_id INT UNSIGNED DEFAULT 0; 
	DECLARE l_csa_id INT UNSIGNED DEFAULT 0; 
	DECLARE l_pi_id INT UNSIGNED DEFAULT 0; 
	DECLARE l_wefo_id INT UNSIGNED DEFAULT 0; 
	DECLARE l_study_name VARCHAR(255) DEFAULT ''; 
	DECLARE l_study_code VARCHAR(255) DEFAULT ''; 
	DECLARE l_ethics_number VARCHAR(255) DEFAULT ''; 
	DECLARE l_funding_number VARCHAR(255) DEFAULT '';
	DECLARE l_funding_code VARCHAR(255) DEFAULT '';
	DECLARE l_mri_time INT; 
	DECLARE l_meg_time INT; 
	DECLARE l_application_received INT; 
	DECLARE l_cog_approval INT; 
	DECLARE l_presentation INT; 
	DECLARE l_ethics_approval INT; 
	DECLARE l_risk_assessment INT; 
	DECLARE l_rules_procedure INT; 
	DECLARE l_created_by INT; 
	DECLARE l_create_date INT; 
	DECLARE l_project_status_id INT; 
	
	DECLARE l_new_project_id INT; 
	DECLARE l_new_collection_id INT; 
	DECLARE l_collection_type_project INT DEFAULT 3; 
	DECLARE l_collection_manager INT DEFAULT 2; 
	DECLARE l_collection_member INT DEFAULT 3; 
	DECLARE l_collection_collab INT DEFAULT 4; 
	DECLARE l_csa_name VARCHAR(255); 
	DECLARE l_pi_name VARCHAR(255); 
	
	
	DECLARE  project_csr CURSOR FOR 
		SELECT s.StudyID,s.UserID,s.CsaID,s.StudyTypeID,S.StudyStatusID,       
		s.StudyCode,s.StudyName,s.EthicsNumber,s.Funding,             
		s.FundingCode,s.MriTime,s.MegTime,s.ApplicationReceived,
		s.CogApproval,s.Presentation,s.EthicsApproval,s.RiskAssessment,     
		s.RulesProcedures,s.CreatedBy,s.CreateDate          
		FROM study.Study s;  
	
	
	DECLARE CONTINUE HANDLER FOR NOT FOUND SET no_rows =1; 
	OPEN project_csr; 
		project_loop: REPEAT
			FETCH project_csr INTO
				l_study_id,l_pi_id,l_csa_id,l_wefo_id,l_project_status_id,
				l_study_code,l_study_name, l_ethics_number,l_funding_number,
				l_funding_code,l_mri_time , l_meg_time, l_application_received ,
				l_cog_approval,l_presentation,l_ethics_approval,l_risk_assessment,
				l_rules_procedure, l_created_by,l_create_date;
			

			SET l_count = (SELECT COUNT(id) FROM projects.project WHERE old_id=l_study_id);
			
			
			
			IF l_count = 0 THEN 

					SET l_pi_name  = (SELECT CONCAT('PI: ' , first_name, ' ' , last_name, '  [', user_name , ']') FROM user WHERE id=l_pi_id); 
					SET l_csa_name  = (SELECT CONCAT('CSA: ' , first_name, ' ' , last_name, '  [', user_name , ']') FROM user WHERE id=l_csa_id); 
					SET l_project_status_id = l_project_status_id + 1; 
					CASE l_csa_id 
		    			WHEN 1 THEN SET l_csa_id=26; # Derek Jones 
		    			WHEN 2 THEN SET l_csa_id=37; # Richard Wise 
		    			WHEN 3 THEN SET l_csa_id=18; # Suresh Muthukumaraswamy
		    			WHEN 4 THEN SET l_csa_id=26; # Derek Jones
		    			WHEN 5 THEN SET l_csa_id=33; # Krish Singh 
		    			WHEN 6 THEN SET l_csa_id=37; # Richard wise 
		    			WHEN 7 THEN SET l_csa_id=38; # John Evans
		    			WHEN 8 THEN SET l_csa_id=36; # Chris Chambers
		    			
					END CASE;


					INSERT INTO projects.project 
					(
						csa_id,pi_id,wefo_id,title,code, 
						funding_number,funding_code,app_received, 
						cog_approval,presentation,ethics_approval, 
						ethics_number,risk_assessment,rules_procedure, 
						mri_time,meg_time,old_id,project_status_id, 
						status_id,created_at,created_by 
					) VALUES (
						l_csa_id,l_pi_id,l_wefo_id,l_study_name, 
						l_study_code,l_funding_number,l_funding_code, 
						l_application_received, l_cog_approval, 
						l_presentation,l_ethics_approval,l_ethics_number, 
						l_risk_assessment,l_rules_procedure,l_mri_time, 
						l_meg_time,l_study_id,l_project_status_id, 
						l_status_active,l_create_date,l_created_by 
					);

					SET l_new_project_id = LAST_INSERT_ID(); 

					#####################################################################################################
					

					INSERT INTO projects.collection  
					(
						title,description,alias,collection_type_id,created_by,created_at
					) 
					VALUES 
					(
						concat( 'Project number ', l_study_id),
						concat(l_pi_name , '. ', l_csa_name), 
						concat( 'project- ', l_study_id),
						
						l_collection_type_project, 
						2, 
						UNIX_TIMESTAMP() 
					); 

					SET l_new_collection_id = LAST_INSERT_ID(); 

					#####################################################################################################
					
					INSERT INTO user_collection
					(
						collection_id, user_id , member_type_id , expiry
					)
					VALUES
					( l_new_collection_id, l_csa_id , l_collection_manager , UNIX_TIMESTAMP() + (10  * (86400 * 365))),
					( l_new_collection_id, l_pi_id  , l_collection_member , UNIX_TIMESTAMP() + (10  * (86400 * 365))); 

					#####################################################################################################
					
					INSERT INTO project_collection
					(
						collection_id, project_id , member_type_id , expiry
					)
					VALUES
					( l_new_collection_id, l_new_project_id  , l_collection_manager , UNIX_TIMESTAMP() + (10  * (86400 * 365))); 

					#####################################################################################################
					
					INSERT INTO user_collection 
					(
						collection_id, user_id , member_type_id , expiry
					) 
						(
							SELECT 
							l_new_collection_id, SGU.UserID, l_collection_collab, (UNIX_TIMESTAMP() + (10  * (86400 * 365)))
							FROM study.StudyGroupUser SGU 
							INNER JOIN study.StudyGroupStudy SGS
							ON SGU.StudyGroupID=SGS.StudyGroupID 
							WHERE SGS.StudyID=l_study_id
						); 
					
					#####################################################################################################
					

			END IF; 
					
		UNTIL no_rows
				
	END REPEAT project_loop; 
	CLOSE project_csr; 
	
	UPDATE projects.project SET code=old_id; 
	
	
	
	
END ;;
DELIMITER ;	








	

