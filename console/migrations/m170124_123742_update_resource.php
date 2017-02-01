<?php

use common\components\XMigration;

class m170124_123742_update_resource extends XMigration
{
    public function init()
    {
        $this->tableName = '{{%resource}}'; 
        return parent::init();  
    }
    /* ************************************************************************* */ 
    public function up()
    {
        $this->init(); 
        $this->update($this->tableName,
                ['title'=>'No selection','Description'=>'No Selection','status_id'=>1], 
                'id=1'); 
        $this->update($this->tableName,
                ['title'=>'Other','Description'=>'Other'],'id=2'); 
        $this->update($this->tableName,
                ['title'=>'MRI','Description'=>'MRI','status_id'=>1], 
                'id=3'); 
        $this->insert($this->tableName,['collection_id'=>1,'title'=>'MEG','description'=>'MEG', 'location'=>'Maindy Rd.', 'sort_order'=>100,'status_id'=>2,'created_at'=>time(),'created_by'=>1 ]);
        $this->insert($this->tableName,['collection_id'=>1,'title'=>'MRI and DNA','description'=>'MRI and DNA', 'location'=>'Maindy Rd.', 'sort_order'=>100,'status_id'=>2,'created_at'=>time(),'created_by'=>1 ]);
         $this->insert($this->tableName,['collection_id'=>1,'title'=>'MRI 3TW','description'=>'MRI 3TW', 'location'=>'Maindy Rd.', 'sort_order'=>100,'status_id'=>2,'created_at'=>time(),'created_by'=>1 ]);
          $this->insert($this->tableName,['collection_id'=>1,'title'=>'MRI 3TE','description'=>'MRI 3TE', 'location'=>'Maindy Rd.', 'sort_order'=>100,'status_id'=>2,'created_at'=>time(),'created_by'=>1 ]);
          $this->insert($this->tableName,['collection_id'=>1,'title'=>'MRI 7T','description'=>'MRI 7T', 'location'=>'Maindy Rd.', 'sort_order'=>100,'status_id'=>2,'created_at'=>time(),'created_by'=>1 ]);

          $this->insert($this->tableName,['collection_id'=>1,'title'=>'TMS','description'=>'TMS', 'location'=>'Maindy Rd.', 'sort_order'=>100,'status_id'=>2,'created_at'=>time(),'created_by'=>1 ]);
          $this->insert($this->tableName,['collection_id'=>1,'title'=>'EEG','description'=>'EEG', 'location'=>'Maindy Rd.', 'sort_order'=>100,'status_id'=>2,'created_at'=>time(),'created_by'=>1 ]);
          $this->insert($this->tableName,['collection_id'=>1,'title'=>'Sleep lab','description'=>'Sleep lab', 'location'=>'Maindy Rd.', 'sort_order'=>100,'status_id'=>2,'created_at'=>time(),'created_by'=>1 ]);


    }
    /* ************************************************************************* */ 
    
    public function down()
    {
        echo "m170124_123742_update_resource cannot be reverted.\n";

        return false;
    }

    /* ************************************************************************* */ 
    
    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
