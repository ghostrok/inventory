/********************************************************
파일명 : JPage.js
설  명 : 페이징

수정일     수정자   Version    Function 명
---------- -------- ---------- --------------
2012.10.22 박상훈   1.0        최초 생성
*********************************************************/	

function fn_pager(form_id, curr_page) {
	
	$(form_id + " input[name=curr_page]").val(curr_page);
	fn_submit({formId: form_id});
}

$(document).ready(function() {
	/* 목록화면 스크롤 처리하기 위해 height 를 계산한다. 
	var cnt = $("#list_tbody").attr("cnt");
	var h = 27 + 15 + 10 + (21 * cnt);

	$("#div_list_box").css({"height":+h+26+"px"});
	$("#table_list_box").css({"height":+h+"px"});
	$("#table_td_list_box").css({"width":"100%","height":+h+"px"});
	
    $("span.curr.page").each(function(index) {
        var $thisCurr = $(this);
        $thisCurr.click(function() {
	        goPage(form_id, $thisCurr.attr("page"));
        });
        
    }); 

    $("#start").bind("click", function() {
        goPage(form_id, $(this).attr("page"), $(this).attr("id"));
    }); 
    $("#prev").bind("click", function() {
        goPage(form_id, $(this).attr("page"), $(this).attr("id"));
    }); 
    $("#next").bind("click", function() {
        goPage(form_id, $(this).attr("page"), $(this).attr("id"));
    }); 
	$("#end").bind("click", function() {
	    goPage(form_id, $(this).attr("page"), $(this).attr("id"));
	});  
	
    function fn_pager(form_id, curr_page) {
    	document.getElementById("curr_page").value = curr_page;
		document.getElementById(form_id).submit();
    }
    $("#"+form_id).keypress(function(e) {
        if (e.keyCode == 13) {
            fn_submit({formId:'#'+form_id});
        }
    });

    $("table.j-table-list tr").mouseover(function(){
        $(this).addClass("j-tr-gray");
    });
    $("table.j-table-list tr").mouseout(function(){
        $(this).removeClass("j-tr-gray");
    });
	*/
});

/*
function fn_pager(formId, callbackId, curr_page) {
	$(formId + " input[name=curr_page]").val(curr_page);
	var opt = {formId:formId, callbackId:callbackId};
	fn_go_page(opt); //JSubmit.js
}
*/


