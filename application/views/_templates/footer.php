</main>
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
<!-- our JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/fuse.js/3.2.0/fuse.min.js"></script>
<script src="<?php echo SITE_BASE . 'js/bootstrap-select-dropdown.min.js">';?></script>
<script>var siteBase='<?php echo SITE_LINK;?>';</script>
<script type="text/javascript" src="<?php echo SITE_BASE; ?>js/application.js"></script>
<?php if (function_exists('customPageFooter')){
    // If a single page needs some javascript or other functionality
    // not needed on all pages, include it in the function customPageFooter
    // on that page. 
          customPageFooter();
      }
?>
</body>
</html>