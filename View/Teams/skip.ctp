<h2>Select Your Team (Skip Mode)</h2>
<?php
echo $this->Form->create(null, array('url'=>array('controller'=>'game_results', 'action'=>'index')));
?>
<h4>Top Team</h4>
<?php
echo $this->Form->select('top_team_id', $team_names);
?>
<h4>Bottom Team</h4>
<?php
echo $this->Form->select('bottom_team_id', $team_names);
echo $this->Form->end('PLAYBALL!');
?>

<h2>Debug</h2>
<?php debug($this->request);  ?>