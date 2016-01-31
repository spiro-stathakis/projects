<?php 
namespace common\components; 
use Yii; 
use yii\base\Object;
use common\components\Types; 
use yii\bootstrap\Html;

class ScreeningResponseComponent extends Object
{

	private $_data; 
	
	
	/* ******************************************************************************************************* */ 
    /* ******************************************************************************************************* */ 
     /* ******************************************************************************************************* */ 
    /* ******************************************************************************************************* */ 
    /* ******************************************************************************************************* */ 
    

    
    /* ******************************************************************************************************* */ 
    public function renderHtmlInput($input_type_id, $options=[])
    {

            $field = $options['prefix_text'] . "&nbsp;";
            switch($input_type_id){
                    case Types::$input_type['small_text']['id']: 
                       
                        $field .= Html::textInput(
                                 sprintf('question_%s',$options['screening_question_id']), 
                                 '', 
                                 ['style'=>'width:60px']
                            );
                             
                        break; 
                    case Types::$input_type['med_text']['id']: 
                         $field .= Html::textInput(
                                 sprintf('question_%s',$options['screening_question_id']), 
                                 '', 
                                 []
                            );
                         break; 
                    case Types::$input_type['large_text']['id']: 
                        $field .= Html::textInput(
                                 sprintf('question_%s',$options['screening_question_id']), 
                                 '', 
                                 ['style'=>'width:240px']
                            );
                         break; 
                    case Types::$input_type['date']['id']: 
                        $field = sprintf('');
                         break; 
                    case Types::$input_type['radio']['id']: 

                    // Enable tristate behavior with custom indeterminate value, custom toggle icon, and a custom label for the indeterminate state.
                            ($options['tristate_option_id'] == Types::$boolean['true']['id'] ) ? $tristate = true : $tristate = false; 
                            $field = Html::radioList(
                                        sprintf('question_%s',$options['screening_question_id']), 
                                        Types::$boolean['null']['id'], 
                                        [
                                            Types::$boolean['true']['description']=>Types::$boolean['true']['description'], 
                                            Types::$boolean['false']['description']=>Types::$boolean['false']['description'], 
                                        
                                        ],
                                        [
                                            'unselect'=>Types::$boolean['null']['description'],
                                            'separator'=>'&nbsp;&nbsp;&nbsp;'
                                        ]); 
   
                        
                         break; 
                    case Types::$input_type['text_agreement']['id']:
                        $field = sprintf('text agreement'); 
                         break; 
                    case Types::$input_type['image_overlay']['id']:
                        $field = sprintf('image overlay'); 
                         break; 

                
            }
                $field .= "&nbsp;" . $options['suffix_text']; 
                return $field; 
    }
    /* ******************************************************************************************************* */ 
    public function getResponses($entry_hash)
	{
        
        return $this->_getData($entry_hash); 

	}
	/* ******************************************************************************************************* */ 
    /* ******************************************************************************************************* */ 
    /* private functions */ 
    /* ******************************************************************************************************* */ 
   
    /* ******************************************************************************************************* */ 
    /* ******************************************************************************************************* */ 
     private  function _getData($entry_hash)
    {
            return (new \yii\db\Query())
                    ->select([
                        'sf.name as screening_form_name', 'sf.title as screening_form_description', 
                        'sf.title as screening_form_title',  
                        'se.id as screening_entry_id','se.subject_id','se.researcher_id', 
                        'se.hash as entry_hash', 'se.progress_id' , 'se.contraindication_id', 
                        'sr.id as screening_response_id', 
                        'sr.screening_question_id' , 'sr.screening_entry_id', 'sr.response', 
                        'sq.caption' , 'sq.content' , 'sq.input_type_id','sq.screening_form_id',
                        'sq.tristate_option_id', 'sq.prefix_text', 'sq.suffix_text' 
                        ])
                    ->from('screening_form sf')
                    ->join('LEFT JOIN' , 'screening_question sq' , 'sq.screening_form_id=sf.id')
                    ->join('LEFT JOIN' , 'screening_entry se' , 'se.screening_form_id=sf.id')
                    ->join('LEFT JOIN' , 'screening_response sr' , 'sr.screening_question_id=sq.id AND sr.screening_entry_id=se.id')
                    ->where('sq.status_id=:status_active AND se.hash=:entry_hash')
                    ->orderBy('sq.sort_order')
                    ->addParams([':status_active'=>Types::$status['active']['id'], 
                                 ':entry_hash'=>$entry_hash 
                        ])
                    ->all();

         

    }
    /* ******************************************************************************************************* */ 
    /* ******************************************************************************************************* */ 
    /* ******************************************************************************************************* */ 
    /* ******************************************************************************************************* */ 
    

}