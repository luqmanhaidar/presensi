<nav id="shortcuts">
	<h6>Admin Menu</h6>
	<ul>
		<li><?php echo anchor('admin/school/classes', 'Kelas') ?></li>
		<li><?php echo anchor('admin/school/subjects', 'Mata Pelajaran'); ?></li>
		<li><?php echo anchor('admin/school/teachers', 'Pengajar'); ?></li>
		<li><?php echo anchor('admin/school/students', 'Siswa')?></li>
    <?php if ($this->kasta->position() == 'admin' || $this->kasta->position() == 'super' ): ?>
		<li><?php echo anchor('admin/school/schoptions', 'Pengaturan')?></li>
    <?php endif; ?>
	</ul>
	<br class="clear-both" />
</nav>