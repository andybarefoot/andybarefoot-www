<?
require_once '../includes/db-social.php';
require_once '../includes/dbactions.php';

$page = intval($_GET["page"]);
if($page==0)$page=1;
$nextPage=$page+1;
$display_num=6;
$start_num=($page-1)*$display_num;

date_default_timezone_set('Europe/London');

?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
		<meta charset="utf-8" />
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<meta name="viewport" content="initial-scale=1.0, width=device-width" />		
		<title>Andy Barefoot</title>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
		<script src="jscript/masonry.pkgd.min.js"></script>
		<script src="jscript/imagesloaded.pkgd.min.js"></script>
		<script src="jscript/lightbox.js"></script>
		<link rel="stylesheet" href="css/reset.css">
		<link rel="stylesheet" href="css/main-r.css">
		<link rel="stylesheet" href="css/lightbox.css">
		<link href='http://fonts.googleapis.com/css?family=Open+Sans+Condensed:300' rel='stylesheet' type='text/css'>
		<script>
			var currentPage=2;
			document.createElement('header');
			jQuery(document).ready(function( $ ) {
				var $container = $('#container');
				// initialize
				$container.masonry({
					itemSelector: '.item'
				});
				$container.imagesLoaded( function() {
					$container.masonry();
				});
				$(function(){
					$(".projectTitle").click(function(){
						$(this).siblings(".projectDesc").slideToggle();
					});
				});
				$(function(){
					$(".highlightTitle").click(function(){
						$(this).siblings(".projectDesc").slideToggle();
					});
				});
/*				function loadSocial(){
					console.log( "more" );
					$('#more').hide();
					$('#loading').show();
					$.get("content"+currentPage+".html", function(response, status, xhr) {
						if ( status == "error" ) {
					    	var msg = "Sorry but there was an error: ";
					    	$("#loading").html( msg + xhr.status + " " + xhr.statusText );
					 	}else{
							console.log(response);
							var moreBlocks = response;
						    var $moreBlocks = $( moreBlocks );
							console.log( $moreBlocks );
						    $container.append( $moreBlocks );
							$container.imagesLoaded( function() {
							    $container.masonry( 'appended', $moreBlocks );
								$('#more').show();
								$('#loading').hide();
							});
							currentPage++;
					 	}
					});
				}
				$(function(){
					$("#more").click(function(){
						loadSocial();
					});
				});          
*/			});
		</script>
	</head>	
	<body>
		<div id="contact"><!-- contact -->
			<header>
				<hgroup>
					<img id="portrait" src="images/andy-barefoot-portrait.png" alt="Andy Barefoot - Digital Professional" />
					<div id="summary">
						<h1><a href="/">Andy Barefoot</a></h1>		
						<p>Digital professional with over 15 years experience of programming, management and digital strategy at Condé Nast and adidas.</p>
					</div>
					<ul>
						<li><a href="https://www.linkedin.com/in/andybarefoot/" target="_blank"><img src="images/icons/png64/linkedin.png" /></a></li>
						<li><a href="mailto:andy@andybarefoot.com"><img src="images/icons/png64/email.png" /></a></li>
						<li><a href="http://instagram.com/andybarefoot" target="_blank"><img src="images/icons/png64/instagram.png" /></a></li>
						<li><a href="http://twitter.com/andybarefoot" target="_blank"><img src="images/icons/png64/twitter.png" /></a></li>
						<li><a href="http://www.facebook.com/profile.php?id=729980577" target="_blank"><img src="images/icons/png64/facebook.png" /></a></li>
					</ul>
				</hgroup>
			</header>
		</div><!-- contact -->
		<div id="projects">
			<div id="projectTitle" class="sectionTitle">
				<h2>Personal Projects</h2>
			</div>
			<div class="project">
				<div class="projectTitle"><h3>Ski VR</h3></div>
				<div class="projectDesc">
					<a href="https://play.google.com/store/apps/details?id=com.GunterGames.SkiVR" target="skivr"><img src="images/ski-vr.png" /></a>
					<p>Ski VR is a quick VR demo built for Google Cardboard but also playable without a headset.</p>
					<p>Slide gracefully down the mountain between trees and alpine chalets in a Virtual Reality winter wonderland.</p>
					<p><a href="https://play.google.com/store/apps/details?id=com.GunterGames.SkiVR" target="skivr">Ski VR on Google Play.</a></p>
				</div>
			</div>
			<div class="project">
				<div class="projectTitle"><h3>Color Hex</h3></div>
				<div class="projectDesc">
					<a href="http://www.guntergames.com/colorhex" target="colorhex"><img src="images/color-hex.jpg" /></a>
					<p>Color Hex is a mobile puzzle game for Android and iOS built and published uing the Unity platform.</p>
					<p>The player must try and match patterns by mixing colours together on a hexagonal grid. As the patterns get more complicated the puzzle becomes more difficult.</p>
					<p>There are 2 play modes with a combined total of 222 levels.</p>
					<p><a href="https://play.google.com/store/apps/details?id=com.guntergames.colourhexnew" target="colorhexplay">Color Hex on Google Play.</a><br />
					<a href="https://itunes.apple.com/gb/app/id1093790722" target="colorhexitunes">Super Color Hex on iTunes.</a></p>
				</div>
			</div>
			<div class="project">
				<div class="projectTitle"><h3>Super Dice</h3></div>
				<div class="projectDesc">
					<a href="http://www.guntergames.com/superdice" target="sneakers"><img src="images/super-dice.jpg" /></a>
					<p>My first attempt at using the Unity platform to create a mobile game was a mobile version of the dice game Farkle.</p>
					<p><a href="http://www.guntergames.com/superdice" target="sneakers">Super Dice</a></p>
				</div>
			</div>
			<div class="project">
				<div class="projectTitle"><h3>All The Sneakers</h3></div>
				<div class="projectDesc">
					<a href="http://www.allthesneakers.com/" target="sneakers"><img src="images/all-the-sneakers.jpg" /></a>
					<p>In-progress search engine of sneakers collating and comparing sneakers from a number of eCommerce sites.</p>
					<p>Regularly spiders a number of sites and compares prices where identical sneakers appear on multiple sites.</p>
					<p><a href="http://www.allthesneakers.com/" target="sneakers">All The Sneakers</a></p>
				</div>
			</div>
			<div class="project">
				<div class="projectTitle"><h3>Winstagram</h3></div>
				<div class="projectDesc">
					<a href="winstagram" target="winstagram" ><img src="images/winstagram.jpg" /></a>
					<p>More and more people are posting photos on their social web blogs. But most of them are not very good photographers. Or have poorly made cameras. The colours come out funny, the edges are all crackly and often some of the image is out of focus.</p>
					<p>I have developed an app to restore these poor quality photographs: <a href="winstagram" target="winstagram" >Winstagram!</a></p>
				</div>
			</div>
			<div class="project">
				<div class="projectTitle"><h3>We can't go on like this</h3></div>
				<div class="projectDesc">
					<a href="/politics/cameron.php" target="cameron"><img src="images/cameron.jpg" /></a>
					<p>Good old David Cameron. He's so suave yet so caring. he just wants the best for the country. He says so in his lovely new <a href="http://www.flickr.com/photos/conservatives/4244583668/sizes/l/in/photostream/" target="flickr-tory">poster campaign</a> (NSFDuring lunch).</p>
					<p>Deface David's poster with your own words with <a href="/politics/cameron.php" target="cameron">"Make your own David Cameron poster"</a>.</p>
					<p>Go on, <a href="/politics/cameron.php" target="_blank">have a go</a>. You know you want to. Make it look like he is saying rude words. Hurr hurr hurr!</p>
				</div>
			</div>
			<div class="project">
				<div class="projectTitle"><h3>Malcolm Tucker</h3></div>
				<div class="projectDesc">
					<a href="/politics/tucker.php" target="tucker"><img src="images/malcolm-tucker.jpg" /></a>
					<p>Combines the <a href="/politics/cameron.php" target="cameron">David Cameron poster generator</a> with the foul-mouthed tirades of Malcolm Tucker, <a href="http://www.youtube.com/watch?v=LugJd6uGJqI" target="youtube-tucker">sweary spin doctor</a> from The Thick of It.</p>
					<p>A random choice of blue bon-mot is substituted every time you click the "Tuckerise" button so <a href="http://www.andybarefoot.com/politics/tucker.php" target="tucker">click away</a>. However, be warned. He is a very very rude man and if you don't like naughty words you probably won't like this.</p>
				</div>
			</div>
			<div class="project">
				<div class="projectTitle"><h3>Invented by the English</h3></div>
				<div class="projectDesc">
					<a href="http://inventedbytheenglish.wordpress.com" target="english"><img src="images/invented.jpg" /></a>
					<p>If it was invented, it was probably invented by an Englishman.</p>
					<p>A retired blog detailing all the greatest inventions of the English.</p>
				</div>
			</div>
		</div><!-- projects -->
		<div id="highlights">
			<div id="highlightTitle" class="sectionTitle">
				<h2>Work Highlights</h2>
			</div>
			<div class="highlight">
				<div class="highlightTitle"><h3>WIRED Germany</h3></div>
				<div class="projectDesc">
					<a href="http://www.wired.de" target="wired"><img src="images/wired-germany.jpg" /></a>
					<p>I was Product Owner for the digital launch of WIRED magazine in Germany.</p>
					<p>WIRED Germany is the first Cond&eacute; Nast title to have a digital membership model with some content only visible to subscribers.</p>
					<p>We launched a responsive website with the emphasis on giving the long form in-depth articles the presentation they deserve.</p>
					<p><a href="http://www.wired.de" target="wired">WIRED Germany</a></p>
				</div>
			</div>
			<div class="highlight">
				<div class="highlightTitle"><h3>Cond&eacute; Nast Hackathon</h3></div>
				<div class="projectDesc">
					<a href="http://www.whatsnewinpublishing.co.uk/content/f%E2%80%99nito-winner-cond%C3%A9-nast-international-hackathon" target="fnito"><img src="images/conde-nast-fnito.jpg" /></a>
					<p>I took part in the first Cond&eacute; Nast International Hackathon joining with the "F’Nito" team to help them develop their cross-platform content concept.</p>
					<p>F'Nito enables the user to read or listen to an article on any of their devices seamlessly switching from text to audio and back and maintaining their place as they switch devices.</p>
					<p>F'Nito won the first prize at the hackathon.</p>
					<p><a href="http://www.whatsnewinpublishing.co.uk/content/f%E2%80%99nito-winner-cond%C3%A9-nast-international-hackathon" target="fnito">Cond&eacute; Nast Hackathon</a></p>
				</div>
			</div>
			<div class="highlight">
				<div class="highlightTitle"><h3>adidas.com</h3></div>
				<div class="projectDesc">
					<a href="http://www.adidas.co.uk" target="adidas"><img src="images/go-all-in.jpg" /></a>
					<p>As Director Digital Brand Platforms led the implementation of the adidas.com global redesig for the Global Marketing department.</p>
					<p>The site integrates a global CMS that supports each of the local markets as well as the global team.</p>
					<p><a href="http://www.adidas.co.uk" target="adidas">adidas</a></p>
				</div>
			</div>
			<div class="highlight">
				<div class="highlightTitle"><h3>adidas Go All In</h3></div>
				<div class="projectDesc">
					<a href="http://discover.adidas.co.uk/goallin/" target="goallin"><img src="images/go-all-in.jpg" /></a>
					<p>The adidas Go All In platform highlighted the breadth of the adidas brand across all sports as well as the Street and Style side of the business.</p>
					<p>I was the adidas person responsible for the technical implementation of the platform and CMS.</p>
					<p>The site was launched globally across over 40 markets.</p>
					<p><a href="http://discover.adidas.co.uk/goallin/" target="goallin">Go All In</a></p>
				</div>
			</div>
		</div><!-- highlights -->
		<div id="social">
			<div id="socialTitle" class="sectionTitle">
				<h2>Social Feed</h2>
			</div><!-- socialTitle -->
			<div id="container">
