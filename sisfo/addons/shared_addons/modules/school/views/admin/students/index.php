<div id="label">
	Halaman ini berisikan nama nama siswa 
</div>

<h3>Daftar Siswa</h3>

<nav id="shortcuts">
	<ul>
		
		<li>
			<?php echo form_open('admin/school/students/index'); ?>
			<?php echo form_dropdown('filter_class',$classes); ?>
			<?php echo form_submit('mysubmit', 'Filter'); ?>
			<?php echo form_close(); ?>
		</li>
        <?php if($this->kasta->is_admin()) : ?>
		<li><?php echo anchor('admin/school/students/create', 'Tambah Siswa', 'id="add_tacher" class="add"'); ?></li>
		<?php endif; ?>
        <br class="clear-both" />
	</ul>
</nav>




<?php echo form_open('admin/school/students/set_class'); ?>
	<table border="0" class="table-list">
		<thead>
		<tr>
            <?php if($this->kasta->is_admin()) : ?>
			<th><?php echo form_checkbox(array('name' => 'action_to_all', 'class' => 'check-all'));?></th>
			<?php endif; ?>
            <th>Username</th>
			<th>Kelas</th>
			<th>Rapor</th>
			<th>Kunjungan terakhir</th>
			<th>Action</th>
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
			<tr>
                <?php if($this->kasta->is_admin()) : ?>
				<td><?php echo form_checkbox('action_to[]', $student->id); ?></td>
				<?php endif; ?>
                <td><?php echo anchor('admin/school/students/profile/' . $student->id, $student->full_name); ?></td>
				<td>
				<?php if($student->grade):?>
					<?php echo $this->to_roman->convert($this->options['start_grade']+$student->grade-1); ?>
					<?php echo ' - '.$student->class_name; ?>
				<?php else: ?>
					-
				<?php endif; ?>
				</td>
				<td><?php echo anchor('admin/school/students/report/' . $student->id, 'Rapor','class="minibutton"'); ?></td>
				<td><?php echo ($student->last_login > 0 ? date('M d, Y', $student->last_login) : 'Belum Pernah'); ?></td>
				<td>
                <?php if($this->kasta->is_admin()) : ?>
					<?php echo anchor('admin/school/students/edit/' . $student->id, lang('user_edit_label'), array('id'=>'edit_teacher','class'=>'minibutton')); ?>  
					<?php echo anchor('admin/users/delete/' . $student->id, lang('user_delete_label'), array('class'=>'confirm minibutton')); ?>
				<?php else: ?>
                    -
                <?php endif; ?>
                </td>
			</tr>			
			<?php endforeach; ?>
		<?php else: ?>
			<tr>
				<td colspan="5">Belum ada daftar siswa, silakan atur pengelompokan pengguna pada tab pengaturan</td>
			</tr>
		<?php endif; ?>
		</tbody>
	</table>
    <?php if($this->kasta->is_admin()) : ?>
	<?php echo form_dropdown('assign_class',$classes); ?>
	<?php echo form_submit('mysubmit', 'Set Kelas'); ?>
    <?php endif; ?>
<?php echo form_close(); ?>

<script type="text/javascript">
jQuery(function($) {
	$("#add_teacher, #edit_subjects, #suggests").colorbox({
		width:"400", height:"350", iframe:true,
		onClosed:function(){ location.reload(); }
	});
});
</script>
