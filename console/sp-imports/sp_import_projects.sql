 
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
	DECLARE l_study_name INT UNSIGNED DEFAULT 0; 
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
						csa_id,
						pi_id,
						wefo_id, 
						study_name, 
						study_code, 
						funding_number, 
						funding_code, 
						app_received, 
						cog_approval, 
						presentation, 
						ethics_approval, 
						ethics_number, 
						risk_assessment, 
						rules_procedure, 
						mri_time, 
						meg_time, 
						old_id, 
						project_status_id, 
						status_id, 
						created_at,
						created_by 
					) VALUES (
						l_csa_id,
						l_pi_id,
						l_wefo_id, 
						l_study_name, 
						l_study_code, 
						l_funding_number, 
						l_funding_code, 
						l_application_received, 
						l_cog_approval, 
						l_presentation, 
						l_ethics_approval, 
						l_ethics_number, 
						l_risk_assessment, 
						l_rules_procedure, 
						l_mri_time, 
						l_meg_time, 
						l_study_id, 
						l_project_status_id, 
						l_status_active,
						l_create_date,
						l_created_by 

					);
			END IF; 
		UNTIL no_rows
				
	END REPEAT project_loop; 
	CLOSE project_csr; 

	
	
	
	
END ;;
DELIMITER ;	








	

