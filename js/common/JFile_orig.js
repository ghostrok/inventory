/********************************************************
파일명 : JFile.js
설  명 : 파일콤퍼넌트 함수

수정일     수정자   Version    Function 명
---------- -------- ---------- --------------
2009.01.12 함장수   1.0        최초 생성
*********************************************************/	


var global_file_context_path = "";


/************************************************************************
<pre>
함수명 : fn_create_file
설  명 : [단일/멀티파일 업로드] 파일 엘레먼트 추가
인  자 : var opt = {
						tdId        : "#td_single_file",  (파일 엘리먼트가 생성될 TD에 부여된 ID)
						elementNm   : "single_file",      (파일 컬럼명)
						elementType : "single",           (파일 엘레먼트 종류 {single, multi})
						requiredYn  : "Y",                (필수여부)
						mode        : "edit"            (수정화면 모드)
                   }
사용법 : 
         $(document).ready(function() {
         	fn_create_file ({
							   tdId        : "#td_single_file",      
							   elementNm   : "single_file",    
							   elementType : "single",    
							   requiredYn  : "Y",  
						       mode        : "edit"  
			         	   });
         });
작성일 : 2009.01.12
작성자 : 함장수

수정일         수정자   수정내용
------------   ------   -------------------
2009.01.12     함장수   최초작성
</pre>
************************************************************************/
function fn_create_file(opt) {
	if (opt.elementType == "single") {
		fn_create_single_file(opt);
	} else if (opt.elementType == "multi") {
		fn_create_multi_file(opt);
	}
}



/************************************************************************
<pre>
함수명 : fn_create_single_file
설  명 : [단일파일 업로드] 파일 엘레먼트 추가
인  자 : var opt = {
						tdId        : "#td_single_file",  (파일 엘리먼트가 생성될 TD에 부여된 ID)
						elementNm   : "single_file",      (파일 컬럼명)
						elementType : "single",           (파일 엘레먼트 종류 {single, multi})
						requiredYn  : "Y",                (필수여부)
						mode        : "edit"            (수정화면 모드)
                   }
사용법 : 
         $(document).ready(function() {
         	fn_create_single_file ({
									   tdId        : "#td_single_file",      
									   elementNm   : "single_file",    
									   elementType : "single",    
									   requiredYn  : "Y",  
								       mode        : "edit"  
			         	          });
         });
작성일 : 2009.01.12
작성자 : 함장수

수정일         수정자   수정내용
------------   ------   -------------------
2009.01.12     함장수   최초작성
</pre>
************************************************************************/
function fn_create_single_file(opt) {
	var tdId          = opt.tdId;
	var elementNm     = opt.elementNm;
	var elementType   = opt.elementType ? opt.elementType : "multi";
	var elementWidth  = opt.elementWidth ? opt.elementWidth : "467";
	var requiredYn    = opt.requiredYn ? opt.requiredYn : "N";
	var validClassExt = opt.validClassExt ? opt.validClassExt : "fileExt";
	var mode          = opt.mode ? opt.mode : "";
	var dscrYn        = opt.dscrYn ? opt.dscrYn : "N";
	var validClass = "";
	if (requiredYn == "Y") validClass = "required"; // 필수이고 수정화면이 아닐경우만 required 클래스 적용

	var tag = "<table border='0' cellpadding='0' cellspacing='0' class='j-table-normal j-file-contents'>"
		    + "<tbody>"
			+ "<tr>"
			+ "<td width='"+elementWidth+"'><input type='text' name='text' style='width:"+elementWidth+"px' class='j-text-file j-readonly' readonly/></td>"
			+ "<td width='10'></td>"
			+ "<td width='60'><span class='j-find'>";

	if (mode == "edit") {
		 tag = tag + "<input type='file' name='"+elementNm+"_file' class='j-hidden-file j-readonly' onchange='fn_set_filevalue(this, \""+validClassExt+"\");fn_set_opt(\""+tdId+"\", \""+elementNm+"\", \""+elementType+"\", \""+requiredYn+"\", \"delete\")' size='1'>"; 
	} else {
		 tag = tag + "<input type='file' name='"+elementNm+"_file' class='j-hidden-file j-readonly' onchange='fn_set_filevalue(this, \""+validClassExt+"\");' size='1'>"; 
	}

    tag = tag + "</span></td>"
	          + "<td width='5'></td>"
		      + "<td width='20'>";
    
	if (mode == "edit") {
		 tag = tag + "<span onclick='fn_clear_fileinput(this,\""+validClassExt+"\");fn_set_opt(\""+tdId+"\", \""+elementNm+"\", \""+elementType+"\", \""+requiredYn+"\", \"none\");' class='j-clear-file'>&nbsp;&nbsp;&nbsp;&nbsp;</span></td>";
	} else {
		 tag = tag + "<span onclick='fn_clear_fileinput(this,\""+validClassExt+"\");' class='j-clear-file'>&nbsp;&nbsp;&nbsp;&nbsp;</span></td>";
	}
    
	tag = tag + "</tr>";

	if (dscrYn == "Y") {	
	    tag = tag + "<tr>"
		  + "<td colspan='5'><input type='text' name='"+elementNm+"_descrition' maxByte='1000' style='width:"+elementWidth+"px;'/><br/>(설명은 한글 <span class='j-essen'>500</span>자, 영문 <span class='j-essen'>1,000</span>자 이하이어야 합니다.)</td>"
		  + "</tr>";
	}

	
	tag = tag + "</tbody>"
		      + "</table>"
		      + "<input type='hidden' name='"+elementNm+"_check' fileName='"+elementNm+"_file' class='"+validClassExt+"  "+validClass+"'/>";
	
	$(tdId).append(tag);
}


