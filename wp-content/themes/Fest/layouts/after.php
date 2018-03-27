<?php 
	
	/**
	 *
	 * Template elements after the page content
	 *
	 **/
	
	// create an access to the template main object
	global $tpl;
	
	// disable direct access to the file	
	defined('GAVERN_WP') or die('Access denied');
	
?>
		
				<?php if(gk_is_active_sidebar('mainbody_bottom')) : ?>
				<div id="gk-mainbody-bottom">
					<?php gk_dynamic_sidebar('mainbody_bottom'); ?>
				</div>
				<?php endif; ?>
			</section><!-- end of the mainbody div -->
		
			<?php 
			if(
				get_option($tpl->name . '_page_layout', 'right') != 'none' && 
				gk_is_active_sidebar('sidebar') && 
				(
					$args == null || 
					($args != null && $args['sidebar'] == true)
				)
			) : ?>
			<?php do_action('gavernwp_before_column'); ?>
			<aside id="gk-sidebar">
				<?php gk_dynamic_sidebar('sidebar'); ?>
			</aside>
			<?php do_action('gavernwp_after_column'); ?>
			<?php endif; ?>
		</div><!-- end of the #gk-mainbody-columns -->
		
		<?php if(gk_is_active_sidebar('bottom1')) : ?>
		<div id="gk-bottom1" class="gk-page widget-area">
			<div>
				<?php gk_dynamic_sidebar('bottom1'); ?>
			</div>
		</div>
		<?php endif; ?>
	</div><!-- end of the .gk-page div -->
	
	<!--[if lt IE 9]>
	<div class="ie-clear"></div>
	<![endif]-->
</div><!-- end of the .gk-page-wrap div -->	

<?php if(gk_is_active_sidebar('sponsors')) : ?>
<div id="gk-sponsors">
	<div class="gk-page widget-area">
		<?php gk_dynamic_sidebar('sponsors'); ?>
	</div>
</div>
<?php endif; ?>

<div id="gk-bottom-wrap">
	<?php if(gk_is_active_sidebar('bottom2')) : ?>
	<div id="gk-bottom2" class="gk-page widget-area">
		<div>
			<?php gk_dynamic_sidebar('bottom2'); ?>
		</div>
	</div>
	<?php endif; ?>
	
	<?php if(gk_is_active_sidebar('bottom3')) : ?>
	<div id="gk-bottom3" class="gk-page widget-area">
		<div>
			<?php gk_dynamic_sidebar('bottom3'); ?>
		</div>
	</div>
	<?php endif; ?>