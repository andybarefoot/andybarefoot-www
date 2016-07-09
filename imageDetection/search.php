<?php
// Get Lat and Long
if(is_numeric($_GET["lat"])){
	$lat = $_GET["lat"];
}
if(is_numeric($_GET["lon"])){
	$lon = $_GET["lon"];
}
if($_GET["search"]=='kebab'){
	$search = 'kebab';
}else if($_GET["search"]=='chips'){
	$search = 'chips';
}else if($_GET["search"]=='burger'){
	$search = 'burger';
}
// Enter the path that the oauth library is in relation to the php file
require_once('../../includes/OAuth.php');
// Import OAuth credentials here  
require_once('../../includes/auth-yelp.php');
// Search criteria
$API_HOST = 'api.yelp.com';
$DEFAULT_TERM = $search;
$DEFAULT_LOCATION = 'Amsterdam';
$DEFAULT_LL = $lat.','.$lon;
$SEARCH_LIMIT = 10;
$SEARCH_PATH = '/v2/search/';
$BUSINESS_PATH = '/v2/business/';
$SEARCH_SORT = 1;
$SEARCH_CATEGORYFILTER = 'hotdogs'; // This is value from https://www.yelp.co.uk/developers/api_console and actually refers to fast food and takeaway restauranst, not exclusively hotdogs

/** 
 * Makes a request to the Yelp API and returns the response
 * 
 * @param    $host    The domain host of the API 
 * @param    $path    The path of the APi after the domain
 * @return   The JSON response from the request      
 */
function request($host, $path) {
    $unsigned_url = "https://" . $host . $path;
    // Token object built using the OAuth library
    $token = new OAuthToken($GLOBALS['TOKEN'], $GLOBALS['TOKEN_SECRET']);
    // Consumer object built using the OAuth library
    $consumer = new OAuthConsumer($GLOBALS['CONSUMER_KEY'], $GLOBALS['CONSUMER_SECRET']);
    // Yelp uses HMAC SHA1 encoding
    $signature_method = new OAuthSignatureMethod_HMAC_SHA1();
    $oauthrequest = OAuthRequest::from_consumer_and_token(
        $consumer, 
        $token, 
        'GET', 
        $unsigned_url
    );
    
    // Sign the request
    $oauthrequest->sign_request($signature_method, $consumer, $token);
    
    // Get the signed URL
    $signed_url = $oauthrequest->to_url();
    
    // Send Yelp API Call
    try {
        $ch = curl_init($signed_url);
        if (FALSE === $ch)
            throw new Exception('Failed to initialize');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        $data = curl_exec($ch);
        if (FALSE === $data)
            throw new Exception(curl_error($ch), curl_errno($ch));
        $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if (200 != $http_status)
            throw new Exception($data, $http_status);
        curl_close($ch);
    } catch(Exception $e) {
        trigger_error(sprintf(
            'Curl failed with error #%d: %s',
            $e->getCode(), $e->getMessage()),
            E_USER_ERROR);
    }
    
    return $data;
}
/**
 * Query the Search API by a search term and location 
 * 
 * @param    $term        The search term passed to the API 
 * @param    $location    The search location passed to the API 
 * @return   The JSON response from the request 
 */
function search($term, $location) {
    $url_params = array();
    
    $url_params['term'] = $term ?: $GLOBALS['DEFAULT_TERM'];
//    $url_params['location'] = $location?: $GLOBALS['DEFAULT_LOCATION'];
    $url_params['ll'] = $location?: $GLOBALS['DEFAULT_LL'];
    $url_params['limit'] = $GLOBALS['SEARCH_LIMIT'];
    $url_params['category'] = $GLOBALS['SEARCH_CATEGORYFILTER'];
    $url_params['sort'] = $GLOBALS['SEARCH_SORT'];
    $search_path = $GLOBALS['SEARCH_PATH'] . "?" . http_build_query($url_params);
    return request($GLOBALS['API_HOST'], $search_path);
}
/**
 * Query the Business API by business_id
 * 
 * @param    $business_id    The ID of the business to query
 * @return   The JSON response from the request 
 */
function get_business($business_id) {
    $business_path = $GLOBALS['BUSINESS_PATH'] . urlencode($business_id);
    
    return request($GLOBALS['API_HOST'], $business_path);
}
/**
 * Queries the API by the input values from the user 
 * 
 * @param    $term        The search term to query
 * @param    $location    The location of the business to query
 */
function query_api($term, $location) {
	$response = json_decode(search($term, $location));
    $business_id = $response->businesses[0]->id;
    
    print sprintf(
        "%d businesses found, querying business info for the top result \"%s\"\n\n",         
        count($response->businesses),
        $business_id
    );
    
    $response = get_business($business_id);
    
    print sprintf("Result for business \"%s\" found:\n", $business_id);
    print "$response\n";
}
/**
 * User input is handled here 
 */
$longopts  = array(
    "term::",
    "location::",
);
/**
 * AB: Queries the API by the input values from the user and returns the object for first business
 * 
 * @param    $term        The search term to query
 * @param    $location    The location of the business to query
 */
function return_first_result($term, $location) {
	$response = json_decode(search($term, $location));
    $business_id = $response->businesses[0]->id;
    $response = get_business($business_id);
    return $response;
}
/**
 * User input is handled here 
 */
$longopts  = array(
    "term::",
    "location::",
);
    
$options = getopt("", $longopts);
$term = $options['term'] ?: '';
$location = $options['location'] ?: '';

$target = return_first_result($term, $location);
print $target;
/*
$target = json_decode(return_first_result($term, $location),true);
$target_name = $target['name'];
$target_rating = $target['rating'];
$target_latitiude = $target['location']['coordinate']['latitude'];
$target_longitude = $target['location']['coordinate']['longitude'];
*/
?>