<?php
// Basic site information.
$PageTitle="Setup Demo";
// Add tags for page header section
function customPageHeader(){?>
<?php }
include_once(PROJECT_ROOT . '/application/views/_templates/header.php');
?>
<!-- Start of page body ----------------------------------------->
<h1>eBay API Demo</h1>
    <!-- main content output -->
    <div>
    </div>
<!-- End of page body ------------------------------------------>
<?php
// Add tags for page footer 
function customPageFooter() { ?>
<!-- Custom JavaScript for this site -->
<script>
</script>
<?php }
include_once(PROJECT_ROOT . '/application/views/_templates/footer.php');
?>