/************************************************************************
<pre>
함수명 : fn_create_multi_file
설  명 : [멀티파일 업로드] 파일 엘레먼트 추가
인  자 : var opt = {
						tdId        : "#td_single_file",  (파일 엘리먼트가 생성될 TD에 부여된 ID)
						elementNm   : "single_file",      (파일 컬럼명)
						elementType : "single",           (파일 엘레먼트 종류 {single, multi})
						requiredYn  : "Y",                (필수여부)
						mode        : "edit"            (수정화면 모드)
                   }
사용법 : 
         $(document).ready(function() {
         	fn_create_multi_file ({
									   tdId        : "#td_single_file",      
									   elementNm   : "single_file",    
									   elementType : "single",    
									   requiredYn  : "Y",  
								       mode        : "edit"  
			         	          });
         });
작성일 : 2009.01.12
작성자 : 함장수

수정일         수정자   수정내용
------------   ------   -------------------
2009.01.12     함장수   최초작성
</pre>
************************************************************************/
function fn_create_multi_file(opt) {
	var tdId          = opt.tdId;
	var elementNm     = opt.elementNm;
	var elementType   = opt.elementType ? opt.elementType : "multi";
	var elementWidth  = opt.elementWidth ? opt.elementWidth : "467";
	var requiredYn    = opt.requiredYn ? opt.requiredYn : "N"; // 현재 여기서는 필요없음
	var validClassExt = opt.validClassExt ? opt.validClassExt : "multiFileExt";
	var fileCnt       = opt.fileCnt ? opt.fileCnt : 5;
	var elementCnt    = $("#div_"+elementNm+"_input > .j-file-object").size();
	var dscrYn        = opt.dscrYn ? opt.dscrYn : "N";
	
	$(tdId).prev().attr("style","vertical-align:top;");
	$(tdId).prev().append("&nbsp;&nbsp;<img src=\""+global_file_context_path+"/images/common/file/file_plus.gif\" style=\"cursor:pointer\" onclick=\"fn_add_fileinput('"+tdId+"','"+elementNm+"','"+fileCnt+"','div_"+elementNm+"_input','"+elementWidth+"', '"+validClassExt+"', '"+dscrYn+"')\" alt=\"파일 입력란 추가\"/>"
                        + "&nbsp;<img src=\""+global_file_context_path+"/images/common/file/file_minus.gif\" style=\"cursor:pointer\" onclick=\"fn_del_fileinput('div_"+elementNm+"_input')\" alt=\"파일 입력란 삭제\"/>");
	
	var tag = "<div id=\"div_"+elementNm+"_input\">";
	
	if (elementCnt < fileCnt) {
		tag = tag + "<div class='j-file-object'>"
				  + "<table border='0' cellpadding='0' cellspacing='0' class='j-table-normal j-file-contents'>"
				  + "<tbody>"
				  + "<tr>"
				  + "<td width='"+elementWidth+"'><input type='text' name='text' style='width:"+elementWidth+"px' class='j-text-file j-readonly' readonly/></td>"
				  + "<td width='10'></td>"
				  + "<td width='60'><span class='j-find'><input type='file' name='"+elementNm+"_file' class='j-hidden-file j-readonly' onchange='fn_set_filevalue(this, \""+validClassExt+"\");' size='1'></span></td>"
				  + "<td width='5'></td>"
				  + "<td width='20'><span onclick='fn_clear_fileinput(this,\""+validClassExt+"\");' class='j-clear-file'>&nbsp;&nbsp;&nbsp;&nbsp;</span></td>"
				  + "</tr>";

		if (dscrYn == "Y") {
	        tag = tag + "<tr>"
                      + "<td colspan='5'><input type='text' name='"+elementNm+"_descrition' maxByte='1000' style='width:"+elementWidth+"px;'/><br/>(설명은 한글 <span class='j-essen'>500</span>자, 영문 <span class='j-essen'>1,000</span>자 이하이어야 합니다.)</td>"
	                  + "</tr>";
		}
		
		tag = tag + "</tbody>"
				  + "</table>"
				  + "</div>";
	}
	
	tag = tag+ "</div><input type='hidden' name='"+elementNm+"_check' fileName='"+elementNm+"_file' class='"+validClassExt+"'/>";
	
	$(tdId).append(tag);
}


