class ArrayExampleController < ApplicationController
    
	#In this example, we plot a Combination chart from data contained
	#in an array. The array will have three columns - first one for Quarter Name
	#second one for sales figure and third one for quantity. 
  
def combination
  #Store Quarter Name, revenue data,  Quantity
	arrData=[
                ["Quarter 1",576000,576],
                ["Quarter 2",448000,448],
                ["Quarter 3",956000,956],
                ["Quarter 4",734000,734],
  ]
	
	#Now, we need to convert this data into combination XML. 
	#We convert using string concatenation.
	#strXML - Stores the entire XML
	#strCategories - Stores XML for the <categories> and child <category> elements
	#strDataRev - Stores XML for current year's sales
	#strDataQty - Stores XML for previous year's sales
	
	
	#Initialize <chart> element
	strXML = "<chart palette='4' caption='Product A - Sales Details' PYAxisName='Revenue' SYAxisName='Quantity (in Units)' numberPrefix='$' formatNumberScale='0' showValues='0' decimals='0' >"
	
	#Initialize <categories> element - necessary to generate a multi-series chart
	strCategories = "<categories>"
	
	#Initiate <dataset> elements
	strDataRev = "<dataset seriesName='Revenue'>"
	strDataQty = "<dataset seriesName='Quantity' parentYAxis='S'>"
	
	#Iterate through the data
index = 0
until index > arrData.length - 1
		#Append <category name='...' /> to strCategories
		strCategories = strCategories + "<category name='" + arrData[index][0].to_s + "' />"
		#Add <set value='...' /> to both the datasets
		strDataRev = strDataRev + "<set value='" + arrData[index][1].to_s + "' />"
		strDataQty = strDataQty + "<set value='" + arrData[index][2].to_s + "' />"		
    index+=1
	end
	
	#Close <categories> element
	strCategories = strCategories + "</categories>"
	
	#Close <dataset> elements
	strDataRev = strDataRev + "</dataset>"
	strDataQty = strDataQty + "</dataset>"
	
	#Assemble the entire XML now
	strXML = strXML + strCategories + strDataRev + strDataQty + "</chart>"
	# headers['Content-Type'] = "text/xml"
  #render :text=> strXML,:layout=>false
	#Create the chart - MS Column 3D Line Combination Chart with data contained in strXML
	@ff=renderChart("/FusionCharts/MSColumn3DLineDY.swf", "", strXML, "productSales", 600, 300, false, false)

end




  
  
  
  
  


#In this example, we plot a multi series chart from data contained
#in an array. The array will have three columns - first one for data label (product)
	#and the next two for data values. The first data value column would store sales information
	#for current year and the second one for previous year.
	
  def multiseries
  
	#Let's store the sales data for 6 products in our array. We also store
	#the name of products. 
	
	#Store Name of Products

arrData =[
                ["Product A",567500,547300],
                ["Product B",815300,584500],
                ["Product C",556800,754000],
                ["Product D",734500,456300],
                ["Product E",676800,754500],
                ["Product F",648500,437600],
]

	#Now, we need to convert this data into multi-series XML. 
	#We convert using string concatenation.
	#strXML - Stores the entire XML
	#strCategories - Stores XML for the <categories> and child <category> elements
	#strDataCurr - Stores XML for current year's sales
	#strDataPrev - Stores XML for previous year's sales
	strXML=''
   strCategories=''
   strDataCurr=''
   strDataPrev=''
   i=''
	
	#Initialize <chart> element
	strXML = "<chart caption='Sales by Product' numberPrefix='$' formatNumberScale='1' rotateValues='1' placeValuesInside='1' decimals='0' >"
	
	#Initialize <categories> element - necessary to generate a multi-series chart
	strCategories = "<categories>"
	
	#Initiate <dataset> elements
	strDataCurr = "<dataset seriesName='Current Year'>"
	strDataPrev = "<dataset seriesName='Previous Year'>"
	index=0
	#Iterate through the data	
	until index >  arrData.length - 1
		#Append <category name='...' /> to strCategories
		strCategories = strCategories + "<category name='" + arrData[index][0].to_s + "' />"
		#Add <set value='...' /> to both the datasets
		strDataCurr = strDataCurr + "<set value='" + arrData[index][1].to_s + "' />"
		strDataPrev = strDataPrev + "<set value='" + arrData[index][2].to_s + "' />"		
    index+=1
	end
	
	#Close <categories> element
	strCategories = strCategories + "</categories>"
	
	#Close <dataset> elements
	strDataCurr = strDataCurr + "</dataset>"
	strDataPrev = strDataPrev + "</dataset>"
	
	#Assemble the entire XML now
	strXML = strXML + strCategories + strDataCurr + strDataPrev + "</chart>"

  # headers['Content-Type'] = "text/xml"
  #render :text=> strXML,:layout=>false
	#Create the chart - MS Column 3D Chart with data contained in strXML
	@chart=renderChart("/FusionCharts/MSColumn3D.swf", "", strXML, "productSales", 600, 300, false, false)

