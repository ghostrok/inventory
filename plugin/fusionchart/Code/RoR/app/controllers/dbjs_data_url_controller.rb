class DbjsDataUrlController < ApplicationController
  
  
  
  def default
	#Initialize the Pie chart with sum of production for each of the factories	
	oRs=''
   oRs2=''
   strQuery=''
	
	#strXML will be used to store the entire XML document generated
	strXML =''
	
	#Generate the chart element
	strXML = "<chart caption='Factory Output report' subCaption='By Quantity' pieSliceDepth='30' showBorder='1' formatNumberScale='0' numberSuffix=' Units' >"	
	
#Iterate through each factory
	oRs = Factorymaster.find(:all)
	
	oRs.each do |recordset|	
		
		@oRs2 = Factoryoutput.find(:all,:conditions=>["FactoryId=?",recordset.FactoryId])
     recordcount = @oRs2.length
     count = 0
     quantity = 0
     while count < recordcount
       quantity = quantity + @oRs2[count][:Quantity].to_i
       count = count + 1
     end
     #puts quantity
    #Generate <set label='..' value='..'/>		
    factoryid = ""
    @oRs2.each do |recordset2|
      if factoryid != recordset2.FactoryId
		strXML = strXML + "<set label='" + recordset.FactoryName + "' value='" + quantity.to_s + "' link='javaScript:updateChart(" + recordset.FactoryId.to_s + ")'/>"
      end
      factoryid = recordset2.FactoryId
		#strXML = strXML + "<set label='" + recordset.FactoryName + "' value='" + recordset2.Quantity.to_s + "' />"
    end
  end
  
	#Finally, close <chart> element
	strXML = strXML + "</chart>"
	
	
	#Create the chart - Pie 3D Chart with data from strXML
	@chart1=renderChart("/FusionCharts/Pie3D.swf", "", strXML, "FactorySum", 500, 250, false, false)

	#Column 2D Chart with changed "No data to display" message
	#We initialize the chart with <chart></chart>
	@chart2=renderChart("/FusionCharts/Column2D.swf?ChartNoDataText=Please select a factory from pie chart above to view detailed data.", "", "<chart></chart>", "FactoryDetailed", 600, 250, false, false)
  
end


def factorydata

	#Request the factory Id from Querystring
	fid = params["FactoryId"]
	
  oRs=''
  strQuery=''
	#strXML will be used to store the entire XML document generated
	strXML=''
  #intCounter	=''
	intCounter = 0
		
	#Generate the chart element string
	strXML = "<chart palette='2' caption='Factory " + fid.to_s + " Output ' subcaption='(In Units)' xAxisName='Date' showValues='1' labelStep='2' >"
	#Now, we get the data for that factory
    factoryid = Factorymaster.find_by_FactoryId(fid.to_s)
	oRs = Factoryoutput.find(:all,:conditions=>["FactoryId=?",factoryid[:FactoryId]])
	#strQuery = "select * from factoryoutputs where FactoryId=" + fid.to_s
	#oRs = Factorymaster.find_by_sql(strQuery)
  
	oRs.each do |recordset|
		#Here, we convert date into a more readable form for set label.
		#strXML = strXML + "<set label='" + recordset.DatePro.slice(5,2) + "/" + recordset.DatePro.slice(8,2) + "' value='" + recordset.Quantity + "'/>"
    strXML = strXML + "<set label='" + recordset.DatePro.to_s + "' value='" + recordset.Quantity.to_s + "'/>"		

 end		
	#Close <chart> element
	strXML = strXML + "</chart>"
  headers['Content-Type'] = "text/xml"
  render :text=> strXML,:layout=>false
end	
end
