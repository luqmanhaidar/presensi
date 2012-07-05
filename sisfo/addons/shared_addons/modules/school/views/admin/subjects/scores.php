<div id="label">
	Halaman Scores
</div>

<div>Kelas <?php echo $abouts->grade.' '.$abouts->class_name; ?></div>
<div>Mata Pelajaran <?php echo $abouts->subjects; ?></div>
<div>Pengajar :: <?php echo $abouts->first_name.' '.$abouts->last_name.' ( '.$abouts->codes.' )'; ?></div>

<?php echo form_open($this->uri->uri_string(), array('class' => 'crud', 'id' => 'folders_crud')); ?>
<?php echo form_hidden('id_cs',$abouts->id_cs); ?>
<table border="0" class="table-list">
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
			<?php if($this->kasta->role($abouts->user_id)): ?>
				<?php echo form_input('score['.$student->id.']',@$mydata[$student->id],'maxlength="2" style="width:20px;"'); ?>
			<?php else: ?>
				<?php echo @$mydata[$student->id]; ?>
			<?php endif; ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</tbody>
</table>
<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save') )); ?>
<?php echo form_close(); ?>