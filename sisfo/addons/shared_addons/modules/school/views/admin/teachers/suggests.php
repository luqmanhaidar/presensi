<?php if (isset($messages['success'])): ?>
<script type="text/javascript">
(function($) {
	$(function() {
		parent.jQuery.colorbox.close();
		return false;
	});
})(jQuery);
</script>
<?php else: ?>

<?php echo form_open($this->uri->uri_string(), array('class' => 'crud', 'id' => 'folders_crud')); ?>
<h2><?php echo lang('files.folders.create'); ?></h2>
<ul>
	<?php echo form_hidden('teachers_id',$teachers->id); ?>
	<li>
		<label for="subjects">Nama Pengajar</label>
		<?php echo $teachers->full_name; ?>
	</li>
	<li>
		<label for="codes">Kode</label>
		<?php echo form_input('codes',$suggests->codes, 'class="required"') ?>
	</li>
	<li>
		<label for="subjecs_id">Mata Pelajaran</label>
		<?php echo form_dropdown('subjects_id',$subjects,$suggests->subjects_id,'class="required"'); ?>
	</li>
	<li>
		<label for="nothing"></label>
		<?php echo form_submit('button_action', lang('buttons.save'), 'class="button"'); ?>
	</li>
</ul>

<?php echo form_close(); ?>

<?php endif; ?>