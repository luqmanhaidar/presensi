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
	<li>
		<label for="subjects">Mata Pelajaran</label>
		<?php echo form_input('subjects',$subjects->subjects, 'class="required"'); ?>
	</li>
	<li>
		<label for="grade">Grade</label>
		<?php echo form_dropdown('grade', $grades,$subjects->grade,'class="required"'); ?>
	</li>
	<li>
		<label for="nothing"></label>
		<?php echo form_submit('button_action', lang('buttons.save'), 'class="button"'); ?>
	</li>
</ul>

<?php echo form_close(); ?>

<?php endif; ?>