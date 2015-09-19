/********************************************************
파일명 : JFile.js
설  명 : 파일콤퍼넌트 함수

수정일      수정자   Version    Function 명
---------- -------- ---------- --------------
2013.09.23 박상훈   1.0        최초 생성
*********************************************************/	

/************************************************************************
<pre>
함수명 : fn_file_download
설  명 : 파일 다운로드 
인  자 : origName, systName, filePath
사용법 : fn_file_download('test.jpg','df8d8fsd-sdf878s-sdfdf','/test')
작성일 : 2013.09.23
작성자 : 박상훈

수정일         수정자   수정내용
------------   ------   -------------------
2013.09.23    박상훈   최초작성
</pre>
************************************************************************/
function fn_file_download(origName, systName, filePath) {
	$("#form_file_download > input[name=origName]").val(origName);
	$("#form_file_download > input[name=systName]").val(systName);
	$("#form_file_download > input[name=filePath]").val(filePath);
	fn_submit({formId:"#form_file_download"});
}

/************************************************************************
<pre>
함수명 : fn_one_file_submit_check
설  명 : 서버에 요청하기전 단일파일 체크 
인  자 : id
사용법 : fn_file_download('reg_file')
작성일 : 2013.09.23
작성자 : 박상훈

수정일         수정자   수정내용
------------   ------   -------------------
2013.09.23    박상훈   최초작성
</pre>
************************************************************************/
function fn_one_file_submit_check(id) {
	
	var fileVal = $("#"+id+"_file").val();
	if (fileVal != null && fileVal != "") {
		$("#"+id+"_opt").val("delete");
	}
}

/************************************************************************
<pre>
함수명 : fn_one_file_edit
설  명 : 단일파일 수정버트
인  자 : id
사용법 : fn_one_file_edit('reg_file')
작성일 : 2013.10.07
작성자 : 박상훈

수정일         수정자   수정내용
------------   ------   -------------------
2013.09.23    박상훈   최초작성
</pre>
 ************************************************************************/
function fn_one_file_edit(id) {
	
	$("#"+id+"_img_edit").hide();
	$("#"+id+"_img_cancel").show();
	$("#div_file_"+id).show();
}

/************************************************************************
<pre>
함수명 : fn_one_file_cancel
설  명 : 단일파일 취소버트
인  자 : id
사용법 : fn_one_file_cancel('reg_file')
작성일 : 2013.10.07
작성자 : 박상훈

수정일         수정자   수정내용
------------   ------   -------------------
2013.09.23    박상훈   최초작성
</pre>
 ************************************************************************/
function fn_one_file_cancel(id) {
	
	var fileContents = $("#div_file_"+id).find(".fileContents");
	var fileObj = $(fileContents).find(".fileObj");
	
	var html = '<input type="file" name="'+$(fileObj).attr("name")+'" id="'+$(fileObj).attr("id")+'" style="'+$(fileObj).attr("style")+'" class="'+$(fileObj).attr("class")+'" />';
	$(fileObj).remove();
	$(fileContents).append(html);
	
	$("#"+id+"_img_cancel").hide();
	$("#"+id+"_img_edit").show();
	$("#div_file_"+id).hide();
}
