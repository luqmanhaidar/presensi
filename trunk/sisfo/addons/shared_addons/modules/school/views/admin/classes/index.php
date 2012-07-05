<div id="label">
	Halaman ini ditujukan untuk melihat daftar kelas yang tersedia untuk saat ini, sekaligus untuk mengadakan perubahan terhadapnya
</div>

<h3>Daftar Kelas yang tersedia</h3>
<?php if($this->kasta->is_admin()) : ?>
<nav id="shortcuts">
	<ul>
		<li><?php echo anchor('admin/school/classes/create', 'Tambah Kelas', 'id="add_class" class="add"'); ?></li>
		<br class="clear-both" />
	</ul>
</nav>
<?php endif; ?>

<?php echo form_open('admin/school/classes/delete'); ?>
	<table border="0" class="table-list">
		<thead>
		<tr>
            <?php if($this->kasta->is_admin()) : ?>
			<th><?php echo form_checkbox(array('name' => 'action_to_all', 'class' => 'check-all'));?></th>
			<?php endif; ?>
            <th>Kelas</th>
			<th>Detail</th>
			<th class="width-10"><span>Action</span></th>
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
		<?php if ($classes): ?>
			<?php foreach ($classes as $class): ?>
			<tr>
            <?php if($this->kasta->is_admin()) : ?>
				<td><?php echo form_checkbox('action_to[]', $class->id); ?></td>
            <?php endif; ?>
				<td><?php echo $class->grade.' '.$class->class_name;?></td>
				<td><?php echo anchor('admin/school/classes/detail/' . $class->id, 'Lihat detail');?></td>
				<td>
                <?php if($this->kasta->is_admin()) : ?>
					<?php echo anchor('admin/school/classes/edit/' . $class->id, 'Ubah', array('id'=>'edit_class')) . ' | '; ?>
					<?php echo anchor('admin/school/classes/delete/' . $class->id, 'Hapus', array('class'=>'confirm'));?>
                <?php else: ?>
                    -
                <?php endif; ?>
                </td>
			</tr>
			<?php endforeach; ?>
		<?php else: ?>
			<tr>
				<td colspan="4">Tidak ada daftar nama kelas yang tersedia</td>
			</tr>
		<?php endif; ?>
		</tbody>
	</table>
    <?php if($this->kasta->is_admin()) : ?>
	<?php $this->load->view('admin/partials/buttons', array('buttons' => array('delete') )); ?>
    <?php endif;?>
<?php echo form_close(); ?>

<script type="text/javascript">
jQuery(function($) {
	$("#add_class, #edit_class").colorbox({
		width:"400", height:"350", iframe:true,
		onClosed:function(){ location.reload(); }
	});
});
</script>
