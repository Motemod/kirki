<?php
/**
 * Retrieve colors from the Colourlovers API.
 *
 * @package     Kirki
 * @category    Addon
 * @author      Aristeides Stathopoulos
 * @copyright   Copyright (c) 2015, Aristeides Stathopoulos
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Kirki_Colourlovers {

	public static function get_palettes( $palettes_nr = 5, $order_by = 'none', $xml = '' ) {

		$palettes = self::parse();
		$palettes = array_slice( $palettes, 0, $palettes_nr );

		foreach( $palettes as $palette ) {
			foreach ( $palette as $key => $value ) {
				$palettes[ $key ] = Kirki_Color::sanitize_hex( $value );
			}
		}

		return $palettes;

	}

	/**
	 * @param string|null $xml
	 */
	public static function parse( $xml = null ) {

		// XML copied from http://www.colourlovers.com/api/palettes/top?numResults=100
		$xml_url  = ( is_null( $xml ) ) ? trailingslashit( kirki_url() ).'assets/xml/colourlovers-top.xml' : $xml;
		$feed_xml = simplexml_load_file( $xml_url );
		$palettes = array();

		foreach ( $feed_xml->palette as $result ) {
			$palettes[] = (array) $result->colors->hex;
		}

		return $palettes;

	}

}
