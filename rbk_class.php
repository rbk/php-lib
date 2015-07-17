<?php 
	
	class RbkHelperFunctions {

		// Uncamel case any string
		public function un_camel_case( $string ){
			preg_match_all('/[A-Z]/', $string, $matches);
			if( count($matches) > 0 ){			
				foreach( $matches[0] as $match ){
					$string = str_replace($match, ' ' . strtolower($match), $string );
				}
			}
			return ucwords($string);
		}
		// Pass an associative array and string with mustache keys and return string replaced output
		public function rbkCurlySwap($shortcodes, $string) {
			foreach( $shortcodes as $key => $value ){
				$string = str_replace( '{{'.$key.'}}', $value, $string );	
			}
			return $string;
		}
	}

?>
