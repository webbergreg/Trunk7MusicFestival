<?php 
	
	/**
	 *
	 * Template elements before the page content
	 *
	 **/
	
	// create an access to the template main object
	global $tpl;
	
	// disable direct access to the file	
	defined('GAVERN_WP') or die('Access denied');
	
?>

<div class="gk-page-wrap<?php if(gk_is_active_sidebar('speakers')) : ?> gk-speakers-exist<?php endif; ?>">
	<?php if(gk_is_active_sidebar('speakers')) : ?>
	<div id="gk-speakers">
		<div class="gk-page widget-area">
			<?php gk_dynamic_sidebar('speakers'); ?>
		</div>
	</div>
	<?php endif; ?>
	
	<?php if(gk_show_breadcrumbs()) : ?>
	<section id="gk-breadcrumbs">
		<div class="gk-page">
			<?php gk_breadcrumbs_output(); ?>
		</div>
	</section>
	<?php endif; ?>
	
	<div class="gk-page">
		<?php if(gk_is_active_sidebar('top1')) : ?>
		<div id="gk-top1">
			<div class="gk-page widget-area">
				<?php gk_dynamic_sidebar('top1'); ?>
			</div>
		</div>
		<?php endif; ?>
		
		<?php if(gk_is_active_sidebar('top2')) : ?>
		<div id="gk-top2">
			<div class="gk-page widget-area">
				<?php gk_dynamic_sidebar('top2'); ?>
			</div>
		</div>
		<?php endif; ?>
	
		<div id="gk-mainbody-columns" <?php if(get_option($tpl->name . '_page_layout', 'right') == 'left') : ?> class="gk-column-left"<?php endif; ?>>
			
			<section>
				<?php if(gk_is_active_sidebar('mainbody_top')) : ?>
				<div id="gk-mainbody-top">
					<?php gk_dynamic_sidebar('mainbody_top'); ?>
				</div>
				<?php endif; ?>
					