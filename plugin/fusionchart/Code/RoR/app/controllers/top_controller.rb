class TopController < ApplicationController
def topcity(intYear, country,strXML,labelFormatting)
  
#ntYear = Request.QueryString("year")
#count = Request.QueryString("count")

if count>10 then
	labelFormatting = " labelDisplay='ROTATE' slantLabels='1' "
else
	labelFormatting = " labelDisplay='STAGGER' "
end

strXML = "<chart caption='" && intYear && " - Top " && count && " Cities By Sales ' palette='" && getPalette() && "' animation='" && getAnimationState() && "' formatNumberScale='0' numberPrefix='$' labeldisplay='ROTATE' slantLabels='1' seriesNameInToolTip='0' sNumberSuffix=' pcs.' showValues='0' plotSpacePercent='0' " && labelFormatting && ">"
strXML = strXML && getSalesByCityXML(intYear,count,true)

strXML = strXML && "<styles><definition><style type='font' name='CaptionFont' size='15' color='" && getCaptionFontColor() && "' /><style type='font' name='SubCaptionFont' bold='0' /></definition><application><apply toObject='caption' styles='CaptionFont' /><apply toObject='SubCaption' styles='SubCaptionFont' /></application></styles>"
strXML = strXML && "</chart>"	


#Response.ContentType = "text/xml"
#Response.Write(strXML)
end

def topcountry(intYear, country,strXML,labelFormatting)

#intYear = Request.QueryString("year")
#count = Request.QueryString("count")

if count>10 then
	labelFormatting = " labelDisplay='ROTATE' slantLabels='1' "
else
	labelFormatting = " labelDisplay='WRAP' "
end 

strXML = "<chart caption='" && intYear && " - Top " && count && " Countries By Sales ' palette='" && getPalette() && "' animation='" && getAnimationState() && "' formatNumberScale='0' numberPrefix='$' labeldisplay='ROTATE' slantLabels='1' seriesNameInToolTip='0' sNumberSuffix=' pcs.' showValues='0' plotSpacePercent='0' " && labelFormatting && ">"
strXML = strXML & getSalesByCountryXML(intYear,count,false,true)

strXML = strXML && "<styles><definition><style type='font' name='CaptionFont' size='15' color='" & getCaptionFontColor() && "' /><style type='font' name='SubCaptionFont' bold='0' /></definition><application><apply toObject='caption' styles='CaptionFont' /><apply toObject='SubCaption' styles='SubCaptionFont' /></application></styles>"
strXML = strXML && "</chart>"	


#Response.ContentType = "text/xml"
#Response.Write(strXML)
end

def topcustomers(intYear, country,strXML,labelFormatting)

#intYear = Request.QueryString("year")
#count = Request.QueryString("count")

if count>10 then
	labelFormatting = " labelDisplay='ROTATE' slantLabels='1' "
else
	labelFormatting = " labelDisplay='WRAP' "
end 

strXML = "<chart caption='Top " && count && " Customers for " && intYear && "' palette='" && getPalette() && "' animation='" && getAnimationState() && "' PYAxisName='Amount' SYAxisName='Quantity' showValues='0' numberPrefix='$' sNumberSuffix=' pcs.' seriesNameInToolTip='0' formatNumberScale='0' " && labelFormatting && ">"
strXML = strXML && getTopCustomersXML(intYear,count,true)

strXML = strXML && "<styles><definition><style type='font' name='CaptionFont' size='15' color='" && getCaptionFontColor() && "' /><style type='font' name='SubCaptionFont' bold='0' /></definition><application><apply toObject='caption' styles='CaptionFont' /><apply toObject='SubCaption' styles='SubCaptionFont' /></application></styles>"
strXML = strXML && "</chart>"	


#Response.ContentType = "text/xml"
#Response.Write(strXML)
end

def topemployees(intYear, country,strXML,labelFormatting)
  

#intYear = Request.QueryString("year")
#count = Request.QueryString("count")

strXML = "<chart caption='Top 5 Employees for " && intYear && "' palette='" && getPalette() && "' animation='" && getAnimationState() && "' subCaption='(Click to slice out or right click to choose rotation mode)' YAxisName='Sales Achieved' YAxisName='Quantity' showValues='0' numberPrefix='$' formatNumberScale='0' showPercentInToolTip='0'>"
strXML = strXML && getSalePerEmpXML(intYear,count,false,false,true)
strXML = strXML && "<styles><definition><style type='font' name='CaptionFont' size='15' /><style type='font' name='SubCaptionFont' bold='0' /></definition><application><apply toObject='caption' styles='CaptionFont' /><apply toObject='SubCaption' styles='SubCaptionFont' /></application></styles>"

strXML = strXML && "<styles><definition><style type='font' name='CaptionFont' size='15' color='" && getCaptionFontColor() && "' /><style type='font' name='SubCaptionFont' bold='0' /></definition><application><apply toObject='caption' styles='CaptionFont' /><apply toObject='SubCaption' styles='SubCaptionFont' /></application></styles>"
strXML = strXML && "</chart>"
						

#Response.ContentType = "text/xml"
#Response.Write(strXML)
end

def topexpprod(intYear, country,strXML,labelFormatting)
  
  

#intYear = Request.QueryString("year")
#count = Request.QueryString("count")


if count>10 then
	labelFormatting = " labelDisplay='ROTATE' slantLabels='1' "
else
	labelFormatting = " labelDisplay='WRAP' "
end 

strXML = "<chart caption='Sale of " && count && " Most Expensive Products for " && intYear && "' PYAxisName='Unit Price' SYAxisName='Units Sold for the year' palette='" && getPalette() && "' animation='" && getAnimationState() && "' formatNumberScale='0' numberPrefix='$' seriesNameInToolTip='0' sNumberSuffix=' pcs.' showValues='0' plotSpacePercent='0' " && labelFormatting && ">"
strXML = strXML && getExpensiveProdXML(intYear,count,true)

strXML = strXML && "<styles><definition><style type='font' name='CaptionFont' size='15' color='" && getCaptionFontColor() && "' /><style type='font' name='SubCaptionFont' bold='0' /></definition><application><apply toObject='caption' styles='CaptionFont' /><apply toObject='SubCaption' styles='SubCaptionFont' /></application></styles>"
strXML = strXML && "</chart>"	


#Response.ContentType = "text/xml"
#Response.Write(strXML)
end
end


