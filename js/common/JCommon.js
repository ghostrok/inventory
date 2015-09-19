/********************************************************
파일명 : JCommon.js
설  명 : JFramework 공통 JavaScript

수정일     수정자   Version    Function 명
---------- -------- ---------- --------------
2009.01.12 함장수   1.0        최초 생성
*********************************************************/



/************************************************************************
함수명 : fn_show_result_message
설  명 : 폼 전송 후 서버에서 보내는 메세지 출력
인  자 : 없음
사용법 : fn_show_result_message()
작성일 : 2009.01.12
작성자 : 함장수

수정일         수정자   수정내용
------------   ------   -------------------
2009.01.12     함장수   최초작성
************************************************************************/
function fn_show_result_message() {
	if (isErrorMessage()) {
		alert(getErrorMessage());
	} else if (isSuccessMessage()){
	    alert(getSuccessMessage());
	}
}

/************************************************************************
함수명 : fn_show_commor_error
설  명 : 자바스크립트 작성시 try{} catch{} 를 사용하여 catch 에 공통적으로
         사용될 메세지
인  자 : e (error object)
사용법 : fn_show_commor_error(e)
작성일 : 2009.01.12
작성자 : 함장수

수정일         수정자   수정내용
------------   ------   -------------------
2009.01.12     함장수   최초작성
************************************************************************/
function fn_show_commor_error(e) {
	var message = "Javascript 에러가 발생했습니다.\n\n관리자에게 문의하세요\n\n";
	    message += "Error Code : "+e.code+"\n\nError Name : "+e.name+"\n\nError Message : "+e.message;

	alert(message);
}



/************************************************************************
함수명 : fn_open_modaldialog
설  명 : modal dialog 팝업창 오픈
인  자 : url(열릴 페이지주소), args, width(너비), height(높이)
사용법 : fn_open_modaldialog(url, args, width, height)
작성일 : 2009.01.12
작성자 : 함장수

수정일         수정자   수정내용
------------   ------   -------------------
2009.01.12     함장수   최초작성
2010.11.02     함장수   오페라 브라우져에서는 modal 이 지원이 안되므로
                        사용하지 않도록 한다.
************************************************************************/
function fn_open_modaldialog( url, args, width, height, scroll ){
	var env_options = "dialogHeight: " + height + "px; dialogWidth: " + width + "px;  edge: Raised; center: Yes; help: No; scroll:"+scroll+"; resizable: No; status: No;";
	return window.showModalDialog( URLAddTime(url), self, env_options);
}




function URLAddTime(url){
	if(url.indexOf("?") == -1 ) url = url + "?" ;
	else url = url + "&" ;
	
	url = url + "popuptime="+ encodeURI(Date()) ;

	return url ;
}


/************************************************************************
함수명 : fn_open_window
설  명 : 팝업창 오픈
인  자 : url(열릴 페이지주소), args, width(너비), height(높이)
사용법 : fn_open_window(url, args, width, height)
작성일 : 2009.01.12
작성자 : 함장수

수정일         수정자   수정내용
------------   ------   -------------------
2009.01.12     함장수   최초작성
************************************************************************/
function fn_open_window(opt){
	
    var url    = opt.url    || "about:blank";
    var width  = opt.width  || "400";
    var height = opt.height || "400";
    var scroll = opt.scroll || "yes";
    var name   = opt.name   || "openWindow";
    var resizable = opt.resizable || "no";
	var winwidth = width; // width of the new window
	var winheight = height; // height of the new window
	var winleft = (screen.width / 2) - (winwidth / 2); // center the window right to left
	var wintop = (screen.height / 2) - (winheight / 2); // center the window top to bottom
	// the values get inserted into the features parameter of the window.open command...
	return window.open( URLAddTime(url), name,'scrollbars='+scroll+',toolbar=no,location=no,directories=no,width=' + winwidth + ',height=' + winheight + ',resizable=' + resizable + ',menubar=no,top=' + wintop + ',left=' + winleft );
}


/************************************************************************
함수명 : fn_open_window
설  명 : 팝업창 오픈
인  자 : url(열릴 페이지주소), args, width(너비), height(높이)
사용법 : fn_open_window(url, args, width, height)
작성일 : 2009.01.12
작성자 : 함장수

수정일         수정자   수정내용
------------   ------   -------------------
2009.01.12     함장수   최초작성
************************************************************************/
function fn_open_dialog(opt){

    fn_submit_ajax({
        formId   :opt.formId,
        indicator:"#indicator",
        dataType :"html",
        success  : fn_make_dialog
    });
    
    function fn_make_dialog(data, status) {

        $(opt.callbackId).html("");
        $(opt.callbackId).append(data);
        $(opt.callbackId).dialog('open');
    }
}