/************************************************************************
<pre>
함수명 : fn_file_info
설  명 : 파일정보 출력
인  자 : var opt = {
                    	tdId        : "#td_single_file",
            			elementNm   : 'etc_file',
						elementType : 'single',
						fileNo      : '2',
						seqNo       : '1',
						origNm      : '파일.doc',
						systNm      : '1a343186-0426-40a3-84ea-ae781f7268ad',
						filePath    : '/code',
						mode        : 'edit',
						requiredYn  : 'Y'
                   }
사용법 : 
        	<script type="text/javascript">
        		fn_file_info({
                    	tdId        : "#td_single_file",
            			elementNm   : 'etc_file',
						elementType : 'single',
						fileNo      : '2',
						seqNo       : '1',
						origNm      : '파일.doc',
						systNm      : '1a343186-0426-40a3-84ea-ae781f7268ad',
						filePath    : '/code',
						mode        : 'edit',
						requiredYn  : 'Y'
            	});
			</script>
작성일 : 2009.01.12
작성자 : 함장수

수정일         수정자   수정내용
------------   ------   -------------------
2009.01.12     함장수   최초작성
</pre>
************************************************************************/
function fn_file_info(opt) {
	var tdId        = opt.tdId;
	var elementNm   = opt.elementNm;
	var elementType = opt.elementType ? opt.elementType : "multi";
	var requiredYn  = opt.requiredYn  ? opt.requiredYn  : "N";
	var fileNo      = opt.fileNo;
	var seqNo       = opt.seqNo;
	var origNm      = opt.origNm;
	var systNm      = opt.systNm;
	var filePath    = opt.filePath;
	var mode        = opt.mode ? opt.mode : "";
	var linkYn      = opt.linkYn ? opt.linkYn  : "Y";
	var fileDscr    = opt.fileDscr ? opt.fileDscr : "";
	
	var downloadUrl = global_file_context_path+"/common/file/download.do?origName="+origNm+"&systName="+systNm+"&filePath="+filePath;
	var tag = "<div class='j-file-object'>";
	if (fileNo == '0') {
		tag = tag + origNm;
	} else { 
		//tag = tag + "<a href='"+downloadUrl+"'>"+origNm+"</a>";
		if (linkYn == "Y") {
			if (fileDscr == "") {
				tag = tag + "<a href=\"#\" onclick=\"fn_file_download('"+origNm+"','"+systNm+"','"+filePath+"')\" >"+origNm+"</a>";
			} else {
				tag = tag + "<a href=\"#\" onclick=\"fn_file_download('"+origNm+"','"+systNm+"','"+filePath+"')\" title=\""+fileDscr+"\" class=\"j-file-tooltip\">"+origNm+"</a>";
			}
		} else {
			tag = tag + origNm;
		}
		if (mode == "edit") {
			if (requiredYn == "N") {
				tag = tag + "&nbsp;&nbsp;<img src='"+global_file_context_path+"/images/common/file/file_clear.gif' style='cursor:pointer' alt='파일 삭제' onclick=\"fn_delete_file($(this),'"+elementNm+"','"+elementType+"','"+tdId+"','"+requiredYn+"')\">";
			}
			tag = tag + "<input type='hidden' name='"+elementNm+"' value='"+fileNo+"'/>"
                      + "<input type='hidden' name='"+elementNm+"_seq' value='"+seqNo+"'/>"
                      + "<input type='hidden' name='"+elementNm+"_opt' value='none'/>";
		}
	}
	tag = tag + "</div>";
	$(tdId).append(tag);
}

