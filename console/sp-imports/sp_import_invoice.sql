 
DROP PROCEDURE IF EXISTS `sp_import_invoice`; 
DELIMITER ;;
 
CREATE  PROCEDURE `sp_import_invoice`()
    MODIFIES SQL DATA
BEGIN 
	
	
	DECLARE no_rows INT UNSIGNED DEFAULT 0; 
	DECLARE l_status_active INT UNSIGNED DEFAULT 2; 
	DECLARE l_count INT UNSIGNED DEFAULT 0; 
	DECLARE l_boolean_true INT UNSIGNED DEFAULT 2; 
	DECLARE l_boolean_false INT UNSIGNED DEFAULT 3; 

	DECLARE l_invoice_id INT UNSIGNED DEFAULT 0; 
	DECLARE l_invoice_number INT UNSIGNED DEFAULT 0; 


	DECLARE l_resource_id INT UNSIGNED DEFAULT 0; 
	DECLARE l_resource_other VARCHAR(4096); 
	DECLARE l_old_id INT UNSIGNED DEFAULT 0; 
	DECLARE l_new_id INT UNSIGNED DEFAULT 0; 
	DECLARE l_amount INT UNSIGNED DEFAULT 0 ; 
	DECLARE l_old_project_id INT UNSIGNED DEFAULT 0; 
	DECLARE l_new_project_id INT UNSIGNED DEFAULT 0; 
	DECLARE l_project_id INT UNSIGNED DEFAULT 0; 
	DECLARE l_qty INT UNSIGNED DEFAULT 0; 
	DECLARE l_old_user_id INT UNSIGNED DEFAULT 0; 
	DECLARE l_new_user_id INT UNSIGNED DEFAULT 0; 
	DECLARE l_created_by INT UNSIGNED DEFAULT 0; 
	DECLARE l_publish_status_id INT UNSIGNED DEFAULT 0; 
	DECLARE l_created_at INT UNSIGNED DEFAULT 0; 

	DECLARE l_all_day_option_id INT UNSIGNED DEFAULT 0; 

	DECLARE  invoice_csr CURSOR FOR 
		SELECT i.InvoiceID,i.StudyID,i.InvoiceNumber,
		i.CreatedBy,ft.FacilityID,ft.FacilityOther,
		ft.FacilityTime,ft.Cost,i.CreateDate,i.CurrentStatusID
		FROM study.Invoice i 
		INNER JOIN study.FacilityTime ft ON ft.InvoiceID=i.InvoiceID 
		INNER JOIN study.RefFacility rf ON rf.FacilityID=ft.FacilityID 	
		ORDER BY i.InvoiceID
		; 
	
	
	DECLARE CONTINUE HANDLER FOR NOT FOUND SET no_rows =1; 
	OPEN invoice_csr; 
		invoice_loop: REPEAT
			FETCH invoice_csr INTO l_invoice_id, l_old_project_id,
			l_invoice_number, l_old_user_id,l_resource_id, 
			l_resource_other,l_qty,l_amount,l_created_at,l_publish_status_id; 

			SET l_created_by = (SELECT id FROM projects.user where old_id=l_old_user_id);
			IF ISNULL(l_created_by) THEN 
				SET l_created_by = 1;
			END IF; 

			SET l_project_id = (SELECT id FROM project WHERE old_id=l_old_project_id);
			IF l_publish_status_id = 12 THEN 
				SET l_publish_status_id = 3; 
			ELSE 
				SET l_publish_status_id = 2;
			END IF; 

			SET l_amount = 0 ; 
			SET l_count = (SELECT COUNT(id) FROM projects.invoice WHERE old_id=l_invoice_id);
			
			IF l_count = 0 THEN 
				
					INSERT INTO projects.invoice 
					(
						invoice_number,
						project_id,
						publish_status_id,
						vat_status_id, 
						amount, 
						old_id, 
						created_at,
						created_by 
					) VALUES (
						l_invoice_number,
						l_project_id,
						l_publish_status_id,
						3, 
						l_amount, 
						l_invoice_id, 
						l_created_at,
						l_created_by
					);
			END IF; 
		UNTIL no_rows
				
	END REPEAT invoice_loop; 
	CLOSE invoice_csr; 

	
	

	
	
END ;;
DELIMITER ;	








	

