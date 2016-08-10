
<p>&nbsp;</p>
<p>&nbsp;</p>

<ul>
<?php foreach($newUsers as $n): ?>  
 <?php echo sprintf('<li>%s %s</li><br />' , $n['first_name'] , $n['last_name'] );?>
<?php endforeach; ?>   
</ul>