function fn_file_download(origName, systName, filePath) {
	$("#form_file_download > input[name=origName]").val(origName);
	$("#form_file_download > input[name=systName]").val(systName);
	$("#form_file_download > input[name=filePath]").val(filePath);
	fn_submit({formId:"#form_file_download"});
}

/************************************************************************
<pre>
함수명 : fn_delete_file
설  명 : 파일 삭제 버튼 클릭 이벤트가 발생 됐을때 opt 에 'delete' 구분자 입력 
인  자 : $(this), elementNm
사용법 : fn_delete_file(obj, eleName)
작성일 : 2009.01.12
작성자 : 함장수

수정일         수정자   수정내용
------------   ------   -------------------
2009.01.12     함장수   최초작성
</pre>
************************************************************************/
function fn_set_opt(tdId, elementNm, elementType, requiredYn, opt) {
    
	$(tdId + "> .j-file-object").children().each(function() {
		
    	if ($(this).attr("name") == elementNm + "_opt") {
    		$(this).val(opt);
    	}
    });
    
}


/************************************************************************
<pre>
함수명 : fn_delete_file
설  명 : 파일 삭제 버튼 클릭 이벤트가 발생 됐을때 opt 에 'delete' 구분자 입력 
인  자 : $(this), elementNm
사용법 : fn_delete_file(obj, eleName)
작성일 : 2009.01.12
작성자 : 함장수

수정일         수정자   수정내용
------------   ------   -------------------
2009.01.12     함장수   최초작성
</pre>
************************************************************************/
function fn_delete_file(obj, elementNm, elementType, tdId, requiredYn) {
	
    $(obj).parent().hide();
    
    $(obj).parent().children().each(function() {
    	if ($(this).attr("name") == elementNm + "_opt") {
    		$(this).val("delete");
    	}
    });
    
}


/************************************************************************
<pre>
함수명 : fn_add_fileinput
설  명 : [멀티파일 업로드] 파일 엘레먼트 추가
인  자 : fileColumeName, fileLayerName, fileEleSize
사용법 : img element 에 onclick 이벤트로 아래와 같이 작성한다.
         <img src="" style="cursor:pointer" onclick="addFileInput('multi_file')"/>
작성일 : 2009.01.12
작성자 : 함장수

수정일         수정자   수정내용
------------   ------   -------------------
2009.01.12     함장수   최초작성
</pre>
************************************************************************/
function fn_add_fileinput(tdId, fileColumeName, fileCnt, fileLayerName, fileEleSize, validClassExt, dscrYn) {
    //var fileCnt   = arguments[1] ? arguments[1] : 5;
    //var fileLayer = arguments[2] ? arguments[2] : "div_file_input";
    //var fileSize  = arguments[3] ? arguments[3] : "467";
	
	var defCnt = $(tdId+" input[name='"+fileColumeName+"']").size();      // DB 에서 출력한 파일 개수
	var eleCnt = $("#"+fileLayerName+" input[name='"+fileColumeName+"_file']").size(); // file Element 개수
	
	var delCnt = 0;                                                                 // 삭제시킨 파일 개수
	$(tdId+"  input[name='"+fileColumeName+"_opt']").each(function(){
		if($(this).val() == "delete"){
			++delCnt;
		}
	});
	
	var n = defCnt - delCnt + eleCnt;

    if (n < fileCnt) {
        var tag = '<div class="j-file-object">'
        		+ '<table border="0" cellpadding="0" cellspacing="0" class="j-table-normal j-file-contents">'
        		+ '<tbody>'
        		+ '<tr>'
            	+ '<td width="'+fileEleSize+'"><input type="text" name="text" style="width:'+fileEleSize+'px;" class="j-text-file j-readonly" readonly/></td>' 
            	+ '<td width="10"></td>'
            	+ '<td width="60"><span class="j-find"><input type="file" name="'+fileColumeName+'_file" class="j-hidden-file j-readonly" onchange="fn_set_filevalue(this, \''+validClassExt+'\');" size="1"></span></td>'
            	+ '<td width="5"></td>'
            	+ '<td width="20"><span onclick="fn_clear_fileinput(this,\''+validClassExt+'\');" class="j-clear-file">&nbsp;&nbsp;&nbsp;&nbsp;</span></td>'
            	+ '</tr>';

		if (dscrYn == "Y") {
	        tag = tag + "<tr>"
                      + "<td colspan='5'><input type='text' name='"+fileColumeName+"_descrition' maxByte='1000' style='width:"+fileEleSize+"px;'/><br/>(설명은 한글 <span class='j-essen'>500</span>자, 영문 <span class='j-essen'>1,000</span>자 이하이어야 합니다.)</td>"
	                  + "</tr>";
		}
		
		tag = tag + "</tbody>"
        	      + '</table>';
        
		$("#"+fileLayerName).append(tag);    

    } else {
        alert("파일은 "+fileCnt+"개까지 업로드할 수 있습니다.");
    }
}


