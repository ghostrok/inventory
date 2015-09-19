<?php 
include_once ($_SERVER['DOCUMENT_ROOT']."/lib/config/config.php");
include_once ($LIB_DIR."/config/config.php");
include_once ($LIB_DIR."/function/function_common.php");
include_once ($SMARTY_HOME."/LoginDAO.php");
$login_dao = new LoginDAO();


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<html>
<head>
<title>:재고관리시스템(inventory)</title>

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="Content-Script-Type" content="text/javascript" />
    <meta http-equiv="Content-Style-Type" content="text/css" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />   
    <meta http-equiv="Page-Enter" content="BlendTrans(Duration=0.1)" />
    <meta http-equiv="Page-Exit" content="BlendTrans(Duration=0.1)" />

    <meta property="og:title"           content="재고관리"/>
    <meta property="og:type"            content="article"/>
    <meta property="og:image"           content=""/>
    <meta property="og:url"             content=""/>
    <meta property="og:description"     content="

    <!-- JQuery 기본셋 -->
    <link rel="stylesheet" type="text/css" href="/js/jquery/themes/smoothness/jquery-ui-1.8.13.custom.css?v=2015041001" />
    <script type="text/javascript" charset="utf-8" src="/js/jquery/jquery-1.8.3.min.js?v=20141217"></script>
    <script type="text/javascript" charset="utf-8" src="/js/jquery/jquery.form.js?v=20141217"></script>
    <script type="text/javascript" charset="utf-8" src="/js/jquery/jquery-ui-1.8.13.custom.min.js?v=20141217"></script>
    <script type="text/javascript" charset="utf-8" src="/js/jquery/jquery.cycle.all.js?v=20141217"></script>
    
    <!-- JQuery Datepicker -->
    <link type="text/css" rel="StyleSheet" href="/js/jquery/datepicker/jquery.datePicker.css?v=2015041001"  />
    <script type="text/javascript" charset="utf-8" src="/js/jquery/datepicker/jquery.date.js?v=20141217"></script>
    <script type="text/javascript" charset="utf-8" src="/js/jquery/datepicker/jquery.datePicker.js?v=20141217"></script>
    <script type="text/javascript" charset="utf-8" src="/js/jquery/datepicker/jquery.datePicker.locale.kr.js?v=20141217"></script>

    <!-- 사용자 정의 -->
    <script type="text/javascript" charset="utf-8" src="/js/common/JCommon.js?v=20141217"></script>
    <script type="text/javascript" charset="utf-8" src="/js/common/JCheck.js?v=20141217"></script>
    <script type="text/javascript" charset="utf-8" src="/js/common/JString.js?v=20141217"></script>
    <script type="text/javascript" charset="utf-8" src="/js/common/JSubmit.js?v=20141217"></script>
    <script type="text/javascript" charset="utf-8" src="/js/common/JFile.js?v=20141217"></script>
    <script type="text/javascript" charset="utf-8" src="/js/common/JIFrame.js?v=20141217"></script>
    <script type="text/javascript" charset="utf-8" src="/js/common/JPage.js?v=20141217"></script>

</head>
<!--
======================================================================================================
This template is available for free download from the Quackit website.

If you have found it to be useful, please consider linking from your website to http://www.quackit.com

Thanks!
======================================================================================================

Note the following:
1. Each frame has it's own 'frame' tag.
2. Each frame has a name (eg, name="menu"). This is used for when you need to load one frame from another. For example, your left frame might have links that, when clicked on, loads a new page in the right frame. This is acheived by using 'target="content"' within your links/anchor tags.
3. Each 'frame' tag has a 'src' attribute. This is where you specify the name of the file to be loaded into that frame when the page first loads.
4. You can change the size of the frames by changing the value of the 'cols' and/or 'rows' attribute. A value of "200" sets the frame at 200 pixels. An asterisk (*) specifies that the frame should use up whatever space is left over from the other frames. You can also use percentage values if desired (i.e. 20%,80%)
5. To specify a border, set 'frameborder' and 'border' to "1". I included both attributes for maximum browser compatibility.
6. The 'framespacing' attribute doesn't work in all browsers, but you can set any numeric value you like here.
7. To learn more about HTML frames, check out: http://www.quackit.com/html/tutorial/html_frames.cfm
-->

<frameset rows="100,*,80" frameborder="0" border="0" framespacing="0">
  <frame name="topNav" src="top_nav.php">
<frameset cols="200,*" frameborder="0" border="0" framespacing="0">
	<frame name="menu" src="left.php" marginheight="0" marginwidth="0" scrolling="auto" noresize>
	<frame name="content" src="main.php" marginheight="0" marginwidth="0" scrolling="auto" noresize>
</frameset>

  <frame name="footer" src="footer.php">

<noframes>
<p>This section (everything between the 'noframes' tags) will only be displayed if the users' browser doesn't support frames. You can provide a link to a non-frames version of the website here. Feel free to use HTML tags within this section.</p>
</noframes>

</frameset>
</html>