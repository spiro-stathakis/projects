read -s -p "Password: " mypassword
echo ""
mysql -u root -p$mypassword  projects_test  < console/sp-imports/sp_import_projects.sql 
mysql -u root -p$mypassword  projects_test  < console/sp-imports/sp_import_subjects.sql
mysql -u root -p$mypassword  projects_test  < console/sp-imports/sp_import_users.sql
 
