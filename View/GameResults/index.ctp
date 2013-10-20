<h2>Game Result</h2>
<?php
echo $this->Form->create('GameResult');
echo $this->Form->input('top_team_id', array('type'=>'hidden', 'value'=>$top_team_id));
echo $this->Form->input('bottom_team_id', array('type'=>'hidden', 'value'=>$bottom_team_id));
echo $this->Form->input('top_score', array('type'=>'hidden', 'value'=>$game_result_detail->score['top']['total']));
echo $this->Form->input('bottom_score', array('type'=>'hidden', 'value'=>$game_result_detail->score['bottom']['total']));
echo $this->Form->end('Save');
?>

<?php
echo $this->Form->create(null, array('url'=>array('controller'=>'homes', 'action'=>'index')));
echo $this->Form->end('Back to Home');
?>

<h2>Score</h2>

<table>
<thead>
<tr>
<th>TEAM</th>
<?php for($inn=1; $inn<=9; $inn++): ?>
<th><?php echo $inn; ?></th>
<?php endfor; ?>
<th>TOTAL</th>
</tr>
</thead>
<tbody>
<tr>
<td><?php echo $top_team_name; ?></td>
<?php for($inn=1; $inn<=9; $inn++): ?>
<td><?php echo $game_result_detail->score['top'][$inn]; ?></td>
<?php endfor; ?>
<td><?php echo $game_result_detail->score['top']['total']; ?></td>
</tr>
<tr>
<td><?php echo $bottom_team_name; ?></td>
<?php for($inn=1; $inn<=9; $inn++): ?>
<td><?php echo $game_result_detail->score['bottom'][$inn]; ?></td>
<?php endfor; ?>
<td><?php echo $game_result_detail->score['bottom']['total']; ?></td>
</tr>
</tbody>
</table>

<table>
<thead>
    <tr>
    <th colspan="3"><?php echo $top_team_name; ?></th>
    <th colspan="3"><?php echo $bottom_team_name; ?></th>
    </tr>
</thead>
<tbody>
    <?php for($i=1; $i<=9; $i++): ?>
    <tr>
    <td><?php echo $i ?></td>
    <td><?php echo $i ?></td>
    <td>PLAYER</td>
    <td><?php echo $i ?></td>
    <td><?php echo $i ?></td>
    <td>player</td>
    </tr>
    <?php endfor; ?>
</tbody>
</table>

<h2>Debug</h2>
<?php debug($this); ?>
