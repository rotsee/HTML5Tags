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
		$parser->setHook( 'aside', array( 'HTML5Tags', 'tagAside' ) );
		$parser->setHook( 'details', array( 'HTML5Tags', 'tagDetails' ) );
		$parser->setHook( 'figure', array( 'HTML5Tags', 'tagFigure' ) );
		$parser->setHook( 'figcaption', array( 'HTML5Tags', 'tagFigcaption' ) );
		$parser->setHook( 'hgroup', array( 'HTML5Tags', 'tagHgroup' ) );
		$parser->setHook( 'mark', array( 'HTML5Tags', 'tagMark' ) );
		$parser->setHook( 'nav', array( 'HTML5Tags', 'tagNav' ) );
		/* Do not register "section" if LabeledSectionTransclusion is installed */
		if ( !class_exists( 'LabeledSectionTransclusion' ) ) {
			$parser->setHook( 'section', array( 'HTML5Tags', 'tagSection' ) );
		}
		$parser->setHook( 'summary', array( 'HTML5Tags', 'tagSummary' ) );
		$parser->setHook( 'time', array( 'HTML5Tags', 'tagTime' ) );
		$parser->setHook( 'footer', array( 'HTML5Tags', 'tagFooter' ) );
		$parser->setHook( 'header', array( 'HTML5Tags', 'tagHeader' ) );
		$parser->setHook( 'aside', array( 'HTML5Tags', 'tagAside' ) );
		return true;

	}

	/* This function takes all attributes that are allowed fot all HTML5 tags,
	    removes them from args and returns them */
	private function extractGlobalAttributes ( &$args ) {

		$allowedGlobalAttributes = array ( 
			'accesskey',
			'hidden',
			'itemtype',
			'class',
			'id',
			'lang',
			'contenteditable',
			'inert',
			'spellcheck',
			'contextmenu',
			'itemid',
			'style',
			'dir',
			'itemprop',
			'tabindex',
			'draggable',
			'itemref',
			'title',
			'dropzone',
			'itemscope',
			'translate',
			'aria-hidden',
		);

		$returnGlobalAttributes = array ();
		foreach ( $args as $k => $v ) {
			if ( in_array( $k, $allowedGlobalAttributes ) || ( strpos( $k, 'data-' ) !== false ) ) {

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
				$html .= " $k='$v'";
			}
		}

		if ( $selfClosing )
			$html .= '/';

		$html .= '>';
		return $html;

	}

	/* Shorthand function for the simplest possible tag function */
	private function html ( $tag, $input, $args, $parser, $frame ) {
		$args = self::extractGlobalAttributes( $args );
		if ( !empty( $args ) ) {
			foreach(  $args as $k => &$v ) {
				$k = htmlspecialchars( $k );
				$v = htmlspecialchars( $parser->recursiveTagParse( $v, $frame ) );
			}
		}
		$start = self::createOpeningTag( $tag, $args );
		$input = $parser->recursiveTagParse ( $input, $frame ); //This does not run Parser::preSaveTransform
		return "$start$input</$tag>";
	}

	public function tagArticle ( $input, $args, $parser, $frame ) {
		return self::html( 'article', $input, $args, $parser, $frame);
	}

	public function tagAside ( $input, $args, $parser, $frame ) {
		return self::html( 'aside', $input, $args, $parser, $frame);
	}

	public function tagDetails ( $input, $args, $parser, $frame ) {
		return self::html( 'details', $input, $args, $parser, $frame);
	}

	public function tagFigcaption ( $input, $args, $parser, $frame ) {
		return self::html( 'figcaption', $input, $args, $parser, $frame);
	}

	public function tagFigure ( $input, $args, $parser, $frame ) {
		return self::html( 'figure', $input, $args, $parser, $frame);
	}

	public function tagFooter ( $input, $args, $parser, $frame ) {
		return self::html( 'footer', $input, $args, $parser, $frame);
	}

	public function tagHeader ( $input, $args, $parser, $frame ) {
		return self::html( 'header', $input, $args, $parser, $frame);
	}

	public function tagHgroup ( $input, $args, $parser, $frame ) {
		return self::html( 'hgroup', $input, $args, $parser, $frame);
	}

	public function tagMark ( $input, $args, $parser, $frame ) {
		return self::html( 'mark', $input, $args, $parser, $frame);
	}

	public function tagNav ( $input, $args, $parser, $frame ) {
		return self::html( 'nav', $input, $args, $parser, $frame);
	}

	public function tagSection ( $input, $args, $parser, $frame ) {
		return self::html( 'section', $input, $args, $parser, $frame);
	}

	public function tagSummary ( $input, $args, $parser, $frame ) {
		return self::html( 'summary', $input, $args, $parser, $frame);
	}

	public function tagTime ( $input, $args, $parser, $frame ) {

		$finalArgs = self::extractGlobalAttributes( $args );
		foreach ( $args as $k => $v ) {
			if ( 'datetime' === $k ) {
				$finalArgs['datetime'] = htmlspecialchars( $v );
			}
		}
		$start = self::createOpeningTag( 'time', $finalArgs );
		$input = $parser->recursivePreprocess ( $input, $frame );
		$input = $parser->recursiveTagParse ( $input, $frame );
		return "$start$input</time>";

	}

}
