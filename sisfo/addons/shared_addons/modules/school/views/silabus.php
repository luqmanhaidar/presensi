<h3>
    <?php echo $detail->subjects; ?>
     grade 
    <?php echo $this->to_roman->convert($this->options['start_grade']+$detail->grade-1); ?>
</h3>
<div>oleh :: <?php echo $detail->first_name.' '.$detail->last_name.' ( '.$detail->codes.' )'; ?></div>
<br />

<div>
    <div><b>Deskripsi</b></div>
    <div>
        <?php if ($detail->desc == NULL): ?>
            Belum ada deskripsi untuk mata pelajaran ini.
        <?php else : ?>
            <?php echo $detail->desc; ?>
        <?php endif; ?>
    </div>
</div>

<br />

<div class="bab-wrapper">
    <?php if($lessons): ?>
        <?php foreach($lessons as $lesson): ?>
            <div class="lesson-wrapper rounded shadow" style="border: solid silver 1px; padding: 10px; margin: 5px 0;">
                <h4><?php echo $lesson->title; ?></h4>
                <div>
                    <?php echo $lesson->resume; ?>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>