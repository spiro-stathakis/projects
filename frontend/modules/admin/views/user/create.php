<?php 
use frontend\packages\AdminAsset; 
use yii\bootstrap\Html;

AdminAsset::register($this);
?>
<p>&nbsp;</p>

<p>&nbsp;</p>

 <div class="row">
            <div class="col-sm-6-offset col-sm-offset-2 col-md-7 col-md-offset-2 main">
       				<div id='search-user'>
       				<?=Html::textInput('search', '' , ['id'=>'searchUser']);?> 
       				<?=Html::submitButton('Search University system', 
       											['onClick'=>'$.app.page.ldapSearchUser()']
       											);?> 
       				</div>
       				<br /> 
       				<div id='div-display-user' style='display:none'>
	       				<table class="table table-bordered">
						    <thead>
						      <tr>
						        <th>Firstname</th>
						        <th>Lastname</th>
						        <th>Email</th>
						        <th>&nbsp;</th>
						      </tr>
						    </thead>
						    <tbody>
						      <tr>
						        <td><span id='span_first_name'></td>
						        <td><span id='span_last_name'></td>
						        <td><span id='span_email'></td>
						        <td><span id='span_submit'>
						        <?=Html::submitButton('Add this user', ['onClick'=>'$.app.page.createUser()']); ?> 
						        </td>
						      </tr>
						    </tbody>
						  </table>
       				</div> 

            </div>
 </div>