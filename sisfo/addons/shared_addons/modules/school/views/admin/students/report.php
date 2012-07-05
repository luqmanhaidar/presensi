<h3>Rapor</h3>

<div class="profile-box rounded">
	<div class="picture-box shadow">
		<?php echo @$picture; ?>
	</div>
	<div class="data-box">
		<div class="profil-label">Nama</div>
		<div class="my-data"><?php echo $myprofiles->first_name.' '.$myprofiles->last_name; ?></div>
		<div class="profil-label">NIS</div>
		<div class="my-data"><?php echo $profiles->id_number; ?></div>
		<div class="profil-label">Kelas</div>
		<div class="my-data"><?php echo $myprofiles->grade.' - '.$myprofiles->class_name; ?></div>
		<div class="pic-button"><?php echo anchor('admin/school/students/picture/'.$myprofiles->user_id, 'Ganti Foto') ?></div>	
	</div>
	<div class="clear"></div>
</div>

<div class="tabs">
    <ul class="tab-menu">
        <li><a href="#raport">Raport</a></li>
        <li><a href="#profile">Profile</a></li>
	</ul>
    <div id="raport">
        <table border="0" class="table-list">
            <thead>
                <tr>
                    <th>Mata Pelajaran</th>
                    <th>Score</th>
                </tr>
            </thead>
            <tbody>
            <?php $total = $i = 0 ?>
            <?php foreach($mysubjects as $subject): ?>
            <?php $myscore = unserialize($subject->data_cs); ?>
                <tr>
                    <td>
                    <?php echo $subject->subjects;?>
                    </td>
                    <td>
                    <?php echo @$myscore[$myprofiles->user_id]; ?>                
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
    </div>
    <div id="profile">
        <table>
            <thead>
                <tr>
                    <th colspan="2">Data Pribadi</th>
                </tr>
            </thead>
            <tbody>
                <?php if($mydata): ?>
                <?php $ttl = '';  ?>
                <?php foreach($mydata as $key=>$val): ?>
                <?php 
                    if ($key == 'tanggal' || $key == 'bulan' || $key == 'tahun') {
                        if ($key == 'tanggal'){$ttl .= $val.' - ';}
                        if ($key == 'bulan'){ $ttl .= $val.' - ';}
                        if ($key == 'tahun'){
                            $ttl .= $val;
                            ?>
                            <tr>
                                <td><div style="text-transform: uppercase; font-weight: bold;">tanggal lahir</div>
                                <br /><?php echo $ttl ?></td>
                            </tr>       
                            <?php
                        }
                    } else {
                ?>
                <tr>
                    <td><div style="text-transform: uppercase; font-weight: bold;"><?php echo str_replace('_',' ',$key); ?></div>
                    <br /><?php echo $val ?></td>
                </tr>
                <?php } ?>
                <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>