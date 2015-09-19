/********************************************************
파일명 : JString.js
설  명 : 문자열 프로토타입

수정일     수정자   Version    Function 명
---------- -------- ---------- --------------
2009.01.12 함장수   1.0        최초 생성
*********************************************************/

/*--------------------------------------------------------------------------------*
 *  String prototype
 *--------------------------------------------------------------------------------*/
//-----------------------------------------------------------------------------
// 문자의 좌, 우 공백 제거
// @return : String
//-----------------------------------------------------------------------------
String.prototype.trim = function() {
    return this.replace(/(^\s*)|(\s*$)/g, "");
};
//-----------------------------------------------------------------------------
// 문자의 좌 공백 제거
// @return : String
//-----------------------------------------------------------------------------
String.prototype.lTrim = function() {
    return this.replace(/(^\s*)/, "");
};
//-----------------------------------------------------------------------------
// 문자의 우 공백 제거
// @return : String
//-----------------------------------------------------------------------------
String.prototype.rTrim = function() {
    return this.replace(/(\s*$)/, "");    
};
	
//-----------------------------------------------------------------------------
// 문자열의 byte 길이 반환
// @return : int
//-----------------------------------------------------------------------------
String.prototype.byteVal = function() {
    var cnt = 0;
    for (var i = 0; i < this.length; i++) {
        if (this.charCodeAt(i) > 127)
            cnt += 2;
        else
            cnt++;
    }
    return cnt;
};
//-----------------------------------------------------------------------------
// 정수형으로 변환
// @return : String
//-----------------------------------------------------------------------------
String.prototype.intVal = function() {
    if(!isNaN(this)) {
        return parseInt(this);
    }
    else {
        return null;    
    }
};
//-----------------------------------------------------------------------------
// 숫자만 가져 오기
// @return : String
//-----------------------------------------------------------------------------
String.prototype.num = function() {
    return (this.trim().replace(/[^0-9]/g, ""));
};
//-----------------------------------------------------------------------------
// 숫자에 3자리마다 , 를 찍어서 반환
// @return : String
//-----------------------------------------------------------------------------
String.prototype.money = function() {
    var num = this.trim();
    while((/(-?[0-9]+)([0-9]{3})/).test(num)) {
        num = num.replace((/(-?[0-9]+)([0-9]{3})/), "$1,$2");
    }
    return num;
};
//-----------------------------------------------------------------------------
// 숫자의 자리수(cnt)에 맞도록 반환
// @return : String
//-----------------------------------------------------------------------------
String.prototype.digits = function(cnt) {
    var digit = "";
    if (this.length < cnt) {
        for(var i = 0; i < cnt - this.length; i++) {
            digit += "0";
        }
    }
    return digit + this;
};
//-----------------------------------------------------------------------------
// " -> &#34; ' -> &#39;로 바꾸어서 반환
// @return : String
//-----------------------------------------------------------------------------
String.prototype.quota = function() {
    return this.replace(/"/g, "&#34;").replace(/'/g, "&#39;");
};
//-----------------------------------------------------------------------------
// 파일 확장자만 가져오기
// @return : String
//-----------------------------------------------------------------------------
String.prototype.ext = function() {
    return (this.indexOf(".") < 0) ? "" : this.substring(this.lastIndexOf(".") + 1, this.length);    
};
//-----------------------------------------------------------------------------
// URL에서 파라메터 제거한 순수한 url 얻기
// @return : String
//-----------------------------------------------------------------------------    
String.prototype.uri = function() {
    var arr = this.split("?");
    arr = arr[0].split("#");
    return arr[0];    
};


//-----------------------------------------------------------------------------
// unicode 를 한글로 변환
// @return : String
//-----------------------------------------------------------------------------
String.prototype.unidecode = function() {
	var split_str = this.split(";");
	var result = "";
	
	for(var i=0;i<split_str.length;i++) {
		result += String.fromCharCode(split_str[i].replace("&#",""));
	}
	return result;
};

/*---------------------------------------------------------------------------------*\
 *  각종 체크 함수들
\*---------------------------------------------------------------------------------*/
//-----------------------------------------------------------------------------
// 정규식에 쓰이는 특수문자를 찾아서 이스케이프 한다.
// @return : String
//-----------------------------------------------------------------------------
String.prototype.meta = function() {
    var str = this;
    var result = "";
    for(var i = 0; i < str.length; i++) {
        if((/([\$\(\)\*\+\.\[\]\?\\\^\{\}\|]{1})/).test(str.charAt(i))) {
            result += str.charAt(i).replace((/([\$\(\)\*\+\.\[\]\?\\\^\{\}\|]{1})/), "\\$1");
        }
        else {
            result += str.charAt(i);
        }
    }
    return result;
};
//-----------------------------------------------------------------------------
// 정규식에 쓰이는 특수문자를 찾아서 이스케이프 한다.
// @return : String
//-----------------------------------------------------------------------------
String.prototype.remove = function(pattern) {
    return (pattern == null) ? this : eval("this.replace(/[" + pattern.meta() + "]/g, \"\")");
};
//-----------------------------------------------------------------------------
// 최소 최대 길이인지 검증
// str.isLength(min [,max])
// @return : boolean
//-----------------------------------------------------------------------------
String.prototype.isLength = function() {
    var min = arguments[0];
    var max = arguments[1] ? arguments[1] : null;
    var success = true;
    if(this.length < min) {
        success = false;
    }
    if(max && this.length > max) {
        success = false;
    }
    return success;
};
//-----------------------------------------------------------------------------
// 최소 최대 바이트인지 검증
// str.isByteLength(min [,max])
// @return : boolean
//-----------------------------------------------------------------------------
String.prototype.isByteLength = function() {
    var min = arguments[0];
    var max = arguments[1] ? arguments[1] : null;
    var success = true;
    if(this.byteVal() < min) {
        success = false;
    }
    if(max && this.byteVal() > max) {
        success = false;
    }
    return success;
};
//-----------------------------------------------------------------------------
// 공백이나 널인지 확인
// @return : boolean
//-----------------------------------------------------------------------------
String.prototype.isBlank = function() {
    var str = this.trim();
    for(var i = 0; i < str.length; i++) {
        if ((str.charAt(i) != "\t") && (str.charAt(i) != "\n") && (str.charAt(i)!="\r")) {
            return false;
        }
    }
    return true;
};
//-----------------------------------------------------------------------------
// 숫자로 구성되어 있는지 학인
// arguments[0] : 허용할 문자셋
// @return : boolean
//-----------------------------------------------------------------------------
String.prototype.isNum = function() {
    return (/^[0-9]+$/).test(this.remove(arguments[0])) ? true : false;
};
//-----------------------------------------------------------------------------
// 영어만 허용 - arguments[0] : 추가 허용할 문자들
// @return : boolean
//-----------------------------------------------------------------------------
String.prototype.isEng = function() {
    return (/^[a-zA-Z]+$/).test(this.remove(arguments[0])) ? true : false;
};
//-----------------------------------------------------------------------------
// 숫자와 영어만 허용 - arguments[0] : 추가 허용할 문자들
// @return : boolean
//-----------------------------------------------------------------------------
String.prototype.isEngNum = function() {
    return (/^[0-9a-zA-Z]+$/).test(this.remove(arguments[0])) ? true : false;
};
//-----------------------------------------------------------------------------
// 숫자와 영어만 허용 - arguments[0] : 추가 허용할 문자들
// @return : boolean
//-----------------------------------------------------------------------------
String.prototype.isNumEng = function() {
    return this.isEngNum(arguments[0]);
};
//-----------------------------------------------------------------------------
// 아이디 체크 영어와 숫자만 체크 첫글자는 영어로 시작 - arguments[0] : 추가 허용할 문자들
// @return : boolean
//-----------------------------------------------------------------------------
String.prototype.isUserid = function() {
    return (/^[a-zA-z]{1}[0-9a-zA-Z]+$/).test(this.remove(arguments[0])) ? true : false;
};
//-----------------------------------------------------------------------------
// 한글 체크 - arguments[0] : 추가 허용할 문자들
// @return : boolean
//-----------------------------------------------------------------------------
String.prototype.isKor = function() {
    return (/^[가-힣]+$/).test(this.remove(arguments[0])) ? true : false;
};
//-----------------------------------------------------------------------------
// 주민번호 체크 - arguments[0] : 주민번호 구분자
// XXXXXX-XXXXXXX
// @return : boolean
//-----------------------------------------------------------------------------
String.prototype.isJumin = function() {
    var arg = arguments[0] ? arguments[0] : "";
    var jumin = eval("this.match(/[0-9]{2}[01]{1}[0-9]{1}[0123]{1}[0-9]{1}" + arg + "[1234]{1}[0-9]{6}$/)");
    if(jumin == null) {
        return false;
    }
    else {
        jumin = jumin.toString().num().toString();
    }
    // 생년월일 체크
    var birthYY = (parseInt(jumin.charAt(6)) == (1 ||2)) ? "19" : "20";
    birthYY += jumin.substr(0, 2);
    var birthMM = jumin.substr(2, 2) - 1;
    var birthDD = jumin.substr(4, 2);
    var birthDay = new Date(birthYY, birthMM, birthDD);
    if(birthDay.getYear() % 100 != jumin.substr(0,2) || birthDay.getMonth() != birthMM || birthDay.getDate() != birthDD) {
        return false;
    }        
    var sum = 0;
    var num = [2, 3, 4, 5, 6, 7, 8, 9, 2, 3, 4, 5];
    var last = parseInt(jumin.charAt(12));
    for(var i = 0; i < 12; i++) {
        sum += parseInt(jumin.charAt(i)) * num[i];
    }
    return ((11 - sum % 11) % 10 == last) ? true : false;
};
//-----------------------------------------------------------------------------
// 외국인 등록번호 체크 - arguments[0] : 등록번호 구분자
// XXXXXX-XXXXXXX
// @return : boolean
//-----------------------------------------------------------------------------
String.prototype.isForeign = function() {
    var arg = arguments[0] ? arguments[0] : "";
    var jumin = eval("this.match(/[0-9]{2}[01]{1}[0-9]{1}[0123]{1}[0-9]{1}" + arg + "[5678]{1}[0-9]{1}[02468]{1}[0-9]{2}[6789]{1}[0-9]{1}$/)");
    if(jumin == null) {
        return false;
    }
    else {
        jumin = jumin.toString().num().toString();
    }
    // 생년월일 체크
    var birthYY = (parseInt(jumin.charAt(6)) == (5 || 6)) ? "19" : "20";
    birthYY += jumin.substr(0, 2);
    var birthMM = jumin.substr(2, 2) - 1;
    var birthDD = jumin.substr(4, 2);
    var birthDay = new Date(birthYY, birthMM, birthDD);
    if(birthDay.getYear() % 100 != jumin.substr(0,2) || birthDay.getMonth() != birthMM || birthDay.getDate() != birthDD) {
        return false;
    }
    if((parseInt(jumin.charAt(7)) * 10 + parseInt(jumin.charAt(8))) % 2 != 0) {
        return false;
    }
    var sum = 0;
    var num = [2, 3, 4, 5, 6, 7, 8, 9, 2, 3, 4, 5];
    var last = parseInt(jumin.charAt(12));
    for(var i = 0; i < 12; i++) {
        sum += parseInt(jumin.charAt(i)) * num[i];
    }
    return (((11 - sum % 11) % 10) + 2 == last) ? true : false;
} ;   
//-----------------------------------------------------------------------------
// 사업자번호 체크 - arguments[0] : 등록번호 구분자
// XXX-XX-XXXXX
// @return : boolean
//-----------------------------------------------------------------------------
String.prototype.isBiznum = function() {
    var arg = arguments[0] ? arguments[0] : "";
    var biznum = eval("this.match(/[0-9]{3}" + arg + "[0-9]{2}" + arg + "[0-9]{5}$/)");
    if(biznum == null) {
        return false;
    }
    else {
        biznum = biznum.toString().num().toString();
    }
    var sum = parseInt(biznum.charAt(0));
    var num = [0, 3, 7, 1, 3, 7, 1, 3];
    for(var i = 1; i < 8; i++) sum += (parseInt(biznum.charAt(i)) * num[i]) % 10;
    sum += Math.floor(parseInt(parseInt(biznum.charAt(8))) * 5 / 10);
    sum += (parseInt(biznum.charAt(8)) * 5) % 10 + parseInt(biznum.charAt(9));
    return (sum % 10 == 0) ? true : false;
};
//-----------------------------------------------------------------------------
// 법인 등록번호 체크 - arguments[0] : 등록번호 구분자
// XXXXXX-XXXXXXX
// ※마지막 10번째(전산오류구분숫자) 숫자가 오류인 법인번호도 존재한다.
//   (법인번호 전산화 이전의 데이터)
//   그러므로 전적으로 신뢰하지 말것!!!!!!!
// @return : boolean
//-----------------------------------------------------------------------------
String.prototype.isCorpnum = function() {
    var arg = arguments[0] ? arguments[0] : "";
    var corpnum = eval("this.match(/[0-9]{6}" + arg + "[0-9]{7}$/)");
    if(corpnum == null) {
        return false;
    }
    else {
        corpnum = corpnum.toString().num().toString();
    }
    var sum = 0;
    var num = [1, 2, 1, 2, 1, 2, 1, 2, 1, 2, 1, 2];
    var last = parseInt(corpnum.charAt(12));
    for(var i = 0; i < 12; i++) {
        sum += parseInt(corpnum.charAt(i)) * num[i];
    }
    return ((10 - sum % 10) % 10 == last) ? true : false;
};
//-----------------------------------------------------------------------------
// 이메일의 유효성을 체크
// @return : boolean
//-----------------------------------------------------------------------------
String.prototype.isEmail = function() {
    return (/\w+([-+.]\w+)*@\w+([-.]\w+)*\.[a-zA-Z]{2,4}$/).test(this.trim());
};
//-----------------------------------------------------------------------------
// 전화번호 체크 - arguments[0] : 전화번호 구분자
// @return : boolean
//-----------------------------------------------------------------------------
String.prototype.isPhone = function() {
    var arg = arguments[0] ? arguments[0] : "";
    return eval("(/(02|0[3-9]{1}[0-9]{1})" + arg + "[1-9]{1}[0-9]{2,3}" + arg + "[0-9]{4}$/).test(this)");
};

//-----------------------------------------------------------------------------
// 전화번호 체크 - arguments[0] : 전화번호 구분자
// @return : boolean
//-----------------------------------------------------------------------------
String.prototype.isPhoneExt = function() {
    var arg = arguments[0] ? arguments[0] : "";
    return eval("(/[1-9]{1}[0-9]{2,3}" + arg + "[0-9]{4}$/).test(this)");
};
//-----------------------------------------------------------------------------
// 핸드폰번호 체크 - arguments[0] : 핸드폰 구분자
// @return : boolean
//-----------------------------------------------------------------------------
String.prototype.isMobile = function() {
    var arg = arguments[0] ? arguments[0] : "";
    return eval("(/01[016789]" + arg + "[1-9]{1}[0-9]{2,3}" + arg + "[0-9]{4}$/).test(this)");
};

//-----------------------------------------------------------------------------
// 구분자 입력 - arguments[0] : 추가 허용할 문자들
// @return : boolean
//-----------------------------------------------------------------------------
String.prototype.gubun = function(pattern, g) {
    var ptn = pattern.split(",");
    var str = "", prv = 0;
    for (var i=0;i<ptn.length ;++i ) {
        if (i == 0) str = this.substring(prv, ptn[i]) ;
        else  str = str + g + this.substring(prv,eval(prv)+eval(ptn[i])) ;
        prv = eval(prv)+eval(ptn[i]);
    }
    return str;
};

//-----------------------------------------------------------------------------
//구분자 입력 - arguments[0] : 구분지을 문자
//@return : String
//-----------------------------------------------------------------------------
String.prototype.splitLast = function() {
    var arg = arguments[0] ? arguments[0] : "";
    var arr = this.split(arg);
    return arr[(arr.length)-1]; 
};
//-----------------------------------------------------------------------------
//아이디 체크
//6자 이상, 영문자나 숫자의 조합
//대소문자를 구분하며, 첫글자는 영문, 특수기는 '_','-'만 사용할 수 있습니다
//@return : boolean
//-----------------------------------------------------------------------------
String.prototype.isId = function() {
    var arg = arguments[0] ? arguments[0] : "";
    return eval("(/^[a-zA-Z]{1}[a-zA-Z0-9\_\-]{5,99}$/).test(this)");
};
//-----------------------------------------------------------------------------
//비밀번호 체크
//6자 이상 20자 이하의 영문, 숫자와 특수기호 (!, @, %, ^, &, *) 만 사용할 수 있으며 대소문자를 구분
//@return : boolean
//-----------------------------------------------------------------------------
String.prototype.isPw = function() {
  var arg = arguments[0] ? arguments[0] : "";
  return eval("(/^[a-zA-Z0-9\!\@\%\^\&\*]{6,20}$/).test(this)");
};


//-----------------------------------------------------------------------------
//MD5 해쉬문자 리턴
// - MD5는 역으로 해석이 불가능한 단방향 32비트 암호화 방식
//   MD5가 완벽한 암호화 방식인것은 아니며 안깨졌던것도 아님.
//   무차별 대입 공격이나 사전공격등에는 비교적 단시간에 깨질수도 있는 취약점이 있음
//   서로 다른 문자열이 암호화 되었더라도 암호화 후 서른두글자에서 잘려나간 해시값이 
//   같은 값이 나오는 경우 존재.
//   그 대안으로 나온게 SHA1 방식이나 SHA256 방식입니다.
// 출처 : 영국RSA사
	/* MD5 Message-Digest Algorithm - JavaScript
	' MODIFICATION HISTORY:
	' 1.0    16-Feb-2001 - Phil Fresle (sales@frez.co.uk) - Initial Version (VB/ASP code)
	' 1.0    21-Feb-2001 - Enrico Mosanghini (erik504@yahoo.com) - JavaScript porting
	*/
//@return : string
//-----------------------------------------------------------------------------
String.prototype.MD5 = function() {
	var sMessage = this;
	
    function RotateLeft(lValue, iShiftBits) {
        return (lValue<<iShiftBits) | (lValue>>>(32-iShiftBits));
    }

    function AddUnsigned(lX,lY) {
        var lX4,lY4,lX8,lY8,lResult;
        lX8 = (lX & 0x80000000);
        lY8 = (lY & 0x80000000);
        lX4 = (lX & 0x40000000);
        lY4 = (lY & 0x40000000);
        lResult = (lX & 0x3FFFFFFF)+(lY & 0x3FFFFFFF);

        if(lX4 & lY4)
            return (lResult ^ 0x80000000 ^ lX8 ^ lY8);
        if (lX4 | lY4) {
            if (lResult & 0x40000000)
            return (lResult ^ 0xC0000000 ^ lX8 ^ lY8);
        else
            return (lResult ^ 0x40000000 ^ lX8 ^ lY8);
        }
        else
            return (lResult ^ lX8 ^ lY8);
    }
 
    function F(x,y,z) {
        return (x & y) | ((~x) & z);
    }
    function G(x,y,z) {
        return (x & z) | (y & (~z));
    }
    function H(x,y,z) {
        return (x ^ y ^ z);
    }
    function I(x,y,z) {
        return (y ^ (x | (~z)));
    }

    function FF(a,b,c,d,x,s,ac) {
        a = AddUnsigned(a, AddUnsigned(AddUnsigned(F(b, c, d), x), ac));
        return AddUnsigned(RotateLeft(a, s), b);
    }
    function GG(a,b,c,d,x,s,ac) {
        a = AddUnsigned(a, AddUnsigned(AddUnsigned(G(b, c, d), x), ac));
        return AddUnsigned(RotateLeft(a, s), b);
    }
    function HH(a,b,c,d,x,s,ac) {
        a = AddUnsigned(a, AddUnsigned(AddUnsigned(H(b, c, d), x), ac));
        return AddUnsigned(RotateLeft(a, s), b);
    }
    function II(a,b,c,d,x,s,ac) {
        a = AddUnsigned(a, AddUnsigned(AddUnsigned(I(b, c, d), x), ac));
        return AddUnsigned(RotateLeft(a, s), b);
    }

    function ConvertToWordArray(sMessage) {
        var lWordCount;
        var lMessageLength = sMessage.length;
        var lNumberOfWords_temp1=lMessageLength + 8;
        var lNumberOfWords_temp2=(lNumberOfWords_temp1-(lNumberOfWords_temp1 % 64))/64;
        var lNumberOfWords = (lNumberOfWords_temp2+1)*16;
        var lWordArray = Array(lNumberOfWords-1);
        var lBytePosition = 0;
        var lByteCount = 0;
        while ( lByteCount < lMessageLength ) {
            lWordCount = (lByteCount-(lByteCount % 4))/4;
            lBytePosition = (lByteCount % 4)*8;
            lWordArray[lWordCount] = (lWordArray[lWordCount] | (sMessage.charCodeAt(lByteCount)<<lBytePosition));
            lByteCount++;
        }
        lWordCount = (lByteCount-(lByteCount % 4))/4;
        lBytePosition = (lByteCount % 4)*8;
        lWordArray[lWordCount] = lWordArray[lWordCount] | (0x80<<lBytePosition);
        lWordArray[lNumberOfWords-2] = lMessageLength<<3;
        lWordArray[lNumberOfWords-1] = lMessageLength>>>29;
        return lWordArray;
    }

    function WordToHex(lValue) {
        var WordToHexValue="",WordToHexValue_temp="",lByte,lCount;
        for (lCount=0; lCount<=3; lCount++) {
            lByte = (lValue>>>(lCount*8)) & 255;
            WordToHexValue_temp = "0" + lByte.toString(16);
            WordToHexValue = WordToHexValue + WordToHexValue_temp.substr(WordToHexValue_temp.length-2,2);
        }
        return WordToHexValue;
    }

    var x = Array();
    var k,AA,BB,CC,DD,a,b,c,d;
    var S11=7, S12=12, S13=17, S14=22;
    var S21=5, S22=9 , S23=14, S24=20;
    var S31=4, S32=11, S33=16, S34=23;
    var S41=6, S42=10, S43=15, S44=21;
    // Steps 1 and 2.  Append padding bits and length and convert to words
    x = ConvertToWordArray(sMessage);
    // Step 3.  Initialise
    a = 0x67452301; b = 0xEFCDAB89; c = 0x98BADCFE; d = 0x10325476;
    // Step 4.  Process the message in 16-word blocks
    for (k=0;k<x.length;k+=16) {
        AA=a; BB=b; CC=c; DD=d;
        a = FF(a,b,c,d,x[k+0], S11,0xD76AA478);
        d = FF(d,a,b,c,x[k+1], S12,0xE8C7B756);
        c = FF(c,d,a,b,x[k+2], S13,0x242070DB);
        b = FF(b,c,d,a,x[k+3], S14,0xC1BDCEEE);
        a = FF(a,b,c,d,x[k+4], S11,0xF57C0FAF);
        d = FF(d,a,b,c,x[k+5], S12,0x4787C62A);
        c = FF(c,d,a,b,x[k+6], S13,0xA8304613);
        b = FF(b,c,d,a,x[k+7], S14,0xFD469501);
        a = FF(a,b,c,d,x[k+8], S11,0x698098D8);
        d = FF(d,a,b,c,x[k+9], S12,0x8B44F7AF);
        c = FF(c,d,a,b,x[k+10],S13,0xFFFF5BB1);
        b = FF(b,c,d,a,x[k+11],S14,0x895CD7BE);
        a = FF(a,b,c,d,x[k+12],S11,0x6B901122);
        d = FF(d,a,b,c,x[k+13],S12,0xFD987193);
        c = FF(c,d,a,b,x[k+14],S13,0xA679438E);
        b = FF(b,c,d,a,x[k+15],S14,0x49B40821);
        a = GG(a,b,c,d,x[k+1], S21,0xF61E2562);
        d = GG(d,a,b,c,x[k+6], S22,0xC040B340);
        c = GG(c,d,a,b,x[k+11],S23,0x265E5A51);
        b = GG(b,c,d,a,x[k+0], S24,0xE9B6C7AA);
        a = GG(a,b,c,d,x[k+5], S21,0xD62F105D);
        d = GG(d,a,b,c,x[k+10],S22,0x2441453);
        c = GG(c,d,a,b,x[k+15],S23,0xD8A1E681);
        b = GG(b,c,d,a,x[k+4], S24,0xE7D3FBC8);
        a = GG(a,b,c,d,x[k+9], S21,0x21E1CDE6);
        d = GG(d,a,b,c,x[k+14],S22,0xC33707D6);
        c = GG(c,d,a,b,x[k+3], S23,0xF4D50D87);
        b = GG(b,c,d,a,x[k+8], S24,0x455A14ED);
        a = GG(a,b,c,d,x[k+13],S21,0xA9E3E905);
        d = GG(d,a,b,c,x[k+2], S22,0xFCEFA3F8);
        c = GG(c,d,a,b,x[k+7], S23,0x676F02D9);
        b = GG(b,c,d,a,x[k+12],S24,0x8D2A4C8A);
        a = HH(a,b,c,d,x[k+5], S31,0xFFFA3942);
        d = HH(d,a,b,c,x[k+8], S32,0x8771F681);
        c = HH(c,d,a,b,x[k+11],S33,0x6D9D6122);
        b = HH(b,c,d,a,x[k+14],S34,0xFDE5380C);
        a = HH(a,b,c,d,x[k+1], S31,0xA4BEEA44);
        d = HH(d,a,b,c,x[k+4], S32,0x4BDECFA9);
        c = HH(c,d,a,b,x[k+7], S33,0xF6BB4B60);
        b = HH(b,c,d,a,x[k+10],S34,0xBEBFBC70);
        a = HH(a,b,c,d,x[k+13],S31,0x289B7EC6);
        d = HH(d,a,b,c,x[k+0], S32,0xEAA127FA);
        c = HH(c,d,a,b,x[k+3], S33,0xD4EF3085);
        b = HH(b,c,d,a,x[k+6], S34,0x4881D05);
        a = HH(a,b,c,d,x[k+9], S31,0xD9D4D039);
        d = HH(d,a,b,c,x[k+12],S32,0xE6DB99E5);
        c = HH(c,d,a,b,x[k+15],S33,0x1FA27CF8);
        b = HH(b,c,d,a,x[k+2], S34,0xC4AC5665);
        a = II(a,b,c,d,x[k+0], S41,0xF4292244);
        d = II(d,a,b,c,x[k+7], S42,0x432AFF97);
        c = II(c,d,a,b,x[k+14],S43,0xAB9423A7);
        b = II(b,c,d,a,x[k+5], S44,0xFC93A039);
        a = II(a,b,c,d,x[k+12],S41,0x655B59C3);
        d = II(d,a,b,c,x[k+3], S42,0x8F0CCC92);
        c = II(c,d,a,b,x[k+10],S43,0xFFEFF47D);
        b = II(b,c,d,a,x[k+1], S44,0x85845DD1);
        a = II(a,b,c,d,x[k+8], S41,0x6FA87E4F);
        d = II(d,a,b,c,x[k+15],S42,0xFE2CE6E0);
        c = II(c,d,a,b,x[k+6], S43,0xA3014314);
        b = II(b,c,d,a,x[k+13],S44,0x4E0811A1);
        a = II(a,b,c,d,x[k+4], S41,0xF7537E82);
        d = II(d,a,b,c,x[k+11],S42,0xBD3AF235);
        c = II(c,d,a,b,x[k+2], S43,0x2AD7D2BB);
        b = II(b,c,d,a,x[k+9], S44,0xEB86D391);
        a = AddUnsigned(a,AA); b=AddUnsigned(b,BB); c=AddUnsigned(c,CC); d=AddUnsigned(d,DD);
    }
    // Step 5.  Output the 128 bit digest
    var temp = WordToHex(a) + WordToHex(b) + WordToHex(c) + WordToHex(d);
    return temp.toLowerCase();
};
