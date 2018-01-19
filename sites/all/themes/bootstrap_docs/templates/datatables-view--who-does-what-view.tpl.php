<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script>
  $(document).ready(function(){

        //Prevent dropdowns from activating when you click text (for copy and paste)
        $('.copy').click(function(event){
          console.log('ay');
          event.stopPropagation();
        });

        //Activate dropdowns
        $('.dropdownclick').click(function(event){
          var id = $(this).attr('id');
          var iconid= '#' + 'icon' + id;
          var dropdown= $('#' + 'dropdown' + id);
          $(iconid).toggleClass("down");
          dropdown.slideToggle();
        });
    });
</script>
</head>
<?php
/**
 * @file
 * Template to display a datatable.
 *
 * - $title : The title of this group of rows.  May be empty.
 * - $header: An array of header labels keyed by field id.
 * - $fields: An array of CSS IDs to use for each field id.
 * - $classes: A class or classes to apply to the table, based on settings.
 * - $row_classes: An array of classes to apply to each row, indexed by row
 *   number. This matches the index in $rows.
 * - $rows: An array of row items. Each row is an array of content.
 *   $rows are keyed by row number, fields within rows are keyed by field ID.
 */
?>
<div class="container">

  <?php if (!empty($title)) : ?>
    <caption><?php print $title; ?></caption>
  <?php endif; ?>

<!-- Print column headers for search results -->
  <div class="row">
    <div class="col-xs-5ths"><h4>Service Offering</h4></div>
    <div class="col-xs-5ths"><h4>ITS Organization</h4></div>
    <div class="col-xs-5ths"><h4>Service Group</h4></div>
    <div class="col-xs-5ths"><h4>Service Owner</h4></div>
    <div class="col-xs-5ths"><h4>Primary Contact</h4></div>
  </div>

  <div class="panel-group">

      <!-- Loop over every returned Service Group -->
      <?php $id=1; ?>
      <?php foreach ($rows as $count => $row): ?>
      <div class="panel panel-default">
        <div id="<?php print $id; ?>" class="dropdownclick">
        <div class="panel-heading">

          <!-- Loop over each field in WDW -->
          <i class="fa fa-angle-right pull-right" id="icon<?php print $id; ?>"></i>
          <?php $i=0; ?>
          <?php foreach ($row as $field => $content): ?>
            <?php $i++; ?>
            <?php if ($i==1): ?>
            <?php print $content; ?>
            </div>      <!-- CLOSE COL -->
              </div>    <!-- CLOSE ROW -->
        </div>          <!-- CLOSE PANEL-HEADING -->
        </div>           <!-- CLOSE CLASS DROPDOWN CLICK -->

        <!-- OPEN INITIALLY HIDDEN PARTS OF THE PANEL -->
        <div id="dropdown<?php print $id; ?>" class="dropdown">
          <ul class="list-group">

            <?php endif; ?>

            <!-- PRINT DESCRIPTION AND I/E Indicator (i==2) + CONTACTS (i==3) -->
            <?php if(($i==2) || ($i==3)): ?>
              <?php print $content; ?>
            <?php endif; ?>
          <?php endforeach; ?>
          </ul>
        </div>
      </div>  <!-- CLOSE PANEL -->
        <?php $id++; ?>
      <?php endforeach; ?>
  </div>      <!-- CLOSE PANEL-GROUP -->
</div>        <!-- CLOSE CONTAINER -->
