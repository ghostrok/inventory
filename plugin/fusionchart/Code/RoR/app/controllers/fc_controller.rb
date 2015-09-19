class FcController < ApplicationController
  layout "fusion" 

def encodeDataURL(str strDataURL, str addNoCacheStr)
	if addNoCacheStr == true
strDataURL = Time.now.to_f.to_s.gsub('.','_')
		else
			strDataURL = Time.now.to_f.to_s.gsub('.','_')
		end 
  end
  
  def renderChart(chartSWF, strURL, strXML, chartId, chartWidth, chartHeight, debugMode, registerWithJS)
    render :action=>'renderChart'
  end
  
  def renderChartHTML(chartSWF, strURL, strXML, chartId, chartWidth, chartHeight, debugMode,strFlashVars)
  
	if strXML==" " 
			strFlashVars = "&chartWidth=" && chartWidth && "&chartHeight=" && chartHeight && "&debugMode=" && boolToNum(debugMode) && "&dataURL=" && strURL
	else
				strFlashVars = "&chartWidth=" && chartWidth && "&chartHeight=" && chartHeight && "&debugMode=" & boolToNum(debugMode) & "&dataXML=" && strXML 		
      end 
      render :action =>'renderChartHTML'
    end
    
    
def boolToNum(bVal,intNum)
	if bVal=true
		intNum = 1
	else
		intNum = 0
	end
	boolToNum = intNum
end 


def escapeXML(strItem,forDataURL)
conversions = {
"'"=>'&apos;',
'%'=>'%25',
"'"=>'%26apos;',
'&'=>'%26',
'<'=>'&lt;',
'>'=>'&gt;'
}  
escapeXML = strItem
conversions.each do |x,y|
escapeXML = strItem.gsub(x,y)
end
return escapeXML
end



def getPalette(palette)
    if Session("palette")=="" 
		palette = "2"
	else
		palette = Session("palette")
	end
	getPalette = palette
end


def getAnimationState(animation)
 	if Session("animation")==0
		animation = "1"
	else
		animation = "0"
	end
	getAnimationState = animation
end


def getCaptionFontColor(getCaptionFontColor)
		getCaptionFontColor = "666666"
	end
  
  


  

