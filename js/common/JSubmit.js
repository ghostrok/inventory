/********************************************************
파일명 : JSubmit.js
설  명 : 폼전송 함수

수정일     수정자   Version    Function 명
---------- -------- ---------- --------------
2009.01.12 함장수   1.0        최초 생성
*********************************************************/


function fn_go_page(opt) {
    var formId = opt.formId ? opt.formId : "#form_page";
    var callbackId = opt.callbackId ? opt.callbackId : "#div_content_main";
    var indizoneId = opt.callbackId ? opt.callbackId : "#div_wrap";
    var url    = opt.url ? opt.url: "";
    
	if (url != "") $(formId).attr("action", url);

	fn_submit_ajax({
	    formId   :formId,
	    indicator:"#indicator",
        indiZone :indizoneId,
	    dataType :"html",
	    success  : fn_make_callback
	});
	
    function fn_make_callback(data, status) {
        $(callbackId).html("");
        $(callbackId).append(data);
    }
    
}


function fn_make_contents(data, status) {
    $("#div_content_main").html("");
    $("#div_content_main").append(data);
}




/************************************************************************
함수명 : fn_submit
설  명 : 폼전송 (기본)
인  자 : subOpt (object)
         예) var subOpt = { formId:"#formid", target:"#targetname" }
사용법 : fn_submit(subOpt)
작성일 : 2009.01.12
작성자 : 함장수

수정일         수정자   수정내용
------------   ------   -------------------
2009.01.12     함장수   최초작성
************************************************************************/
function fn_submit(subOpt) {
	
	try {
		// 화면에서 페이징 검색 버튼이 눌러졌을 경우 curr_page를 1로 바꿔준다.
		if ( subOpt.form_id != null && (subOpt.form_id == (subOpt.formId.replace(/[#]/g, ""))) ) {
			if ($("#curr_page")) {
				$("#"+form_id+" > #curr_page").val("1");
			}
		}
	} catch (e) {}
	
	if (subOpt.before) {
		if (subOpt.before()) {
			$(subOpt.formId).attr("target", subOpt.target || "");
			//document.getElementById(subOpt.formId.replace(/[#]/g, "")).target = subOpt.target || "";
			$(subOpt.formId).submit();
		}
	} else {
		$(subOpt.formId).attr("target", subOpt.target || "");
		//document.getElementById(subOpt.formId.replace(/[#]/g, "")).target = subOpt.target || "";
		$(subOpt.formId).submit();
	}
}

/************************************************************************
함수명 : fn_submit_excel
설  명 : 엑셀파일 다운로드 폼 전송
인  자 : subOpt (object)
         예) var subOpt = { formId:"#formid", target:"#targetname" }
사용법 : fn_submit_excel(subOpt)
작성일 : 2009.01.12
작성자 : 함장수

수정일         수정자   수정내용
------------   ------   -------------------
2009.01.12     함장수   최초작성
************************************************************************/
function fn_submit_excel(subOpt) {
	fn_submit(subOpt);
}
/************************************************************************
함수명 : fn_submit_ajax
설  명 : 폼전송 (ajax)
인  자 : subOpt (object)
         예) 
           var subOpt = {
		  		formId: "#form id",
		        indicator: "#indicator id",
		        before: function (data, form, options) {},
		        success: function (data, statusText) {},
		        error: function (status, request) {}
                // other available options:
                // target:    "#target id"// target element(s) to be updated with server response (html push)
                // dataType:  null        // 'xml', 'script', or 'json' (expected server response type)
                // clearForm: true        // clear all form fields after successful submit 
                // resetForm: true        // reset the form after successful submit 
                // timeout:   3000
		       }
         
사용법 : 
		$(document).ready(function() {
		
		      =========================================================================
		       설명 : 저장버튼을 클릭 후 publishing 이 성공하면 
		              ActionErrors, ActionFiedlErrors, ActionMessages 를 
		              alert 으로 출력한다.
		      ========================================================================= 
		     function qnaInsertComplete(event,data) {
		         fn_show_result_message();
		         // 메세지 이외에 처리해야 할 로직이 있을 경우 여기에 작성
		     }
		     
		      =========================================================================
		       설명 : 전송 전 처리해야 할 로직이 있을 경우 여기에 작성한다.
		              class 에 의한 폼 검증 외에 여기서도 폼 검증이 가능하다.
		      =========================================================================
		     function qnaInsertBefore(formData, form, options) { 
		         return true; 
		     }  
		     
		     fn_submit_ajax({
		         formId:"#form_qna_write",
		         indicator:"#indicator",
		         time:6000,
		         dataType: "json",
		         before: function(formData, form, options) {
		             return qnaInsertBefore(formData, form, options);
		         },
		         success: function(data, status){
		             qnaInsertComplete(data, status);
		         }
		     }); 


작성일 : 2009.01.12
작성자 : 함장수

수정일         수정자   수정내용
------------   ------   -------------------
2009.01.12     함장수   최초작성
************************************************************************/
function fn_submit_ajax(subOpt) {
	if (subOpt.action != null && subOpt.action != "") {
		$(subOpt.formId).attr("action", subOpt.action);
	}
	
	if($(subOpt.formId).attr("action") == null) {
		alert("$ Error : form ID를 정확히 설정하여 주세요" 
				+ "\n$ form ID : " + subOpt.formId);
		return;
	}

    $(subOpt.formId).ajaxSubmit({
	    type: "POST",
        target: subOpt.target,
        beforeSubmit: function(formData, form, options) {
    		var result = true;

    		if (subOpt.indicator || subOpt.indiZone) {
    			fn_show_indicator(subOpt);    			
    		}
    		
			if (subOpt.before) {
				result = subOpt.before(formData, form, options); 
			}
			if (!result && (subOpt.indicator || subOpt.indiZone)) {
    			fn_hide_indicator(subOpt);
			}
			
			return result;
        },
        success: function(data, status) {
    		if (subOpt.indicator || subOpt.indiZone) {
    			fn_hide_indicator(subOpt);
    		}
			
			// dataType 이 json, xml 일 경우 
			if (subOpt.dataType == "json" || subOpt.dataType == "xml") {
		    	if (typeof data.result == "object") {
		    		subOpt.success(data, status);
		    	} else if (typeof data.error == "object") {
					var message = "서버와 통신중 에러가 발생했습니다.\n\n관리자에게 문의하세요\n\nMessage:\n    ";
					alert(message+data.error.message);
				}
			} else {
    	    	if (subOpt.success) {
    	    		subOpt.success(data, status);
    	    	}
			}
			
        },
        error: function(request, errorText, error) {
    		if (subOpt.indicator || subOpt.indiZone) {
    			fn_hide_indicator(subOpt);
    		}
	    	if (subOpt.error) {
	    		subOpt.error(request, errorText, error);
	    	}
    		fn_show_error_state(request, errorText, error);
        },
   		timeout: subOpt.timeout||40000,
		dataType: subOpt.dataType,
		clearForm: subOpt.clearForm,
		resetForm: subOpt.resetForm,
		iframeTarget : subOpt.iframeTarget||null,
        isAsync: subOpt.isAsync||false

	});
}


/************************************************************************
함수명 : fn_submit_valid
설  명 : 폼 검증 후 전송 (기본)
인  자 : subOpt (object)
         예) var subOpt = { formId:"#formid", target:"#targetname" }
사용법 : fn_submit_valid(subOpt)
작성일 : 2009.01.12
작성자 : 함장수

수정일         수정자   수정내용
------------   ------   -------------------
2009.01.12     함장수   최초작성
************************************************************************/
function fn_submit_valid(subOpt) {
	
	$(subOpt.formId).validate({
		invalidHandler: fn_invalid_handler,
		submitHandler: function(form, validator){
			
			// before 가 있을 시 return 값이 true 경우 submit 한다.
			if (subOpt.before) {
				if (subOpt.before()) {
					document.getElementById(subOpt.formId.replace(/[#]/g, "")).target = subOpt.target || "";
					form.submit();
				}
			} else {
				document.getElementById(subOpt.formId.replace(/[#]/g, "")).target = subOpt.target || "";
				form.submit();
			}
		}
    });
}


/************************************************************************
함수명 : fn_submit_valid_ajax
설  명 : 폼 검증 후 전송 (ajax)
인  자 : subOpt (object)
         예) 
           var subOpt = {
		  		formId: "#form id",
		        indicator: "#indicator id",
		        before: function (data, form, options) {},
		        success: function (data, statusText) {},
		        error: function (status, request) {}
                // other available options:
                // target:    "#target id"// target element(s) to be updated with server response (html push)
                // dataType:  null        // 'xml', 'script', or 'json' (expected server response type)
                // clearForm: true        // clear all form fields after successful submit 
                // resetForm: true        // reset the form after successful submit 
                // timeout:   3000
		       }
         
사용법 : 
	      =========================================================================
	       설명 : 저장버튼을 클릭 후 publishing 이 성공하면 
	              ActionErrors, ActionFiedlErrors, ActionMessages 를 
	              alert 으로 출력한다.
	      ========================================================================= 
	     function qnaInsertComplete(event,data) {
	         fn_show_result_message();
	         // 메세지 이외에 처리해야 할 로직이 있을 경우 여기에 작성
	     }
	     
	      =========================================================================
	       설명 : 전송 전 처리해야 할 로직이 있을 경우 여기에 작성한다.
	              class 에 의한 폼 검증 외에 여기서도 폼 검증이 가능하다.
	      =========================================================================
	     function qnaInsertBefore(formData, form, options) { 
	         return true; 
	     }  
	     
	     fn_submit_valid_ajax({
	         formId:"#form_qna_write",
	         indicator:"#indicator",
	         before: function(formData, form, options) {
	             return qnaInsertBefore(formData, form, options);
	         },
	         success: function(data, status){
	             qnaInsertComplete(data, status);
	         }
	     });


작성일 : 2009.01.12
작성자 : 함장수

수정일         수정자   수정내용
------------   ------   -------------------
2009.01.12     함장수   최초작성
************************************************************************/
function fn_submit_valid_ajax(subOpt) {
	
	if($(subOpt.formId).attr("action") == null) {
		alert("$ Error : form ID를 정확히 설정하여 주세요" 
				+ "\n$ form ID : " + subOpt.formId);
		return;
	}

	$(subOpt.formId).validate({
		invalidHandler: fn_invalid_handler,
		submitHandler: function(form) {
            $(subOpt.formId).ajaxSubmit({
			    type: "POST",
                target: subOpt.target,
                beforeSubmit: function(formData, form, options) {
            		var result = true;

            		if (subOpt.indicator || subOpt.indiZone) {
            			fn_show_indicator(subOpt);
            		}
            		
    				if (subOpt.before) {
    					result = subOpt.before(formData, form, options); 
    				}
    				
    				if (!result && (subOpt.indicator || subOpt.indiZone)) {
    	    			fn_hide_indicator(subOpt);
    				}
    				
    				return result;
                },
                success: function(data, status) {
            		if (subOpt.indicator || subOpt.indiZone) {
            			fn_hide_indicator(subOpt);
            		}
					
					// dataType 이 json, xml 일 경우 
					if (subOpt.dataType == "json" || subOpt.dataType == "xml") {
				    	if (typeof data.result == "object") {
				    		subOpt.success(data, status);
				    	} else if (typeof data.error == "object") {
							var message = "서버와 통신중 에러가 발생했습니다.\n\n관리자에게 문의하세요\n\nMessage:\n    ";
							alert(message+data.error.message);
						}
					} else {
		    	    	if (subOpt.success) {
		    	    		subOpt.success(data, status);
		    	    	}
					}
                },
                error:  function(request, errorText, error) {
            		if (subOpt.indicator || subOpt.indiZone) {
            			fn_hide_indicator(subOpt);
            		}
        	    	if (subOpt.error) {
        	    		subOpt.error(request, errorText, error);
        	    	}
            		fn_show_error_state(request, errorText, error);
                },
           		timeout: subOpt.timeout||40000,
				dataType:subOpt.dataType,
				clearForm: subOpt.clearForm,
				resetForm: subOpt.resetForm,
		        isAsync: subOpt.isAsync||false
    		});
			
	    }
    });
}

function fn_get_submit_ajax(subOpt) {
	
	$.ajax({
		type: "GET",
		url: subOpt.action,
		data: subOpt.data,
		beforeSend: function() {
		
			var result = true;
	
			if (subOpt.indicator || subOpt.indiZone) {
				fn_show_indicator(subOpt);    			
			}
			
			if (subOpt.before) {
				result = subOpt.before(formData, form, options); 
			}
			if (!result && (subOpt.indicator || subOpt.indiZone)) {
				fn_hide_indicator(subOpt);
			}
			
			return result;
		},
		success: function(data, status) {
		
			if (subOpt.indicator || subOpt.indiZone) {
				fn_hide_indicator(subOpt);
			}
			
			// dataType 이 json, xml 일 경우 
			if (subOpt.dataType == "json" || subOpt.dataType == "xml") {
		    	if (typeof data.result == "object") {
		    		subOpt.success(data, status);
		    	} else if (typeof data.error == "object") {
					var message = "서버와 통신중 에러가 발생했습니다.\n\n관리자에게 문의하세요\n\nMessage:\n    ";
					alert(message+data.error.message);
				}
			} else {
		    	if (subOpt.success) {
		    		subOpt.success(data, status);
		    	}
			}
		},
	    error: function(request, errorText, error) {
    		if (subOpt.indicator || subOpt.indiZone) {
    			fn_hide_indicator(subOpt);
    		}
	    	if (subOpt.error) {
	    		subOpt.error(request, errorText, error);
	    	}
    		fn_show_error_state(request, errorText, error);
        },
   		timeout: subOpt.timeout||40000,
		dataType: subOpt.dataType,
        isAsync: subOpt.isAsync||false
	})

    $(subOpt.formId).ajaxSubmit({
	    type: "POST",
        target: subOpt.target,
        beforeSubmit: function(formData, form, options) {
    		var result = true;

    		if (subOpt.indicator || subOpt.indiZone) {
    			fn_show_indicator(subOpt);    			
    		}
    		
			if (subOpt.before) {
				result = subOpt.before(formData, form, options); 
			}
			if (!result && (subOpt.indicator || subOpt.indiZone)) {
    			fn_hide_indicator(subOpt);
			}
			
			return result;
        },
        success: function(data, status) {
    		if (subOpt.indicator || subOpt.indiZone) {
    			fn_hide_indicator(subOpt);
    		}
			
			// dataType 이 json, xml 일 경우 
			if (subOpt.dataType == "json" || subOpt.dataType == "xml") {
		    	if (typeof data.result == "object") {
		    		subOpt.success(data, status);
		    	} else if (typeof data.error == "object") {
					var message = "서버와 통신중 에러가 발생했습니다.\n\n관리자에게 문의하세요\n\nMessage:\n    ";
					alert(message+data.error.message);
				}
			} else {
    	    	if (subOpt.success) {
    	    		subOpt.success(data, status);
    	    	}
			}
			
        },
        error: function(request, errorText, error) {
    		if (subOpt.indicator || subOpt.indiZone) {
    			fn_hide_indicator(subOpt);
    		}
	    	if (subOpt.error) {
	    		subOpt.error(request, errorText, error);
	    	}
    		fn_show_error_state(request, errorText, error);
        },
   		timeout: subOpt.timeout||40000,
		dataType: subOpt.dataType,
		clearForm: subOpt.clearForm,
		resetForm: subOpt.resetForm,
		iframeTarget : subOpt.iframeTarget||null,
        isAsync: subOpt.isAsync||false

	});
}

/************************************************************************
함수명 : fn_show_error_state
설  명 : ajax 통신일때 서버에서 오류가 발생했을경우 보여지는 메세지
         이 함수는 ajax 호출 함수내에서 사용한다.
인  자 : request, errorText, error
사용법 : fn_show_error_state(request, errorText, error)
작성일 : 2009.01.12
작성자 : 함장수

수정일         수정자   수정내용
------------   ------   -------------------
2009.01.12     함장수   최초작성
************************************************************************/
function fn_show_error_state(request, errorText, error) {
	
	alert("$ 서버와 통신중 에러가 발생했습니다. 관리자에게 문의하세요."
			+ "\n\n$ request.status : " + request.status
			+ "\n$ request.statusText : " + request.statusText
			+ "\n$ ajax error : " + errorText);
			//+ "\n\n$ exception stack ==============================================================="
			//+ "\n\n" + error.replace(/\<br>/g, "")
}


/************************************************************************
함수명 : fn_invalid_handler
설  명 : 폼 검증 할때 유효성에 어긋났을경우 출력되는 메세지
         폼 검증 함수에서 사용한다.
인  자 : form, validator
사용법 : fn_invalid_handler(form, validator)
작성일 : 2009.01.12
작성자 : 함장수

수정일         수정자   수정내용
------------   ------   -------------------
2009.01.12     함장수   최초작성
************************************************************************/
function fn_invalid_handler(form, validator) {
	var errors = validator.numberOfInvalids();
	if (errors) {
		var message = errors == 1
			? '1개의 항목이 잘못되었습니다. 화면에 강조된 내용을 보세요!'
			: errors + ' 개의 항목이 잘못되었습니다. 화면에 강조된 내용을 보세요!';
		//var message ="입력된 값이 잘 못 되었습니다. 아래에 강조된 내용을 보세요!";
		//$("div.error span").html(message);
		//$("div.error").show();
		alert(message);
	} else {
		//$("div.error").hide();
	}
}



/************************************************************************
함수명 : fn_reset_form
설  명 : 폼 리셋
인  자 : formId ("#formid")
사용법 : fn_reset_form(formId)
작성일 : 2010.09.26
작성자 : 함장수

수정일         수정자   수정내용
------------   ------   -------------------
2010.09.26     함장수   최초작성
************************************************************************/
function fn_reset_form(subOpt) {
	$(subOpt.formId).validate().resetForm();
	$("#div_total_errors span").html("");
	$("#div_total_errors").hide();
}



/************************************************************************
함수명 : fn_reset_form
설  명 : 폼 리셋
인  자 : formId ("#elementId")
사용법 : fn_hide_eroor_label(elementId)
작성일 : 2010.09.26
작성자 : 함장수

수정일         수정자   수정내용
------------   ------   -------------------
2010.09.26     함장수   최초작성
************************************************************************/
function fn_hide_error_label(elementId) {
	$("#"+elementId).removeClass("error");
	$("label.error").filter("label[for="+elementId+"]").hide();
}


/************************************************************************
함수명 : fn_confirm_save
설  명 : 저장시 확인 메세지
인  자 : 
사용법 : fn_confirm_save()
작성일 : 2010.09.26
작성자 : 함장수

수정일         수정자   수정내용
------------   ------   -------------------
2010.09.26     함장수   최초작성
************************************************************************/
function fn_confirm_save() {
    return confirm("저장하시겠습니까?");
}


function fn_hide_indicator(subOpt) {
	if (subOpt.indiZone) {
		$("#ajax_overlay").remove();
	}

	if (subOpt.indicator) {
		$(subOpt.indicator).hide();
	}
}


function fn_show_indicator(subOpt) {

	var _win = jQuery(window);
	var _doc = jQuery(document);
    var _docHeight = _doc.height();
    var _winWidth = _win.width();
    var _winHeight = _win.height();
    var _w = 354;
    var _h = 128;
    var pos = null;
    
	if ($("#leftFrm").attr("id") != null) {
    	_winWidth += $("#leftFrm").offset().left;
    }
	
    if (subOpt.indiZone) {
    	
    	fn_hide_indiZone();
    	
	    var _indiZone = $(subOpt.indiZone);
	    var _indiZoneOffset = _indiZone.offset();
	    
	    //pos = [_indiZoneOffset.left + _indiZone.width()/2 - _w/2, _indiZoneOffset.top + _indiZone.height()/2 - _h/2];
	    pos = [(_docHeight > _winHeight) ? _winWidth/2 - _w/2 - 18 : _winWidth/2 - _w/2,  _doc.scrollTop() + _winHeight/2 - _h/2];
	    
	    jQuery('<div />').attr('id', "ajax_overlay").addClass("ax_overlay").css({
	    	position: 'absolute',
	    	left:_indiZoneOffset.left,
	    	top:_indiZoneOffset.top,
	    	width: _indiZone.width(),
	    	height: _indiZone.height(),
	    	opacity: 0.2,
	    	zIndex: 100000
	    }).appendTo(document.body);
	}
    else {
    	
    	pos = [(_docHeight > _winHeight) ? _winWidth/2 - _w/2 - 18 : _winWidth/2 - _w/2,  _doc.scrollTop() + _winHeight/2 - _h/2];
    }
    
    if (subOpt.indicator) {
    	
    	$(subOpt.indicator).css({
    		position:"absolute",
    		left:pos[0],
    		top:pos[1],
    		width:_w,
    		height:_h,
    		zIndex: 1000001
    	});
    	$(subOpt.indicator).show();
    }
}

function fn_show_indiZone(indiZone) {
	
	fn_hide_indiZone();
	
    var _indiZone = $(indiZone);
    var _indiZoneOffset = _indiZone.offset();
    
    jQuery('<div />').attr('id', "ajax_overlay").addClass("ax_overlay").css({
    	position: 'absolute',
    	left:_indiZoneOffset.left,
    	top:_indiZoneOffset.top,
    	width: _indiZone.width(),
    	height: _indiZone.height(),
    	opacity: 0.5,
    	zIndex: 100000
    }).appendTo(document.body);
}

function fn_hide_indiZone() {
	
	$("#ajax_overlay").remove();
}