<?php 
$I = new AcceptanceTester($scenario);
$I->wantTo('Ensure landing page is online');
$I->amOnPage('/'); 
$I->see('Our Crm'); 

