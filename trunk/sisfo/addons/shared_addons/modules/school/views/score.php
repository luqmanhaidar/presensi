<br />
<div>Kelas <?php echo $abouts->grade.' '.$abouts->class_name; ?></div>
<div>Mata Pelajaran <?php echo $abouts->subjects; ?></div>
<div style="font-size:10px">Pengajar :: <?php echo $abouts->first_name.' '.$abouts->last_name.' ( '.$abouts->codes.' )'; ?></div>

<br />
<table border="0" class="front-table rounded">
	<thead>
	<tr>
		<th>Nama</th>
		<th>Score</th>
	</tr>
	</thead>
	<tbody>
	<?php foreach($students as $student): ?>
		<tr>
			<td>
				<?php echo $student->first_name.' '.$student->last_name; ?>
			</td>
			<td>
				<?php echo @$mydata[$student->id]; ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</tbody>
</table>