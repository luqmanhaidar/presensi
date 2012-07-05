<style type="text/css">
	label { width: 23% !important; }
</style>
<div id="label">
	Halaman pengaturan sistem sekolah
</div>

<h3>Kelas <?php echo $grades.' - '.$classes->class_name ?></h3>

<div class="box-container">
	<div class="tabs">
		<ul class="tab-menu">
			<li><a href="#students">Nama-nama Siswa</a></li>
            <li><a href="#overview">Mata Pelajaran</a></li>
            <?php if($this->kasta->is_admin()): ?>
			<li><a href="#subjects">Edit Mata Pelajaran</a></li>
			<?php endif; ?>
		</ul>
		<div id="students">
                <table>
					<thead>
						<th>
							Daftar nama-nama siswa yang terdaftar di kelas ini;
						</th>
					</thead>
					<tbody>
					<?php foreach ($mystudent as $student): ?>
						<tr>
							<td>
								<?php // echo $student->first_name.' '.$student->last_name; ?>
                                <?php echo anchor('admin/school/students/report/'.$student->id,$student->first_name.' '.$student->last_name) ?>
							</td>
						</tr>
					<?php endforeach; ?>
					</tbody>
				</table>
        </div>
		<div id="overview">
			<table>
					<thead>
						<th>
							Daftar Mata pelajaran beserta pengajarnya;
						</th>
					</thead>
					<tbody>
					<?php foreach ($mysubject as $my): ?>
						<tr>
							<td>
								<?php echo anchor('admin/school/subjects/scores/'.$my->id_cs,$my->subjects.' grade '.$this->to_roman->convert($this->options['start_grade']+$my->grade-1) );?>
							     <br />oleh 
                                <?php echo $my->first_name.' '.$my->last_name; ?>
                            </td>
						</tr>
					<?php endforeach; ?>
					</tbody>
				</table>
		</div>
		
		<?php if($this->kasta->is_admin()): ?>
		<div id="subjects">
			<?php echo form_open(uri_string(), 'class="crud"'); ?>

				<table>
					<thead>
						
					</thead>
					<tbody>
					<?php $master = ''; ?>
					<?php foreach($subjects as $subject): ?>
					
						<?php if ($subject->subjects_id != $master): ?>
							<tr>
								<td colspan="3">
									<b><?php echo $subject->subjects.' Grade '; ?>
									<?php echo $this->to_roman->convert($this->options['start_grade']+$subject->grade-1); ?></b>
								</td>
							</tr>
							<?php $master = $subject->subjects_id; ?>
						<?php endif; ?>
						<tr>
							<td style="width: 30px"><?php echo form_checkbox('subject[]', $subject->ts_id, in_array($subject->ts_id,$mine)); ?></td>
							<td><?php echo '( '.$subject->codes.' ) '.$subject->first_name.' '.$subject->last_name; ?></td>
						</tr>
					<?php endforeach; ?>
			
					</tbody>
				</table>
			
				<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel'))); ?>
			
			<?php echo form_close(); ?>
		</div>
		<?php endif; ?>
        
        
	</div>
</div>