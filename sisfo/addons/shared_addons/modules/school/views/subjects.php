<h3>Daftar Mata Pelajaran</h3>
	<table class="front-table rounded">
		<thead>
		<tr>
			<th>Mata Pelajaran</th>
			<th>Pengajar</th>
		</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="2">
					<div class="inner"><?php $this->load->view('admin/partials/pagination'); ?></div>
				</td>
			</tr>
		</tfoot>
		<tbody>
		<?php if ($subjects): ?>
			<?php foreach ($subjects as $subject): ?>
			<tr>
				<td><b><?php echo $subject->subjects.' Grade '.$subject->grade;?></b></td>
				<td>
                <ul>
				    <?php if (isset($subject->the_teacher)): ?>
        			<?php foreach ($subject->the_teacher as $key=>$val): ?>
        			     <li> <?php echo anchor('school/subjects/silabus/' . $key, $val); ?></li>
        				
        			<?php endforeach; ?>
        			<?php endif; ?>	
                </ul>
				</td>
			</tr>
			<?php endforeach; ?>
		<?php else: ?>
			<tr>
				<td colspan="2">Tidak ada daftar mata pelajaran yang tersedia</td>
			</tr>
		<?php endif; ?>
		</tbody>
	</table>