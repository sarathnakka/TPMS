<?php
	
	/*
	* PHP Embed Class (This is not a proper embed class, just a workaround on it)
	* This will just embed Video, Images, Audio according to the providers
	* Paulo Regina - 2014
	* Version: 1.0
	*/
	
	class EmbedEmbed
	{
		// Providers keys must match Rules Keys
		
		// The Regex to find embed code of providers
		public $providers_regex = array(
			
			// video
			"dailymotion.com/video/" => "/DM_CurrentVideoXID='(.*?)';/",
			"youtube.com/watch" => '/"video_id": "(.*?)"/',
			"youtu.be" => '/"video_id": "(.*?)"/',
			"blip.tv" => '/data-cliptext="(.*?)"/',
			"vimeo.com" => '/"clip":{"id":(.*?),/',
			"break.com/video/" => "/sGlobalContentID : '(.*?)',/",
			"metacafe.com/watch/" => '/"itemID":"(.*?)",/',
			"funnyordie.com/videos/" => '/video id="videoPlayer-(.*?)"/',
			"collegehumor.com/video/" => '/"post_id": "(.*?)",/',
			"youku.com/v_show/" => "/videoId2= '(.*?)';/",
			
			// Audio
			"soundcloud.com/" => '/&lt;!\[CDATA\[(.*?)\]\]&gt;</',
			"official.fm/" => '/&quot;track_id&quot;:&quot;(.*?)&quot;,/',
			
			// Rich
			"slideshare.net" => '/"id":"(.*?)"/',
			"screenr.com/" => "/screencast_page.screenrId = '(.*?)';/"
		);
		
		// The Embed Rules provided by the providers
		private $rules = array(
		
			// video 
			'dailymotion.com/video/' => '<iframe frameborder="0" width="100%" height="270" src="http://www.dailymotion.com/embed/video/%embed_code%" allowfullscreen></iframe>',
			'youtube.com/watch' => '<iframe width="100%" height="315" src="http://www.youtube.com/embed/%embed_code%" frameborder="0" allowfullscreen></iframe>',
			'youtu.be' => '<iframe width="100%" height="315" src="http://www.youtube.com/embed/%embed_code%" frameborder="0" allowfullscreen></iframe>',
			'blip.tv' => '%embed_code%',
			'vimeo.com' => '<iframe src="http://player.vimeo.com/video/%embed_code%" width="100%" height="281" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>',
			'break.com/video/' => '<iframe src="http://www.break.com/embed/%embed_code%?embed=1" width="100%" height="280" webkitallowfullscreen mozallowfullscreen allowfullscreen frameborder="0"></iframe>',
			'metacafe.com/watch/' => '<iframe src="http://www.metacafe.com/embed/%embed_code%/" width="100%" height="248" allowFullScreen frameborder=0></iframe>',
			'funnyordie.com/videos/' => '<iframe src="http://www.funnyordie.com/embed/%embed_code%" width="100%" height="400" frameborder="0" allowfullscreen webkitallowfullscreen mozallowfullscreen></iframe>',
			'collegehumor.com/video/' => '<iframe src="http://www.collegehumor.com/e/%embed_code%" width="100%" height="369" frameborder="0" webkitAllowFullScreen allowFullScreen></iframe>',
			'youku.com/v_show/' => '<iframe width="100%" height="498" src="http://player.youku.com/embed/%embed_code%" frameborder="0" allowfullscreen></iframe>',
			
			// Audio
			"soundcloud.com/" => '%embed_code%',
			"official.fm/" => '<iframe width="100%" height="400" frameborder="no" src="http://www.official.fm/player?width=auto&height=400&aspect=flat&feed=http%3A%2F%2Fwww.official.fm%2Ffeed%2Ftracks%2F%embed_code%.json"></iframe>',
			
			// Rich
			"slideshare.net" => '<iframe src="//www.slideshare.net/slideshow/embed_code/%embed_code%" width="100%" height="356" frameborder="0" marginwidth="0" marginheight="0" scrolling="no" style="border:1px solid #CCC; border-width:1px 1px 0; margin-bottom:5px; max-width: 100%;" allowfullscreen></iframe>',
			"screenr.com/" => '<iframe src="https://www.screenr.com/embed/%embed_code%" width="100%" height="396" frameborder="0"></iframe>'
			
		);
		
		// Grab URL data
		private function fetch_url($url)
		{
			// According to Providers API (Navigate to their API instead of website)
			if($this->find_rule($url) == 'soundcloud.com/')
			{
				$url = 'http://soundcloud.com/oembed?format=xml&url='.$url.'&iframe=true';	
			}

			$ch = curl_init();
			$timeout = 2000;
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.0)");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,false);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,false);
			curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
			$data = curl_exec($ch);
			curl_close($ch);
			
			return $data;		
		}
		
		// Find Rule
		private function find_rule($url)
		{
			foreach($this->rules as $key => $rule)
			{
				if(stripos($url, $key))
				{
					return $key; 
				} 
			}
		}
		
		// Extract Embed Codes
		public function extract_embed_code($url, $extract)
		{
			$html = $this->fetch_url($url);
			preg_match_all($extract, $html, $matches);
			return $matches[1][0];
		}
		
		// Format URL
		private function format_url($text, $url_mode='')
		{
			if(stripos($text, '/') == true)
			{
				// from: http://css-tricks.com/snippets/php/find-urls-in-text-make-links/
				$reg_exUrl = '$\b(https?)://[-A-Z0-9+&@#/%?=~_|!:,.;]*[-A-Z0-9+&@#/%=~_|]$i';
				preg_match_all($reg_exUrl, $text, $matches);
				
				$new_matches = array_unique(array_map('trim',$matches[0]));

				$usedPatterns = array();
				foreach($new_matches as $pattern)
				{
					if(!array_key_exists($pattern, $usedPatterns))
					{
						$usedPatterns[$pattern] = true;
						$pattern2 = substr($pattern, -3);
						if($pattern2 == "gif" || $pattern2 == "peg" || $pattern2 == "jpg" || $pattern2 == "png") {
							$text = str_replace($pattern, '<br /><a href="'.$pattern.'"><img class="img-responsive" src="'.$pattern.'"></a><br />', $text); 
						} else {
							if($url_mode == 'normal' || $url_mode == '' || $url_mode == 'embed')
							{
								$text = $pattern;
							} elseif($url_mode == 'to_link') {
								$text = str_replace($pattern, '<a href="'.$pattern.'" target="_new">'.$pattern.'</a>', $text);	
							}
						}   
					}
				} 
				return $text;
			} else {
				return $text;	
			}
		}
		
		// Embed 
		public function oembed($string)
		{
			$url = $this->format_url($string);
			
			if(stripos($url, '/') == true)
			{
				$found_rule = $this->find_rule($url);
				if($found_rule)
				{
					$extracted = $this->extract_embed_code($url, $this->providers_regex[$found_rule]);
					$embed_data = html_entity_decode(str_replace('%embed_code%', $extracted, $this->rules[$found_rule]));
					return str_ireplace($url, '<br />'.$embed_data.'<br />', $string);
				} else {
					return $this->format_url($string, 'to_link');
				}
			} else {
				return $string;	
			}
		}
		
		// How to debug?
		// $embed->extract_embed_code('http://www.official.fm/tracks/track-code-here', $embed->providers_regex['official.fm/']);
		// $embed->oembed('check out this song: https://www.soundcloud.com/url-here');
	}
	
	$embed = new EmbedEmbed();
	
?>