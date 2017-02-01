 
DROP PROCEDURE IF EXISTS `sp_import_invoice_entry`; 
DELIMITER ;;
 
CREATE  PROCEDURE `sp_import_invoice_entry`()
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
	DECLARE l_unit_cost INT UNSIGNED DEFAULT 0 ; 
	DECLARE l_total_cost INT UNSIGNED DEFAULT 0 ; 
	DECLARE l_qty INT UNSIGNED DEFAULT 0; 
	DECLARE l_facility_time_id INT UNSIGNED DEFAULT 0; 
	DECLARE l_old_project_id INT UNSIGNED DEFAULT 0; 
	DECLARE l_new_project_id INT UNSIGNED DEFAULT 0; 
	DECLARE l_project_id INT UNSIGNED DEFAULT 0; 
	DECLARE l_old_user_id INT UNSIGNED DEFAULT 0; 
	DECLARE l_new_user_id INT UNSIGNED DEFAULT 0; 
	DECLARE l_created_by INT UNSIGNED DEFAULT 0; 
	DECLARE l_publish_status_id INT UNSIGNED DEFAULT 0; 
	DECLARE l_created_at INT UNSIGNED DEFAULT 0; 
	DECLARE l_old_invoice_id INT UNSIGNED DEFAULT 0;
	 

	DECLARE  invoice_csr CURSOR FOR 
		SELECT ft.FacilityTimeID,ft.StudyID,ft.InvoiceID,
		ft.FacilityID,ft.FacilityOther,ft.FacilityTime, 
		ft.Cost,ft.CreateDate,ft.CreatedBy
		FROM study.FacilityTime ft ORDER BY ft.FacilityTimeID; 
	
	
	DECLARE CONTINUE HANDLER FOR NOT FOUND SET no_rows =1; 
	OPEN invoice_csr; 
		invoice_loop: REPEAT
			FETCH invoice_csr INTO l_facility_time_id, 
			l_old_project_id, l_old_invoice_id, 
			l_resource_id,l_resource_other,l_qty, l_total_cost, 
			l_created_at,l_old_user_id; 

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

			SET l_invoice_id = (SELECT id FROM projects.invoice WHERE old_id=l_old_invoice_id); 
			

			SET l_unit_cost = 0 ; 
			SET l_count = (SELECT COUNT(id) FROM projects.invoice_entry WHERE old_id=l_facility_time_id);
			IF l_count = 0 THEN 
				
					INSERT INTO projects.invoice_entry 
					(
						invoice_id,
						resource_id,
						resource_other,
						unit_cost, 
						qty, 
						total_cost, 
						old_id, 
						created_at,
						created_by 
					) VALUES (
						l_invoice_id, 
						l_resource_id, 
						l_resource_other, 
						l_unit_cost, 
						l_qty, 
						l_total_cost, 
						l_facility_time_id, 
						l_created_at,
						l_created_by
					);
			END IF; 
		UNTIL no_rows
				
	END REPEAT invoice_loop; 
	CLOSE invoice_csr; 

	
	UPDATE projects.invoice_entry SET qty=1 WHERE qty=0; 
	UPDATE projects.invoice_entry SET unit_cost=total_cost / qty; 
	UPDATE projects.invoice 
	SET projects.invoice.amount=
			(SELECT SUM(projects.invoice_entry.total_cost) FROM 
					projects.invoice_entry   
					WHERE projects.invoice_entry.invoice_id=projects.invoice.id 
			);
	
	
END ;;
DELIMITER ;	








	