/************************************************************************
함수명 : fn_font_zoom
설  명 : 폰트 크기 변경
인  자 : state(plus or minus), e(event)
사용법 : fn_font_zoom('plus', event)
작성일 : 2009.01.12
작성자 : 함장수

수정일         수정자   수정내용
------------   ------   -------------------
2009.01.12     함장수   최초작성
************************************************************************/
var currentFontSize = 3;
function fn_font_zoom(state, e){
	var idx;
	var arrFontSize = new Array();

	arrFontSize[0] = "75%";
	arrFontSize[1] = "85%";
	arrFontSize[2] = "95%";
	arrFontSize[3] = "100%";
	arrFontSize[4] = "110%";
	arrFontSize[5] = "120%";
	arrFontSize[6] = "130%";
	
	var e = e || window.event;
	if (e) {
		if (state == "plus") {		
			if (currentFontSize < 6 ) {
				idx = currentFontSize + 1;
				currentFontSize = idx;
			}else{
				idx = 6;
				currentFontSize = idx;
			}			
		} else if (state == "default") {
			idx = 1;
			currentFontSize = idx;
		} else if (state == "minus") {			
			if ( currentFontSize >= 1) {
				idx = currentFontSize - 1;
				currentFontSize = idx;
			}else{
				idx = 0;
				currentFontSize = idx;
			}
		}		
	}
	document.body.style.fontSize = arrFontSize[idx];
	return false;
}



/************************************************************************
함수명 : fn_get_properties
설  명 : object 속성 출력
인  자 : obj (오브젝트)
사용법 : fn_get_properties('plus', event)
작성일 : 2009.01.12
작성자 : 함장수

수정일         수정자   수정내용
------------   ------   -------------------
2009.01.12     함장수   최초작성
************************************************************************/
function fn_get_properties(obj) {
	var names = "";
	for (var name in obj) names = names + ", " + name;
	
	alert(names);
}

/*
 * 현재 사용안함. 향후 사용 밑 변경
function checkBoxAutoInputNAutoCheck() {

	// 1
	$("input[type=checkbox]").each(function(index) {
		var class_nm = $(this).attr("name");
		var val = $("."+class_nm).val();
		
		if (val == "Y") {
			$(this).attr("checked",true);
		} else if (val == "N") {
			$(this).attr("checked",false);
		}
	});

	// 2
	$(":checkbox").click(function() {
		var name = $(this).attr("name");
		var ele = "input[name="+name+"]:checkbox";
		$(ele).each(function(index) {
			var ch_name = $(this).attr("name");
			var inElement = $("."+ch_name).get();
			
			if ($(this).is(":checked")) {
				$(inElement[index]).val("Y");
			} else {
				$(inElement[index]).val("N");
			}
			
		});
	});
}
*/





/************************************************************************
함수명 : fn_get_browser
설  명 : 브라우져 종류를 리턴한다.
인  자 :  
사용법 : fn_get_browser()
작성일 : 2011.11.02
작성자 : 함장수

수정일         수정자   수정내용
------------   ------   -------------------
2011.11.02     함장수   최초작성
************************************************************************/
function fn_get_browser() {
	
	var info = {name:'',ver:''};
	if (navigator.userAgent.indexOf("MSIE") != -1) {
		info.name = "IE";
	} else if (navigator.userAgent.indexOf("Opera") != -1) {
		info.name = "OP";
	} else if (navigator.userAgent.indexOf("Safari") != -1) {
		info.name = "SF";
	} else if (navigator.userAgent.indexOf("Mozilla") != -1) {
		if (navigator.appVersion.indexOf("5.0 (Windows; ko)") != -1) {
			info.name = "FF";
		} else if (navigator.appVersion.indexOf("5.0 (Windows; U; Windows NT 5.1; en-US") != -1) {
			info.name = "CR";
		} else if (navigator.appVersion.indexOf("Safari") != -1) {
			info.name = "SF";
		} else {
			info.name = "MZ";
		}
	}
	
	return info;
}

