<?php
use WPDM\__\__;
use function WPDM\AddOn\wpdm_acf;

if (!defined('ABSPATH')) die();
__::push($params, 'items_per_page', 20);
$items_per_page = __::valueof($params, 'items_per_page', 20, 'int');
$cols = __::valueof($params, 'cols', ['default' => 'page_link,file_count,download_count|categories|update_date|download_link'], 'txt'); // isset($params['cols']) ? __::sanitize_var($params['cols'], 'safetxt') : 'page_link,file_count,download_count|categories|update_date|download_link';
$colheads = __::valueof($params, 'colheads', ['default' => 'Title|Categories|Download'], 'txt');
$cols = __::explodes("|", $cols);
$colheads = explode("|", $colheads);
foreach ($cols as $index => &$col) {
	$col = explode(",", $col);
	$colheads[$index] = !isset($colheads[$index]) ? esc_attr($col[0]) : esc_attr($colheads[$index]);
}

$column_positions = array();

$table_id = __::sanitize_var($table_id, 'alphanum');

//$coltemplate['title'] = $coltemplate['post_title'] = "%the_title%";
$coltemplate['page_link'] = "<a class=\"package-title\" href=\"%s\">%s</a>";
$t = time();
$process = [];
if ($jstable === 1) {
	$_cols = explode("|", wpdm_valueof($params, 'cols', ['default' => '']));
	$datatable_col = (isset($params['order_by']) && $params['order_by'] == 'title') ? 0 : array_search(wpdm_valueof($params, 'order_by'), $_cols);
	if (!$datatable_col || $datatable_col < 0) $datatable_col = 0;
	$datatable_order = (isset($params['order']) && $params['order'] == 'DESC') ? 'desc' : 'asc';

	?>
    <script src="<?php echo WPDM_BASE_URL . 'assets/js/jquery.dataTables.min.js' ?>"></script>
    <script src="<?php echo WPDM_BASE_URL . 'assets/js/dataTables.bootstrap4.min.js' ?>"></script>
    <link href="<?php echo WPDM_BASE_URL . 'assets/css/jquery.dataTables.min.css' ?>" rel="stylesheet"/>

    <script>
       
		/**shital script start here */
		
			
			
			jQuery("document").ready(function () {

      jQuery("#filterTable").dataTable({
        "searching": true
      });

      //Get a reference to the new datatable
      var table = jQuery('#filterTable').DataTable();

      //Take the category filter drop down and append it to the datatables_filter div. 
      //You can use this same idea to move the filter anywhere withing the datatable that you want.
      jQuery("#filterTable_filter.dataTables_filter").append(jQuery("#categoryFilter"));
      
      //Get the column index for the Category column to be used in the method below ($.fn.dataTable.ext.search.push)
      //This tells datatables what column to filter on when a user selects a value from the dropdown.
      //It's important that the text used here (Category) is the same for used in the header of the column to filter
      var categoryIndex = 0;
      jQuery("#filterTable th").each(function (i) {
        if (jQuery(jQuery(this)).html() == "Category") {
          categoryIndex = i; return false;
        }
      });

      //Use the built in datatables API to filter the existing rows by the Category column
      jQuery.fn.dataTable.ext.search.push(
        function (settings, data, dataIndex) {
          var selectedItem = jQuery('#categoryFilter').val()
          var category = data[categoryIndex];
          if (selectedItem === "" || category.includes(selectedItem)) {
            return true;
          }
          return false;
        }
      );

      //Set the change event for the Category Filter dropdown to redraw the datatable each time
      //a user selects a new filter.
      jQuery("#categoryFilter").change(function (e) {
        table.draw();
      });

      table.draw();
    });
	

		/**shital script end here */

    </script>
<?php } ?>
<style>
    .wpdmdt-toolbar {
        padding: 10px;
    }

    .wpdmdt-toolbarb {
        padding: 5px 10px 10px;
    }

    .wpdmdt-toolbar > div {
        display: inline-block;
    }

    table, td, th {
        border: 0;
    }

    #wpdm-all-packages .card {
        overflow: hidden;
    }

    .dataTables_wrapper .table {
        margin: 0;
    }

    #filterTable {
        border-bottom: 1px solid #dddddd;
        border-top: 1px solid #dddddd;
        font-size: 10pt;
        min-width: 100%;
    }

    #filterTable .wpdm-download-link img {
        box-shadow: none !important;
        max-width: 100%;
    }

    .w3eden .pagination {
        margin: 0 !important;
    }

    #filterTable td:not(:first-child) {
        vertical-align: middle !important;
    }

    #filterTable td.__dt_col_download_link .btn {
        display: block;
        width: 100%;
    }

    #filterTable td.__dt_col_download_link,
    #filterTable th#download_link {
        max-width: 155px !important;
        width: 155px;

    }

    #filterTable th {
        background-color: rgba(0, 0, 0, 0.04);
        border-bottom: 1px solid rgba(0, 0, 0, 0.025);
    }

    #filterTable_length label,
    #filterTable_filter label {
        font-weight: 400;
    }

    #filterTable_filter input[type=search] {
        display: inline-block;
        width: 200px;
        font-size: 12px;
    }

    #filterTable_length select {
        display: inline-block;
        width: 60px;
        font-size: 11px;
    }

    #filterTable .package-title {
        color: #36597C;
        font-size: 11pt;
        font-weight: 700;
    }

    #filterTable .small-txt {
        margin-right: 7px;
    }

    #filterTable td.__dt_col_categories {
        max-width: 300px;
    }

    #filterTable .small-txt,
    #filterTable small {
        font-size: 9pt;
    }

    .w3eden .table-striped tbody tr:nth-of-type(2n+1) {
        background-color: rgba(0, 0, 0, 0.015);
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button:active,
    .dataTables_wrapper .dataTables_paginate .paginate_button:focus,
    .dataTables_wrapper .dataTables_paginate .paginate_button:hover,
    .dataTables_wrapper .dataTables_paginate .paginate_button {
        margin: 0 !important;
        padding: 0 !important;
        border: 0 !important;
        background: transparent !important;
    }

    .paginate_button.page-item.active a {
        background: var(--color-primary) !important;
        color: #fff !important;
    }
#filterTable .wpdm-download-link.btn.btn-primary {
  width: 119px;
}

    @media (max-width: 799px) {
        #filterTable tr {
            display: block;
            border: 3px solid rgba(0, 0, 0, 0.3) !important;
            margin-bottom: 10px !important;
            position: relative;
        }

        #filterTable thead {
            display: none;
        }

        #filterTable,
        #filterTable td:first-child {
            border: 0 !important;
        }

        #filterTable td {
            display: block;
        }

        #filterTable td.__dt_col_download_link {
            display: block;
            max-width: 100% !important;
            width: auto !important;

        }
    }


