 
DROP PROCEDURE IF EXISTS `sp_inserts`; 
DELIMITER ;;
 
CREATE  PROCEDURE `sp_inserts`()
    MODIFIES SQL DATA
BEGIN 
	
	
	DECLARE l_collection_cubric_int INT UNSIGNED DEFAULT 3; 
	DECLARE l_collection_park_place INT UNSIGNED DEFAULT 2; 

	DECLARE l_new_user_id INT UNSIGNED DEFAULT 0; 
	DECLARE l_member_type_member INT UNSIGNED DEFAULT 3; 
	
	INSERT INTO user_collection (collection_id, user_id, member_type_id, created_at,created_by)
	(SELECT l_collection_park_place, u.id , l_member_type_member , UNIX_TIMESTAMP() , 1  FROM user u ); 

	
END ;;
DELIMITER ;	








	

