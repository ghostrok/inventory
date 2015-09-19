
/*********** SITE, domain Setting *****************/
var domUrl = window.location.href;

// .com -> co.kr
if( domUrl.indexOf("cheongsol.com")>= 0 ){
	var rdrctUrl = domUrl.replace("cheongsol.com","cheongsol.co.kr");
	window.location.replace(rdrctUrl);
} else if (domUrl.indexOf("localhost")>= 0) {
	
}
// domain setting
else {
	document.domain="cheongsol.co.kr";
}
