
	
<!-- Add an extra div to allow the elements within it to be sortable! -->
<div id="sortable">

	<!-- Dashboard Widgets -->
	{{ widgets:area slug="dashboard" }}

	<!-- Begin Recent Comments -->
	<!--
	<?php if (isset($recent_comments) AND is_array($recent_comments) AND $theme_options->pyrocms_recent_comments == 'yes') : ?>
	<div class="one_half">
		
		<section class="draggable title">
			<h4><?php echo lang('comments.recent_comments') ?></h4>
			<a class="tooltip-s toggle" title="Toggle this element"></a>
		</section>
		
		<section class="item">
			<ul>
				<?php if (count($recent_comments)): ?>
						<?php foreach ($recent_comments AS $rant) : ?>
							<li>
								<p><?php echo sprintf(lang('comments.list_comment'), $rant->name, $rant->item); ?> <em><?php echo (Settings::get('comment_markdown') AND $rant->parsed > '') ? strip_tags($rant->parsed) : $rant->comment; ?></em></p>
							</li>
						<?php endforeach; ?>
				<?php else: ?>
						<?php echo lang('comments.no_comments');?>
				<?php endif; ?>
			</ul>
		</section>

	</div>		
	<?php endif; ?>
	-->
	<!-- End Recent Comments -->
	
	<!-- Begin Quick Links -->
	<!--
	<?php if ($theme_options->pyrocms_quick_links == 'no') : ?>
	<div class="one_half last">
		
		<section class="draggable title">
			<h4><?php echo lang('cp_admin_quick_links') ?></h4>
			<a class="tooltip-s toggle" title="Toggle this element"></a>
		</section>
		
		<section id="quick_links" class="item <?php echo isset($rss_items); ?>">
			<ul>
				<?php if(array_key_exists('comments', $this->permissions) OR $this->current_user->group == 'admin'): ?>
				<li>
					<a class="tooltip-s" title="<?php echo lang('cp_manage_comments'); ?>" href="<?php echo site_url('admin/comments') ?>"><?php echo image('icons/comments.png'); ?></a>
				</li>
				<?php endif; ?>
				
				<?php if(array_key_exists('pages', $this->permissions) OR $this->current_user->group == 'admin'): ?>
				<li>
					<a class="tooltip-s" title="<?php echo lang('cp_manage_pages'); ?>" href="<?php echo site_url('admin/pages') ?>"><?php echo image('icons/pages.png'); ?></a>
				</li>
				<?php endif; ?>
				
				<?php if(array_key_exists('files', $this->permissions) OR $this->current_user->group == 'admin'): ?>
				<li>
					<a class="tooltip-s" title="<?php echo lang('cp_manage_files'); ?>" href="<?php echo site_url('admin/files') ?>"><?php echo image('icons/files.png'); ?></a>
				</li>
				<?php endif; ?>
				
				<?php if(array_key_exists('users', $this->permissions) OR $this->current_user->group == 'admin'): ?>
				<li>
					<a class="tooltip-s" title="<?php echo lang('cp_manage_users'); ?>" href="<?php echo site_url('admin/users') ?>"><?php echo image('icons/users.png'); ?></a>
				</li>
				<?php endif; ?>
			</ul>
		</section>

	</div>		
	<?php endif; ?>
	-->
	<!-- End Quick Links -->

	<!-- Begin RSS Feed -->
	<?php if ( isset($rss_items) AND $theme_options->pyrocms_news_feed == 'yes') : ?>
	<div id="feed" class="one_full">
		
		<section class="draggable title">
			<h4><?php echo lang('cp_news_feed_title'); ?></h4>
			<a class="tooltip-s toggle" title="Toggle this element"></a>
		</section>
		
		<section class="item">	
			<ul>
				<!--
				<?php foreach($rss_items as $rss_item): ?>
				<li>
						
					<?php
						$item_date	= strtotime($rss_item->get_date());
						$item_month = date('M', $item_date);
						$item_day	= date('j', $item_date);
					?>
						
					<div class="date">
						<span class="month">
							<?php echo $item_month ?>
						</span>
						<span class="day">
							<?php echo $item_day; ?>
						</span>
					</div>
					
					<h4><?php echo anchor($rss_item->get_permalink(), $rss_item->get_title(), 'target="_blank"'); ?></h4>
											
					<p class='item_body'><?php echo $rss_item->get_description(); ?></p>
				</li>
				<?php endforeach; ?>
				-->
			</ul>
		</section>

	</div>		
	<?php endif; ?>
	<!-- End RSS Feed -->

</div>
<!-- End sortable div -->