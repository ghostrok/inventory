<script type="text/javascript"> 

	function queryCheck()
	{
	
		    if(!document.form1.s_que.value){
		   	alert('검색어를 입력하세요');
		   	return false;
		    }
	
		document.form1.submit();
	}  

	function dateSelect1(docForm,selectIndex) 
	{
	    watch = new Date(docForm.fromyear.options[docForm.fromyear.selectedIndex].text, docForm.frommonth.options[docForm.frommonth.selectedIndex].value,1);
	    hourDiffer = watch - 86400000;
	    calendar = new Date(hourDiffer);
	
	    var daysInMonth = calendar.getDate();
	        for (var i = 0; i < docForm.fromday.length; i++) {
	            docForm.fromday.options[0] = null;
	        }
	        for (var i = 0; i < daysInMonth; i++) {
	            docForm.fromday.options[i] = new Option(i+1);
	    }
	    document.form1.fromday.options[0].selected = true;
	}
	
	function Today1(fromyear,mon,day) 
	{
			if(fromyear == "null" && mon == "null" && day == "null"){       
			today = new Date();
			this_year=today.getFullYear();
			this_month=today.getMonth();
			this_month+=1;
			if(this_month <10) this_month="0" + this_month;
			
			this_day=today.getDate();
			if(this_day<10) this_day="0" + this_day;     
		} else {  
	     var this_year = eval(fromyear);
	     var this_month = eval(mon); 
	     var this_day = eval(day);
		}
		  montharray=new Array(31, 29, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31); 
		  maxdays = montharray[this_month-1]; 
	
		  if (this_month==2) { 
		      if ((this_year/4)!=parseInt(this_year/4)) maxdays=28; 
		      else maxdays=29; 
		  } 
		
		document.writeln("<select name='fromyear' id='gyear' size=1 onChange='dateSelect1(this.form,this.form.frommonth.selectedIndex);'>");
		for(i=this_year-100;i<this_year+6;i++){//현재 년도에서 과거로 5년까지 미래로 5년까지를 표시함
		   if(i==this_year) document.writeln("<OPTION VALUE="+i+ " selected >" +i); 
		   else document.writeln("<OPTION VALUE="+i+ ">" +i); 
		}    
		document.writeln("</select>년");      
		document.writeln("<select name='frommonth' id='gmonth' size=1 onChange='dateSelect1(this.form,this.selectedIndex);'>");
		 for(i=1;i<=12;i++){ 
			 if(i<10){
			     if(i==this_month) document.writeln("<OPTION VALUE=0" +i+ " selected >0"+i); 
			     else document.writeln("<OPTION VALUE=0" +i+ ">0"+i);
			 }         
			 else{
			     if(i==this_month) document.writeln("<OPTION VALUE=" +i+ " selected >" +i);  
			     else document.writeln("<OPTION VALUE=" +i+ ">" +i);  
			 }                     
		}         
		document.writeln("</select>월");
		document.writeln("<select name='fromday' id='gday' size=1>");
		
		 for(i=1;i<=maxdays;i++){ 
		   if(i<10){
		       if(i==this_day) document.writeln("<OPTION VALUE=0" +i+ " selected >0"+i); 
		       else document.writeln("<OPTION VALUE=0" +i+ ">0"+i); 
		   } else {
		       if(i==this_day) document.writeln("<OPTION VALUE=" +i+ " selected } >"+i); 
		       else document.writeln("<OPTION VALUE=" +i+ ">" +i);  
		   }                     
		}
		document.writeln("</select>일"); 
	}

	$(document).ready(function() {
	
		// 현재날짜
	  $('#today_btn').click(function() {
			$("#gyear").val("<?=$today_y?>") ;							
			$("#gmonth").val("<?=$today_m?>") ;							
			$("#gday").val("<?=$today_d?>") ;							
		});
	
		// 한달전
	  $('#month_btn').click(function() {
			$("#gyear").val("<?=$before_m_y?>") ;							
			$("#gmonth").val("<?=$before_m_m?>") ;							
			$("#gday").val("<?=$before_m_d?>") ;							
		});
	
		// 일주일전
	  $('#week_btn').click(function() {
			$("#gyear").val("<?=$before_w_y?>") ;							
			$("#gmonth").val("<?=$before_w_m?>") ;							
			$("#gday").val("<?=$before_w_d?>") ;							
		});
		
	});
</script> 	

<iframe name="ifrm" id="ifrm" width="1" height="1"></iframe>


 
<?php 
//req(r);
?>