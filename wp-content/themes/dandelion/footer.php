  <div id="footer-container">
  <?php if(get_opt('_widgetized_footer')!='off'){?>
    <div id="footer">
      <div id="footer-columns">
<?php 
print_footer_sidebar('footer-first', false);
print_footer_sidebar('footer-second', false);
//print_footer_sidebar('footer-third', false);
//print_footer_sidebar('footer-fourth', true);
?>
</div>
</div>
</div>
<?php } ?>
<div id="copyrights">
<h5 style="text-align:center;">&copy; Copyright <?php bloginfo('name'); ?> <?php echo date("Y"); ?> - <a href="/copyright-disclaimer/">Disclaimer</a> - <a href="/privacy-policy/">Privacy Policy</a> - <a href="http://bloompost.com/payments/">Payments Page</a></h5>
</div>
<!-- FOOTER ENDS -->
</div>
</div>
</div>
<?php wp_footer(); 
echo(get_opt('_analytics')); ?>
</body>
</html>
