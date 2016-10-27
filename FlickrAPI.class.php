<?php 
/**
* Class to work with Flickr API
* @getPhotos
* @getPhotosByTag
* @getPhotosByUser
* 
* Usage:
*
*	$f = new phpFlickr( "Flickr API KEY" );
*	$photos = $f->getPhotosByUser( "Flickr User Id" );
*	echo json_encode( $photos, JSON_PRETTY_PRINT	);
*	echo '<pre>'; print_r( $photos ); echo '</pre>';
*
*/
class phpFlickr {

	public $api_key = '';
	public $user_id = '';
	public $secret = '';
	public $format = 'php_serial';
	public $flickr_url = 'https://api.flickr.com/services/rest/?';
	public $request = '';
	public $errors = array();
	public $result;
	
	/**
	 * Setup the class for making API calls
	 * @param string $api_key Required to make requests to Flickr
	 * @param string $secret  Only required for using more advanced parts of the API
	 */
	function __construct( $api_key, $secret = NULL ) {
		$this->api_key = ( empty($api_key) ) ? array_push($this->errors, 'Please provide an API key.') : $api_key ;
		if( count($this->errors) > 0 ) { print_r( $this->errors ); return false; };

		// Save this if you end up using more advanced parts of API
		// $this->secret = ( empty($secret) ) ? array_push($this->errors, 'Please provide an secret key.') : $secret ;

	}

	/** Set the user id for the current instanciated object */
	public function setUserId( $user_id ) {
		$this->user_id = ( !empty($user_id) ) ? $user_id : array_push($this->errors, 'Please provide a user id.');
	}

	/**
	 * Prepare a url encoded request from given array
	 * @param  array $params Associative array of valid request parameters
	 * @return NA         Sets the current objects request string
	 */
	function prepare_request( $params ){
		$encoded_params = array();
		foreach ($params as $k => $v){
			$encoded_params[] = urlencode($k).'='.urlencode($v);
		}
		$this->request = "https://api.flickr.com/services/rest/?".implode('&', $encoded_params);
	}

	/**
	 * Makes actual request to Flickr and returns raw response 
	 */
	public function make_request( ){
		$response = file_get_contents($this->request);
		$response_object = unserialize($response);
		return $response_object; 
	}

	/**
	 * Get 100 photos from flickr by providing the user id
	 * @param  string $user_id Flickr user id
	 * @param  string $format  format you preferre the result to be returned as
	 * @return array          array of photos
	 */
	public function getPhotosByUser( $user_id, $format = 'php_serial' ) {

		if( empty($user_id) ) {
			array_push($this->errors, 'Please provide an secret key.');
			print_r( $this->errors );
			return;			
		}

		$params = array(
			'api_key'	=> $this->api_key, 
			'method' => 'flickr.people.getPhotos', 
			'user_id' => $user_id, 
			'format' => $format,
			'extras' => 'url_s,url_o' // Add other size options: url_z,url_l
		);

		$this->prepare_request($params);
		$response = $this->make_request();
		return ( $response && isset($response['photos']) && isset($response['photos']['photo']) ) ? $response['photos']['photo'] : $response; // Parse error codes before returning
	
	}

}
?>
