<h2>Standings</h2>
<?php
echo $this->Form->create('Standings');
echo $this->Form->input('team_id', array('type'=>'hidden', 'value'=>$team_id));
echo $this->Form->end('Save');
?>

<?php
echo $this->Form->create(null, array('url'=>array('controller'=>'homes', 'action'=>'index')));
echo $this->Form->end('Back to Home');
?>

<table>
<thead>
<tr>
<th>NUM</th>
<th>TEAM</th>
<th>W</th>
<th>L</th>
<th>T</th>
<th>PCT</th>
<th>GB</th>
</tr>
</thead>
<tbody>
<?php for($num=0; $num<count($standings); $num++): ?>
<tr>
<td><?php echo $num+1; ?></td>
<td><?php echo $team_id_name[$standings[$num]['team_id']]; ?></td>
<td><?php echo $standings[$num]['wins']; ?></td>
<td><?php echo $standings[$num]['losses']; ?></td>
<td><?php echo $standings[$num]['ties']; ?></td>
<td><?php echo $standings[$num]['pct']; ?></td>
<td><?php echo $standings[$num]['gb']; ?></td>
</tr>
<?php endfor; ?>
</tbody>
</table>

<h2>Debug</h2>
<?php debug($this); ?>
