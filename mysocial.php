<?
/*
require_once '/nfs/c05/h04/mnt/73815/domains/andybarefoot.com/includes/db-social.php';
require_once '/nfs/c05/h04/mnt/73815/domains/andybarefoot.com/includes/dbactions.php';
require_once '/nfs/c05/h04/mnt/73815/domains/andybarefoot.com/includes/twitter-functions.php';
require_once '/nfs/c05/h04/mnt/73815/domains/andybarefoot.com/includes/instagram-functions.php';
require_once '/nfs/c05/h04/mnt/73815/domains/andybarefoot.com/includes/twitter-api.php';
*/
require_once '../includes/db-social.php';
require_once '../includes/dbactions.php';
require_once '../includes/twitter-functions.php';
require_once '../includes/instagram-functions.php';
require_once '../includes/twitter-api.php';

// INSTAGRAM ACCOUNTS
// adidas 20269764
// adidas Originals 9187952
// adidas NEO 12958644
// adidas Women 39486634
// Y-3 175694806
// adidas Basketball 206161490
// andybarefoot 1539646
// testbarefoot 287930161


echo ' INSTAGRAM<br/>';
$instAccounts = array(
"1539646"
);

// test tweeting to www.twitter.com/testbarefoot
/* 
$tweetText='The control tweet ';				
$tweetText.=rand(0, 1000000);				
$twitterAccount='1086010394';
$newTweetResponse=twNewPost($twitterAccount,$tweetText);
*/

foreach($instAccounts as $instAccount){
	echo "<br/>Account: ".$instAccount."<br/>";
	$photos = insGetPosts($instAccount, 5);
	if(is_array($photos)){
		echo "SUCCESS: ";
		foreach($photos as $photo){
			$captionText=$photo["caption"]["text"];	
			$imageLow=$photo["images"]["low_resolution"]["url"];	
			$imageStd=$photo["images"]["standard_resolution"]["url"];	
			$videoLow=$photo["videos"]["low_resolution"]["url"];	
			$videoStd=$photo["videos"]["standard_resolution"]["url"];	
			$createdTime=$photo["created_time"];	
			$photo_id=$photo["id"];	
			$user_id=$photo["user"]["id"];	
			$userName=$photo["user"]["username"];	
			$userFullName=$photo["user"]["full_name"];	
			$saveDate=date('Y-m-d H:i:s',$createdTime-(8*3600));
			$saveText=addSlashes($captionText);
			echo ' FOUND | '.$userFullName.' | '.$photo_id.' | <img src="'.$imageLow.'"/><br/>';
			$sqlStmt="SELECT * FROM `posts` WHERE `post_network` = 2 AND `post_local_post` = '$photo_id' LIMIT 0 , 30";
			$posts=getData($sqlStmt);
			if(!$posts){
				$sqlStmt="INSERT INTO `db73815_social`.`posts` (`post_id`, `post_network`, `post_local_user`, `post_local_post`, `post_date`, `post_display`) VALUES (NULL, '2', '$user_id', '$photo_id', '$saveDate', '1')";
				$newPost=insertDataReturnID($sqlStmt);
				$sqlStmt="INSERT INTO `db73815_social`.`instagrams` (`instagram_id`, `instagram_local_id`, `instagram_user`, `instagram_date`, `instagram_text`, `instagram_low_res`, `instagram_std_res`, `instagram_low_res_vid`, `instagram_std_res_vid`) VALUES (NULL, '$photo_id', '$user_id', '$saveDate', '$saveText', '$imageLow', '$imageStd', '$videoLow', '$videoStd')";
				$newInstagram=insertDataReturnID($sqlStmt);
				echo ' NEW | '.$userFullName.' | '.$imageLow.'<br/>';
			}
		}
		echo $userName,"<br/>";
	}else{
		echo "FAILURE: ".$instAccount,"<br/>";
	}
}

