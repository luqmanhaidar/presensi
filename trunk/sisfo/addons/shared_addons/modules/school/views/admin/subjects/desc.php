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
    <?php echo form_hidden('id',$subject->id); ?>
<h2>Update Deskripsi Mata Pelajaran</h2>
<ul>
    <li>
        <label for="desc">Deskripsi</label>
        <textarea name="desc" cols="70" rows="10">
            <?php echo $subject->desc; ?>
        </textarea>
    </li>
    <li>
        <?php echo form_submit('button_action', 'Update', 'class="button"'); ?>
    </li>
</ul>
<?php echo form_close(); ?>
<?php endif; ?>