<?php
/**
 * Specials
 * 
 * BOOTSTRAP v1.0.BETA
 *
 * @package page
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: header_php.php 3000 2006-02-09 21:11:37Z wilt $
 *
 * zca_responsive_default BASE
 *
 */

require(DIR_WS_MODULES . zen_get_module_directory('require_languages.php'));

$define_page = zen_get_file_directory(DIR_WS_LANGUAGES . $_SESSION['language'] . '/html_includes/', FILENAME_DEFINE_SPECIALS, 'false');

$breadcrumb->add(NAVBAR_TITLE);

// display order dropdown
  $disp_order_default = PRODUCT_SPECIAL_LIST_SORT_DEFAULT;

  require(DIR_WS_MODULES . zen_get_module_directory(FILENAME_LISTING_DISPLAY_ORDER));

	$listing_sql = "SELECT p.products_id, p.products_type, pd.products_name, p.products_image, p.products_price, p.products_tax_class_id, p.products_date_added, p.products_model, p.products_quantity, p.products_weight, p.product_is_call,
                                  p.product_is_always_free_shipping, p.products_qty_box_status,
                                  p.master_categories_id

                         FROM (" . TABLE_PRODUCTS . " p
                         LEFT JOIN " . TABLE_SPECIALS . " s on p.products_id = s.products_id
                         LEFT JOIN " . TABLE_PRODUCTS_DESCRIPTION . " pd on p.products_id = pd.products_id )
                         WHERE p.products_id = s.products_id 
                         AND p.products_id = pd.products_id and p.products_status = '1'
                         AND s.status = 1
                         AND pd.language_id = :languageID " . $order_by;

$listing_sql = $db->bindVars($listing_sql, ':languageID', $_SESSION['languages_id'], 'integer');

//check to see if we are in normal mode ... not showcase, not maintenance, etc
$show_submit = zen_run_normal();
$define_list = array('PRODUCT_LIST_MODEL' => PRODUCT_LIST_MODEL,
'PRODUCT_LIST_NAME' => PRODUCT_LIST_NAME,
'PRODUCT_LIST_MANUFACTURER' => PRODUCT_LIST_MANUFACTURER,
'PRODUCT_LIST_PRICE' => PRODUCT_LIST_PRICE,
'PRODUCT_LIST_QUANTITY' => PRODUCT_LIST_QUANTITY,
'PRODUCT_LIST_WEIGHT' => PRODUCT_LIST_WEIGHT,
'PRODUCT_LIST_IMAGE' => PRODUCT_LIST_IMAGE);

asort($define_list);
reset($define_list);
$column_list = array();
foreach ($define_list as $key => $value)
{
	if ($value > 0) $column_list[] = $key;
}
?>