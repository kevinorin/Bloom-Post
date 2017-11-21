<?php
/*
 Template Name: Home page
 */

get_header();

if(have_posts()){
	while(have_posts()){
		the_post();
		$title=get_the_title();
		$pageId=get_the_ID();
		$subtitle=get_post_meta($pageId, 'subtitle_value', true);
		$slider=get_post_meta($pageId, 'slider_value', true);	
		$slider_prefix=get_post_meta($post->ID, 'slider_name_value', true);
		if($slider_prefix=='default'){
			$slider_prefix='';
		} 

		//include(TEMPLATEPATH . '/includes/page-header.php');
		$layoutclass='';
		if($layout=='left'){
			$layoutclass='sidebar-to-left';
		}

		$content_id='content';
		if($layout=='full'){
			$content_id='full-width';
		}
		
		
?>

<div id="slider-container">
<div id="slider-container-shadow"></div>
<div id="static-header-img">

<?php if(is_page()){ 
	if(function_exists('has_post_thumbnail') && has_post_thumbnail()){ ?>
 <?php the_post_thumbnail('static-header-img'); ?>
<?php } 
 }else{ ?>
<img src="<?php echo $static_image; ?>"/>
<?php } ?>
<div id="header-image-link"><img src="<?php bloginfo('template_directory'); ?>/images/Bloom_centered_03.jpg" id="header-image-text" /><a id="header-button" href="<?php get_site_url(); ?>/services/"><img src="<?php bloginfo('template_directory'); ?>/images/Bloom_centered_07.jpg" /></a></div>
</div>
</div>
</div>

<div id="content-container" class="content-gradient">
  <!--<div id="full-width">-->
	<div class="two-columns1">
	   <!--content-->
		<?php 
			the_content();
			}
		}
		?>   
	</div>

    <div class="two-columns2">
<?php 
for($i=1; $i<=3; $i++){
	$suf=$i==3?'-3':'';
	?>
	 <div class="services-box right-column">
	<!--<h4><a href="<?php echo get_opt('_home_box_btn_link'.$i); ?>" ><?php echo get_opt('_home_box_title'.$i); ?></a></h4>-->
	 <?php if(get_opt('_home_box_icon'.$i)!=''){ ?>
		<a href="<?php echo get_opt('_home_box_btn_link'.$i); ?>" ><img src="<?php echo get_opt('_home_box_icon'.$i); ?>" class="img-frame" /></a>
		
		<a class="home_box_hover" href="<?php echo get_opt('_home_box_btn_link'.$i); ?>" ><span class="desc"><?php echo get_opt('_home_box_desc'.$i); ?>
		<?php if(trim(get_opt('_home_box_btn_text'.$i))!=''){ ?>
        <?php echo get_opt('_home_box_btn_text'.$i); ?><span class="more-arrow">&raquo;</span>
        <?php } ?>
		</span></a>
     <?php } ?>
         <!--<?php echo get_opt('_home_box_desc'.$i); ?>
         <?php if(trim(get_opt('_home_box_btn_text'.$i))!=''){ ?>
        <a href="<?php echo get_opt('_home_box_btn_link'.$i); ?>" ><?php echo get_opt('_home_box_btn_text'.$i); ?><span class="more-arrow">&raquo;</span></a>
        <?php } ?>-->
         </div>
<?php }
?>
</div>
<!--</div>-->
<div class="clear"></div>
</div>
<?php
get_footer();
?>