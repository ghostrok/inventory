# Filters added to this controller will be run for all controllers in the application.
# Likewise, all the methods added will be available for all controllers.
class ApplicationController < ActionController::Base
  
  def renderChart(chartSWF, strURL, strXML, chartId, chartWidth, chartHeight, debugMode, registerWithJS)
    renderChartText= "<!-- START Script Block for Chart " + chartId + " -->" + " \n "
    renderChartText= renderChartText + " \t <div id='"+chartId+"Div' align='center'>" + " \n "
		#		'The above text "Chart" is shown to users before the chart has started loading 	(if there is a lag in relaying SWF from server). This text is also shown to users who do not have Flash Player installed. You can configure it as per your needs.
    renderChartText= renderChartText + "\t \t" + ' Chart. ' + " \n "
    renderChartText= renderChartText + " \t </div> \n "
		#Now, we render the chart using FusionCharts Class. Each chart's instance (JavaScript) Id is named as chart_"chartId".		
    renderChartText= renderChartText + "\t" + '<script type="text/javascript">' + " \n "
    #Instantiate the Chart	
    renderChartText= renderChartText + "\t \t" +  'var chart_'+chartId+' = new FusionCharts("'+chartSWF+'", "'+chartId+'", "'+chartWidth.to_s+'", "'+chartHeight.to_s+'", "'+boolToNum(debugMode).to_s+'", "'+boolToNum(registerWithJS).to_s+'");' + " \n"
  	if strXML=="" 
      #Set the dataURL of the chart
      renderChartText= renderChartText + "\t \t" +'chart_'+chartId+'.setDataURL("'+strURL+'");' + " \n "
		else 
      #Provide entire XML data using dataXML method 
      renderChartText= renderChartText + "\t \t" +'chart_'+chartId+'.setDataXML("'+strXML+'");' + " \n "
		end
    #Finally, render the chart.
		renderChartText= renderChartText + "\t \t" +'chart_'+chartId+'.render("'+chartId+'Div");	' + " \n "
    renderChartText= renderChartText + "\t" + '</script>' + " \n "
    renderChartText= renderChartText + " \n <!-- END Script Block for Chart " + chartId + " -->"
    return renderChartText
  end
  
  def boolToNum(bVal)
    if bVal==true
      intNum = 1
    else
      intNum = 0
    end
    boolToNum = intNum
  end

  def renderChartHTML(chartSWF, strURL, strXML, chartId, chartWidth, chartHeight, debugMode)
    #Generate the FlashVars string based on whether dataURL has been provided or dataXML.
    strFlashVars=''
    if strXML==""
      #DataURL Mode
      strFlashVars = "&chartWidth="+ chartWidth.to_s+ "&chartHeight=" + chartHeight.to_s + "&debugMode=" + boolToNum(debugMode).to_s + "&dataURL=" + strURL
    else
      #DataXML Mode
      strFlashVars = "&chartWidth=" + chartWidth.to_s + "&chartHeight=" +chartHeight.to_s + "&debugMode=" + boolToNum(debugMode).to_s + "&dataXML=" + strXML 		
    end
  	renderChartText='<!-- START Code Block for Chart ' + chartId +' -->' + " \n "
    renderChartText=renderChartText+'<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" width="'+ chartWidth.to_s + '" height="' + chartHeight.to_s + '" id="' + chartId + '">' + " \n "
    renderChartText=renderChartText+ "\t" + '<param name="allowScriptAccess" value="always" />' + " \n "
		renderChartText=renderChartText+ "\t" + '<param name="movie" value="'+chartSWF+'"/>' + " \n "
		renderChartText=renderChartText+ "\t" + '<param name="FlashVars" value="'+strFlashVars+'" />' + " \n "
		renderChartText=renderChartText+ "\t" + '<param name="quality" value="high" />' + " \n "
		renderChartText=renderChartText+ "\t" + '<embed src="'+chartSWF+'" FlashVars="' + strFlashVars + '" quality="high" width="' + chartWidth.to_s +  '" height="'+chartHeight.to_s + '" name="' + chartId + '" allowScriptAccess="always" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />' + " \n "
    renderChartText=renderChartText+ '</object>' + " \n "
    renderChartText=renderChartText+'<!-- END Code Block for Chart ' + chartId +' -->'
    renderChartHTML=renderChartText
  end

end