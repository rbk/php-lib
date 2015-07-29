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

		public function rbkVimeo( $src, $size = array(500,281) ){
			$default = 'https://player.vimeo.com/video/119144844?badge=0';
			$iframe = '<iframe 
				src="https://player.vimeo.com/video/119144844?badge=0" 
				width="'.$size[0].'" 
				height="'.$size[1].'" 
				frameborder="0" 
				webkitallowfullscreen 
				mozallowfullscreen 
				allowfullscreen>
			</iframe>';

		}

	}
	$rbk = new RbkHelperFunctions();


?>
