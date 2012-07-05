<h3>
    <?php echo $detail->subjects; ?>
     grade 
    <?php echo $this->to_roman->convert($this->options['start_grade']+$detail->grade-1); ?>
</h3>
<div>oleh :: <?php echo $detail->first_name.' '.$detail->last_name.' ( '.$detail->codes.' )'; ?></div>

<br />

<!-- BAGIAN NAVIGASI -->

<div id="label">
	Mata pelajaran ini di ajarkan di kelas ::
</div>
<nav id="shortcuts">
    <ul>
        <?php foreach ($classes as $class): ?>
            <li>
            <?php echo anchor('admin/school/subjects/scores/'.$class->id_cs, 
            $this->to_roman->convert($this->options['start_grade']+$class->grade-1).'-'.
            $class->class_name, 'id="add_lesson"'); ?>
            </li>
        <?php endforeach; ?>
        <br class="clear-both" />
    </ul>
</nav>
<!-- AKHIR BAGIAN NAVIGASI -->

<div>
    <div>Description</div>
    <div>
        <?php if ($detail->desc == NULL): ?>
            Belum ada deskripsi untuk mata pelajaran ini.
        <?php else : ?>
            <?php echo $detail->desc; ?>
        <?php endif; ?>
    </div>
    <?php if($this->kasta->role($detail->user_id)): ?>
    <div><?php echo anchor('admin/school/subjects/update_desc/'.$detail->ts_id, 'Perbaharui Deskripsi', 'id="update_desc"'); ?></div>
	<?php endif; ?>
</div>

<br />

<div class="bab-wrapper">
    <?php if($lessons): ?>
        <?php foreach($lessons as $lesson): ?>
            <div class="lesson-wrapper" style="border: solid silver 1px; padding: 10px; margin: 5px 0;">
                <h4><?php echo $lesson->title; ?></h4>
                <div>
                    <?php echo $lesson->resume; ?>
                </div>
                
                <?php if($this->uri->segment(6) == 'edit' && $this->uri->segment(7) == $lesson->id_lesson) : ?>
                    <?php echo form_open('admin/school/subjects/update_lesson/'.$lesson->id_lesson, 'class="crud"'); ?>
                            <?php echo form_hidden('ts_id',$detail->ts_id) ?>
                            <ol>
                                <li>
                                    <b>Form perubahan sub materi</b>
                                </li>
                				<li class="even">
                					<label for="title">Judul</label>
                					<?php echo form_hidden('id_lesson',$lesson->id_lesson, 'maxlength="100"'); ?>
                                    <?php echo form_hidden('id_silabus',$this->uri->segment(5), 'maxlength="100"'); ?>
                                    <?php echo form_input('title',$lesson->title, 'maxlength="100"'); ?>
                					<span class="required-icon tooltip">Wajib di isi</span>
                				</li>
                
                				<li>
                					<?php echo form_textarea(array('id'=>'body', 'name'=>'resume', 'value' =>  stripslashes($lesson->resume), 'rows' => 10, 'class'=>'wysiwyg-advanced')); ?>
                				</li>
                
                			</ol>
                            <?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel') )); ?>
                    <?php echo form_close(); ?>
                <?php endif; ?>
                
                <?php if($this->kasta->role($detail->user_id)): ?>
                <?php echo anchor('admin/school/subjects/silabus/'.$detail->ts_id.'/edit/'.$lesson->id_lesson,'Edit'); ?> |
                <?php echo anchor('admin/school/subjects/delete_lesson/'.$lesson->id_lesson.'/'.$detail->ts_id,'Hapus'); ?>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<!-- ADD ROLE SYSTEM -->
<?php if($this->kasta->role($detail->user_id)): ?>

<?php if($this->uri->segment(6) == 'add_lesson') : ?>
    <?php echo form_open(uri_string(), 'class="crud"'); ?>
            <?php echo form_hidden('ts_id',$detail->ts_id) ?>
            <ol>
                <li>
                    <b>Form penambahan sub materi</b>
                </li>
				<li class="even">
					<label for="title">Judul</label>
					<?php echo form_input('title','', 'maxlength="100"'); ?>
					<span class="required-icon tooltip">Wajib di isi</span>
				</li>

				<li>
					<?php echo form_textarea(array('id'=>'body', 'name'=>'resume', 'value' =>  stripslashes(''), 'rows' => 10, 'class'=>'wysiwyg-advanced')); ?>
				</li>

			</ol>
            <?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel') )); ?>
    <?php echo form_close(); ?>
<?php else: ?>
    <?php echo anchor('admin/school/subjects/silabus/'.$detail->ts_id.'/add_lesson', 'Tambah sub materi', 'id="add_lesson"'); ?>
<?php endif; ?>

<?php endif; ?>
<!-- END OF ROLE SYSTEM -->

<script type="text/javascript">
jQuery(function($) {
	$("#update_desc").colorbox({
		width:"700", height:"400", iframe:true,
		onClosed:function(){ location.reload(); }
	});
});
</script>