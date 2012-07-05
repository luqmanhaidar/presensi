<div id="label">
	Halaman ini berisikan daftar nama-nama pengajar beserta nama mata pelajaran yang diampu
</div>

<h3>Daftar Pengajar</h3>
<?php if($this->kasta->is_admin()) : ?>
<nav id="shortcuts">
	<ul>
		<li><?php echo anchor('admin/school/teachers/create', 'Tambah Pengajar', 'id="add_tacher" class="add"'); ?></li>
		<br class="clear-both" />
	</ul>
</nav>
<?php endif; ?>

<?php echo form_open('admin/school/subjects/delete'); ?>
	<table border="0" class="table-list">
		<thead>
		<tr>
			<th>Username</th>
			<th>Group</th>
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
		<?php if ($teachers): ?>
			<?php foreach ($teachers as $teacher): ?>
			<tr <?php if($this->kasta->role($teacher->id)){echo 'style="background-color:#e9ffe9;"';} ?>>
				<td><?php echo anchor('admin/school/teachers/profile/' . $teacher->id, $teacher->full_name); ?></td>
				<td><?php echo $teacher->role_title; ?></td>
				<td><?php echo ($teacher->last_login > 0 ? date('M d, Y', $teacher->last_login) : 'Belum Pernah'); ?></td>
				<td>
				<?php if($this->kasta->is_admin()) : ?>
					<?php echo anchor('admin/school/teachers/add_subject/' . $teacher->id, 'Tambah Mata Pelajaran', array('id'=>'suggests')); ?>
					<?php echo anchor('admin/school/teachers/edit/' . $teacher->id, lang('user_edit_label'), array('id'=>'edit_teacher')); ?>  
					<?php echo anchor('admin/users/delete/' . $teacher->id, lang('user_delete_label'), array('class'=>'confirm minibutton')); ?>
				<?php else: ?>
					no action permited
				<?php endif; ?>
				</td>
			</tr>
			<?php if (isset($teacher->the_subject)): ?>
			<?php foreach ($teacher->the_subject as $key=>$val): ?>
			<tr>				
				<td colspan="4">
				- <?php echo $val; ?>
				</td>
			</tr>
			<?php endforeach; ?>
			<?php endif; ?>
			
			<?php endforeach; ?>
		<?php else: ?>
			<tr>
				<td colspan="3">Tidak ada daftar mata pelajaran yang tersedia</td>
			</tr>
		<?php endif; ?>
		</tbody>
	</table>
<?php echo form_close(); ?>

<script type="text/javascript">
jQuery(function($) {
	$("#add_teacher, #edit_subjects, #suggests").colorbox({
		width:"400", height:"350", iframe:true,
		onClosed:function(){ location.reload(); }
	});
});
</script>
