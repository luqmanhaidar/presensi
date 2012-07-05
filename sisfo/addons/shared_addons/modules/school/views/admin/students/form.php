<?php if ($this->method == 'create'): ?>
	<h3>Penambahan data siswa</h3>
<?php else: ?>
	<h3>Perubahan data siswa</h3>
<?php endif; ?>

<?php echo form_open($this->uri->uri_string(), 'class="crud"'); ?>
<fieldset>
	<ol>
		<li class="even">
			<label for="first_name">Nama Depan</label>
			<?php echo form_input('first_name', @$member->first_name); ?>
			<span class="required-icon tooltip">required</span>
		</li>

		<li>
			<label for="last_name">Nama Belakang</label>
			<?php echo form_input('last_name', @$member->last_name); ?>
			<span class="required-icon tooltip"><?php echo lang('required_label');?></span>
		</li>

		<li class="even">
			<label for="email">Email</label>
			<?php echo form_input('email', @$member->email); ?>
			<span class="required-icon tooltip">required</span>
		</li>

		<li>
			<label for="username">Username</label>
			<?php echo form_input('username', @$member->username); ?>
			<span class="required-icon tooltip">required</span>
		</li>

		<li class="even">
			<label for="display_name">Nama Yang ditampilkan</label>
			<?php echo form_input('display_name', @$member->display_name); ?>
			<span class="required-icon tooltip"><?php echo lang('required_label');?></span>
		</li>

		<?php echo form_hidden('group_id',$the_groups->name); ?>
		<li>
			<label for="active"><?php echo 	lang('user_activate_label');?></label>
			<?php echo form_checkbox('active', 1, (isset($member->active) && $member->active == 1)); ?>
		</li>
		<li class="even">
			<label for="password">Password</label>
			<?php echo form_password('password'); ?>
			<?php if ($this->method == 'create'): ?>
			<span class="required-icon tooltip"><?php echo lang('required_label');?></span>
			<?php endif; ?>
		</li>

		<li>
			<label for="confirm_password">Konfirmasi Password</label>
			<?php echo form_password('confirm_password'); ?>
			<?php if ($this->method == 'create'): ?>
			<span class="required-icon tooltip"><?php echo lang('required_label');?></span>
			<?php endif; ?>
		</li>
		<li class="even">
			<label for="id_number">N.I.S</label>
			<?php echo form_input('id_number', @$profile->id_number); ?>
		</li>
		<li>
			<label for="class">Kelas</label>
			<?php echo form_dropdown('class',$classes,@$my_class->class_id); ?>
		</li>
	</ol>
</fieldset>

<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel') )); ?>

<?php echo form_close(); ?>