end


#In this example, we plot a single series chart from data contained
	#in an array. The array will have two columns - first one for data label
	#and the next one for data values.


def singleseries
	#Let's store the sales data for 6 products in our array). We also store
	#the name of products. 
  	#Store Name of Products , sales data
	arrData=[
                ["Product A",567500],
                ["Product B",815300],
                ["Product C",556800],
                ["Product D",734500],
                ["Product E",676800],
                ["Product F",648500]
  ]
	

	#Now, we need to convert this data into XML. We convert using string concatenation.
	strXML=''
	#Initialize <chart> element
	strXML = "<chart caption='Sales by Product' numberPrefix='$' formatNumberScale='0'>"
	#Convert data to XML and append
  index=0
	until index > arrData.length - 1
		strXML = strXML + "<set label='" + arrData[index][0].to_s + "' value='" + arrData[index][1].to_s + "' />"
     index+=1
	end
	#Close <chart> element
	strXML = strXML + "</chart>"
	
	#Create the chart - Column 3D Chart with data contained in strXML
	@chart=renderChart("/FusionCharts/Column3D.swf", "", strXML, "productSales", 600, 300, false, false)
    
  end
  
  
  #In this example, we plot a Stacked chart from data contained
	#in an array. The array will have three columns - first one for Quarter Name
	#and the next two for data values. The first data value column would store sales information
	#for Product A and the second one for Product B.
  
  def stacked
		#Store Name of Products, Sales data for Product A,Sales data for Product B
	arrData=[
                ["Quarter 1",567500,547300],
                ["Quarter 2",815300,594500],
                ["Quarter 3",556800,754000],
                ["Quarter 4",734500,456300],
  ]
	
	#Now, we need to convert this data into multi-series XML. 
	#We convert using string concatenation.
	#strXML - Stores the entire XML
	#strCategories - Stores XML for the <categories> and child <category> elements
	#strDataProdA - Stores XML for current year's sales
	#strDataProdB - Stores XML for previous year's sales
	 strXML=''
   strCategories=''
    strDataProdA=''
    strDataProdB=''
    index=0
	
	#Initialize <chart> element
	strXML = "<chart caption='Sales' numberPrefix='$' formatNumberScale='0'>"
	
	#Initialize <categories> element - necessary to generate a stacked chart
	strCategories = "<categories>"
	
	#Initiate <dataset> elements
	strDataProdA = "<dataset seriesName='Product A'>"
	strDataProdB = "<dataset seriesName='Product B'>"
	
	#Iterate through the data	
	until index > arrData.length - 1
		#Append <category name='...' /> to strCategories
		strCategories = strCategories + "<category name='" + arrData[index][0].to_s + "' />"
		#Add <set value='...' /> to both the datasets
		strDataProdA = strDataProdA + "<set value='" + arrData[index][1].to_s + "' />"
		strDataProdB = strDataProdB + "<set value='"  + arrData[index][2].to_s + "' />"		
    index+=1
	end
	
	#Close <categories> element
	strCategories = strCategories + "</categories>"
	
	#Close <dataset> elements
	strDataProdA = strDataProdA + "</dataset>"
	strDataProdB = strDataProdB + "</dataset>"
	
	#Assemble the entire XML now
	strXML = strXML + strCategories + strDataProdA + strDataProdB + "</chart>"
	
	#Create the chart - Stacked Column 3D Chart with data contained in strXML
	@chart=renderChart("/FusionCharts/StackedColumn3D.swf", "", strXML, "productSales", 500, 300, false, false)
end
end
