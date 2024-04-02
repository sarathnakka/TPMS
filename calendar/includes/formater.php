<?php
	
	/*
	* PHP Formater
	* This will format some BBCode to HTML
	* Paulo Regina - 2014
	* Version: 1.0
	*/
	
	class BBCodeFormater
	{
		// BB Code to HTML Rules
		private $bb_code_tags = array(
			'[heading1]' => '<h1>', '[/heading1]' => '</h1>',
    		'[heading2]' => '<h2>', '[/heading2]' => '</h2>',
    		'[heading3]' => '<h3>', '[/heading3]' => '</h3>',
			'[heading4]' => '<h4>', '[/heading4]' => '</h4>',
    		'[heading5]' => '<h5>', '[/heading5]' => '</h5>',
    		'[heading6]' => '<h6>', '[/heading6]' => '</h6>',
			
			'[h1]' => '<h1>', '[/h1]' => '</h1>',
    		'[h2]' => '<h2>', '[/h2]' => '</h2>',
    		'[h3]' => '<h3>', '[/h3]' => '</h3>',
			'[h4]' => '<h4>', '[/h4]' => '</h4>',
    		'[h5]' => '<h5>', '[/h5]' => '</h5>',
    		'[h6]' => '<h6>', '[/h6]' => '</h6>',
			
			'[paragraph]' => '<p>', '[/paragraph]' => '</p>',
    		'[p]' => '<p>', '[/p]' => '</p>',
			
			'[left]' => '<p style="text-align:left;">', '[/left]' => '</p>',
			'[right]' => '<p style="text-align:right;">', '[/right]' => '</p>',
			'[center]' => '<p style="text-align:center;">', '[/center]' => '</p>',
			'[justify]' => '<p style="text-align:justify;">', '[/justify]' => '</p>',
			
			'[bold]' => '<strong>', '[/bold]' => '</strong>',
			'[b]' => '<strong>', '[/b]' => '</strong>',
			
			'[italic]' => '<em>', '[/italic]' => '</em>',
			'[i]' => '<em>', '[/i]' => '</em>',
			
			'[underline]' => '<span style="text-decoration:underline;">', '[/underline]' => '</span>',
			'[u]' => '<span style="text-decoration:underline;">','[/u]' => '</span>',
			
			'[unordered_list]' => '<ul>', '[/unordered_list]' => '</ul>',
   			'[list]' => '<ul>', '[/list]' => '</ul>',
    		'[ul]' => '<ul>', '[/ul]' => '</ul>',

    		'[ordered_list]' => '<ol>', '[/ordered_list]' => '</ol>',
    		'[ol]' => '<ol>', '[/ol]' => '</ol>',
			
    		'[item]' => '<li>', '[/item]' => '</li>',
    		'[li]' => '<li>', '[/li]' => '</li>',
			'[*]' => '<li>', '[/*]' => '</li>',
			
			'[code]' => '<code>', '[/code]' => '</code>',
    		'[preformatted]' => '<pre>', '[/preformatted]' => '</pre>',
    		'[pre]' => '<pre>', '[/pre]' => '</pre>',
			
			'[break]' => '<br>',
    		'[br]' => '<br>',
    		'[newline]' => '<br>',
    		'[nl]' => '<br>'
			
		);
		
		private $advanced_bb_code_tags = array(
			"/\[url](.*?)\[\/url]/i" => "<a href='http://$1'>$1</a>",
			"/\[url=(.*?)\](.*?)\[\/url\]/i" => "<a href='$1' title='$1'>$2</a>",
			"/\[img\]([^[]*)\[\/img\]/i" => "<img src='$1' alt=' ' />",
			"/\[image\]([^[]*)\[\/image\]/i" => "<img src='$1' alt=' ' />",
	  	);

		// Convert BB Code to HTML Code
		public function html_format($string)
		{
			$string = str_ireplace(array_keys($this->bb_code_tags), array_values($this->bb_code_tags), $string);
			
			if(stripos($string, '[/url]') == true || stripos($string, '[/img]') == true || stripos($string, '[/image]') == true)
			{
				foreach($this->advanced_bb_code_tags as $match => $replacement) 
				{
					$string = preg_replace($match, $replacement, $string);
				}
			}
			
  			return $string;
		}
	}
	
	$formater = new BBCodeFormater();
	
?>