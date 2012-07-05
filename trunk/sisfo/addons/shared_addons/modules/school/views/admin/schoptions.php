<style type="text/css">
	label { width: 23% !important; }
</style>
<div id="label">
	Halaman pengaturan sistem sekolah
</div>

<h3>Preferences</h3>

<?php echo form_open('admin/school/schoptions/update', 'class="crud"'); ?>

<div class="box-container">
	<div class="tabs">
		<ul class="tab-menu">
			<li><a href="#pengguna">Pengguna</a></li>
			<li><a href="#kelas">Kelas</a></li>
			<li><a href="#tahun">Tahun Ajaran</a></li>
		</ul>
		
		<div id="pengguna">
			<fieldset>
				<ol>
					<li>
						<label for="admin_group_id"> Grup Admin Sekolah</label>
						<div class="width-40">
							<?php echo form_dropdown('admin_group_id',$group,$options['admin_group_id']) ?>
						</div>
					</li>
					
					<li class="even">
						<label for="teacher_group_id"> Grup Pengajar</label>
						<div class="width-40">
							<?php echo form_dropdown('teacher_group_id',$group,$options['teacher_group_id']) ?>
						</div>
					</li>
					
					<li>
						<label for="student_group_id"> Grup Siswa</label>
						<div class="width-40">
							<?php echo form_dropdown('student_group_id',$group,$options['student_group_id']) ?>
						</div>
					</li>
				</ol>
			</fieldset>
		</div>
		
		<div id="kelas">
			<fieldset>
				<ol>
					<li>
						<label for="total_grade"> Jumlah Grade</label>
						<div class="width-40">
							<?php echo form_input('total_grade',$options['total_grade']) ?>
						</div>
					</li>
					<li class="even">
						<label for="start_grade"> Awal Grade</label>
						<div class="width-40">
							<?php echo form_input('start_grade',$options['start_grade']) ?>
							ditulis dalam angka arab (standar)
						</div>
					</li>
					<li>
						<label for="grade_roman"> Penulisan Grade</label>
						<div class="width-40">
							<?php $opt_grade = array('1'=>'Romawi','0'=>'Standar (angka arab)'); ?>
							<?php echo form_dropdown('grade_roman',$opt_grade,$options['grade_roman']) ?>
						</div>
					</li>
				</ol>
			</fieldset>
		</div>
		
		<div id="tahun">
			<fieldset>
				<ol>
					<li>
						<label for="active_years"> Tahun Ajaran</label>
						<select name="active_years">
							<?php $years = $options['active_years']; ?>
							<?php for($y=$years-10;$y<=$years+10;$y++): ?>
								<option value="<?php echo $y ?>" <?php if($y==$years){echo 'selected';} ?>>
									<?php echo $y.' / '.$x=$y+1; ?>
								</option>
							<?php endfor; ?>
						</select>
					</li>
				</ol>
			</fieldset>
		</div>
	</div>
</div>
	
<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save') )); ?>
<?php echo form_close(); ?>
