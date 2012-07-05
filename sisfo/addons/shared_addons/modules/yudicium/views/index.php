<h2 id="page_title" class="page-title">
	<?php echo lang('yudicium_add') ?>
</h2>
<div>
	<?php if(validation_errors()):?>
	<div class="error-box">
		<?php echo validation_errors();?>
	</div>
	<?php endif;?>

	<?php echo form_open('yudicium/create', array('id'=>'user_edit'));?>

	<fieldset id="user_names">
		<legend><?php echo lang('yudicium_profile') ?></legend>
		<ul>
			<li class="float-left spacer-right">
				<label for="name"><?php echo lang('yudicium_name') ?></label><br/>
				<?php echo form_input('name'); ?>
			</li>

			<li>
				<label for="nim"><?php echo lang('yudicium_nim') ?></label><br/>
				<?php echo form_input('nim'); ?>
			</li>
			
			<li>
				<label for="department"><?php echo lang('yudicium_department') ?></label>	
				<?php echo form_dropdown('department', $prodies); ?>			
			</li>
			<li>
				<label for="lecture"><?php echo lang('yudicium_pa')?></label>
				<?php echo form_dropdown('pa',$lectures); ?>
			</li>
			<li class="multiple_fields">
				<div class="fields2">
					<div>
						<label for="religion"><?php echo lang('yudicium_religion')?></label>
						<?php echo form_dropdown('religion',$religions); ?>
					</div>
					<div>
						<label for="gender"><?php echo lang('yudicium_gender')?></label>
						<?php echo form_dropdown('religion',array('L'=>'L','P')); ?>
					</div>
					<div>
						<label for="merriage"><?php echo lang('yudicium_merriage')?></label>
						<?php echo form_dropdown('merriage',array('Kawin'=>'Kawin','Belum Kawin'=>'Belum Kawin')); ?>
					</div>
				</div>
			</li>
			<li class="multiple_fields">
				<div class="fields2">
					<div>
						<label for="pob"><?php echo lang('yudicium_pob') ?>:</label>
						<?php echo form_input('pob'); ?>
					</div>
					<div>
						<label for="dob"><?php echo lang('yudicium_dob') ?>:</label>
						<?php echo form_input('dob','','id="datepicker"'); ?>
					</div>
					
				</div>
			</li>
			<li>
				<label for="address"><?php echo lang('yudicium_address')?></label>
				<?php echo form_textarea('address'); ?>
			</li>
			<li>
				<label for="parrent"><?php echo lang('yudicium_parrent')?></label>
				<?php echo form_input('parrent'); ?>
			</li>
			<li>
				<label for="parrent-address"><?php echo lang('yudicium_parrent_address')?></label>
				<?php echo form_textarea('parrent_address'); ?>
			</li>
			<li>
				<label for="parental"><?php echo lang('yudicium_parental')?></label>
				<?php echo form_dropdown('parental',array('PBU'=>'PBU','UTUL'=>'UTUL','PKS'=>'PKS')); ?>
			</li>
			<li>
				<label for="soo"><?php echo lang('yudicium_soo')?></label>
				<?php echo form_input('soo'); ?>
			</li>
			<li>
				<label for="school-address"><?php echo lang('yudicium_school_address')?></label>
				<?php echo form_textarea('school_address'); ?>
			</li>
		</ul>
	</fieldset>
	<fieldset id="graduate">
		<legend>Diisi Sesuai DHS</legend>
		<ul>
			<li class="multiple_fields">
				<div class="fields2">
					<div>
						<label for="graduation"><?php echo lang('yudicium_graduation')?></label>
						<?php echo form_input('graduation','','id="graduation"'); ?>
					</div>
					<div>
						<label for="ipk"><?php echo lang('yudicium_ipk')?></label>
						<?php echo form_input('ipk'); ?>
					</div>
					<div>
						<label for="sks"><?php echo lang('yudicium_sks')?></label>
						<?php echo form_input('sks'); ?>
					</div>
				
				</div>
			</li>	
		</ul>
	</fieldset>
	<fieldset>
		<legend>Data Tugas Akhir</legend>
		<ul>
			
			<li>
				<label for="thesis"><?php echo lang('yudicium_thesis')?></label>
				<?php echo form_dropdown('thesis',array('Skripsi'=>'Skripsi','Bukan Skripsi'=>'Bukan Skripsi','D3'=>'D3')); ?>
			</li>
			<li>
				<label for="thesis_title"><?php echo lang('yudicium_thesis_title')?></label>
				<?php echo form_textarea('thesis_title'); ?>
			</li>
			<li>
				<label for="lecture"><?php echo lang('yudicium_lecture')?></label>
				<?php echo form_dropdown('lecture',$lectures); ?>
			</li>
			<li class="multiple_fields">
				<div class="fields2">
					<div>
						<label for="start"><?php echo lang('yudicium_start')?></label>
						<?php echo form_input('start','','id="start"'); ?>
					</div>
					<div>
						<label for="finish"><?php echo lang('yudicium_finish')?></label>
						<?php echo form_input('finish','','id="finish"'); ?>
					</div>
					<div>
						<label for="yudicium_date"><?php echo lang('yudicium_date')?></label>
						<?php echo form_input('yudicium_date','','id="date"'); ?>
					</div>
				
				</div>
			</li>
		</ul>
	</fieldset>
	<fieldset>
		<legend>Kontak</legend>
		<ul>
			
			<li>
				<label for="phone"><?php echo lang('yudicium_phone')?></label>
				<?php echo form_input('phone'); ?>
			</li>
			<li>
				<label for="email"><?php echo lang('yudicium_email')?></label>
				<?php echo form_input('email'); ?>
			</li>
		</ul>
	</fieldset>
	<?php echo form_submit('submit', 'Simpan'); ?>
	<?php echo form_close(); ?>
</div>