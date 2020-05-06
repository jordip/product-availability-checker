<?php

/**
 * Define the helper functions.
 *
 * Loads and defines the helper functions.
 *
 * @since      1.0.0
 * @package    Pac
 * @subpackage Pac/includes
 * @author     Jordi Plana <hello@jordiplana.com>
 */

class Pac_Helper {

	/**
	 * Gets the content of a URL.
	 *
	 * @param string $url
	 * @return string $result
	 */
	public function get_url_content( $url ) {
		$cSession = curl_init();
		curl_setopt( $cSession, CURLOPT_URL, $url );
		curl_setopt( $cSession, CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $cSession, CURLOPT_HEADER, false );
		$result = curl_exec( $cSession );
		curl_close( $cSession );
		return $result;
	}

	public function get_amazon_asin( $content, $shortlink = false ) {
		$matches         = array();
		$link_regex      = '/<a.*href=".*amazon\..*?\/([A-Z0-9]{10})/';
		$shortlink_regex = '/<a.*href="(.*amzn\.(?:to|com)\/.*?)"/';
		if ( ! $shortlink ) {
			preg_match_all( $link_regex, $content, $matches, PREG_SET_ORDER );
		} else {
			preg_match_all( $shortlink_regex, $content, $shortlink_matches, PREG_SET_ORDER );
			foreach ( $shortlink_matches as $match ) {
				// Shortlinks needs to be unshortened.
				$content = $this->get_url_content( $match[1] );
				preg_match_all( $link_regex, $content, $link_matches, PREG_SET_ORDER );
				$matches = array_merge( $matches, $link_matches );
			}
		}

		return $matches;
	}
}
