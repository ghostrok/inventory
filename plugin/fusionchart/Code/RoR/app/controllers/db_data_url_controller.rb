class DbDataUrlController < ApplicationController
  
   def default
  
  #In this example, we show how to connect FusionCharts to a database 
	#using dataURL method. In our other examples, we've used dataXML method
	#where the XML is generated in the same page as chart. Here, the XML data
	#for the chart would be generated in PieData.asp.
	
	#To illustrate how to pass additional data as querystring to dataURL, 
	#we've added an animate	property, which will be passed to PieData.asp. 
	#PieData.asp would handle this animate property and then generate the 
	#XML accordingly.
	
  #For the sake of ease, we've used an MySQL .  It just contains two tables, which are linked to each
	#other.
		
	#Variable to contain dataURL
  strDataURL=''
	
	#Set DataURL with animation property to 1
	#NOTE: It's necessary to encode the dataURL if you've added parameters to it
	strDataURL = CGI.escape("/db_data_url/piedata?animate=1")
	
	#Create the chart - Pie 3D Chart with dataURL as strDataURL
	@chart= renderChart("/FusionCharts/Pie3D.swf", strDataURL, "", "FactorySum", 600, 300, false, false)
  end



def piedata
  #This page generates the XML data for the Pie Chart contained in
	#Default.asp. 	
	
#For the sake of ease, we've used an MySQL . It just contains two tables, which are linked to each
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
	oRs=Factorymaster.find(:all)
  
	oRs.each do |recordset|
		#Now create second recordset to get details for this factory
		
		#strQuery = "select sum(Quantity) as TotOutput from factoryoutputs where FactoryId=" + recordset.FactoryId.to_s
		#oRs2=Factoryoutput.find_by_sql(strQuery)			
    @oRs2 = Factoryoutput.find(:all,:conditions=>["FactoryId=?",recordset.FactoryId.to_s])
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
        strXML = strXML + "<set label='" + recordset.FactoryName + "' value='" + quantity.to_s + "' />"
      end
      factoryid = recordset2.FactoryId
		#strXML = strXML + "<set label='" + recordset.FactoryName + "' value='" + recordset2.Quantity.to_s + "' />"
    end
  end
	#Finally, close <chart> element
	strXML = strXML + "</chart>"
  headers['Content-Type'] = "text/xml"
  render :text=> strXML,:layout=>false
end

end
