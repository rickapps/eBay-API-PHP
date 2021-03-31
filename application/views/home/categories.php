<?php
// Demonstrate use of eBay Category Search.
$PageTitle="eBay Categories";
// Add tags for page header section
function customPageHeader(){?>
<?php }
include_once(PROJECT_ROOT . '/application/views/_templates/header.php');
include_once(PROJECT_ROOT . '/application/views/catModal.php'); 
?>
<!-- Start of page body ----------------------------------------->
<h1>Search eBay Categories</h1>
    <!-- main content output -->
    <div>
    <button type="button" class="btn btn-sm btn-light float-right" data-toggle="modal" data-target="#categoryModal">New</button>
     </div>
<!-- End of page body ------------------------------------------>
<?php
// Add tags for page footer 
function customPageFooter() { ?>
<!-- Custom JavaScript for this site -->
<!-- Code for category search modal -->
<script type="text/javascript" src="<?php echo SITE_URL; ?>js/catModal.js"></script>
<?php }
include_once(PROJECT_ROOT . '/application/views/_templates/footer.php');
?>