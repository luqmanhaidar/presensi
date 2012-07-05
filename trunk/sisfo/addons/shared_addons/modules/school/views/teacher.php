<h3>Daftar Pengajar</h3>
<div id="label">
	Halaman ini berisikan daftar nama-nama pengajar beserta nama mata pelajaran yang diampu
</div>


	<table border="0" class="front-table rounded">
		<thead>
		<tr>
			<th>Nama</th>
			<th>Mata Pelajaran</th>
		</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="3">
					<div class="inner"><?php $this->load->view('admin/partials/pagination'); ?></div>
				</td>
			</tr>
		</tfoot>
		<tbody>
		<?php if ($teachers): ?>
			<?php foreach ($teachers as $teacher): ?>
			<tr>
				<td><?php echo anchor('school/teacher/detail/' . $teacher->id, $teacher->full_name); ?></td>
				<td>
                    <?php if (isset($teacher->the_subject)): ?>
        			<?php foreach ($teacher->the_subject as $key=>$val): ?>
        			
        				<?php echo $val; ?>
        				<br />
        			
        			<?php endforeach; ?>
        			<?php endif; ?>
                </td>
			</tr>
			
			
			<?php endforeach; ?>
		<?php else: ?>
			<tr>
				<td colspan="3">Tidak ada daftar mata pelajaran yang tersedia</td>
			</tr>
		<?php endif; ?>
		</tbody>
	</table>