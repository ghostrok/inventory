   	<link rel="stylesheet" type="text/css" href="http://gangnam.cheongsol.co.kr/css/portal2/default.css?v=2015041001" />
   	<link rel="stylesheet" type="text/css" href="http://gangnam.cheongsol.co.kr/css/portal2/JPortalAll.css?v=2015041001" />
   	
    
    <!-- ======================================================== -->
    <!-- 페이징 영역 -->
    <!-- ======================================================== -->

	<form>

	<!-- 목록 개수 -->
	<!-- 페이지 수 -->
	<!-- 코드목록에서 메뉴기능등급 관련 코드를 취득한다. -->
	   	
<?
	
	function page_show($page,$total_page,$zone_scale,$filename,$link)
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

			//$p_zone = "<a href=\"$filename?$link&page=$page\"><img src=\"$IMG_DIR/news/page_pre.gif\" alt=\"앞\" class=\"img_align\"></a>&nbsp;&nbsp;";
			$p_zone = "<a href=\"javascript:fn_pager('#form_post_list', '10')\" class=\"prev\" title=\"이전\"><span class=\"blind\">이전</span></a>\n";
		} 
			else 
		{
			//$p_zone = "<a href=\"$filename?$link&page=$page\"><img src=\"$IMG_DIR/news/page_pre.gif\" alt=\"앞\" class=\"img_align\"></a>&nbsp;&nbsp;";
			$p_zone = "<a href=\"javascript:fn_pager('#form_post_list', '10')\" class=\"prev\" title=\"이전\"><span class=\"blind\">이전</span></a>\n";
		}
		
		
		//다음블록
		if($zone < $total_zone)
		{
			$page = $last_page + 1;

			//$n_zone = "<a href=\"$filename?$link&page=$page\"><img src=\"$IMG_DIR/news/page_next.gif\" alt=\"앞\" class=\"img_align\"></a>&nbsp;&nbsp;";
			$n_zone = "<a href=\"javascript:fn_pager('#form_post_list', '21')\" class=\"last\" title=\"다음\"><span class=\"blind\">다음</span></a>\n";
		} 
			else 
		{
			//$n_zone = "<img src=\"$IMG_DIR/news/page_next.gif\" alt=\"앞\" class=\"img_align\">&nbsp;&nbsp;";
			$n_zone = "<a href=\"javascript:fn_pager('#form_post_list', '21')\" class=\"last\" title=\"다음\"><span class=\"blind\">다음</span></a>\n";
		}
		
		
		
		// 페이지 번호
		for($page_link = $first_page+1 ; $page_link <= $last_page; $page_link++) {
			
			
			if($orig_page == $page_link)
			{
				// 현재페이지
				//$this_page .= "$page_link&nbsp;&nbsp;&nbsp;";
				$this_page .= "<a href=\"javascript:void(0);\" class=\"on\" title=\"11\">".$page_link."</a>\n";
			}
				else
			{
				// 번호표시페이지
				//$this_page .="<a href=\"$filename?$link&page=$page_link\">$page_link</a>&nbsp;&nbsp;&nbsp;";
				$this_page .="<a href=\"$filename?$link&page=$page_link\" title=\"".$page_link."\">".$page_link."</a>\n";
			}
	
		}
		
		$beg_div  = "<div class=\"paging\"> " ;
		$end_div  = "</div>"	;
		
		$page_go = $beg_div.$p_zone.$this_page.$n_zone.$end_div;
		
		return $page_go;
	}	
         
         
         
?>

		    <!-- ======================================================== -->
		        
</form>



    
    <!-- ======================================================== -->
    <!-- 페이징 영역 끝 -->
    <!-- ======================================================== -->
