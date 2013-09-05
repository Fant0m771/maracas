<?php

/**
 * @file
 * Template to display a view as a table.
 *
 * - $title : The title of this group of rows.  May be empty.
 * - $header: An array of header labels keyed by field id.
 * - $header_classes: An array of header classes keyed by field id.
 * - $fields: An array of CSS IDs to use for each field id.
 * - $classes: A class or classes to apply to the table, based on settings.
 * - $row_classes: An array of classes to apply to each row, indexed by row
 *   number. This matches the index in $rows.
 * - $rows: An array of row items. Each row is an array of content.
 *   $rows are keyed by row number, fields within rows are keyed by field ID.
 * - $field_classes: An array of classes to apply to each field, indexed by
 *   field id, then row number. This matches the index in $rows.
 * @ingroup views_templates
 */
?>
<?php
       $i = 0;
       foreach ($rows as $row_count => $row): ?>
       <div class="view_block_last_advice <?php print ($i % 2 == 0) ? "even" : "odd" ?>">
         <div class="view_block_last_advice_title">
           <?php print $row['title']; ?>
         </div>
            <div class="last_advice_block_pop_up">
              <div class="advice_wrapper_pop_up">
                <span class="body_content">
                  <?php print $row['body']; ?>
                    <?php //print $row['view_node']; ?>
                    <div class="view_block_advice_attr">
                       <span class="view_block_advice_date"><?php print $row['created']; ?></span><span class="view_block_counter_advice_comment"><?php //print $row['comment_count']; ?></span>
                    </div>
                </span>
                </div> 
                <div class="view_block_last_advice_border"></div>          
            </div>
           
       </div> 
       <?php $i++; ?>
<?php endforeach; ?>