/************************************************************************
함수명 : fn_get_opener
설  명 : opener 객체를 리턴한다.
인  자 :  
사용법 : fn_get_opener()
작성일 : 2011.11.02
작성자 : 함장수

수정일         수정자   수정내용
------------   ------   -------------------
2011.11.02     함장수   최초작성
************************************************************************/
function fn_get_opener() {
	
	var pop_cnt = window.name.splitLast("_");
	if (typeof(eval(pop_cnt)) == Number) {
		
		if (pop_cnt == 0) {
			op = self;
		} else if (pop_cnt == 1) {
			op = window.opener;
		} else if (pop_cnt == 2) {
			op = window.opener.opener;
		} else if (pop_cnt == 3) {
			op = window.opener.opener.opener;
		} else if (pop_cnt == 4) {
			op = window.opener.opener.opener.opener;
		} else if (pop_cnt == 5) {
			op = window.opener.opener.opener.opener.opener;
		}
	} else {
		op = window.opener;
	}
	return op;
}


function fn_set_cookie(name, value, expiredays) {
    var today = new Date();
    today.setDate(today.getDate()+expiredays);
    document.cookie = name + "=" + escape(value) + "; path=/; expires=" + today.toGMTString() + ";";
}
function fn_get_cookie(name) {
    var wcname = name + "=";
    var wcstart, wcend, end;
    var i = 0;

    var str = document.cookie.split(";");
    for (var k=0; k<str.length;k++) {
    	var v = str[k].split("=");
    	if (name == v[0].trim()) {
    		return v[1];
    	}
    }
    return "";
}

//트위터
function fn_send_twitter(title, url){
	
	var msg = $("#snsTitle").text();
	
	if (title != "") {
		msg += "[" + title + "]";
	}
	else if ($("#snsContentTitle").text() != "") {
		msg += "[" + $("#snsContentTitle").text() + "]";
	}
	
	if (url == "") {
		url = $("#homepageUrl").text();
	}
	
	var href = "http://twitter.com/home?status=" + encodeURIComponent(msg) + " " + encodeURIComponent(url);
	var a = window.open(href, 'twitter', '');
    
	if( a ){
		a.focus();
	}
}

// 페이스북
function fn_send_faceBook(title, url){
	
	var msg = $("#snsTitle").text();
	
	if (title != "") {
		msg += "[" + title + "]";
	}
	
	if (url == "") {
		url = $("#homepageUrl").text();
	}
	
	//var href = "http://www.facebook.com/sharer.php?t=" + encodeURIComponent(msg)+ "&u=" + encodeURIComponent(url);
	var href = "http://www.facebook.com/sharer.php?u=" + encodeURIComponent(url);
	var a = window.open(href, 'facebook', '');
    
	if( a ){
		a.focus();
	}
}

// 미투데이
function fn_send_me2day(title, url){
	
	var msg = $("#snsTitle").text();
	
	if (title != "") {
		msg += "[" + title + "]";
	}
	else if ($("#snsContentTitle").text() != "") {
		msg += "[" + $("#snsContentTitle").text() + "]";
	}
	
	if (url == "") {
		url = $("#homepageUrl").text();
	}
	
	var tag = $("#snsTag").text();
	
	var href = "http://me2day.net/posts/new?new_post[body]=" + encodeURIComponent(msg) + " " + encodeURIComponent(url) + "&new_post[tags]=" + encodeURIComponent(tag);
	var a = window.open(href, 'me2Day', '');
    
	if( a ){
		a.focus();
	}
}

/**
 * 해당 폼객체의 입력값에 숫자만 있는지 체크
 * obj    : 폼 객체
 */
function cm_chkNumber(obj) {		
    if (cm_isNumber(obj)) {
    	return;
    }
    else {
    	var str = obj.value;
		var len = str.length
		alert("숫자로만 입력해 주세요");
		//obj.value = str.substring(0,len-1);
		obj.value = "";
		return;
    }    		
}

/**
 * 해당 폼객체의 입력값에 숫자만 있는지 체크
 * obj    : 폼 객체 
 * RETURN : boolean
 */
function cm_isNumber(obj) {
    var chars = "0123456789";
    return cm_containsCharsOnly(obj, chars);
}


/**
 * 해당 폼 객체의 입력값이 특정 문자(chars)만으로 되어있는지 체크(특정 문자만 허용하려 할 때 사용) 
 * obj    : 폼 객체 (form name을 붙여서 넘긴다. 예:formName.chboxName)
 * chars  : 체크할 문자
 * RETURN : boolean
 */
