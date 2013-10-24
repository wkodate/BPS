<h2>Standings</h2>
<?php
echo $this->Form->create('Standing');
echo $this->Form->input('team_1_id', array('type'=>'hidden', 'value'=>$lg1_team_id[0]));
echo $this->Form->input('wins_1', array('type'=>'hidden', 'value'=>$standings[0]['wins']));
echo $this->Form->input('losses_1', array('type'=>'hidden', 'value'=>$standings[0]['losses']));
echo $this->Form->input('ties_1', array('type'=>'hidden', 'value'=>$standings[0]['ties']));
echo $this->Form->input('team_2_id', array('type'=>'hidden', 'value'=>$lg1_team_id[1]));
echo $this->Form->input('wins_2', array('type'=>'hidden', 'value'=>$standings[1]['wins']));
echo $this->Form->input('losses_2', array('type'=>'hidden', 'value'=>$standings[1]['losses']));
echo $this->Form->input('ties_2', array('type'=>'hidden', 'value'=>$standings[1]['ties']));
echo $this->Form->input('team_3_id', array('type'=>'hidden', 'value'=>$lg1_team_id[2]));
echo $this->Form->input('wins_3', array('type'=>'hidden', 'value'=>$standings[2]['wins']));
echo $this->Form->input('losses_3', array('type'=>'hidden', 'value'=>$standings[2]['losses']));
echo $this->Form->input('ties_3', array('type'=>'hidden', 'value'=>$standings[2]['ties']));
echo $this->Form->input('team_4_id', array('type'=>'hidden', 'value'=>$lg1_team_id[3]));
echo $this->Form->input('wins_4', array('type'=>'hidden', 'value'=>$standings[3]['wins']));
echo $this->Form->input('losses_4', array('type'=>'hidden', 'value'=>$standings[3]['losses']));
echo $this->Form->input('ties_4', array('type'=>'hidden', 'value'=>$standings[3]['ties']));
echo $this->Form->input('team_5_id', array('type'=>'hidden', 'value'=>$lg1_team_id[4]));
echo $this->Form->input('wins_5', array('type'=>'hidden', 'value'=>$standings[4]['wins']));
echo $this->Form->input('losses_5', array('type'=>'hidden', 'value'=>$standings[4]['losses']));
echo $this->Form->input('ties_5', array('type'=>'hidden', 'value'=>$standings[4]['ties']));
echo $this->Form->input('team_6_id', array('type'=>'hidden', 'value'=>$lg1_team_id[5]));
echo $this->Form->input('wins_6', array('type'=>'hidden', 'value'=>$standings[5]['wins']));
echo $this->Form->input('losses_6', array('type'=>'hidden', 'value'=>$standings[5]['losses']));
echo $this->Form->input('ties_6', array('type'=>'hidden', 'value'=>$standings[5]['ties']));
echo $this->Form->end('Save');
?>

<?php
echo $this->Form->create(null, array('url'=>array('controller'=>'homes', 'action'=>'index')));
echo $this->Form->end('Back to Home');
?>

<table>
<thead>
<tr>
<th colspan=7>League1</th>
</tr>
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
<?php $lg_num=1; ?>
<td><?php echo $num+1; ?></td>
<?php $lg = "lg".$lg_num; ?>
<td><?php echo ${$lg."_team_id_name"}[$standings[$num]['team_id']]; ?></td>
<td><?php echo $standings[$num]['wins']; ?></td>
<td><?php echo $standings[$num]['losses']; ?></td>
<td><?php echo $standings[$num]['ties']; ?></td>
<td><?php echo number_format($standings[$num]['pct'], 3); ?></td>
<td><?php echo $standings[$num]['gb']; ?></td>
</tr>
<?php endfor; ?>
</tbody>
</table>

<h2>Debug</h2>
<?php debug($this); ?>
