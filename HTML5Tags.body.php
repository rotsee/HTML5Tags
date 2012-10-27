<?php
/**
 * Helper class for implementing core functionality 
 *
 * @author Leo Wallentin
 */

class HTML5Tags {

	/* Sets all hooks on ParserFirstCallInit 
	    TODO: Should probably check for each and everyone that they are not already set */
	public function setHooks ( $parser ) {
		$parser->setHook( 'article', array( 'HTML5Tags', 'tagArticle' ) );
		$parser->setHook( 'figure', array( 'HTML5Tags', 'tagFigure' ) );
		$parser->setHook( 'figcaption', array( 'HTML5Tags', 'tagFigcaption' ) );
		$parser->setHook( 'hgroup', array( 'HTML5Tags', 'tagHgroup' ) );
		$parser->setHook( 'mark', array( 'HTML5Tags', 'tagMark' ) );
		$parser->setHook( 'nav', array( 'HTML5Tags', 'tagNav' ) );
		/* Do not register "section" if LabeledSectionTransclusion is installed */
		if ( !class_exists( 'LabeledSectionTransclusion' ) ) {
			$parser->setHook( 'section', array( 'HTML5Tags', 'tagSection' ) );
		}
		$parser->setHook( 'time', array( 'HTML5Tags', 'tagTime' ) );
		$parser->setHook( 'footer', array( 'HTML5Tags', 'tagFooter' ) );
		$parser->setHook( 'header', array( 'HTML5Tags', 'tagHeader' ) );
		return true;

	}

	/* This function takes all attributes that are common among HTML5 attributes,
	    removes them from args and returns them */
	private function extractGlobalAttributes ( &$args ) {

		$allowedGlobalAttributes = array ( 'accesskey', 'hidden', 'itemtype', 'class', 'id', 'lang', 'contenteditable', 'inert', 'spellcheck', 'contextmenu', 'itemid', 'style', 'dir', 'itemprop', 'tabindex', 'draggable', 'itemref', 'title', 'dropzone', 'itemscope', 'translate' );

		$returnGlobalAttributes = array ();
		foreach ( $args as $k => $v ) {
			if ( in_array( $k, $allowedGlobalAttributes ) ) {

				$returnGlobalAttributes[$k] = $v;
				unset ( $args[$k] );

			}
		}
		return $returnGlobalAttributes;
	}

	/* Create an opening tag with attributes */
	private function createOpeningTag ( $name, $args, $selfClosing = false ) {

		$html = "<$name";
		if ( !empty( $args ) ) {
			foreach(  $args as $k => $v ) {
				$html .= ' '. htmlspecialchars( $k ).'="'. htmlspecialchars($v).'"';
			}
		}

		if ( $selfclosing )
			$html .= '/';

		$html .= '>';
		return $html;

	}


	public function tagArticle ( $input, $args, $parser, $frame ) {

		$args = self::extractGlobalAttributes( $args );
		$start = self::createOpeningTag( 'article', $args );
		return "$start$input</article>";

	}

	public function tagAside ( $input, $args, $parser, $frame ) {

		$args = self::extractGlobalAttributes( $args );
		$start = self::createOpeningTag( 'aside', $args );
		return "$start$input</aside>";

	}

	public function tagFigcaption ( $input, $args, $parser, $frame ) {

		$args = self::extractGlobalAttributes( $args );
		$start = self::createOpeningTag( 'figcaption', $args );
		return "$start$input</figcaption>";

	}

	public function tagFigure ( $input, $args, $parser, $frame ) {

		$args = self::extractGlobalAttributes( $args );
		$start = self::createOpeningTag( 'figcaption', $args );
		return "$start$input</figcaption>";

	}

	public function tagFooter ( $input, $args, $parser, $frame ) {

		$args = self::extractGlobalAttributes( $args );
		$start = self::createOpeningTag( 'footer', $args );
		return "$start$input</footer>";

	}

	public function tagHeader ( $input, $args, $parser, $frame ) {

		$args = self::extractGlobalAttributes( $args );
		$start = self::createOpeningTag( 'header', $args );
		return "$start$input</header>";

	}

	public function tagHgroup ( $input, $args, $parser, $frame ) {

		$args = self::extractGlobalAttributes( $args );
		$start = self::createOpeningTag( 'hgroup', $args );
		return "$start$input</hgroup>";

	}

	public function tagMark ( $input, $args, $parser, $frame ) {

		$args = self::extractGlobalAttributes( $args );
		$start = self::createOpeningTag( 'mark', $args );
		return "$start$input</mark>";

	}

	public function tagNav ( $input, $args, $parser, $frame ) {

		$args = self::extractGlobalAttributes( $args );
		$start = self::createOpeningTag( 'nav', $args );
		return "$start$input</nav>";

	}

	public function tagSection ( $input, $args, $parser, $frame ) {

		$args = self::extractGlobalAttributes( $args );
		$start = self::createOpeningTag( 'section', $args );
		return "$start$input</section>";

	}

	public function tagTime ( $input, $args, $parser, $frame ) {

		$finalArgs = self::extractGlobalAttributes( $args );
		foreach ( $args as $k => $v ) {
			if ( 'datetime' === $k ) {
				$finalArgs['datetime'] = htmlspecialchars( $v );
			}
		}
		$start = self::createOpeningTag( 'time', $finalArgs );
		return "$start$input</time>";

	}

}