/************************************************************************
<pre>
함수명 : fn_del_fileinput
설  명 : [멀티파일 업로드] file element 삭제 (마지막 element 삭제)
인  자 : fileLayerName
사용법 : img element 에 onclick 이벤트로 아래와 같이 작성한다.
         <img src="" style="cursor:pointer" onclick="fn_del_fileinput('multi_file')"/>
작성일 : 2009.01.12
작성자 : 함장수

수정일         수정자   수정내용
------------   ------   -------------------
2009.01.12     함장수   최초작성
</pre>
************************************************************************/
function fn_del_fileinput(fileLayerName) {
    //var fileLayer = arguments[0] ? arguments[0] : "div_file_input";
	
	var cnt = $("#"+fileLayerName+" > .j-file-object input[type=file]").length;
    if (cnt > 1) {
        $("#"+fileLayerName+" > .j-file-object:last").remove();
    }
	
}


/************************************************************************
<pre>
함수명 : fn_clear_fileinput
설  명 : [멀티파일 업로드] file element value 삭제
인  자 : obj (element 객체)
사용법 : img element 에 onclick 이벤트로 아래와 같이 작성한다.
         <span onclick="clearFileInput(this);" class="j-clear-file">
작성일 : 2009.01.12
작성자 : 함장수

수정일         수정자   수정내용
------------   ------   -------------------
2009.01.12     함장수   최초작성
</pre>
************************************************************************/
function fn_clear_fileinput(obj, validClassExt) {

    var index = $(".j-file-contents .j-clear-file").index($(obj));
    $elem = $($(".j-file-contents .j-hidden-file").get(index));
    
    $elem.replaceWith($elem.clone(true).attr("value",""));

    $($(".j-file-contents .j-text-file").get(index)).val("");
	
	var objName = $($("."+validClassExt).get(index)).attr("name");
	
	$($(".fileExt").get(index)).val("");
	
}


/************************************************************************
<pre>
함수명 : fn_set_filevalue
설  명 : 파일객체를 이미지로 대체후 파일 객체의 value 값이 변경되었을때 실행된다.
인  자 : obj (element 객체)
사용법 : img element 에 onchange 이벤트로 아래와 같이 작성한다.
         <input type="file" name="com_resume_file" class="j-hidden-file" onchange="setFileValue(this);" size="1">
작성일 : 2009.01.12
작성자 : 함장수

수정일         수정자   수정내용
------------   ------   -------------------
2009.01.12     함장수   최초작성
</pre>
************************************************************************/
function fn_set_filevalue(fileObj, validClassExt) {
	$(fileObj).parent().parent().prev().prev().children("input[type=text]").val( $(fileObj).val() );

	if ( $(fileObj).hasClass("error") || $(fileObj).val() != ""  ) {
		
		var formObj = $(fileObj).parents("form");
		var fileName = $(fileObj).attr("name");
		var checkObj = $("input[fileName="+fileName+"]");

		if ( $(checkObj).hasClass(validClassExt) ) {
			$(checkObj).val($(fileObj).val());
		}
		
		$(formObj).validate().element($(checkObj));
	}
}
