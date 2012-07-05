<h3>Daftar Siswa</h3>
<div>
<?php echo form_open('school/student'); ?>
<?php echo form_dropdown('filter_class',$classes); ?>
<?php echo form_submit('mysubmit', 'Filter'); ?>
<?php echo form_close(); ?>
</div>
<br class="clear-both" />
<br />
	<table border="0" class="front-table rounded">
		<thead>
		<tr>
			<th>Nama</th>
			<th>Kelas</th>
		</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="3">
					<div class="inner"><?php $this->load->view('admin/partials/pagination'); ?></div>
				</td>
			</tr>
		</tfoot>
		<tbody>
		<?php if ($students): ?>
			<?php foreach ($students as $student): ?>
			<tr <?php if($this->kasta->is_mine($student->user_id)){echo 'style="background-color:#fff0bb"';}  ?>>
				<td><?php echo anchor('school/student/detail/' . $student->id, $student->full_name); ?></td>
				<td>
					<?php echo $this->to_roman->convert($this->options['start_grade']+$student->grade-1); ?>
					<?php echo ' - '.$student->class_name; ?>
				</td>
			</tr>			
			<?php endforeach; ?>
		<?php else: ?>
			<tr>
				<td colspan="2">Belum ada daftar siswa, silakan atur pengelompokan pengguna pada tab pengaturan</td>
			</tr>
		<?php endif; ?>
		</tbody>
	</table>