<h2>Select Pennant Team</h2>
<?php
echo $this->Form->create(null, array('url'=>array('controller'=>'standings', 'action'=>'index')));
?>
<h4>Team1</h4>
<?php
echo $this->Form->select('team_1_id', $team_names, array("value" => 1));
?>
<h4>Team2</h4>
<?php
echo $this->Form->select('team_2_id', $team_names, array("value" => 2));
?>
<h4>Team3</h4>
<?php
echo $this->Form->select('team_3_id', $team_names, array("value" => 3));
?>
<h4>Team4</h4>
<?php
echo $this->Form->select('team_4_id', $team_names, array("value" => 4));
?>
<h4>Team5</h4>
<?php
echo $this->Form->select('team_5_id', $team_names, array("value" => 5));
?>
<h4>Team6</h4>
<?php
echo $this->Form->select('team_6_id', $team_names, array("value" => 6));
echo $this->Form->end('GET STARTED!');
?>

<h2>Debug</h2>
<?php debug($this->request);  ?>
