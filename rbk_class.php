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
			if( !$this->filter_video_links($src) ){
				echo 'Not correct video link';return;
			}
			$iframe = '<iframe 
				src="'.$this->filter_video_links($src).'" 
				width="'.$size[0].'" 
				height="'.$size[1].'" 
				frameborder="0" 
				webkitallowfullscreen 
				mozallowfullscreen 
				allowfullscreen>
			</iframe>';
			return $iframe;
		}
		public function filter_video_links( $content ){

			$youtube_link = '@^\s*https?://(?:www\.)?(?:youtube.com/watch\?|youtu.be/)([^\s"]+)\s*$@im';
			$vimeo_link = '@^\s*https?://(?:www\.)?(?:vimeo.com/)@im';

			if( preg_match( $vimeo_link, $content ) ) {
				// vimeo
				$content = preg_replace( $vimeo_link, 'https://player.vimeo.com/video/', $content );
				return $content;
			} else if ( preg_match( $youtube_link, $content ) ) {
				// youtube
				$content = str_replace( 'https://www.youtube.com/watch?v=', 'http://www.youtube.com/embed/', $content );
				return $content;
			} else {
				return false;
			}

		}
		public function selected_option( $array, $option ){
			$output = '';
			for( $i=0; $i<count($array); $i++ ){
				$selected = '';
				if( preg_match( '/' . $option . '/', $array[$i]) ){
					$selected = 'selected';
				}
				$output.= '<option '.$selected.'>'.$array[$i].'</option>';
			}	
			return $output;
		}

	}
	


?>