<?
	$sqlStmt="SELECT * FROM `myposts` ORDER BY `mypost_time` DESC LIMIT ".$start_num.", ".$display_num."";
	$posts=getData($sqlStmt);
	foreach($posts as $post){
		$post_id=$post["mypost_ID"];
		$post_platform=$post["mypost_platform"];
		$post_time=$post["mypost_time"];
		$post_hasimage=$post["mypost_hasimage"];
		$post_image=$post["mypost_image"];
		$post_hasvideo=$post["mypost_hasvideo"];
		$post_video=$post["mypost_video"];
		$post_caption=stripslashes($post["mypost_caption"]);
		$date = DateTime::createFromFormat('Y-m-d H:i:s', $post_time);
		$post_date_str = $date->format('jS F Y');
		/*
		if($post_network==1){
			$tweet_text=stripslashes($post["tweet_text"]);
			$twitter_acc_name=$post["twitter_acc_name"];
			$findLinks=true;
			$offset = 0;
			while($findLinks){
				$linkPos = strrpos($tweet_text,"http://",$offset);
				if($linkPos !== false){
					$linkEnd = 	strpos($tweet_text," ",$linkPos);
					if($linkEnd === false){
						$linkEnd = strlen($tweet_text);
					}
					$linkURL = substr($tweet_text, $linkPos, $linkEnd-$linkPos);
					$tweet_text = substr_replace($tweet_text, '</a>', $linkEnd, 0);
					$tweet_text = substr_replace($tweet_text, '<a href="'.$linkURL.'" target="_blank">', $linkPos, 0);
					$offset = 0-(strlen($tweet_text)-$linkPos);
				}else{
					$findLinks=false;
				}
			}
			echo '<div class="masonryImage twitterBlock"><p>'.$tweet_text.'</p><div class="dateText">'.$twit_icon_str.$post_date_str.'</div></div>';			
		}else */
		if($post_platform==2){
			echo '<div class="item">'."\n";
			echo '<div class="dateText">'."\n";
			echo '<a href="http://instagram.com/andybarefoot" target="_blank"><img src="images/icons/png32/instagram.png" width="24" height="24" /></a>'."\n";
			echo $post_date_str."\n";
			echo '</div><!-- class: dateText -->'."\n";
			if($post_hasvideo==1){
				echo '<video controls><source src="'.$post_video.'" type="video/mp4"></video>'."\n";
			}else{
				echo '<a href="'.$post_image.'" rel="lightbox" title="'.$post_caption.'">'."\n";
				echo '<img class="photoImg" src="'.$post_image.'" />'."\n";
				echo '</a>'."\n";;
			}
			echo '<p>'.$post_caption.'</p>'."\n";

			echo '</div><!-- class: item -->'."\n";
			echo "\n";
		}/*else if($post_network==3){
			$tumblr_type=stripslashes($post["blog_type"]);
			$tumblr_text=stripslashes($post["blog_title"]);
			$tumblr_text="";
			$tumblr_acc_name=$post["blog_acc_screen_name"];
			$tumblr_image=$post["blog_thumb"];
			$tumblr_width=$post["blog_thumb_width"];
			$tumblr_height=$post["blog_thumb_height"];
			$tumblr_id=$post["blog_id"];
			if(($tumblr_type==2)||($tumblr_type==3)){
				if($tumblr_width>$tumblr_height){
					$h=306;
					$w=round($tumblr_width/($tumblr_height/306));
				}else{
					$w=306;
					$h=round($tumblr_height/($tumblr_width/306));
				}
				$s_str=' width="'.$w.'" height="'.$h.'"';
				$offset=round(($w-306)/2);
				$first=true;
				$sqlStmt="SELECT * FROM `blog_photos` WHERE `blog_photos`.`blog_id`= ".$tumblr_id." ORDER BY `blog_photos`.`blog_id` ASC";
				$gallery_images=getData($sqlStmt);
				$firstURL=$gallery_images[0]["blog_photo_url"];
				echo '<div class="masonryImage instagramBlock">';
				if($tumblr_type==2)echo '<img class="icon" src="images/iconPhotoGallery.png" />';
				if($tumblr_type==3)echo '<img class="icon" src="images/iconPhoto.png" />';
				echo '<div class="img_container"><a href="'.$firstURL.'" rel="lightbox[blog'.$tumblr_id.']" title="'.$tumblr_text.'"><img src="'.$tumblr_image.'" '.$s_str.' style="margin-left: -'.$offset.'px;"/></a></div><p><span class="blue">'.$tumblr_acc_name.'</span> '.$tumblr_text.'</p><div class="dateText">'.$post_date_str.'</div></div>';			
	//			echo '<div class="masonryImage instagramBlock"><img class="icon" src="images/iconInstagram.png" /><div class="img_container" style="background: url(\''.$tumblr_image.'\') no-repeat center top;"></div><p><span class="blue">'.$tumblr_acc_name.'</span> '.$tumblr_text.'</p><div class="dateText">'.$post_date_str.'</div></div>';			
				for($i=1;$i<count($gallery_images); $i++){
					$gallery_image_url=$gallery_images[$i]["blog_photo_url"];
					echo '<a href="'.$gallery_image_url.'" rel="lightbox[blog'.$tumblr_id.']" title="'.$tumblr_text.'"></a>';
				}
			}else if($tumblr_type==8){
				echo '<div class="masonryImage videoBlock"><img class="icon" src="images/iconPhotoGallery.png" /><iframe width="632" height="355" src="'.$tumblr_image.'?wmode=transparent&autohide=1&egm=0&hd=1&iv_load_policy=3&modestbranding=1&rel=0&showinfo=0&showsearch=0" frameborder="0" allowfullscreen></iframe><p><span class="blue">'.$tumblr_acc_name.'</span> '.$tumblr_text.'</p><div class="dateText">'.$post_date_str.'</div></div>';
			}
		}*/
	}
?>	
	
			</div><!-- container -->
<!--
			<div id="more" class="dateText">
				Load more social feed
			</div>
			<div id="loading" class="dateText">
				Loading...
			</div>
-->
		</div><!-- social -->
	</body>
</html>
