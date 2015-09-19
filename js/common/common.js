function setFileUpload(){
$("input").filter("[type=file]")
.bind("change", function(){
$(this).parent().find("span").filter("[class=size]").show();
$(this).parent().find("button").show();
$(this).parent().find("span").filter("[class=filename]").html($(this).val());
});
}

$(document).ready(function() {
	setFileUpload();
});