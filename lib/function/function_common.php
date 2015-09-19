<?


function change_to_utf($utfStr) 
{
  if (iconv("UTF-8","UTF-8",$utfStr) == $utfStr) {
    return $utfStr;
  }
  else {
    return iconv("EUC-KR","UTF-8",$utfStr);
  }
}



/*
 * XSS filter 
 *
 * This was built from numerous sources
 * (thanks all, sorry I didn't track to credit you)
 * 
 * It was tested against *most* exploits here: http://ha.ckers.org/xss.html
 * WARNING: Some weren't tested!!!
 * Those include the Actionscript and SSI samples, or any newer than Jan 2011
 *
 *
 * TO-DO: compare to SymphonyCMS filter:
 * https://github.com/symphonycms/xssfilter/blob/master/extension.driver.php
 * (Symphony's is probably faster than my hack)
 */
 

function FilterXss22($data)
{
        // Fix &entity\n;
        $data = str_replace(array('&amp;','&lt;','&gt;'), array('&amp;amp;','&amp;lt;','&amp;gt;'), $data);
        $data = preg_replace('/(&#*\w+)[\x00-\x20]+;/u', '$1;', $data);
        $data = preg_replace('/(&#x*[0-9A-F]+);*/iu', '$1;', $data);
        $data = html_entity_decode($data, ENT_COMPAT, 'UTF-8');
 
        // Remove any attribute starting with "on" or xmlns
        $data = preg_replace('#(<[^>]+?[\x00-\x20"\'])(?:on|xmlns)[^>]*+>#iu', '$1>', $data);
 
        // Remove javascript: and vbscript: protocols
        $data = preg_replace('#([a-z]*)[\x00-\x20]*=[\x00-\x20]*([`\'"]*)[\x00-\x20]*j[\x00-\x20]*a[\x00-\x20]*v[\x00-\x20]*a[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2nojavascript...', $data);
        $data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*v[\x00-\x20]*b[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2novbscript...', $data);
        $data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*-moz-binding[\x00-\x20]*:#u', '$1=$2nomozbinding...', $data);
 
        // Only works in IE: <span style="width: expression(alert('Ping!'));"></span>
        $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?expression[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
        $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?behaviour[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
        $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:*[^>]*+>#iu', '$1>', $data);
 
        // Remove namespaced elements (we do not need them)
        $data = preg_replace('#</*\w+:\w[^>]*+>#i', '', $data);
 
        do
        {
                // Remove really unwanted tags
                $old_data = $data;
                $data = preg_replace('#</*(?:applet|b(?:ase|gsound|link)|embed|frame(?:set)?|i(?:frame|layer)|l(?:ayer|ink)|meta|object|s(?:cript|tyle)|title|xml)[^>]*+>#i', '', $data);
        }
        while ($old_data !== $data);
 
        // we are done...
        return $data;
}


/*function quote_smart($value)
{
    // Stripslashes
    if (get_magic_quotes_gpc()) {
        $value = stripslashes($value);
    }
    // Quote if not integer
    if (!is_numeric($value)) {
        $value = "'" . mysql_real_escape_string($value) . "'";
    }
    return $value;
}
*/



//SQL Injection Replacement (TMP)
function FilterInjection($post){
	
	$lowerpost = strtolower ($post);
	
	$data = str_replace('--', '', $post);
	$data = str_replace("'", '', $post);
	$data = str_replace('=', '', $post);
	$data = str_replace(';', '', $post);
	
	if(!(strpos($lowerpost, ' or ')===FALSE))	{ return false;}
	if(!(strpos($lowerpost, 'table')===FALSE))	{ return false;}

	return $post;
}



function FilterXSS($value) {
	$value = htmlentities($value, ENT_QUOTES, 'UTF-8'); // use htmlspecialchars() if you want
 
	return $value;
}


/**
 * Enter description here ... Prestatement 로 변경할 것!
 */
function SetFilter()
{
	
	// 파라미터 필터
	$search = filter_input(INPUT_POST | INPUT_GET, 'search', FILTER_SANITIZE_SPECIAL_CHARS);	
	
	$ret = array();
	
	
	//$methods = array("GET", "POST");
	
	foreach ($_GET as $key=>$val) 
	{
		
		// XSS & Sql Injectin Prevent
	    $key	= FilterXSS($key);
	    
	    $val	= FilterXSS($val);
	    //$val	= FilterInjection($val);
	    
	    // Reset Parameters
	    $_GET[$key] = $val;
	    
	}
		

	foreach ($_POST as $key=>$val) 
	{
		
		// XSS & Sql Injectin Prevent
	    $key	= FilterXSS($key);
	    
	    $val	= FilterXSS($val);
	    //$val	= FilterInjection($val);
	    
	    // Reset Parameters
	    $_POST[$key] = $val;
	    
	}

	
	foreach ($_REQUEST as $key=>$val) 
	{
		
		// XSS & Sql Injectin Prevent
	    $key	= FilterXSS($key);
	    
	    $val	= FilterXSS($val);
	    //$val	= FilterInjection($val);
	    
	    // Reset Parameters
	    $_REQUEST[$key] = $val;
	    
	}
		
	
}



/* make a URL small */
function make_bitly_url($url, $login, $appkey, $format = 'json',$version = '2.0.1')
{
	//create the URL
	$bitly = 'http://api.bit.ly/shorten?version='.$version.'&longUrl='.urlencode($url).'&login='.$login.'&apiKey='.$appkey.'&format='.$format;
	
	//get the url
	//could also use cURL here
	$response = file_get_contents($bitly);
	
	//print_r($response);
	
	//parse depending on desired format
	if(strtolower($format) == 'json')
	{
		$json = @json_decode($response,true);
		return $json['results'][$url]['shortUrl'];
	}
	else //xml
	{
		$xml = simplexml_load_string($response);
		return 'http://bit.ly/'.$xml->results->nodeKeyVal->hash;
	}
}
/* usage */
//$short = make_bitly_url('http://naver.com','ghostrok','R_e99ff7c25ba6d80341cce0a563a99a84','json');
//echo 'The short URL is:  '.$short; 




/**
 * 다양한 리턴값 받기
 * @param unknown_type $Val
 */
function req($Val, $ret=''){
	echo"<pre>";
	if($Val=="u" && !empty($ret)) { echo "USER:";   print_r($ret); }
	if($Val=="g"){echo "GET:";   	print_r($_GET);}
	if($Val=="p"){echo "POST:";  	print_r($_POST);}
	if($Val=="s"){echo "세션:";   	print_r($_SESSION); }
	if($Val=="c"){echo "쿠키:";   	print_r($_COOKIE);   }
	if($Val=="r"){echo "반환값:"; 	print_r($_REQUEST); }
	if($Val=="f"){echo "파일:";   	print_r($_FILES);}
	if($Val=="server"){echo "서버:";   	print_r($_SERVER);}
	echo"</pre>";
}


/**
 * 경고메시지 
 * @param unknown_type $msg
 * @param unknown_type $cmd
 * @param unknown_type $url
 */
function alert_msg( $msg, $cmd="", $url="" ) {
	echo "
	<script language='javascript'>";

	if( $msg != "" ) echo "alert( '$msg' ); ";

	if( $cmd == "window_close" ) 			echo " window.close(); ";
	else if( $cmd == "window_reload" ) 		echo " document.location.reload(); ";
	else if( $cmd == "opener_reload" ) 		echo " opener.location.reload(); window.close(); ";
	else if( $cmd == "opener_reload2" ) 	echo " parent.location.reload(); history.back(); ";
	else if( $cmd == "location" ) 			echo " document.location.href = '$url'; ";
	else if( $cmd == "replace" ) 			echo " document.location.replace('$url'); ";
	else if( $cmd == "opener_move" ) 		echo " parent.location.href = '$url'; ";
	else if( $cmd == "opener_location" ) 	echo " opener.location.href = '$url';window.close(); ";
	else if( $cmd == "window_back" ) 		echo " history.back(); ";
	else if( $cmd == "window_back2" ) 		echo " history.go(-2); ";

	echo "</script>";
}


	/**
	 * 한글자르기
	 * @param unknown_type $str
	 * @param unknown_type $len
	 * @param unknown_type $trail
	 * @param unknown_type $using
	 * @return mixed|string
	 */
	function string_cut($str, $len, $add="..") {
		
		$ret = mb_substr($str, 0, $len, 'UTF-8');

		$full_len 	= strlen($str);
		$cut_len	= strlen($ret);
		
		if($full_len > $cut_len) 
		{
			$ret .= $add ;
		}
		
		return $ret;
	}

	
	function socialno_check($resno1, $resno2) {
	  $resno = $resno1 . $resno2;
	
	  // 형태 검사: 총 13자리의 숫자, 7번째는 1..4의 값을 가짐
	  if (!ereg('^[[:digit:]]{6}[1-4][[:digit:]]{6}$', $resno))
	    return false;
	
	  // 날짜 유효성 검사
	  $birthYear = ('2' >= $resno[6]) ? '19' : '20';
	  $birthYear += substr($resno, 0, 2);
	  $birthMonth = substr($resno, 2, 2);
	  $birthDate = substr($resno, 4, 2);
	  if (!checkdate($birthMonth, $birthDate, $birthYear))
	    return false;
	
	  // Checksum 코드의 유효성 검사
	  for ($i = 0; $i < 13; $i++) $buf[$i] = (int) $resno[$i];
	  $multipliers = array(2,3,4,5,6,7,8,9,2,3,4,5);
	  for ($i = $sum = 0; $i < 12; $i++) $sum += ($buf[$i] *= $multipliers[$i]);
	  if ((11 - ($sum % 11)) % 10 != $buf[12])
	    return false;
	
	  // 모든 검사를 통과하면 유효한 주민등록번호임
	  return true;
	}
	
	



	function page_begin($page,$total,$scale)
	{
		if(!$page){$page = 1;}
		if(!$total)
		{
			$begin = 0;
		} 
			else 
		{
			$begin = $scale * ($page -1);	
		}
	 return array($begin,$page);
	}

	
/*
 
								<!-- first -->
								<td style='padding-left:0px;padding-right:0px'>
									<a href='javascript:commentList(1)' class='page_normal'>
										<div style='background:url(/cms/images/page2_left2.jpg) no-repeat left center;margin-left:0px;width:22px'/>&nbsp;</div>
									</a>
								</td>
								
								<!-- prev page -->
								<td style='padding-left:0px;padding-right:0px'>
									<div style='fil-ter:alpha(opacity=50);opacity:0.5'>
									<div style='background:url(/cms/images/page2_left1.jpg) no-repeat left center;margin-left:3px;margin-right:3px;width:16px'/>&nbsp;</div>
								</td>
									
								<!-- 페이지(1) -->
								<td align='center' style='padding-left:7px;padding-right:7px'>
									<a href="javascript:commentList(1)"><span style='font-weight:bold;white-space:nowrap' class='page_bold'>1</span></a>
								</td>
								
								<td width='1'><img src='/cms/images/page2_line.jpg' class='line_09' style='vertical-align:middle'/></td>
								
								<!-- 페이지(2) -->
								<td align='center' style='padding-left:7px;padding-right:7px'>
									<a href="javascript:commentList(2)"><span style=';white-space:nowrap' class='page_normal'>2</span></a>
								</td>
								
								
								<!-- next -->
								<td style='padding-left:0px;padding-right:0px'>
									<div style='fil-ter:alpha(opacity=50);opacity:0.5'><div style='background:url(/cms/images/page2_right1.jpg) no-repeat right center;margin-left:3px;margin-right:3px;width:16px'/>&nbsp;</div>
								</td>
								
								<!-- end -->
								<td style='padding-left:0px;padding-right:0px'>
									<a href='javascript:commentList(2)' class='page_normal'><div style='background:url(/cms/images/page2_right2.jpg) no-repeat right center;margin-right:0px;width:22px' >&nbsp;</div></a>
								</td>

 */	
	function page_show($page,$total_page,$zone_scale,$filename,$link)
	{
		global $img_url;
		
		$IMG_DIR 		= "http://".$_SERVER['SERVER_NAME']."/img";
		
		
		//페이지가 없어면 첫페이지
		if(!$page){$page = 1;}
		$orig_page  = $page;
		$link ="$link";		
		$total_zone = ceil($total_page/$zone_scale); // 총 블럭 수
		$zone = ceil($page/$zone_scale); //현재 블럭
	
		$first_page = ($zone -1)*$zone_scale;
		$last_page = $zone*$zone_scale;
	
		if($total_zone <= $zone) {
			$last_page = $total_page;
		}
		//이전블록
		
		
		if($zone > 1)
		{
			$page = $first_page;
			//$p_zone .= "<p class=\"previous-button\"><a href=\"$filename?$link&page=$page\"><img src=\"$IMG_DIR/btn_prev.gif\" alt=\"앞\" class=\"img_align\"></a></p>";
			
			
			$p_zone .= "
						<td style='padding-left:0px;padding-right:0px'>
						<a href=\"$filename?$link&page=$page\" class='page_normal'>
						<div style='background:url(/cms/images/page2_left1.jpg) no-repeat left center;margin-left:0px;width:22px'/>&nbsp;</div>
						</a>
						</td>
						";			
		} 
			else 
		{
			$p_zone .= "
						<td style='padding-left:0px;padding-right:0px'>
						<a href=\"$filename?$link&page=$page\" class='page_normal'>
						<div style='background:url(/cms/images/page2_left1.jpg) no-repeat left center;margin-left:0px;width:22px'/>&nbsp;</div>
						</a>
						</td>
						";
		}
		
		
		//다음블록
		if($zone < $total_zone)
		{
			$page = $last_page + 1;
			//$n_zone = "<li class=\"nav\"><p class=\"previous-button\"><a href=\"$filename?$link&page=$page\"><img src=\"$IMG_DIR/btn_next.gif\" alt=\"뒤\" class=\"img_align\"></a></p>";
			$n_zone = "
						<td style='padding-left:0px;padding-right:0px'>
						<div><a href=\"$filename?$link&page=$page\"><div style='background:url(/cms/images/page2_right1.jpg) no-repeat right center;margin-left:3px;margin-right:3px;width:16px'/>&nbsp;</div></a>
						</td>
					";
						
		} 
			else 
		{
			//$n_zone = "<li class=\"nav\"><p class=\"previous-button\"><a href=\"#\"><img src=\"$IMG_DIR/btn_next.gif\" alt=\"뒤\" class=\"img_align\"></a></p>";
			// <div style='fil-ter:alpha(opacity=50);opacity:0.5'>
			$n_zone = "
						<td style='padding-left:0px;padding-right:0px'>
						<div><div style='background:url(/cms/images/page2_right1.jpg) no-repeat right center;margin-left:3px;margin-right:3px;width:16px'/>&nbsp;</div>
						</td>
					";			
		}
		
		
		
		// 페이지 번호
		for($page_link = $first_page+1 ; $page_link <= $last_page; $page_link++){
			
			if($orig_page == $page_link)
			{
				//$this_page .= "<li><a href=\"\" class=\"pagingOn\">$page_link</a></li>";
				$this_page .= "
				<td align='center' style='padding-left:7px;padding-right:7px'>
				<!--
				<a href=\"javascript:commentList(1)\"><span style='font-weight:bold;white-space:nowrap' class='page_bold'>1</span></a>
				-->
				<a href=\"".$NOW_PAGE."?$link&page=".$page_link."\"><span style='font-weight:bold;white-space:nowrap' class='page_bold'>$page_link</span></a>
				</td>
				<td width='1'><img src='/cms/images/page2_line.jpg' class='line_09' style='vertical-align:middle'/></td>
				";
								
				
			}
				else
			{
				//$this_page .="<li><a href=\"$filename?$link&page=$page_link\" class=\"\">$page_link</a></li>";
				
				$this_page .= "
				<td align='center' style='padding-left:7px;padding-right:7px'>
				<!--
				<a href=\"javascript:commentList(1)\"><span style='font-weight:bold;white-space:nowrap' class='page_bold'>1</span></a>
				-->
				<a href=\"".$NOW_PAGE."?$link&page=".$page_link."\"><span>$page_link</span></a>
				</td>
				<td width='1'><img src='/cms/images/page2_line.jpg' class='line_09' style='vertical-align:middle'/></td>
				";				
			}
		}
		

		
		//$begin_zone  = "<p><a href=\"".$NOW_PAGE."?page=1\"><img src=\"$IMG_DIR/btn_prev2.gif\"  alt=\"맨앞\" class=\"img_align\" /></a><p>"	;
		
		$begin_zone  = "
		<td style='padding-left:0px;padding-right:0px'>
		<a href=\"".$NOW_PAGE."?$link&page=1\" class='page_normal'>
		<div style='background:url(/cms/images/page2_left2.jpg) no-repeat left center;margin-left:0px;width:22px'/>&nbsp;</div>
		</a>
		</td>
		";		
	
		//$end_zone    = "<p><a href=\"".$NOW_PAGE."?page=".$total_page."\"><img src=\"$IMG_DIR/btn_next2.gif\" alt=\"맨뒤\" class=\"img_align\"></a></p>"	;
		$end_zone    = "
		<td style='padding-left:0px;padding-right:0px'>
		<a href=\"".$NOW_PAGE."?$link&page=".$total_page."\" class='page_normal'><div style='background:url(/cms/images/page2_right2.jpg) no-repeat right center;margin-right:0px;width:22px' >&nbsp;</div></a>
		</td>
		";
		
		
		$page_go = "".$begin_zone."&nbsp;&nbsp;".$p_zone."".$this_page."".$n_zone.$end_zone."";
		
		return $page_go;
	}	

			

	function page_show_root($page,$total_page,$zone_scale,$filename,$link)
	{
		global $img_url;
		
		$IMG_DIR 		= "http://".$_SERVER['SERVER_NAME']."/img";
		
		//페이지가 없어면 첫페이지
		if(!$page){$page = 1;}
		$orig_page  = $page;
		$link="$link";		
		$total_zone = ceil($total_page/$zone_scale); // 총 블럭 수
		$zone = ceil($page/$zone_scale); //현재 블럭
	
		$first_page = ($zone -1)*$zone_scale;
		$last_page = $zone*$zone_scale;
	
		if($total_zone <= $zone) {
			$last_page = $total_page;
		}
		//이전블록
		if($zone > 1)
		{
			$page = $first_page;

			$p_zone = "<a href=\"$filename?$link&page=$page\"><img src=\"$IMG_DIR/news/page_pre.gif\" alt=\"앞\" class=\"img_align\"></a>&nbsp;&nbsp;";
		} 
			else 
		{
			$p_zone = "<a href=\"$filename?$link&page=$page\"><img src=\"$IMG_DIR/news/page_pre.gif\" alt=\"앞\" class=\"img_align\"></a>&nbsp;&nbsp;";
		}
		
		
		//다음블록
		if($zone < $total_zone)
		{
			$page = $last_page + 1;

			$n_zone = "<a href=\"$filename?$link&page=$page\"><img src=\"$IMG_DIR/news/page_next.gif\" alt=\"앞\" class=\"img_align\"></a>&nbsp;&nbsp;";
		} 
			else 
		{
			$n_zone = "<img src=\"$IMG_DIR/news/page_next.gif\" alt=\"앞\" class=\"img_align\">&nbsp;&nbsp;";
		}
		
		// 페이지 번호
		for($page_link = $first_page+1 ; $page_link <= $last_page; $page_link++){
			
			if($orig_page == $page_link)
			{
				$this_page .= "$page_link&nbsp;&nbsp;&nbsp;";
			}
				else
			{
				$this_page .="<a href=\"$filename?$link&page=$page_link\">$page_link</a>&nbsp;&nbsp;&nbsp;";
			}
	
		}
		
		$begin_zone  = "<a href=\"".$NOW_PAGE."?page=1\"><img src=\"$IMG_DIR/news/page_pre2.gif\"  alt=\"맨앞\" class=\"img_align\" /></a> "	;
		$end_zone    = "<a href=\"".$NOW_PAGE."?page=".$total_page."\"><img src=\"$IMG_DIR/news/page_next2.gif\" alt=\"맨뒤\" class=\"img_align\"></a>  "	;
		
		$page_go = $begin_zone.$p_zone.$this_page.$n_zone.$end_zone;
		
		return $page_go;
	}	
	
	
	
	function page_show_admin($page,$total_page,$zone_scale,$filename,$link)
	{
		global $img_url;
		
		$IMG_DIR 		= "http://".$_SERVER['SERVER_NAME']."/img";
		
		//페이지가 없어면 첫페이지
		if(!$page){$page = 1;}
		$orig_page  = $page;
		$link="$link";		
		$total_zone = ceil($total_page/$zone_scale); // 총 블럭 수
		$zone = ceil($page/$zone_scale); //현재 블럭
	
		$first_page = ($zone -1)*$zone_scale;
		$last_page = $zone*$zone_scale;
	
		if($total_zone <= $zone) {
			$last_page = $total_page;
		}
		//이전블록
		if($zone > 1)
		{
			$page = $first_page;

			$p_zone = "<a href=\"$filename?$link&page=$page\"><img src=\"$IMG_DIR/news/page_pre.gif\" alt=\"앞\" class=\"img_align\"></a>&nbsp;&nbsp;";
		} 
			else 
		{
			$p_zone = "<a href=\"$filename?$link&page=$page\"><img src=\"$IMG_DIR/news/page_pre.gif\" alt=\"앞\" class=\"img_align\"></a>&nbsp;&nbsp;";
		}
		
		
		//다음블록
		if($zone < $total_zone)
		{
			$page = $last_page + 1;

			$n_zone = "<a href=\"$filename?$link&page=$page\"><img src=\"$IMG_DIR/news/page_next.gif\" alt=\"앞\" class=\"img_align\"></a>&nbsp;&nbsp;";
		} 
			else 
		{
			$n_zone = "<img src=\"$IMG_DIR/news/page_next.gif\" alt=\"앞\" class=\"img_align\">&nbsp;&nbsp;";
		}
		
		// 페이지 번호
		for($page_link = $first_page+1 ; $page_link <= $last_page; $page_link++){
			
			if($orig_page == $page_link)
			{
				$this_page .= "$page_link&nbsp;&nbsp;&nbsp;";
			}
				else
			{
				$this_page .="<a href=\"$filename?$link&page=$page_link\">$page_link</a>&nbsp;&nbsp;&nbsp;";
			}
	
		}
		
		$begin_zone  = "<a href=\"".$NOW_PAGE."?tbl=".$_GET['tbl']."&page=1\"><img src=\"$IMG_DIR/news/page_pre2.gif\"  alt=\"맨앞\" class=\"img_align\" /></a> "	;
		$end_zone    = "<a href=\"".$NOW_PAGE."?tbl=".$_GET['tbl']."&page=".$total_page."\"><img src=\"$IMG_DIR/news/page_next2.gif\" alt=\"맨뒤\" class=\"img_align\"></a>  "	;
		
		$page_go = $begin_zone.$p_zone.$this_page.$n_zone.$end_zone;
		
		return $page_go;
	}	

	
         function login_session() { 
            $w=date("Ymd_his"); 
            
            srand((double)microtime()*1000000);    
            
            $r= rand(1, 100000); 
            
            return $w."_".$r; 
         } 
	

         
         
         
         
		function passwd_create($idsu)
		{
			$num = array(a,b,c,d,e,f,g,h,i,j,k,l,m,n,o,p,q,r,s,t,u,v,w,x,y,z,1,2,3,4,5,6,7,8,9,0);
			
			for($i=0;$i<$idsu;$i++)
			{
				$rand = rand(0,35);
				$pass .= $num[$rand];
			}
			
			return $pass;
		}         
         

		
/* 이미지 저장 함수정의 */

	function getImg($content) 
	{
		$img = "";
		preg_match("<img [^<>]*>", $content, $imgTag);
		
		if($imgTag[0]){ 
			if( stristr($imgTag[0], "http://") ) {
				preg_match("/http:\/\/.*\.(jp[e]?g|gif|png)/Ui", $imgTag[0], $imgName);
				$img = $imgName[0];
			} else {
				preg_match("/.*\.(jp[e]?g|gif|png)/Ui", $imgTag[0], $imgName);
				$img = $imgName[0];
			}
		}
		return $img;
	}

		function getImg2($content) 
		{
			$img = "";
			preg_match("<input [^<>]*>", $content, $imgTag);
			
			if($imgTag[0]){ 
				if( stristr($imgTag[0], "http://") ) {
					preg_match("/http:\/\/.*\.(jp[e]?g|gif|png)/Ui", $imgTag[0], $imgName);
					$img = $imgName[0];
				} else {
					preg_match("/.*\.(jp[e]?g|gif|png)/Ui", $imgTag[0], $imgName);
					$img = $imgName[0];
				}
			}
			return $img;
		}
		

#### 썸너일 함수시작 ####
function thumnail($file, $save_filename, $save_path, $max_width, $max_height)
{
       $img_info = getImageSize($file);
       if($img_info[2] == 1)
       {
              $src_img = ImageCreateFromGif($file);
              }elseif($img_info[2] == 2){
              $src_img = ImageCreateFromJPEG($file);
              }elseif($img_info[2] == 3){
              $src_img = ImageCreateFromPNG($file);
              }else{
              return 0;
       }
       $img_width = $img_info[0];
       $img_height = $img_info[1];

       if($img_width > $max_width || $img_height > $max_height)
       {
              if($img_width == $img_height)
              {
                     $dst_width = $max_width;
                     $dst_height = $max_height;
              }elseif($img_width > $img_height){
                     $dst_width = $max_width;
                     $dst_height = ceil(($max_width / $img_width) * $img_height);
              }else{
                     $dst_height = $max_height;
                     $dst_width = ceil(($max_height / $img_height) * $img_width);
              }
       }else{
              $dst_width = $img_width;
              $dst_height = $img_height;
       }
       if($dst_width < $max_width) $srcx = ceil(($max_width - $dst_width)/2); else $srcx = 0;
       if($dst_height < $max_height) $srcy = ceil(($max_height - $dst_height)/2); else $srcy = 0;

       if($img_info[2] == 1) 
       {
              $dst_img = imagecreate($max_width, $max_height);
       }else{
              $dst_img = imagecreatetruecolor($max_width, $max_height);
       }

       $bgc = ImageColorAllocate($dst_img, 255, 255, 255);
       ImageFilledRectangle($dst_img, 0, 0, $max_width, $max_height, $bgc); 
       ImageCopyResampled($dst_img, $src_img, $srcx, $srcy, 0, 0, $dst_width, $dst_height, ImageSX($src_img),ImageSY($src_img));

       if($img_info[2] == 1) 
       {
              ImageInterlace($dst_img);
              ImageGif($dst_img, $save_path.$save_filename);
       }elseif($img_info[2] == 2){
              ImageInterlace($dst_img);
              ImageJPEG($dst_img, $save_path.$save_filename);
       }elseif($img_info[2] == 3){
              ImagePNG($dst_img, $save_path.$save_filename);
       }
       ImageDestroy($dst_img);
       ImageDestroy($src_img);
}
#### 썸네일 끝 ####


	function date_type($date, $type="")
	{
		$ret = "";
		if(empty($type))
		{
			$ret = $date;
		}else if($type=="A"){
			$ret = substr(str_replace("-",".",$date),2,14);
		}
		
		return $ret;
	}

	

function Gsnetwork_file_check($file)
{
	if(!preg_match("/\//",$file))
	{
		$file = "2011/".$file;
	}
	
	
	$filename = "/app/ask/".$file;
	
	$filename = trim($filename);	
	
	//echo file_exists($filename);
	
	if (file_exists($filename) == 1) {
		
		$ret = 'Y';
	}
	else
	{
		$ret = 'N';
	}
	
	
	$ret = "Y";
	
	/*
	// 업로드 포트
	$up_url = "1.227.196.9";
	$up_port = 7777;
	$conn_id = ftp_connect($up_url, $up_port);
	if ($conn_id)
	{
			$login_result = ftp_login($conn_id, "ask", "ask!@#");
			if ($login_result)
			{
				ftp_pasv($conn_id,true);
				if(!preg_match("/.mp4/i",$file))
				{
					$res = ftp_size($conn_id, $file.".mp4");
				}else{
					$res = ftp_size($conn_id, $file);
				}

				if ($res != -1)
				{
					$ret = "Y";
				}else{
					$ret = "N";
				}

			}
	}
	ftp_close($conn_id);
	*/
	
	return $ret;
}



function flowplay_flash($file, $m_width="", $m_height="", $bg_image="")
{
	
	$rand_num = rand(111,999);
	$movie_file = "mp4:".$file;
	//$movie_url = $movie_file;
	//if(!eregi("/",$file))
	if(!preg_match("/\//",$file))
	{
		// 2011년도 구 동영상
		//if(!eregi(".mp4",$file))
		if(!preg_match("/.mp4/",$file))
		{
			$movie_url = "http://ask.cheongsol.co.kr/2011/".$file.".mp4";
		}else{
			$movie_url = "http://ask.cheongsol.co.kr/2011/".$file;
		}

	}else{
		
		// 최신동영상
		if(!preg_match("/.mp4/",$file))
		{
			$movie_url = "http://ask.cheongsol.co.kr/".$file.".mp4";
		}else{
			$movie_url = "http://ask.cheongsol.co.kr/".$file;
		}
	}
	
	//echo $movie_url;


	if(empty($m_width))
	{
		$m_width="640";
	}

	if(empty($m_height))
	{
		$m_height="377";
	}


	
	$file_check = Gsnetwork_file_check($file);
	
	
	//$bg_image = "http://img.etoos.com/report/report/2014/03/it/movie.jpg";
	
	
	if(!empty($bg_image))
	{
		$bg_opt = "background-image:url('{$bg_image}')";
	}
	
	if ($file_check=="Y") {
		
		//echo "<div id='related_{$rand_num}'></div>\n";
		
		//echo "<div id='info_{$rand_num}'></div>\n";
		
		//echo "<div id='movie_banner_{$rand_num}' id=\"splash_img\" style=\"display:none;\" class=\"startad_mov\"><a href='{$main_link}' target='parent'><img src=\"{$main_img}\" /></a></div>";
		
		echo "<div id='movie_layer_{$rand_num}' style='width:{$m_width}px;height:{$m_height}px; {$bg_opt}' ></div>\n";
		
		include $_SERVER['DOCUMENT_ROOT']."/inc/flowplay.php";
		
		echo "</div>";
		
	} else {
		if($m_width==511)
		{
			echo "<img src='http://ask.cheongsol.co.kr/data/ask_cate_thumbnail/movie_trans_msg_s.jpg'>";
		}else{
			echo "<img src='http://ask.cheongsol.co.kr/data/ask_cate_thumbnail/movie_trans_msg.jpg'>";
		}
	}
}



function flowplay($file, $m_width="", $m_height="", $pmode="", $bg_image='')
{
	
	//$file = 'CS/firstree/001_001_002_003_038_11061.mp4';
	//$file = 'CS/firstree/14K_01_1.mp4';
	
	$rand_num = rand(111,999);
	$movie_file = "mp4:".$file;
	//$movie_url = $movie_file;
	//if(!eregi("/",$file))
	if(!preg_match("/\//",$file))
	{
		// 2011년도 구 동영상
		//if(!eregi(".mp4",$file))
		if(!preg_match("/.mp4/",$file))
		{
			$movie_url = "http://ask.cheongsol.co.kr/2011/".$file.".mp4";
		}else{
			$movie_url = "http://ask.cheongsol.co.kr/2011/".$file;
		}

	}else{
		
		// 최신동영상
		if(!preg_match("/.mp4/",$file))
		{
			$movie_url = "http://ask.cheongsol.co.kr/".$file.".mp4";
		}else{
			$movie_url = "http://ask.cheongsol.co.kr/".$file;
		}
	}
	
	//echo $movie_url;

	$file_check = Gsnetwork_file_check($file);

	if(empty($m_width))
	{
		$m_width="640";
	}

	if(empty($m_height))
	{
		$m_height="377";
	}

	/*
	// AB다
	$p_banner[0]['link_url']	= "/nondang/abda.php";
	$p_banner[0]['banner_img']	= "http://www.ask.co.kr/images/flowplayer/ad_preload_abda.png";

	// 독쫑수학
	$p_banner[1]['link_url']	= "/nondang/dokjjong_subject_math.php";
	$p_banner[1]['banner_img']	= "http://img.ask.co.kr/images/banner/flowplayer/bnpreload_math.png";

	// 성적조작단 시즌3
	$p_banner[2]['link_url']	= "javascript:alert(\"준비중입니다!\");";
	$p_banner[2]['banner_img']	= "http://img.ask.co.kr/banner/flowplayer/bnpreload_levelup.png";

	$p_nansu = mt_rand(0, 2);
	*/


	
	
	if ($file_check=="Y") {
		
		//echo "<div id='related_{$rand_num}'></div>";
		//echo "<div id='info_{$rand_num}'></div>";
		//echo "<div id='movie_banner_{$rand_num}' id=\"splash_img\" style=\"display:none;\" class=\"startad_mov\"><a href='{$main_link}' target='parent'><img src=\"{$main_img}\" /></a></div>";
		//echo "<div id='movie_layer_{$rand_num}' style='width:{$m_width}px;height:{$m_height}px' ></div>";
		
		//include $_SERVER['DOCUMENT_ROOT']."/inc/flowplay.php";
		include $_SERVER['DOCUMENT_ROOT']."/inc/flowplay_html5.php";
		
		//echo "<script>flowplayer('{$movie_file}', '', '', '');</script>";
	} else {
		if($m_width==511)
		{
			echo "<img src='http://ask.cheongsol.co.kr/data/ask_cate_thumbnail/movie_trans_msg_s.jpg'>";
		}else{
			echo "<img src='http://ask.cheongsol.co.kr/data/ask_cate_thumbnail/movie_trans_msg.jpg'>";
		}
	}
}



function flowplay_tmp($file, $m_width="", $m_height="")
{
	
	//$file = 'CS/firstree/001_001_002_003_038_11061.mp4';
	//$file = 'CS/firstree/14K_01_1.mp4';
	
	$rand_num = rand(111,999);
	$movie_file = "mp4:".$file;
	//$movie_url = $movie_file;
	//if(!eregi("/",$file))
	if(!preg_match("/\//",$file))
	{
		// 2011년도 구 동영상
		//if(!eregi(".mp4",$file))
		if(!preg_match("/.mp4/",$file))
		{
			$movie_url = "http://ask.cheongsol.co.kr/2011/".$file.".mp4";
		}else{
			$movie_url = "http://ask.cheongsol.co.kr/2011/".$file;
		}

	}else{
		
		// 최신동영상
		if(!preg_match("/.mp4/",$file))
		{
			$movie_url = "http://ask.cheongsol.co.kr/".$file.".mp4";
		}else{
			$movie_url = "http://ask.cheongsol.co.kr/".$file;
		}
	}
	
	//echo $movie_url;

	$file_check = Gsnetwork_file_check($file);

	if(empty($m_width))
	{
		$m_width="640";
	}

	if(empty($m_height))
	{
		$m_height="377";
	}


	
	if ($file_check=="Y") {
		
		//echo "<div id='related_{$rand_num}'></div>";
		//echo "<div id='info_{$rand_num}'></div>";
		//echo "<div id='movie_banner_{$rand_num}' id=\"splash_img\" style=\"display:none;\" class=\"startad_mov\"><a href='{$main_link}' target='parent'><img src=\"{$main_img}\" /></a></div>";
		//echo "<div id='movie_layer_{$rand_num}' style='width:{$m_width}px;height:{$m_height}px' ></div>";
		
		//include $_SERVER['DOCUMENT_ROOT']."/inc/flowplay.php";
		include $_SERVER['DOCUMENT_ROOT']."/inc/flowplay_html5_tmp.php";
		
		//echo "<script>flowplayer('{$movie_file}', '', '', '');</script>";
	} else {
		if($m_width==511)
		{
			echo "<img src='http://ask.cheongsol.co.kr/data/ask_cate_thumbnail/movie_trans_msg_s.jpg'>";
		}else{
			echo "<img src='http://ask.cheongsol.co.kr/data/ask_cate_thumbnail/movie_trans_msg.jpg'>";
		}
	}
}



function nowcdn_movie_flash($file, $bno="", $m_width="", $m_height="", $mode="", $bg_image="") {
	static $nowcdn_movie_num = 1;
	$nowcdn_movie_num++;

	//----------------------모바일기기가 아닐경우 flowplayer로 재생 START----------------------------//
	$mobile_agent_cnt = 0;
	$arr_browser = array("test","iPhone","iPod","iPad","IEMobile","Mobile","lgtelecom","PPC","Android");
	
	for($b=0; $b<sizeof($arr_browser); $b++){
		if(stripos($_SERVER[HTTP_USER_AGENT], $arr_browser[$b]) > -1) $mobile_agent_cnt++;
	}
	
	if($mobile_agent_cnt==0)
	{
		flowplay_flash($file, $m_width, $m_height, $bg_image);
		return;
	}
	/////////////////-----------------------END---------------------/////////////////////////////////

	global $mysql;
	$db = new kMysql($mysql);
	list($cate_code) = $db->select_fetch_row("p_board", array("p_category"), "where no='{$bno}'");
//	$cate_code = "010202";
//	echo $cate_code." | ".substr($cate_code,0,6)." | ";
	list($p_imgfile) = $db->select_fetch_row("ask_cate_thumbnail", array("p_imgfile"), "where cate_code='{$cate_code}'");
	if (!$p_imgfile) {
		list($p_imgfile) = $db->select_fetch_row("ask_cate_thumbnail", array("p_imgfile"), "where cate_code='".substr($cate_code,0,6)."'");
	}
	if (!$p_imgfile) {
		list($p_imgfile) = $db->select_fetch_row("ask_cate_thumbnail", array("p_imgfile"), "where cate_code='".substr($cate_code,0,4)."'");
	}
	if (!$p_imgfile) {
		list($p_imgfile) = $db->select_fetch_row("ask_cate_thumbnail", array("p_imgfile"), "where cate_code='".substr($cate_code,0,2)."'");
	}
	if (!$p_imgfile) {
		list($p_imgfile) = $db->select_fetch_row("ask_cate_thumbnail", array("p_imgfile"), "where cate_code=''");
	}


	// 업로드 포트
	
	/*
	$up_url = "1.227.196.9";
	$up_port = 7777;
	$conn_id = ftp_connect($up_url, $up_port);
	*/

	$mobile = 0;
	$arr_browser = array("test","iPhone","iPod","iPad","IEMobile","Mobile","lgtelecom","PPC","Android");
	for($b=0; $b<sizeof($arr_browser); $b++){
		if(stripos($_SERVER[HTTP_USER_AGENT], $arr_browser[$b]) > -1) $mobile++;
	}


	if($mobile){


			//if(!eregi("/",$file))
			if(!preg_match("/\//i",$file))
			{
				if(preg_match("/mp4/i",$file))
				{
					//$serverURL = "http://mento.ask.gscdn.com/2011/".$file;
					$serverURL = "http://ask.cheongsol.co.kr/2011/".$file;
				}else{
					//$serverURL = "http://mento.ask.gscdn.com/2011/".$file.".mp4";
					$serverURL = "http://ask.cheongsol.co.kr/2011/".$file;
				}

			}else{
				//if(ereg("mp4",$file))
				if(preg_match("/mp4/i",$file))
				{
					//$serverURL = "http://mento.ask.gscdn.com/".$file;
					$serverURL = "http://ask.cheongsol.co.kr/".$file;
				}else{
					//$serverURL = "http://mento.ask.gscdn.com/".$file.".mp4";
					$serverURL = "http://ask.cheongsol.co.kr/".$file.".mp4";
				}

			}

			//qr코드일경우 리퍼페이지가없으니 바로 동영상 플레이 이동
			$refer_page = $_SERVER['HTTP_REFERER'];
			
			
			if(empty($refer_page) && $mode!="pagestop")
			{
				echo "<script>location.href='{$serverURL}';</script>";
			}



			///$code = "<a href='http://mentor.nowcdn.co.kr/mentor/mp4:{$file}.mp4/playlist.m3u8'>".$serverURL."</a>";

			$code = <<<END
				<div id="nowcdn_movie_{$nowcdn_movie_num}"><a href="{$serverURL}"><img src='http://ask.cheongsol.co.kr/data/ask_cate_thumbnail/{$p_imgfile}' style="cursor:pointer" onclick='nowcdn_movie_play{$nowcdn_movie_num}();'></a></div>
END;


	}

	return $code;
}





/**
 * @Method Name  : nowcdn_movie
 * @작성일   : 2013. 8. 2.
 * @작성자   : ghostrok
 * @변경이력  :
 * @Method 설명 :
 * @param unknown $file
 * @param string $bno
 * @param string $m_width
 * @param string $m_height
 * @param string $mode
 * @return void|string
 */

function nowcdn_movie($file, $bno="", $m_width="", $m_height="", $mode="", $pmode='', $bg_image='') {
	
	static $nowcdn_movie_num = 1;
	$nowcdn_movie_num++;

	/*
	echo $mode;
	exit;
	*/
	
	//----------------------모바일기기가 아닐경우 flowplayer로 재생 START----------------------------//
	$mobile_agent_cnt = 0;
	$arr_browser = array("test","iPhone","iPod","iPad","IEMobile","Mobile","lgtelecom","PPC","Android");
	
	for($b=0; $b<sizeof($arr_browser); $b++){
		if(stripos($_SERVER[HTTP_USER_AGENT], $arr_browser[$b]) > -1) $mobile_agent_cnt++;
	}
	
	if($mobile_agent_cnt==0)
	{
		// HTML5 플레이어 호출 
		flowplay($file, $m_width, $m_height, $pmode, $bg_image);
		
		return;
	}
	/////////////////-----------------------END---------------------/////////////////////////////////


	$p_imgfile = "_1306745303.jpg";
	

	$mobile = 0;
	$arr_browser = array("test","iPhone","iPod","iPad","IEMobile","Mobile","lgtelecom","PPC","Android");
	for($b=0; $b<sizeof($arr_browser); $b++){
		if(stripos($_SERVER[HTTP_USER_AGENT], $arr_browser[$b]) > -1) $mobile++;
	}


	if($mobile){


			//if(!eregi("/",$file))
			if(!preg_match("/\//i",$file))
			{
				if(preg_match("/mp4/i",$file))
				{
					//$serverURL = "http://mento.ask.gscdn.com/2011/".$file;
					$serverURL = "http://ask.cheongsol.co.kr/2011/".$file;
				}else{
					//$serverURL = "http://mento.ask.gscdn.com/2011/".$file.".mp4";
					$serverURL = "http://ask.cheongsol.co.kr/2011/".$file;
				}

			}else{
				//if(ereg("mp4",$file))
				if(preg_match("/mp4/i",$file))
				{
					//$serverURL = "http://mento.ask.gscdn.com/".$file;
					$serverURL = "http://ask.cheongsol.co.kr/".$file;
				}else{
					//$serverURL = "http://mento.ask.gscdn.com/".$file.".mp4";
					$serverURL = "http://ask.cheongsol.co.kr/".$file.".mp4";
				}

			}

			//qr코드일경우 리퍼페이지가없으니 바로 동영상 플레이 이동
			$refer_page = $_SERVER['HTTP_REFERER'];
			
			
			if(empty($refer_page) && $mode!="pagestop")
			{
				echo "<script>location.href='{$serverURL}';</script>";
			}

;

			///$code = "<a href='http://mentor.nowcdn.co.kr/mentor/mp4:{$file}.mp4/playlist.m3u8'>".$serverURL."</a>";

			$code = <<<END
				<div id="nowcdn_movie_{$nowcdn_movie_num}"><a href="{$serverURL}"><img src='http://ask.cheongsol.co.kr/data/ask_cate_thumbnail/{$p_imgfile}' style="cursor:pointer" onclick='nowcdn_movie_play{$nowcdn_movie_num}();'></a></div>
END;


	}

	return $code;
}


function nowcdn_movie_tmp($file, $bno="", $m_width="", $m_height="", $mode="") {
	static $nowcdn_movie_num = 1;
	$nowcdn_movie_num++;

	//----------------------모바일기기가 아닐경우 flowplayer로 재생 START----------------------------//
	$mobile_agent_cnt = 0;
	$arr_browser = array("test","iPhone","iPod","iPad","IEMobile","Mobile","lgtelecom","PPC","Android");
	
	for($b=0; $b<sizeof($arr_browser); $b++){
		if(stripos($_SERVER[HTTP_USER_AGENT], $arr_browser[$b]) > -1) $mobile_agent_cnt++;
	}
	
	if($mobile_agent_cnt==0)
	{
		flowplay_tmp($file, $m_width, $m_height);
		return;
	}
	/////////////////-----------------------END---------------------/////////////////////////////////

	global $mysql;
	$db = new kMysql($mysql);
	list($cate_code) = $db->select_fetch_row("p_board", array("p_category"), "where no='{$bno}'");
//	$cate_code = "010202";
//	echo $cate_code." | ".substr($cate_code,0,6)." | ";
	list($p_imgfile) = $db->select_fetch_row("ask_cate_thumbnail", array("p_imgfile"), "where cate_code='{$cate_code}'");
	if (!$p_imgfile) {
		list($p_imgfile) = $db->select_fetch_row("ask_cate_thumbnail", array("p_imgfile"), "where cate_code='".substr($cate_code,0,6)."'");
	}
	if (!$p_imgfile) {
		list($p_imgfile) = $db->select_fetch_row("ask_cate_thumbnail", array("p_imgfile"), "where cate_code='".substr($cate_code,0,4)."'");
	}
	if (!$p_imgfile) {
		list($p_imgfile) = $db->select_fetch_row("ask_cate_thumbnail", array("p_imgfile"), "where cate_code='".substr($cate_code,0,2)."'");
	}
	if (!$p_imgfile) {
		list($p_imgfile) = $db->select_fetch_row("ask_cate_thumbnail", array("p_imgfile"), "where cate_code=''");
	}


	// 업로드 포트
	
	/*
	$up_url = "1.227.196.9";
	$up_port = 7777;
	$conn_id = ftp_connect($up_url, $up_port);
	*/

	$mobile = 0;
	$arr_browser = array("test","iPhone","iPod","iPad","IEMobile","Mobile","lgtelecom","PPC","Android");
	for($b=0; $b<sizeof($arr_browser); $b++){
		if(stripos($_SERVER[HTTP_USER_AGENT], $arr_browser[$b]) > -1) $mobile++;
	}


	if($mobile){


			//if(!eregi("/",$file))
			if(!preg_match("/\//i",$file))
			{
				if(preg_match("/mp4/i",$file))
				{
					//$serverURL = "http://mento.ask.gscdn.com/2011/".$file;
					$serverURL = "http://ask.cheongsol.co.kr/2011/".$file;
				}else{
					//$serverURL = "http://mento.ask.gscdn.com/2011/".$file.".mp4";
					$serverURL = "http://ask.cheongsol.co.kr/2011/".$file;
				}

			}else{
				//if(ereg("mp4",$file))
				if(preg_match("/mp4/i",$file))
				{
					//$serverURL = "http://mento.ask.gscdn.com/".$file;
					$serverURL = "http://ask.cheongsol.co.kr/".$file;
				}else{
					//$serverURL = "http://mento.ask.gscdn.com/".$file.".mp4";
					$serverURL = "http://ask.cheongsol.co.kr/".$file.".mp4";
				}

			}

			//qr코드일경우 리퍼페이지가없으니 바로 동영상 플레이 이동
			$refer_page = $_SERVER['HTTP_REFERER'];
			
			
			if(empty($refer_page) && $mode!="pagestop")
			{
				echo "<script>location.href='{$serverURL}';</script>";
			}



			///$code = "<a href='http://mentor.nowcdn.co.kr/mentor/mp4:{$file}.mp4/playlist.m3u8'>".$serverURL."</a>";

			$code = <<<END
				<div id="nowcdn_movie_{$nowcdn_movie_num}"><a href="{$serverURL}"><img src='http://ask.cheongsol.co.kr/data/ask_cate_thumbnail/{$p_imgfile}' style="cursor:pointer" onclick='nowcdn_movie_play{$nowcdn_movie_num}();'></a></div>
END;


	}

	return $code;
}
	
	function getMentalkNansuChk($args) {
		if (is_array($args)) foreach ($args as $k => $v) ${$k} = $v;

		$rand_num = mt_rand(0, $end_num);

		include_once($_SERVER['DOCUMENT_ROOT']."/thefun/event/event_mento_talk.php");

		if ($title_arr['subject'.$tab_menu][$rand_num] == "" || ($nansu == $rand_num) || ($mento_num == $rand_num)) {
			#제목이 없을경우 다른 멘토로.. 난수 재 생성
			$args				= array();
			$args['nansu']		= $rand_num;
			$Args['end_num']	= $end_num;
			$Args['tab_menu']	= $tab_menu;
			$Args['mento_num']	= $mento_num;

			util::getMentalkNansuChk($args);

			return;
		}

		return $rand_num;
	}
			

	/*<pre>
	* package_name
	*   |_ file_name
	* </pre>
	* 
	* Desc : 공통페이징 함수 
	* @Company : ETOOS. Inc
	* @Author  : ghostrok
	* @Date    : 2014. 3. 24. 오후 4:19:01
	* @Version : 
	*/
	function paging_new($totalnum, $curpage, $num_page, $num_list, $pre_url="", $pagetype="board")
	{
		$_page = $curpage ? (int)$curpage : 1;

		$p[page] = 1; // 제외
		if($pagetype == "board")
		{
			if($pre_url) $url = $pre_url;
			else $url = boardlib::make_url($_SERVER[PHP_SELF], $p);

			$page = boardlib::page_array($totalnum, $_page, $num_page, $num_list, $url);
		}else if($pagetype == "comment") {
	        	$page = boardlib::page_array_comment($totalnum, $_page, $num_page, $num_list);
		}


		$msg_pprev = "
		<a href='{$page['pprev']}' title='맨앞' class='num_first'></a>"; // 처음

		$msg_nnext = "
		<a href='{$page['nnext']}' title='맨뒤' class='num_end'></a> "; // 끝

		$msg_prev = "
		<a href='{$page['prev']}' title='이전' class='num_prev'></a>"; // 이전
		$msg_next = "
		<a href='{$page['next']}' title='다음' class='num_next'></a>"; // 다음

		if($page['pprev'])
		{
			$pprev = "
			<a href='{$page['pprev']}' title='맨앞' class='num_first'></a>";
		}else {
			$pprev = "
			<a href='javascript:;' title='맨앞' class='num_first'></a>"; // 반투명
		}

		if($page['nnext']) {
			$nnext = "
			<a href='{$page['nnext']}' title='맨뒤' class='num_end'></a>";
		}
		else {
			$nnext = "
			<a href='javascript:;' title='맨뒤' class='num_end'></a>"; // 반투명
		}

		if($page[prev]) {
			$prev = "
			<a href='{$page['prev']}' title='이전' class='num_prev'></a>";
		}
		else {
			$prev = "
			<a href='javascript:;' title='이전' class='num_prev'></a>"; // 반투명
		}

		if($page[next]) {
			$next = "
			<a href='{$page['next']}' title='다음' class='num_next'></a>";
		}
		else {
			$next = "
			<a href='javascript:;' title='다음' class='num_next'></a>"; // 반투명
		}




		$msg .= $pprev." ";
		$msg .= $prev." ";


		$p = (int)$page["page0"]; if($p == 0) $p = "1";
		for($i=0; $i<$num_list; $i++) {
			if($page["link$i"] == "") break;

			$style = $p == $_page ? "font-weight:bold" : "";
			$cls = $p == $_page ? "class='cur_num'" : "class='num_box'";

			//if($i > 0) $msg .= "<img src='{$imgLine}' class='line_09' style='vertical-align:middle'/></td>";

			$msg .= " <a href=\"{$page["link$i"]}\" ><strong {$cls}>{$p}</strong></a> ";
			$p = $p+1;
		}
		if($i==0) {
			$msg .= " <strong class='cur_num'>1</strong> ";
		}

		$msg .= $next." ";
		$msg .= $nnext." ";

		return $msg;
	}
		
	
	/**
	 * Enter description here ...
	 * @param unknown_type $msg
	 */
	function writeLog($logs, $file_name='')
	{
		
		if(empty($file_name)) {
		
			$fname ="/app/ask/log/etc/etc_".date('Ymd').".txt";
		} else {
			
			$fname ="/app/ask/log/etc/".$file_name."_".date('Ymd').".txt";
		}
		
		
		$logs   = date("Y/m/d H:i:s")." : ".$logs."\n";
		
		
		
		/*
		$host = @getenv("HOSTNAME");
		$Home = @getenv("ORACLE_HOME");
		$ymd = date("Y/m/d H:i:s");

		$string = $msg;
		$string .= "\n conn error : \n". print_r(@ocierror($this->conn[$connName]), true);
		$string .= "\n stmt error : \n" . print_r(@ocierror($this->stmt), true);
		$string .= "\n query : \n" . $this->qry;
		$string .= "\n arrBind : \n" . print_r($this->arrBind, true);

		$tmp = array();
		foreach($_POST as $key => $value) {
			$tmp[]  = $key."=".$value;
		}

		$param = implode('&', $tmp);
		*/
		
		
		$fp = @fopen($fname,"a+");

		/*
		$message  = "\n\n-------------------------------------------------------------------------------------------------\n\n";
		//$message .= 'userid = ' . (isUser() ? getUserId() : 'guest') . ', remote_addr = ' .getIP();
		$message .= ', date = ' . $ymd . ', request_uri = ' . ($_SERVER['REQUEST_URI'] ? $_SERVER['REQUEST_URI'] : $PHP_SELF);
		$message .= ', parameters = ' . $param . ', host = ' . $host . ', home = ' .  $Home . "\n\n" . $string;
		*/
		

		@fwrite($fp, $logs);
		@fclose($fp);
				
	}
		
	
?>