<?php
/**
 * Popup Settings param
 *
 * @package     Wow_Plugin
 * @copyright   Copyright (c) 2018, Dmytro Lobov
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0
 */

// Popup Title
$popuptitle = array (
	'name' => 'param[popuptitle]',
	'id'   => 'popuptitle',
	'type' => 'text',
	'val'  => isset( $param['popuptitle'] ) ? $param['popuptitle'] : '',
);

// Popup Title help
$popuptitle_help = array (
  'text' => __('Enter the title fo popup.', $this->text_domain),
);

// Popup Content
$popupcontent = array(
  'name' => 'param[popupcontent]',
  'id'   => 'popupcontent',
  'type' => 'editor',
  'val'  => isset( $param[ 'popupcontent' ] ) ? $param[ 'popupcontent' ] : '',
);

// Popup Content help
$popupcontent_help = array (
  'text' => __('Enter Popup content.', $this->text_domain),
);