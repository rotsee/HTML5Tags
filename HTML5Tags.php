<?php
/**
 * Extension HTML5Tags - llows some extra HTML5 tags in wiki code
 * @version 0.1 - 2012/10/27
 *
 * @link http://www.mediawiki.org/wiki/Extension:HTML5Tags Documentation
 *
 * @file HTML5Tags.php
 * @ingroup Extensions
 * @package MediaWiki
 * @author Leo Wallentin (Rotsee)
 * @license http://www.opensource.org/licenses/BSD-2-Clause BSD
 */

/* Set up extension */
if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not an entry point.' );
}

if ( version_compare( $wgVersion, '1.18', '<' ) ) {
	die( '<b>Error:</b> This version of HTML5Tags requires MediaWiki 1.18 or above.' );
}

define( 'HTML5TAGS_VERSION', '0.1' );

$wgExtensionCredits['parserhook'][] = array(
        'path' => __FILE__,
        'name' => 'HTML5 Tags',
        'description' => 'html5tags-desc',
        'version' => HTML5TAGS_VERSION, 
        'author' => array( '[http://xn--ssongsmat-v2a.nu Leo Wallentin]', ),
        'url' => "http://www.mediawiki.org/wiki/Extension:HTML5Tags",
);

$dir = dirname( __FILE__ ) . '/';

/**
 * Message class  
 */ 
$wgExtensionMessagesFiles['HTML5Tags' ] = $dir . 'HTML5Tags.i18n.php';

$wgAutoloadClasses[ 'HTML5Tags' ] = $dir . 'HTML5Tags.body.php';
 
# Define a setup function
$wgHooks['ParserFirstCallInit'][] = 'wfHTML5TagsParserInit';
 
function wfHTML5TagsParserInit ( $parser ) {

	HTML5Tags::setHooks( $parser );
	return true;

}
