<?php 
$gist_data = get_gist_data($meta['gist-id'][0]);

?>
<span class="gist-wrapper">
	<?php echo $the_content; ?>
	<?php if(isset($gist_data['html_url'])) { ?>
		<a class="button git-link" href="<?php echo $gist_data['html_url']; ?>" target="_blank">
			<span class="fa-icon fa-icon-button fa-icon-github"></span><?php _e('View Full Code on GitHub'); ?>
		</a>
	<?php } ?>
</span>