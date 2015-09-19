  class BasicExampleController < ApplicationController
  #This page demonstrates the ease of generating charts using FusionCharts.
	#For this chart, we've used a pre-defined Data.xml (contained in /Data/ folder)
	#Ideally, you would NOT use a physical data file. Instead you'll have 
	#your own ASP scripts virtually relay the XML data document. Such examples are also present.
	#For a head-start, we've kept this example very simple.

	def basicchart
    #Create the chart - Column 3D Chart with data from Data/Data.xml
    @chart = renderChartHTML("/FusionCharts/Column3D.swf", "/Data/Data.xml", "", "myFirst", 600, 300, false)
  end
  
  #This page demonstrates the ease of generating charts using FusionCharts.
	#For this chart, we've used a string variable to contain our entire XML data.
	
	#Ideally, you would generate XML data documents at run-time, after interfacing with
	#forms or databases etc.Such examples are also present.
	#Here, we've kept this example very simple.

  def basicdataxml
    #Create an XML data document in a string variable
    strXML = ""
    strXML = strXML + "<chart caption='Monthly Unit Sales' xAxisName='Month' yAxisName='Units' showValues='0' formatNumberScale='0' showBorder='1'>"
    strXML = strXML + "<set label='Jan' value='462' />"
    strXML = strXML + "<set label='Feb' value='857' />"
    strXML = strXML + "<set label='Mar' value='671' />"
    strXML = strXML + "<set label='Apr' value='494' />"
    strXML = strXML + "<set label='May' value='761' />"
    strXML = strXML + "<set label='Jun' value='960' />"
    strXML = strXML + "<set label='Jul' value='629' />"
    strXML = strXML + "<set label='Aug' value='622' />"
    strXML = strXML + "<set label='Sep' value='376' />"
    strXML = strXML + "<set label='Oct' value='494' />"
    strXML = strXML + "<set label='Nov' value='761' />"
    strXML = strXML + "<set label='Dec' value='960' />"
    strXML = strXML + "</chart>"
    #Create the chart - Column 3D Chart with data from strXML variable using dataXML method
    @chart=renderChartHTML("/FusionCharts/Column3D.swf", "", strXML, "myNext", 600, 300, false)
  end
  
  #This page demonstrates the ease of generating charts using FusionCharts.
	#For this chart, we've used a string variable to contain our entire XML data.
	
	#Ideally, you would generate XML data documents at run-time, after interfacing with
	#forms or databases etc.Such examples are also present.
	#Here, we've kept this example very simple.
	
  def dataxml
    #Create an XML data document in a string variable
		strXML = ""
    strXML = strXML + "<chart caption='Monthly Unit Sales' xAxisName='Month' yAxisName='Units' showValues='0' formatNumberScale='0' showBorder='1'>"
    strXML = strXML + "<set label='Jan' value='462' />"
    strXML = strXML + "<set label='Feb' value='857' />"
    strXML = strXML + "<set label='Mar' value='671' />"
    strXML = strXML + "<set label='Apr' value='494' />"
    strXML = strXML + "<set label='May' value='761' />"
    strXML = strXML + "<set label='Jun' value='960' />"
    strXML = strXML + "<set label='Jul' value='629' />"
    strXML = strXML + "<set label='Aug' value='622' />"
    strXML = strXML + "<set label='Sep' value='376' />"
    strXML = strXML + "<set label='Oct' value='494' />"
    strXML = strXML + "<set label='Nov' value='761' />"
    strXML = strXML + "<set label='Dec' value='960' />"
    strXML = strXML + "</chart>"
		#Create the chart - Column 3D Chart with data from strXML variable using dataXML method
    @chart=renderChart("/FusionCharts/Column3D.swf", "", strXML, "myNext", 600, 300, false, false)
  end

  def multichart
    #This page demonstrates how you can show multiple charts on the same page.
    #For this example, all the charts use the pre-built Data.xml (contained in /Data/ folder)
    #However, you can very easily change the data source for any chart. 
    #IMPORTANT NOTE: Each chart necessarily needs to have a unique ID on the page.
    #If you do not provide a unique Id, only the last chart might be visible.
    #Here, we've used the ID chart1, chart2 and chart3 for the 3 charts on page.
		#Create the chart - Column 3D Chart with data from Data/Data.xml
    @Chart3D= renderChart("/FusionCharts/Column3D.swf", "/Data/Data.xml", "", "chart1", 600, 300, false, false)
    #Now, create a Column 2D Chart
    @Chart2D= renderChart("/FusionCharts/Column2D.swf", "/Data/Data.xml", "", "chart2", 600, 300, false, false)
    #'Now, create a Line 2D Chart
    @Line2D= renderChart("/FusionCharts/Line.swf", "/Data/Data.xml", "", "chart3", 600, 300, false, false)
  end
  
  #This page demonstrates the ease of generating charts using FusionCharts.
	#For this chart, we've used a pre-defined Data.xml (contained in /Data/ folder)
	#Ideally, you would NOT use a physical data file. Instead you'll have 
	#your own ASP scripts virtually relay the XML data document. Such examples are also present.
	#For a head-start, we've kept this example very simple.
	
	def simplechart
    #Create the chart - Column 3D Chart with data from Data/Data.xml
    @chart=renderChart("/FusionCharts/Column3D.swf", "/Data/Data.xml", "", "myFirst", 600, 300, false, false)
  end
  
end