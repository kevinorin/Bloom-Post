<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes() ?>>
<head>
<meta http-equiv="Content-Type"
	content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<title>
<?php wp_title(''); ?>
</title>

<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS" href="<?php bloginfo('rss2_url'); ?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/prettyPhoto.css" type="text/css" media="screen" charset="utf-8" />
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/nivo-slider.css" type="text/css" media="screen" charset="utf-8" />
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/superfish.css" type="text/css" media="screen" charset="utf-8" />
<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/cssLoader.php" type="text/css" media="screen" charset="utf-8" />
<?php if(get_opt('_favicon')){ ?>
<link rel="shortcut icon" type="image/x-icon" href="<?php echo get_opt('_favicon'); ?>" />
<?php } ?>

<!--Google fonts-->
<?php if(get_opt('_enable_google_fonts')!='off'){
$fonts=pexeto_get_google_fonts();
foreach($fonts as $font){
	?>
<link href='<?php echo $font; ?>' rel='stylesheet' type='text/css' />
<?php }
}
?>
	
<?php wp_enqueue_script("jquery"); ?>
<?php wp_head(); ?>

<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/script/jquery.prettyPhoto.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/script/jquery.tools.min.js"></script> 
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/script/script.js"></script>

<?php 
$enable_cufon=get_opt('_enable_cufon');
if($enable_cufon=='on'){
if(get_opt('_custom_cufon_font')!=''){
	$font_file=get_opt('_custom_cufon_font');
}else{
	$font_file=get_template_directory_uri().'/script/fonts/'.get_opt('_cufon_font');
}
?>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/script/cufon-yui.js"></script>
<script type="text/javascript" src="<?php echo $font_file; ?>"></script>
<?php 
}

?>

<script type="text/javascript">
pexetoSite.enableCufon="<?php echo $enable_cufon; ?>";
pexetoSite.ajaxurl="<?php echo admin_url('admin-ajax.php'); ?>";
pexetoSite.lightboxOptions = <?php echo json_encode(pexeto_get_lightbox_options()); ?>;
jQuery(document).ready(function($){
	pexetoSite.initSite();
});
</script>

<?php if (is_page_template('template-portfolio.php')) { 
//load the scripts for the portfolio template
	?>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/script/portfolio-previewer.js"></script>

<?php } ?>

<?php if (is_page_template('template-portfolio-gallery.php')) { 
//load the scripts for the portfolio gallery template
	?>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/script/portfolio-setter.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/script/jquery-easing.js"></script>
<?php } ?>
	
<?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?>
<!-- enables nested comments in WP 2.7 -->


<!--[if lte IE 6]>
<link href="<?php echo get_template_directory_uri(); ?>/css/style_ie6.css" rel="stylesheet" type="text/css" /> 
 <input type="hidden" value="<?php echo get_template_directory_uri(); ?>" id="baseurl" /> 
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/script/supersleight.js"></script>
<![endif]-->

<!--[if IE 7]>
<link href="<?php echo get_template_directory_uri(); ?>/css/style_ie7.css" rel="stylesheet" type="text/css" />  
<![endif]-->


<?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?>

</head>
<?php $bodyclass=$enable_cufon=='on'?'class="cufon"':'';?>
<body <?php echo $bodyclass; ?>>
<div id="main-container">

<div class="center">
<div id="site">
  <div id="header" >
  <div id="logo-container"><a href="<?php echo home_url(); ?>"><img src="<?php echo get_template_directory_uri(); ?>/images/header.jpg" height="100" width="390" alt="Bloom Post" /></a></div>
  
  <div id="header-top">
   
	
	
	
<div id="menu-container">
      <div id="menu">
<?php wp_nav_menu(array('theme_location' => 'pexeto_main_menu' )); ?>
	<!--<span class="fb-like-menu">          <script>function fb_like() {
	          url=location.href;
	          title=document.title;
	          window.open('http://www.facebook.com/sharer.php?u='+encodeURIComponent(url)+'&t='+encodeURIComponent(title),'sharer','toolbar=0,status=0,width=626,height=436');
	          return false;}</script>
				<a href="http://www.facebook.com/share.php?u=http://bloompost.com" onclick="return fb_like()" target="_blank">
					<img src="http://dreamgrowers.net/bloompost.com/wp-content/uploads/bloom-fb-share.png" alt="" title="bloom-fb-small" width="100" height="52" class="alignright size-full wp-image-543" />
				</a>
	</span>-->
	
	

 </div>
     </div>
	 <iframe src="//www.facebook.com/plugins/like.php?href=http%3A%2F%2Fwww.facebook.com%2FBloomPostHealing&amp;send=false&amp;layout=button_count&amp;width=100&amp;show_faces=false&amp;font=arial&amp;colorscheme=light&amp;action=like&amp;height=21&amp;appId=10150095312700523&amp;ref=top_right" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:100px; height:21px;" class="fb-like-menu" id="fb-like-iframe" allowTransparency="true"></iframe>
    </div>