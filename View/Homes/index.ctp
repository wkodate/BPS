<h2>Mode </h2>
<?php
# echo $this->Form->create(null, array('url'=>array('controller'=>'teams', 'action'=>'index')));
echo $this->Form->create(null, array('url'=>array('controller'=>'matches', 'action'=>'index')));
echo $this->Form->end('Match');
?>

<?php
echo $this->Form->create(null, array('url'=>array('controller'=>'teams', 'action'=>'pennant')));
echo $this->Form->end('Pennant');
?>

<h2>Debug</h2>
<?php debug($this->request);  ?>
