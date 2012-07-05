<div id="label">
	Halaman ini berisikan daftar mata pelajaran yang disediakan
</div>

<h3>Daftar Mata Pelajaran</h3>
<?php if($this->kasta->is_admin()) : ?>
<nav id="shortcuts">
	<ul>
		<li><?php echo anchor('admin/school/subjects/create', 'Tambah Mata Pelajaran', 'id="add_subjects" class="add"'); ?></li>
		<br class="clear-both" />
	</ul>
</nav>
<?php endif; ?>

<?php echo form_open('admin/school/subjects/delete'); ?>
	<table border="0" class="table-list">
		<thead>
		<tr>
			<th>Mata Pelajaran</th>
			<th class="width-10"><span>Action</span></th>
		</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="2">
					<div class="inner"><?php $this->load->view('admin/partials/pagination'); ?></div>
				</td>
			</tr>
		</tfoot>
		<tbody>
		<?php if ($subjects): ?>
			<?php foreach ($subjects as $subject): ?>
			<tr>
				<td><b><?php echo $subject->subjects.' Grade '.$subject->grade;?></b></td>
				<td>
                <?php if($this->kasta->is_admin()) : ?>
					<?php echo anchor('admin/school/subjects/add_teacher/' . $subject->id, 'Tambah Pengajar', 'id="suggests"') . ' | '; ?>
					<?php echo anchor('admin/school/subjects/update/' . $subject->id, 'Ubah', 'id="edit_subjects"') . ' | '; ?>
					<?php echo anchor('admin/school/subjects/delete/' . $subject->id, 'Hapus', array('class'=>'confirm'));?>
				<?php else:?>
                    -
                <?php endif; ?>
                </td>
			</tr>
			<?php if (isset($subject->the_teacher)): ?>
			<?php foreach ($subject->the_teacher as $key=>$val): ?>
			<tr <?php if($this->kasta->role($val['id'])){echo 'style="background-color:#e9ffe9;"';} ?>>
				<td>
				- <?php echo anchor('admin/school/subjects/silabus/' . $key, $val['data']); ?>
				</td>
				<td>
				<?php echo anchor('admin/school/subjects/update_ts/' . $val['ts_id'], 'Update', 'id="update-ts"'); ?> | 
				<?php echo anchor('admin/school/subjects/delete_ts/' . $val['ts_id'], 'Delete'); ?>
				</td>
			</tr>
			<?php endforeach; ?>
			<?php endif; ?>
			
			<?php endforeach; ?>
		<?php else: ?>
			<tr>
				<td colspan="2">Tidak ada daftar mata pelajaran yang tersedia</td>
			</tr>
		<?php endif; ?>
		</tbody>
	</table>
<?php echo form_close(); ?>

<script type="text/javascript">
jQuery(function($) {
	$("#add_subjects, #edit_subjects, #suggests, #update-ts").colorbox({
		width:"400", height:"350", iframe:true,
		onClosed:function(){ location.reload(); }
	});
});
</script>
