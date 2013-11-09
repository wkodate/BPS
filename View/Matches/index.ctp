<h2>Game Select </h2>
<?php
echo $this->Form->create(null, array('url'=>array('controller'=>'teams', 'action'=>'index')));
echo $this->Form->input('mode', array('type'=>'hidden', 'value'=>1));
echo $this->Form->end('NormalGame');
?>

<?php
echo $this->Form->create(null, array('url'=>array('controller'=>'teams', 'action'=>'skip')));
echo $this->Form->input('mode', array('type'=>'hidden', 'value'=>2));
echo $this->Form->end('SkipGame');
?>

<h2>Debug</h2>
<?php debug($this->request);  ?>
