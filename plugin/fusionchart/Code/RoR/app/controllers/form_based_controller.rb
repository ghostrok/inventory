class FormBasedController < ApplicationController
  
  def index
    end
    
  def chart
  #We first request the data from the form (Default.asp)
	intSoups=''
  intSalads=''
  intSandwiches=''
  intBeverages=''
  intDesserts=''
	intSoups = params["Soups"]
	intSalads = params["Salads"]
	intSandwiches = params["Sandwiches"]
	intBeverages = params["Beverages"]
	intDesserts   = params["Desserts"]
	
	#In this example, we're directly showing this data back on chart.
	#In your apps, you can do the required processing and then show the 
	#relevant data only.
	
	#Now that we've the data in variables, we need to convert this into XML.
	#The simplest method to convert data into XML is using string concatenation.	
	strXML=''
	#Initialize <chart> element
	strXML = "<chart caption='Sales by Product Category' subCaption='For this week' showPercentValues='1' pieSliceDepth='30' showBorder='1'>"
	#Add all data
	strXML = strXML + "<set label='Soups' value='" + intSoups.to_s + "' />"
	strXML = strXML + "<set label='Salads' value='" + intSalads.to_s + "' />"
	strXML = strXML + "<set label='Sandwiches' value='" + intSandwiches.to_s + "' />"
	strXML = strXML + "<set label='Beverages' value='" + intBeverages.to_s + "' />"
	strXML = strXML + "<set label='Desserts' value='" + intDesserts.to_s + "' />"
	#Close <chart> element
	strXML = strXML + "</chart>"
	
	#Create the chart - Pie 3D Chart with data from strXML
	@chart=renderChart("/FusionCharts/Pie3D.swf", "", strXML, "Sales", 500, 300, false, false)

  end
  
  def default
  
  #In this example, we show how to connect FusionCharts to a database 
	#using dataURL method. In our other examples, we've used dataXML method
	#where the XML is generated in the same page as chart. Here, the XML data
	#for the chart would be generated in PieData.asp.
	
	#To illustrate how to pass additional data as querystring to dataURL, 
	#we've added an animate	property, which will be passed to PieData.asp. 
	#PieData.asp would handle this animate property and then generate the 
	#XML accordingly.
	
	#For the sake of ease, we've used an Access database which is present in
	#../DB/FactoryDB.mdb. It just contains two tables, which are linked to each
	#other.
		
	#Variable to contain dataURL
  strDataURL=''
	
	#Set DataURL with animation property to 1
	#NOTE: It's necessary to encode the dataURL if you've added parameters to it
	strDataURL = CGI.escape("/form_based/piedata?animate=1")
	
	#Create the chart - Pie 3D Chart with dataURL as strDataURL
	@chart= renderChart("/FusionCharts/Pie3D.swf", strDataURL, "", "FactorySum", 600, 300, false, false)
end



def piedata
  #This page generates the XML data for the Pie Chart contained in
	#Default.asp. 	
	
	#For the sake of ease, we've used an Access database which is present in
	#../DB/FactoryDB.mdb. It just contains two tables, which are linked to each
	#other. 
		
	#Database Objects - Initialization
	oRs=''
  oRs2=''
  strQuery=''
	#strXML will be used to store the entire XML document generated
	strXML=''
	
	#Default.asp has passed us a property animate. We request that.
  animateChart=''
	animateChart = params["animate"]
	#Set default value of 1
	if animateChart="" 
		animateChart = "1"
	end 
	
	 
	#Generate the chart element
	strXML = "<chart caption='Factory Output report' subCaption='By Quantity' pieSliceDepth='30' showBorder='1' formatNumberScale='0' numberSuffix=' Units' animation=' " + animateChart.to_s + "'>"
	
	#Iterate through each factory
	strSQL = "select * from factorymasters"
	oRs1=Factorymaster.find_by_sql(strSQL)
  
	oRs1.each do |recordset|
		#Now create second recordset to get details for this factory
		
		strSQL = "select sum(Quantity) as TotOutput from factoryoutputs where id=" + recordset.id.to_s
		oRs2=Factoryoutput.find_by_sql(strSQL)			
		#Generate <set label='..' value='..'/>	
      oRs2.each do |recordset2|
		strXML = strXML + "<set label='" + recordset.FactoryName + "' value='" + recordset2.TotOutput.to_s + "' />"
    end
			end
	#Finally, close <chart> element
	strXML = strXML + "</chart>"
headers['Content-Type'] = "text/xml"
  render :text=> strXML,:layout=>false
end

  
  
end
