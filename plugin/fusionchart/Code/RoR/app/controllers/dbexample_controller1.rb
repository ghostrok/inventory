class DbexampleController < ApplicationController
   def basicdbexample
    
  #In this example, we show how to connect FusionCharts to a database.
#For the sake of ease, we've used an MySQL .  It just contains two tables, which are linked to each
	#other. 
		
  animateChart = params['animate']
	#Set default value of 1
	if animateChart="" then
		animateChart = "1"
	end if
  
	#Database Objects - Initialization
	oRs=''
  oRs2=''
  strQuery=''
	#strXML will be used to store the entire XML document generated
	strXML=''
	
	#Create the recordset to retrieve data
	#Generate the chart element
	strXML = "<chart caption='Factory Output report' subCaption='By Quantity' pieSliceDepth='30' showBorder='1' formatNumberScale='0' numberSuffix=' Units animation='" + animateChart + "'>"
	
	#Iterate through each factory
	oRs = Factorymaster.find(:all)
		
	oRs.each do |recordset|	
		
		#Now create second recordset to get details for this factory
		
    @oRs2 = Factoryoutput.find(:all,:conditions=>["FactoryId=?",recordset.FactoryId.to_s])
    recordcount = @oRs2.length
    count = 0
    quantity = 0
      while count < recordcount
        quantity = quantity + @oRs2[count][:Quantity].to_i
        count = count + 1
      end
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
  
		#Close recordset
	#Finally, close <chart> element
	strXML = strXML + "</chart>"
	
#Create the chart - Pie 3D Chart with data from strXML
	@chart=renderChart("/FusionCharts/Pie3D.swf", "", strXML, "FactorySum", 600, 300, false, false)
end

def default
	#In this example, we show how to connect FusionCharts to a database.
#For the sake of ease, we've used an MySQL .  It just contains two tables, which are linked to each
	#other. 
		
	#Database Objects - Initialization
	 oRs=''
   oRs2=''
   strQuery=''
	#strXML will be used to store the entire XML document generated
  strXML=''
	
	#We also keep a flag to specify whether we've to animate the chart or not.
	#If the user is viewing the detailed chart and comes back to this page, he shouldn't
	#see the animation again.
	animateChart=''
	animateChart = params["animate"]
	#Set default value of 1
	if animateChart==""
		animateChart = "1"
	end 
	
	
	#Generate the chart element
	strXML = "<chart caption='Factory Output report' subCaption='By Quantity' pieSliceDepth='30' showBorder='1' formatNumberScale='0' numberSuffix=' Units' animation=' " + animateChart.to_s + "'>"
	
	#Iterate through each factory
	oRs = Factorymaster.find(:all)
	
	oRs.each do |recordset|
		#Now create second recordset to get details for this factory
		
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
        strXML = strXML + "<set label='" + recordset.FactoryName + "' value='" + quantity.to_s + "' link='" + CGI.escape("/dbexample/detailed?FactoryId=" + recordset.FactoryId.to_s) + "'/>"
      end
      factoryid = recordset2.FactoryId
		#strXML = strXML + "<set label='" + recordset.FactoryName + "' value='" + recordset2.Quantity.to_s + "' />"
    end
  end
		#Finally, close <chart> element
	strXML = strXML + "</chart>"
	
	#Create the chart - Pie 3D Chart with data from strXML
	@chart1= renderChart("/FusionCharts/Pie3D.swf", "", strXML, "FactorySum", 600, 300, false, false)
end


def detailed
  #This page is invoked from Default.asp. When the user clicks on a pie
	#slice in Default.asp, the factory Id is passed to this page. We need
	#to get that factory id, get information from database and then show
	#a detailed chart.
	
	#First, get the factory Id

	#Request the factory Id from Querystring
	fid = params["FactoryId"]
	
	oRs=''
  strQuery=''
	#strXML will be used to store the entire XML document generated
  strXML=''	
	intCounter = 0
	
	
	#Generate the chart element string
	strXML = "<chart palette='2' caption='Factory " + fid.to_s + " Output ' subcaption='(In Units)' xAxisName='Date' showValues='1' labelStep='2' >"
	#Now, we get the data for that factory
  factoryid = Factorymaster.find_by_FactoryId(fid.to_s)
	oRs = Factoryoutput.find(:all,:conditions=>["FactoryId=?",factoryid[:FactoryId]])
  
	oRs.each do |recordset|
		#Here, we convert date into a more readable form for set label.
    		strXML = strXML + "<set label='" + recordset.DatePro.to_s + "' value='" + recordset.Quantity.to_s + "'/>"		
  end
	strXML = strXML + "</chart>"
  
	
#Create the chart - Column 2D Chart with data from strXML
	@chart1=renderChart("/FusionCharts/Column2D.swf", "", strXML, "FactoryDetailed", 600, 300, false, false)
end
  
 end