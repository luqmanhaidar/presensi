<h3>Rapor</h3>

Nama : <?php echo $myprofiles->first_name.' '.$myprofiles->last_name; ?><br />
Kelas : <?php echo $myprofiles->grade.' - '.$myprofiles->class_name; ?><br /><br />

<br /><br />

		<table border="0" class="table-list">
            <thead>
                <tr>
                    <th>Mata Pelajaran</th>
                    <th>Score</th>
                    <th>Nilai Kelas</th>
                </tr>
            </thead>
            <tbody>
            <?php $total = $i = 0 ?>
            <?php foreach($mysubjects as $subject): ?>
            <?php $myscore = unserialize($subject->data_cs); ?>
                <tr>
                    <td>
                    <?php echo $subject->subjects;?><br />
                    <div style="font-size:10px;">
                    <?php echo 'oleh : '.($subject->first_name).' '.($subject->last_name).' ('; ?>
                    <?php echo anchor('school/subjects/silabus/'.$subject->ts_id,($subject->codes)); ?>
                    <?php echo ') ';?>
                    </div>
                    </td>
                    <td>
                    <?php echo @$myscore[$myprofiles->user_id]; ?>                
                    </td>
                    <td>
                    <?php echo anchor('school/class_score/'.$subject->id_cs,'Lihat nilai satu kelas'); ?>
                    
                    </td>
                </tr>
            <?php $i++; ?>
            <?php $total += @$myscore[$myprofiles->user_id]; ?>
            <?php endforeach; ?>
            <?php $i == 0 ? $rates = 0 : $rates = $total/$i; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td><b>Total</b></td>
                    <td><?php echo $total; ?></td>
                </tr>
                <tr>
                    <td colspan="2"><b>Rata Rata : </b><?php echo $rates ?></td>
                </tr>
            </tfoot>
        </table>