function cm_containsCharsOnly(obj,chars) {
    for (var inx = 0; inx < obj.value.length; inx++) {
       if (chars.indexOf(obj.value.charAt(inx)) == -1)
           return false;
    }
    return true;
}

// 공통 정의 ========================================================================

function fn_center_pos(ele_expr) {
	
	var _win = jQuery(window);
	var _doc = jQuery(document);
    var _docHeight = _doc.height();
    var _winWidth = _win.width();
    var _winHeight = _win.height();
    var _w = $(ele_expr).width();
    var _h = $(ele_expr).height();
    
	return [(_docHeight > _winHeight) ? _winWidth/2 - _w/2 - 18 : _winWidth/2 - _w/2,  _doc.scrollTop() + _winHeight/2 - _h/2];
}

// 공통 코드 가져오기
function fn_code_list(sup_cd, callback) {
	
	$.ajax({
		type: "POST",
		url : "/common/codeList.do",
		data : {"cd_grp_id":sup_cd},
		dataType : "json",
		success  : callback
	});
}
function fn_code_selectbox_html(code_list, elementId, headerText, value) {
	
	var html = '<select name="'+elementId+'" id="'+elementId+'" class="select">';
	
	if (headerText != "") {
		html += '<option value="">'+headerText+'</option>';
	}
	
	if (code_list != null) {
		
		for (var i=0; i<code_list.length; i++) {
			
			var map = code_list[i];
			
			html += '<option value="'+map.CD_ID+'"';
			if (map.CD_ID == value) html += 'selected="selected"';
			html += ' >'+map.CD_NM+'</option>';
		}
	}
	
	html += '</select>';
	
	return html;
}

// 바이트 수 체크
function fn_byte_check(ele_id, cut, status_ele_id) {

	var ele = $("#"+ele_id);
	var status_ele = $("#"+status_ele_id);

	var temp_str = $(ele).val();
	var byte_len = fn_byte_len(temp_str);

	if (status_ele_id != null) $(status_ele).text(byte_len);

	if (cut < byte_len) {
		alert(cut+"byte까지 입력이 가능합니다");
		while(cut < byte_len) {
			temp_str = temp_str.substring(0, temp_str.length-1);
			$(ele).val(temp_str);
			byte_len = fn_byte_len(temp_str);
			if (status_ele_id != null) $(status_ele).text(byte_len);
		}
	}
}
function fn_byte_len(str) {
	
	var resultSize = 0;
	if(str == null) {
		return 0;
	}

	for(var i=0; i<str.length; i++) {     
		       
		var c = escape(str.charAt(i));

		//기본 아스키코드
		if(c.length == 1) {                 
			resultSize ++;             
		}
		//한글 혹은 기타
		else if(c.indexOf("%u") != -1) {
			resultSize += 2;
		}
		else {
			resultSize ++;             
		}
	}                   
	return resultSize;
}

function rendomRange(min, max) {
	
	return Math.floor( (Math.random()*(max-min+1)) + min );
}

// 수능날짜 셋팅 (2014.11.13)
var v_today = new Date();
//var v_today = new Date(2014,10,12,20,10,57);
var v_examday = new Date(2014,10,13,0,0,0); // month는 -1해준다.
var v_dday_s = Math.ceil((v_examday.getTime()-v_today.getTime())/1000);
var v_dday_d = Math.ceil((v_examday.getTime()-v_today.getTime())/(24*60*60*1000));
if (v_dday_s < 0) v_dday_s = 0;
if (v_dday_d < 0) v_dday_d = 0;

/*
//수능 D-day 설정
var v_today = new Date();
var v_lastday = new Date(2014,10,13); // 11월은 10으로 표현됨.( month (from 0-11) )
var v_dday = Math.ceil((v_lastday.getTime()-v_today.getTime())/(24*60*60*1000));
if(v_dday<0) v_dday=0;
v_dday = fn_right("00"+v_dday,3);
//alert(v_dday);

var v_dday_01 =  v_dday.substr(0,1);
var v_dday_02 =  v_dday.substr(1,1);
var v_dday_03 =  v_dday.substr(2,3);

function fn_right(str, n) {
	if (n <= 0) {
		  return "";
	} else if (n > String(str).length) {
		  return str;
	} else {
		  var iLen = String(str).length;
		  return String(str).substring(iLen, iLen - n);
	}
}
*/
