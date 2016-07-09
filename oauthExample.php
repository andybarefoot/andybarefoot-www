<?php
require_once('../includes/OAuth.php');
require_once('../includes/auth-yelp.php');
$API_HOST = 'api.yelp.com';
$DEFAULT_TERM = 'kebab';
$DEFAULT_LOCATION = 'Amsterdam';
$DEFAULT_LL = '52.324586,0.1411213';
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
 * param    $term        The search term passed to the API 
 * param    $location    The search location passed to the API 
 * return   The JSON response from the request 
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
 * User input is handled here 
 */
$longopts  = array(
    "term::",
    "location::",
);
    
$options = getopt("", $longopts);
$term = $options['term'] ?: '';
$location = $options['location'] ?: '';

//$target = return_first_result($term, $location);
$target = search($term, $location);
print $target;

?>