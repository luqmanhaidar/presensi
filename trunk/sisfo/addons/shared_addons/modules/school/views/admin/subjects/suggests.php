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
	<?php echo form_hidden('subjects_id',$subjects->id); ?>
	<li>
		<label for="subjects">Mata Pelajaran</label>
		<?php echo $subjects->subjects.' grade '.$subjects->grade; ?>
	</li>
	<li>
		<label for="subjects">Kode</label>
		<?php echo form_input('codes',$suggests->codes, 'class="required"') ?>
	</li>
	<li>
		<label for="teachers_id">Pengajar</label>
		<?php echo form_dropdown('teachers_id',$teachers,$suggests->teachers_id,'class="required"'); ?>
	</li>
	<li>
		<label for="nothing"></label>
		<?php echo form_submit('button_action', lang('buttons.save'), 'class="button"'); ?>
	</li>
</ul>

<?php echo form_close(); ?>

<?php endif; ?>