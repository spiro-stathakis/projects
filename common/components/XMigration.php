<?php
namespace common\components;
use yii\db\Schema;
use yii\db\Migration;


class XMigration extends Migration
{


    public $mysqlOptions ; 
    public $tableName;
    public function init()
    {
       

        if ($this->db->driverName == 'mysql')
              $this->mysqlOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB'; 

       
       return true; 
    }



}