</style>
<div class="w3eden">
    <div id="wpdm-all-packages">
    
   
<?php 
if ( is_user_logged_in() ) { 
 // echo 'Username: ' . $current_user->user_login . "\n";  wpdm_logout_url
 ?>
 
 <a class="udb-item" href="<?php echo wp_logout_url(); ?>"><i class="m-icon fas fa-sign-out-alt color-danger mr-3"></i><span class="color-red"><?php _e('Logout', 'wmdpro'); ?></span></a>
 
<?php /*?> <a class="udb-item" href="<?php echo wpdm_logout_url(home_url( '/library/' )); ?>"><i class="m-icon fas fa-sign-out-alt color-danger mr-3"></i><span class="color-red"><?php _e('Logout', 'wmdpro'); ?></span></a><?php */?>
 
 
  <?php
}
?>

<div class="category-filter">
<?php 


$terms =  get_terms( array( 
    'taxonomy' => 'wpdmcategory',
    'orderby' => 'name',
	'order' => 'ASC',
	'hide_empty' => true, //can be 1, '1' too
));
	 
	 $count = count($terms);
	 if ( $count > 0 ){
		 ?>
<select id="categoryFilter" class="form-control">
   <option value="">Select Category</option>
     <?php
      foreach  ($terms as $term) {
       echo '<option value="'.$term->name.'">'.$term->name.'</option> ';
      }
    ?>
      </select>
      
      <?php
      }
	  ?>
    </div>
   

    <!-- Set up the datatable -->
    
    
    <table class="table" id="filterTable">
      <thead>
        <tr>
          <th scope="col">Image</th>
          <th scope="col">Title</th>
          <th scope="col">Category</th>
          <th scope="col">Download</th>
        </tr>
      </thead>
      <tbody>
      
      <?php
      $cfurl = get_permalink();

			$query_params = ["post_type" => "wpdmpro", "posts_per_page" => $items, "offset" => $offset];
			if (isset($tax_query)) $query_params['tax_query'] = $tax_query;
			$query_params['orderby'] = (isset($params['order_by'])) ? $params['order_by'] : 'date';

			$order_field = isset($params['order_by']) ? $params['order_by'] : 'date';
			$order = isset($params['order']) ? $params['order'] : 'DESC';

			$order_fields = array('__wpdm_download_count', '__wpdm_view_count', '__wpdm_package_size_b');
			if (!in_array("__wpdm_" . $order_field, $order_fields)) {
				$query_params['orderby'] = $order_field;
				$query_params['order'] = $order;
			} else {
				$query_params['orderby'] = 'meta_value_num';
				$query_params['meta_key'] = "__wpdm_" . $order_field;
				$query_params['order'] = $order;
			}

			if (is_array(wpdm_query_var('tax'))) {
				foreach (wpdm_query_var('tax') as $tax => $term) {
					$query_params['tax_query'][] = [
						'taxonomy' => $tax,
						'field' => 'slug',
						'terms' => [$term]
					];
					$query_params['tax_query']['relation'] = 'AND';
				}
			}
			$taxonomies = get_object_taxonomies('wpdmpro');
			//wpdmprecho($query_params);
			$q = new WP_Query($query_params);
			$total_files = $q->found_posts;
			
			while ($q->have_posts()): $q->the_post();
				$ext = "unknown";
				$data = [];// WPDM()->package->prepare(get_the_ID(), $template, "link")->packageData;
				global $post;
				$data += (array)$post;
				$data['id'] = $data['ID'];
				$data['files'] = WPDM()->package->getFiles(get_the_ID());
                //wpdmdd($data);
				
				$data['author'] = get_the_author_meta('display_name', $data['post_author']);
				if (isset($data['files']) && count($data['files'])) {
					if (count($data['files']) == 1) {
						$tmpavar = $data['files'];
						$ffile = $tmpvar = array_shift($tmpavar);
						$tmpvar = explode(".", $tmpvar);
						$ext = count($tmpvar) > 1 ? end($tmpvar) : $ext;
					} else
						$ext = 'zip';
				} else $data['files'] = array();

				foreach ($taxonomies as $taxonomy) {
					$terms = wp_get_post_terms(get_the_ID(), $taxonomy);
					$_terms = array();
					foreach ($terms as $term) {
						$lurl = add_query_arg(['tax' => [$taxonomy => $term->slug]], $cfurl);
						//$_terms[] = "<a class='sbyc' href='{$lurl}'>{$term->name}</a>";
						$_terms[] = $term->name;
					}
					$_terms = @implode(", ", $_terms);
					$data[$taxonomy] = $_terms;
				}


				if ($ext == '') $ext = 'unknown';

				$ext = \WPDM\__\FileSystem::fileTypeIcon($ext);

				if (isset($data['icon']) && $data['icon'] !== '') $ext = $data['icon'];

				if (isset($params['thumb']) && (int)$params['thumb'] == 1) $ext = wpdm_thumb($post, array(96, 104), 'url');

				
				
				$data['download_url'] = '';
				$data['download_link'] = WPDM()->package->downloadLink($data['ID'], 0, ['template_type' => 'link']);
				//$data = apply_filters("wpdm_after_prepare_package_data", $data);
				//$download_link = htmlspecialchars_decode($data['download_link']);
				$download_link = $data['download_link'];
				if (function_exists('wpdmpp_effective_price') && wpdmpp_effective_price($data['ID']) > 0)
					$download_link = wpdmpp_waytocart($data, 'btn-primary');
				?>
				<tr>
                 <td scope="col"><img src="<?php echo $ext; ?>" height="104" width="96"/></td>
          <td scope="col"><strong><?php echo  esc_attr($data['post_title']);?></strong><br /><?php echo  esc_attr($data['post_content']);?></td>
          <td scope="col"><?php echo $data['wpdmcategory'];?></td>
           <td scope="col"><?php echo $download_link ? $download_link : '<button type="button" disabled="disabled" class="btn btn-danger btn-block">' . __("Download", "download-manager") . '</button>'?></td>
        </tr>
				<?php

			 endwhile; 
			
	  ?>

      </tbody>
    </table>
		<?php
		wp_reset_query();
		?>

    </div>
</div>