/*

echo ' <br/>TWITTER<br/>';


// TWITTER
// 300114634 adidas
// 20348431 adidas Originals
// 180593993 adidas NEO Label
// 32688895 adidas Y-3
// 219683269 adidasfootball
// 441129326 adidas Basketball
// 20784240 adidas soccer
// 20434358 adidas Running
// 67427568 adidas Golf
// 20784526 official adidas shop
// 21072903 adidas Group blog
// 49685778 adidas Group Jobs
// 61312712 adidas America
// 35706371 adidas UK
// 25487201 adidas France
// 313245901 adidas_ES
// 549274648 adidas Argentina
// 415859364 Nike
// 5885732 Nike Basketball
// 41147159 Nike Football
// 337726224 Nike Running
// 98533811 Nike Sportswear
// 466807381 NikeFuel
// 50883209 PUMA
// 25881149 andybarefoot
// 1086010394 testbarefoot

$twitAccounts = array(
"300114634",
"20348431",
"180593993",
"32688895",
"219683269",
"441129326",
"20784240",
"20434358",
"67427568",
"20784526",
"21072903",
"49685778",
"61312712",
"35706371",
"25487201",
"313245901",
"549274648",
"415859364",
"5885732",
"41147159",
"337726224",
"98533811",
"466807381",
"50883209",
"25881149",
"1086010394",
);


foreach($twitAccounts as $twitAccount){
	$tweets = twGetPosts($twitAccount,200);
	if(is_array($tweets)){
		foreach($tweets as $tweet){
			$user_id=$twitAccount;
			$countTweets++;	
			$tweetID=$tweet["id_str"];	
			$tweetText=$tweet["text"];	
			$displayDateOrig=$tweet["created_at"];
			$displayDate=date('d/m h:i',strtotime($tweet["created_at"]));
			$saveDate=date('Y-m-d H:i:s',strtotime($tweet["created_at"]));
			$retweeted=$tweet["retweeted_status"];
			$tweetUser=$tweet["user"]["id_str"];
			$replyName=$tweet["in_reply_to_screen_name"];
			$medias= $tweet["entities"]["media"];
			if((!$retweeted)&&(!$replyName)){
				$countOwnTweets++;
				$firstOwnTweet=$tweet["created_at"];
				if(!$lastOwnTweet)$lastOwnTweet=$tweet["created_at"];
			}
			if(!$lastTweet)$lastTweet=$tweet["created_at"];
			$firstTweet=$tweet["created_at"];
		    if($retweeted){
		    	$saveRetweet=1;
		    	$countRetweeted++;
			}else{
		    	$saveRetweet=0;
			}
		   	if($replyName){
		    	$saveReply=1;
		   		$countReplies++;
			}else{
		    	$saveReply=0;
			}
			if($medias){
				foreach($medias as $media){
					if((!$retweeted)&&(!$replyName))$countMedia++;
			    	$mediaURL=$media["url"];
			    	$mediaImage=$media["media_url"];
				}
			}
			$urls= $tweet["entities"]["urls"];
			if($urls){
				if((!$retweeted)&&(!$replyName))$countHasLinks++;
				foreach($urls as $url){
					if((!$retweeted)&&(!$replyName))$countLinks++;
			    	$urlText=$url["url"];
			    	$urlURL=$url["url"];
			    	if($url["display_url"])$urlText=$url["display_url"];
			    	if($url["expanded_url"])$urlURL=$url["expanded_url"];
				}
			}
			$hashs= $tweet["entities"]["hashtags"];
			if($hashs){
				if((!$retweeted)&&(!$replyName))$countHasHashtags++;
				foreach($hashs as $hash){
					if((!$retweeted)&&(!$replyName))$countHashtags++;
				}		
			}
			$mentions= $tweet["entities"]["user_mentions"];
			if($mentions){
				if((!$retweeted)&&(!$replyName))$countHasMentions++;
				foreach($mentions as $mention){
					if((!$retweeted)&&(!$replyName))$countMentions++;
					$screenName=$mention["screen_name"];
				}
			}
			$retweets=$tweet["retweet_count"];
			if((!$retweeted)&&(!$replyName))$countRetweets+=$retweets;		
			if($rowType=="evenRow"){
				$rowType="oddRow";
			}else{
				$rowType="evenRow";
			}
		
			$saveText=addslashes($tweetText);
		
			$sqlStmt="SELECT * FROM `posts` WHERE `post_network` =1 AND `post_local_post` = '$tweetID' LIMIT 0 , 30";
			$posts=getData($sqlStmt);
			if(!$posts){
				$sqlStmt="INSERT INTO `db73815_social`.`posts` (`post_id`, `post_network`, `post_local_user`, `post_local_post`, `post_date`) VALUES (NULL, '1', '$user_id', '$tweetID', '$saveDate')";
				$newPost=insertDataReturnID($sqlStmt);
				$sqlStmt="INSERT INTO `db73815_social`.`tweets` (`tweet_id`, `tweet_user`, `tweet_date`, `tweet_text`, `tweet_isReply`, `tweet_isRetweet`) VALUES ('$tweetID', '$user_id', '$saveDate', '$saveText', '$saveReply', '$saveRetweet');";
				$newTweet=insertDataReturnID($sqlStmt);
				echo ' NEW | '.$twitAccount.' | '.$saveText.'<br/>';
			}	
		}
	}else{
		echo "FAILURE: ".$tweets,"<br/>";
	}
}

*/

?>