/********************************************************
파일명 : JEditor.js
설  명 : JFramework 공통 JavaScript

수정일     수정자   Version    Function 명
---------- -------- ---------- --------------
2012.10.26 박상훈   1.0        최초 생성
*********************************************************/

// 객체 생성
var JEditor = new Object();

/************************************************************************
함수명 : create
설  명 : 에디터 생성
인  자 : textarea id
사용법 : 
작성일 : 2012.10.26
작성자 : 박상훈

수정일         수정자   수정내용
------------   ------   -------------------
2012.10.26     박상훈   최초작성
 ************************************************************************/

JEditor.create = function (opt) {
	
	this.path = opt.path ? opt.path : "";
	this.id   = opt.id   ? opt.id : "cntt";
	
	this.oEditors = [];
	
	nhn.husky.EZCreator.createInIFrame({ 
		oAppRef: this.oEditors, 
		elPlaceHolder: this.id, 
		sSkinURI: this.path + "/js/plugin/smartEditor2/SmartEditor2Skin.html", 
		fCreator: "createSEditor2",
		htParams: {
			fOnBeforeUnload: function() {}
		}
	});
	
};

JEditor.create.prototype = {
		
	update: function () {
	
		this.oEditors.getById[this.id].exec("UPDATE_CONTENTS_FIELD", []);
	},
	
	focus: function () {
		this.oEditors[0].exec("FOCUS", []);
	}
	
};
