<?php
function fetch_tags_for_image($path){
	$tags = [];
	$payload = '{"requests": [{"image": {"content": "'.base64_encode(file_get_contents($path)).'"}, "features": [{"type": "LABEL_DETECTION", "maxResults": "10"}]}]}';
	file_put_contents('payload.json', $payload);
	$cmd = 'curl -k -s -H "Content-Type: application/json" https://vision.googleapis.com/v1/images:annotate?key=AIzaSyAePBRf0_ur64H8Z0T6HWuHF47RGn7in9A --data-binary @payload.json';
	exec($cmd, $result);
	print "test";
	print serialize($result);
	if($json = @json_decode(join($result, "\n"))){
		print "test1";
		print $result;
		foreach($json->responses[0]->labelAnnotations as $tag){
			$tags[] = $tag->description;
		}
	}
	return $tags;
}
fetch_tags_for_image("images/test01.jpg");
?>