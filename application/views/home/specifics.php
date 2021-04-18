<?php
// Demonstrate eBay Item Specifics.
$PageTitle="Item Specifics";
// Add tags for page header section
function customPageHeader(){?>
<?php }
include_once(PROJECT_ROOT . '/application/views/_templates/header.php');
include_once(PROJECT_ROOT . '/application/views/specificsModal.php'); 
?>
<!-- Start of page body ----------------------------------------->
<h1>eBay Item Specifics</h1>
    <!-- main content output -->
    <div>
    <p>Demo of API call get_item_aspects_for_category.<br><a 
     href='https://developer.ebay.com/api-docs/commerce/taxonomy/resources/methods' 
     target="_blank" rel="noopener noreferrer">Documentation</a>
     </p>
     </div>
     <div class="text-center">
    <button type="button" class="btn btn-md btn-primary" data-toggle="modal" data-target="#itemSpecifics">Specifics</button>
    </div>
<!-- End of page body ------------------------------------------>
<?php
// Add tags for page footer 
function customPageFooter() { ?>
<!-- Custom JavaScript for this site -->
<script>
$(document).ready(function() {
    // Item specifics modal is opening
    $('#itemSpecifics').on('show.bs.modal', function (e) {
        var category = $('#CategoryID');
        var item = $('#RID');
        $('#itemSpecifics .modal-body').load('/process/loadSpecifics/' + item.val() + '/' + category.val(), function() {
            $('#specMaster').trigger('change');
        });
    });
});
</script>
<?php }
include_once(PROJECT_ROOT . '/application/views/_templates/footer.php');
?>