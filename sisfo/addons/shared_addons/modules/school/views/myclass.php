				<br style="clear:both" />
				<table class="front-table rounded">
					<thead>
						<th>
							Daftar nama-nama teman sekelas saya
						</th>
					</thead>
					<tbody>
					<?php foreach ($mystudent as $student): ?>
						<tr>
							<td>
								<?php // echo $student->first_name.' '.$student->last_name; ?>
                                <?php echo $student->first_name.' '.$student->last_name ?>
							</td>
						</tr>
					<?php endforeach; ?>
					</tbody>
				</table>