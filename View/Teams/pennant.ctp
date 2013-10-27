<h2>Pennant</h2>
<?php
echo $this->Form->create(null, array('url'=>array('controller'=>'standings', 'action'=>'index')));
?>
<table>
<thead>
<tr>
<th colspan=2>Pennant Settings</th>
</tr>
</thead>
<tr>
<td>Games</td>
<td>
<?php echo $this->Form->select('games', array(25=>25, 50=>50, 75=>75, 100=>100, 125=>125), array("value" => 125)); ?>
</td>
</tr>
</table>

<table>
<thead>
<tr>
<th colspan=2>League1</th>
<th colspan=2>League2</th>
</tr>
</thead>
<tbody>
<tr>
<td>Team1</td>
<td>
<?php echo $this->Form->select('lg1tm1', $team_names, array("value" => 1)); ?>
</td>
<td>Team1</td>
<td>
<?php echo $this->Form->select('lg2tm1', $team_names, array("value" => 2)); ?>
</td>
</tr>
<tr>
<td>Team2</td>
<td>
<?php echo $this->Form->select('lg1tm2', $team_names, array("value" => 4)); ?>
</td>
<td>Team2</td>
<td>
<?php echo $this->Form->select('lg2tm2', $team_names, array("value" => 3)); ?>
</td>
</tr>
<tr>
<td>Team3</td>
<td>
<?php echo $this->Form->select('lg1tm3', $team_names, array("value" => 5)); ?>
</td>
<td>Team3</td>
<td>
<?php echo $this->Form->select('lg2tm3', $team_names, array("value" => 6)); ?>
</td>
</tr>
<tr>
<td>Team4</td>
<td>
<?php echo $this->Form->select('lg1tm4', $team_names, array("value" => 8)); ?>
</td>
<td>Team4</td>
<td>
<?php echo $this->Form->select('lg2tm4', $team_names, array("value" => 7)); ?>
</td>
</tr>
<tr>
<td>Team5</td>
<td>
<?php echo $this->Form->select('lg1tm5', $team_names, array("value" => 9)); ?>
</td>
<td>Team5</td>
<td>
<?php echo $this->Form->select('lg2tm5', $team_names, array("value" => 10)); ?>
</td>
</tr>
<tr>
<td>Team6</td>
<td>
<?php echo $this->Form->select('lg1tm6', $team_names, array("value" => 12)); ?>
</td>
<td>Team6</td>
<td>
<?php echo $this->Form->select('lg2tm6', $team_names, array("value" => 11)); ?>
</td>
</tr>
</tbody>
</table>
<?php
echo $this->Form->end('GET STARTED!');
?>
<h2>Debug</h2>
<?php debug($this->request);  ?>
