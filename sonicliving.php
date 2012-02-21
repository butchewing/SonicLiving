<?php
/**
 * The SonicLiving API PHP Library
 * @author Butch Ewing - http://butchewing.com
 * @version 0.01
 *
 * The SonicLiving API requires an API key and is available for both commercial and non-commercial use.
 * V1 API Documentation can be found at http://sonicliving.com/apiv1
 * V2 API Documentation, API Keys, and Usage Policies can be found at http://sonicliving.com/api_home
 * 
 **/
if ( ! class_exists( 'SonicLiving' ) )
{
	class SonicLiving 
	{
		protected $api_key;
		protected $v1_api_endpoint = "https://api.sonicliving.com/api/";
		protected $v2_api_endpoint = "https://api.sonicliving.com/v2/";
		protected $user_agent = "Sonic Living PHP Library v0.01";
	
		/**
		 * Sets the API for the Instance of the Class
		 *  
		 * @param apikey = required, string - Your SonicLiving API Key
		 *
		 * @return API Key
		 *
		 **/
		public function setAPI( $apikey )
		{
			$this->api_key = $apikey;
		}
	
		/**
		 * Gets the API for the current instance of the Class. Good for debugging
		 *  
		 * @return API Key
		 *
		 **/
		public function getAPI()
		{
			return $this->api_key;
		}

		/**
		 * Basic Curl Method
		 *
		 * @param url = required, URL — The URL to call the API
		 *  
		 * @return JSON Decoded String
		 *
		 **/
		private function _curl( $url )
		{
			$ch = curl_init( $url );
			$options = array( 
		        CURLOPT_RETURNTRANSFER 	=> 1,
		        CURLOPT_USERAGENT      	=> $this->user_agent 
		    );
			curl_setopt_array( $ch, $options ); 

		    ob_start();
			$response = curl_exec( $ch );
		   	$responseInfo = curl_getinfo( $ch );
		    ob_end_clean();
			curl_close( $ch );
			unset( $ch );
			
			if ( $responseInfo['http_code'] == 200 )
			{
				$entries = json_decode( $response );
				return $entries;
			}
			else
			{
				throw new Exception( "Request was returned with a failing httpCode: " . $responseInfo['http_code'] );
			}
		}
		
		/**
		 * v2 API » event/get
		 * Retrieve details for a specific event
		 * Given an event ID, this call returns all the details it can (such as images, description, and related venues). 
		 * For multiple events, a maximum of 100 records is returned.
		 * @example http://api.sonicliving.com/v2/event/get?key=mykey&event_id=100&host_info=foo&offset=10
		 *
		 * HTTP method: GET
		 * @param event_id = required, one or more integers — The event ID(s)
		 * @param host_info = optional, boolean — Whether to display host info (default false)
		 * @param offset = optional, integer — The number of rows to skip in the result set
		 *  
		 * @return JSON Decoded String
		 *
		 **/
		public function eventGet( $event_id, $host_info=NULL, $offset=NULL )
		{
			if ( $this->api_key == null || $this->api_key == "" )
			{
				throw new Exception( "No API Key is set." );
			}
			else
			{
				$url = $this->v2_api_endpoint . "event/get?key=" . $this->api_key . "&" . $event_id;
				
				if ( $host_info )
				{
					$url .= "&" . $host_info;
				}
				
				if ( $offset )
				{
					$url .= "&" . $offset;
				}
				
				return $this->_curl( $url );
			}
		}
		
		/**
		 * v2 API » event/popular
		 * Return the most popular events
		 * @example http://api.sonicliving.com/v2/event/popular?key=mykey&sort=foo
		 *
		 * HTTP method: GET
		 * @param sort = optional, string — The list order valid values are 'date' or 'popular' (default 'popular')
		 *  
		 * @return JSON Decoded String
		 *
		 **/
		public function eventPopular( $sort=NULL )
		{
			if ( $this->api_key == null || $this->api_key == "" )
			{
				throw new Exception( "No API Key is set." );
			}
			else
			{
				$url = $this->v2_api_endpoint . "event/popular?key=" . $this->api_key;
				
				if ( $sort )
				{
					$url .= "&" . $sort;
				}
				
				return $this->_curl( $url );
			}
		}

		/**
		 * v2 API » event/popular_by_ip
		 * Return the most popular events
		 * @example http://api.sonicliving.com/v2/event/popular_by_ip?key=mykey&ip_address=foo&latitude=foo&longitude=foo&sort=foo&limit=10
		 *
		 * HTTP method: GET
		 * @param ip_address = optional, ip — The IP Address
		 * @param latitude = optional, float — The Latitude
		 * @param longitude = optional, float — The Longitude
		 * @param sort = optional, string — The list order valid values are 'date' or 'popular' (default 'popular')
		 * @param limit = optional, integer — Limit the number of records returned (default / maximum: '25')
		 *  
		 * @return JSON Decoded String
		 *
		 **/
		public function eventPopularByIp( $ip_address=NULL, $latitude=NULL, $longitude=NULL, $sort=NULL, $limit=NULL )
		{
			if ( $this->api_key == null || $this->api_key == "" )
			{
				throw new Exception( "No API Key is set." );
			}
			else
			{
				$url = $this->v2_api_endpoint . "event/popular_by_ip?key=" . $this->api_key;
				
				if ( $ip_address )
				{
					$url .= "&" . $ip_address;
				}
				
				if ( $latitude )
				{
					$url .= "&" . $sort;
				}
				
				if ( $longitude )
				{
					$url .= "&" . $longitude;
				}
				
				if ( $sort )
				{
					$url .= "&" . $sort;
				}
				
				if ( $limit )
				{
					$url .= "&" . $limit;
				}
				
				return $this->_curl( $url );
			}
		}
		
		/**
		 * v2 API » event/ursvp
		 * Return the URSVP count for an event
		 * @example http://api.sonicliving.com/v2/event/ursvp?key=mykey&event_id=100
		 *
		 * HTTP method: GET
		 * @param event_id = required, integer — The event ID
		 *  
		 * @return JSON Decoded String
		 *
		 **/
		public function eventUrsvp( $event_id )
		{
			if ( $this->api_key == null || $this->api_key == "" )
			{
				throw new Exception( "No API Key is set." );
			}
			else
			{
				$url = $this->v2_api_endpoint . "event/ursvp?key=" . $this->api_key . "&" . $event_id;
				return $this->_curl( $url );
			}
		}

		/**
		 * v2 API » location/locate
		 * Given an IP address or postal code, return the nearest location
		 * @example http://api.sonicliving.com/v2/location/locate?key=mykey&postalcode=94103&ip_address=foo&latitude=foo&longitude=foo&radius=foo
		 *
		 * HTTP method: GET
		 * @param postalcode = one-of, string — The ZIP or postal code to match
		 * @param ip_address = one-of, ip — The IP address to match
		 * @param latitude = one-of, float — The latitude from HTML5
		 * @param longitude = one-of, float — the longitude from HTML5
		 * @param radius = optional, integer — The radius to match (in miles)
		 *  
		 * @return JSON Decoded String
		 *
		 **/
		public function locationLocate( $postalcode=NULL, $ip_address=NULL, $latitude=NULL, $longitude=NULL, $radius=NULL )
		{
			if ( $this->api_key == null || $this->api_key == "" )
			{
				throw new Exception( "No API Key is set." );
			}
			else
			{
				$url = $this->v2_api_endpoint . "location/locate?key=" . $this->api_key;
				
				if ( $postalcode )
				{
					$url .= "&" . $postalcode;
				}
				
				if ( $ip_address )
				{
					$url .= "&" . $ip_address;
				}
				
				if ( $latitude )
				{
					$url .= "&" . $sort;
				}
				
				if ( $longitude )
				{
					$url .= "&" . $longitude;
				}
				
				if ( $radius )
				{
					$url .= "&" . $radius;
				}
				
				return $this->_curl( $url );
			}
		}
		
		/**
		 * v2 API » location/recognize
		 * Return all matching locations based on name
		 * @example http://api.sonicliving.com/v2/location/recognize?key=mykey&search=foo
		 *
		 * HTTP method: GET
		 * @param search = required, string — The text to look for when performing a full or partial location-name search
		 *  
		 * @return JSON Decoded String
		 *
		 **/
		public function locationRecognize( $search )
		{
			if ( $this->api_key == null || $this->api_key == "" )
			{
				throw new Exception( "No API Key is set." );
			}
			else
			{
				$url = $this->v2_api_endpoint . "location/recognize?key=" . $this->api_key . "&" . $search;
				return $this->_curl( $url );
			}
		}
	
		/**
		 * v2 API » performer/get
		 * Fetch the details of a given performer
		 * @example http://api.sonicliving.com/v2/performer/get?key=mykey&performer_id=100&performer_guid=foo&host_id=100
		 *
		 * HTTP method: GET
		 * @param performer_id = one-of, one or more integers — The performer ID
		 * @param performer_guid = one-of, one or more strings — The performer GUID
		 * @param host_id = optional, integer — The host to restrict the results to (useful for GUID-based calls)		
		 *  
		 * @return JSON Decoded String
		 *
		 **/
		public function performerGet( $performer_id=NULL, $performer_guid=NULL, $host_id=NULL )
		{
			if ( $this->api_key == null || $this->api_key == "" )
			{
				throw new Exception( "No API Key is set." );
			}
			else
			{
				$url = $this->v2_api_endpoint . "performer/get?key=" . $this->api_key;
				
				if ( $performer_id )
				{
					$url .= "&performer_id=" . $performer_id;
				}
				
				if ( $performer_guid )
				{
					$url .= "&performer_guid=" . $performer_guid;
				}
				
				if ( $host_id )
				{
					$url .= "&host_id=" . $host_id;
				}
				
				return $this->_curl( $url );
			}
		}
		
		/**
		 * v2 API » performer/recognize
		 * Return the best performer match based on name
		 * @example http://api.sonicliving.com/v2/performer/recognize?key=mykey&search=foo
		 *
		 * HTTP method: GET
		 * @param search = required, string — Return the best performer match based on name
		 *  
		 * @return JSON Decoded String
		 *
		 **/
		public function performerRecognize( $search )
		{
			if ( $this->api_key == null || $this->api_key == "" )
			{
				throw new Exception( "No API Key is set." );
			}
			else
			{
				$find = array( "'", " ", "/", "?", "&" );
				$replace = array( "%27", "%20", "%252", "%252", "and" );
				$search = str_replace( $find, $replace, $search );

				$url = $this->v2_api_endpoint . "performer/recognize?key=" . $this->api_key . "&search=" . $search;
				return $this->_curl( $url );
			}
		}
		
		/**
		 * v2 API » performer/search
		 * Generate a list based on a search key
		 * @example http://api.sonicliving.com/v2/performer/search?key=mykey&search=foo&host_id=100
		 *
		 * HTTP method: GET
		 * @param search = required, string — Return any performers whose name matches this string
		 * @param host_id = optional, one or more integers — Restrict the results to specific host ID(s)	
		 *  
		 * @return JSON Decoded String
		 *
		 **/
		public function performerSearch( $search, $host_id=NULL )
		{
			if ( $this->api_key == null || $this->api_key == "" )
			{
				throw new Exception( "No API Key is set." );
			}
			else
			{
				$url = $this->v2_api_endpoint . "performer/search?key=" . $this->api_key . "&search=" . $performer_id;
				
				if ( $host_id )
				{
					$url .= "&" . $host_id;
				}
				
				return $this->_curl( $url );
			}
		}
		
		/**
		 * v2 API » performer/upcoming
		 * Given a performer ID, return upcoming events
		 * @example http://api.sonicliving.com/v2/performer/upcoming?key=mykey&performer_id=100
		 *
		 * HTTP method: GET
		 * @param performer_id = required, one or more integers — The performer ID(s)		
		 *  
		 * @return JSON Decoded String
		 *
		 **/
		public function performerUpcoming( $performer_id )
		{
			if ( $this->api_key == null || $this->api_key == "" )
			{
				throw new Exception( "No API Key is set." );
			}
			else
			{
				$url = $this->v2_api_endpoint . "performer/upcoming?key=" . $this->api_key . "&performer_id=" . $performer_id;
				return $this->_curl( $url );
			}
		}
		
		/**
		 * v2 API » reflection/methods
		 * Show all available methods for the given API key
		 * @example http://api.sonicliving.com/v2/reflection/methods?key=mykey
		 *
		 * HTTP method: GET		
		 *  
		 * @return JSON Decoded String
		 *
		 **/
		public function reflectionMethods()
		{
			if ( $this->api_key == null || $this->api_key == "" )
			{
				throw new Exception( "No API Key is set." );
			}
			else
			{
				$url = $this->v2_api_endpoint . "reflection/methods?key=" . $this->api_key;
				return $this->_curl( $url );
			}
		}
		
		/**
		 * v2 API » venue/get
		 * Find the details of a given venue.
		 * @example http://api.sonicliving.com/v2/venue/get?key=mykey&venue_id=100
		 *
		 * HTTP method: GET	
		 * @param venue_id = required, integer — The venue ID
		 *  
		 * @return JSON Decoded String
		 *
		 **/
		public function venueGet( $venue_id )
		{
			if ( $this->api_key == null || $this->api_key == "" )
			{
				throw new Exception( "No API Key is set." );
			}
			else
			{
				$url = $this->v2_api_endpoint . "venue/get?key=" . $this->api_key . "&" . $venue_id;
				return $this->_curl( $url );
			}
		}
		
		/**
		 * v2 API » venue/lookup
		 * Find the details of a given venue.
		 * @example http://api.sonicliving.com/v2/venue/lookup?key=mykey&name=foo&city_id=100
		 *
		 * HTTP method: GET	
		 * @param name = one-of, string — The venue name
		 * @param city_id = one-of, integer — The SL city_id
		 *  
		 * @return JSON Decoded String
		 *
		 **/
		public function venueLookup( $venue_id )
		{
			if ( $this->api_key == null || $this->api_key == "" )
			{
				throw new Exception( "No API Key is set." );
			}
			else
			{
				$url = $this->v2_api_endpoint . "venue/lookup?key=" . $this->api_key;
				
				if ( $name )
				{
					$url .= "&" . $name;
				}
				
				if ( $city_id )
				{
					$url .= "&" . $city_id;
				}
				
				return $this->_curl( $url );
			}
		}
		
		/**
		 * v2 API » venue/recognize
		 * Return all matching venues based on name
		 * @example http://api.sonicliving.com/v2/venue/recognize?key=mykey&search=foo
		 *
		 * HTTP method: GET	
		 * @param search = required, string — The text to use when performing a full or partial location-name search
		 *  
		 * @return JSON Decoded String
		 *
		 **/
		public function venueRecognize( $search )
		{
			if ( $this->api_key == null || $this->api_key == "" )
			{
				throw new Exception( "No API Key is set." );
			}
			else
			{
				$url = $this->v2_api_endpoint . "venue/recognize?key=" . $this->api_key . "&" . $search;				
				return $this->_curl( $url );
			}
		}
		
		/**
		 * v2 API » venue/upcoming
		 * Given a venue ID, return upcoming events
		 * @example http://api.sonicliving.com/v2/venue/upcoming?key=mykey&venue_id=100
		 *
		 * HTTP method: GET	
		 * @param venue_id = required, one or more integers — The venue ID(s)
		 *  
		 * @return JSON Decoded String
		 *
		 **/
		public function venueUpcoming( $venue_id )
		{
			if ( $this->api_key == null || $this->api_key == "" )
			{
				throw new Exception( "No API Key is set." );
			}
			else
			{
				$url = $this->v2_api_endpoint . "venue/upcoming?key=" . $this->api_key . "&" . $venue_id;				
				return $this->_curl( $url );
			}
		}
		
		/**
		 * v1 API » artists
		 * Given a performer ID, return upcoming events
		 * @example http://api.sonicliving.com/api/?artists[]=wilco&artists[]=bikini%20kill&zips[]=94110&key=mykey
		 *
		 * HTTP method: GET
		 * @param artists[] = required, array of artist names
		 * @param current_ip_loc = optional, restrict search to a geo location based on the requesting current ip address 	
		 * @param zips[] = optional, restrict search to a zip code
		 * @param radius = optional, specify the radius around zip codes to look for shows (140 mile radius limit)
		 * @param limit = optional, limit number of results
		 *  
		 * @return JSON Decoded String
		 *
		 **/
		public function v1getArtistsConcerts( $artists=NULL, $current_ip_loc=TRUE, $zips=NULL, $radius=NULL, $limit=1 )
		{
			if ( $this->api_key == null || $this->api_key == "" )
			{
				throw new Exception( "No API Key is set." );
			}
			else
			{								
				$url = $this->v1_api_endpoint. "?key=" . $this->api_key;
				
				if ( $current_ip_loc == "TRUE" )
				{
					$url .= "&current_ip_loc=true";
				}
				
				if ( $artists )
				{
					if ( is_array( $artists ) )
					{
						foreach ( $artists as $artist )
						{
							$url .= "&artists[]=" . $artist;
						}
					}
					else
					{
						$url .= "&artists[]=" . $artists;
					}
				}
				else
				{
					$url .= "&artists[]=" . basename( CLEANURL );
				}		
				
				if ( $zips != NULL )
				{
					if ( is_array( $zips ) )
					{
						foreach ( $artists as $artist )
						{
							$url .= "&zips[]=" . $zips;
						}
					}
					else
					{
						$url .= "&zips[]=" . $zips;
					}
				}
				
				if ( $radius != NULL )
				{
					$url .= "&radius=" . $radius;
				}
				
				$url .= "&limit=" . $limit;
				
				return $this->_curl( $url );
			}
		}

	}// END class 
}