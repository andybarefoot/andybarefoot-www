<?php
$tracking  = [];
$dir = new DirectoryIterator(dirname("__FILE__"));
foreach ($dir as $fileinfo) {
	if (!$fileinfo->isDot()) {
		print($fileinfo->getFilename());
		print("<br>");
		if ($fileinfo->getExtension()=="jpg") {
			$size = getimagesize($fileinfo->getFilename(), $info);
			if(isset($info['APP13'])){
				$iptc = iptcparse($info['APP13']);
				foreach ($iptc as $key => $value) {
					if($key=="2#025"){
						foreach ($value as $keyword) {
							if(preg_match('/^[0-9]{1,}/', $keyword)){
								print_r($keyword);
								print("<br>");
								if (array_key_exists('x'.$keyword, $tracking)) {
									$tracking['x'.$keyword]++;
								}else{
									$tracking['x'.$keyword]=31;
								}
								$suffix="_".$tracking['x'.$keyword];
								$file = $fileinfo->getFilename();
								$newfile = 'renamed/'.$keyword.$suffix.'.jpg';
								if (!copy($file, $newfile)) {
									echo "failed to copy";
								}
							}
						}
					}
				}
			}
			print("<br>XXXXXXXXXX<br>");
			$size = 0;
		}
	}
}
?>
