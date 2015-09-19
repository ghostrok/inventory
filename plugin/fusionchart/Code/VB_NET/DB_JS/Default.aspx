<%@ Page language="vb" Codebehind="Default.aspx.vb" AutoEventWireup="false" Inherits="InfoSoftGlobal.InfoSoftGlobal.GeneralPages.ASP.NET.DB_JS._Default" %>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" >
<HTML>
	<HEAD>
		<TITLE>FusionCharts - Database + JavaScript Example </TITLE>
		<meta name="GENERATOR" Content="Microsoft Visual Studio .NET 7.1">
		<meta name="CODE_LANGUAGE" Content="C#">
		<meta name="vs_defaultClientScript" content="JavaScript">
		<meta name="vs_targetSchema" content="http://schemas.microsoft.com/intellisense/ie5">
		<SCRIPT LANGUAGE="Javascript" SRC="../../FusionCharts/FusionCharts.js">
		//You need to include the above JS file, if you intend to embed the chart using JavaScript.
		//Embedding using JavaScripts avoids the "Click to Activate..." issue in Internet Explorer
		//When you make your own charts, make sure that the path to this JS file is correct. Else, you would get JavaScript errors.
		</SCRIPT>
		<SCRIPT LANGUAGE="JavaScript">
		//Here, we use a mix of server side script (ASP) and JavaScript to
		//render our data for factory chart in JavaScript variables. We'll later
		//utilize this data to dynamically plot charts.
		
		//All our data is stored in the data array. From ASP, we iterate through
		//each recordset of data and then store it as nested arrays in this data array.
		var data = new Array();
		//Write the data as JavaScript variables here
		<%=GetScript()%>
		
		
		//The data is now present as arrays in JavaScript. Local JavaScript functions
		//can access it and make use of it. We'll see how to make use of it.
		
		
		/** 
		 * updateChart method is invoked when the user clicks on a pie slice.
		 * In this method, we get the index of the factory, build the XML data
		 * for that that factory, using data stored in data array, and finally
		 * update the Column Chart.
		 *	@param	factoryIndex	Sequential Index of the factory.
		*/		
		function updateChart(factoryIndex){
			//Storage for XML data document
			var strXML = "<chart palette='2' caption='Factory " + factoryIndex  + " Output ' subcaption='(In Units)' xAxisName='Date' showValues='1' labelStep='2' >";
			
			//Add <set> elements
			var i=0;
			for (i=0; i<data[factoryIndex].length; i++){
				strXML = strXML + "<set label='" + data[factoryIndex][i][0] + "' value='" + data[factoryIndex][i][1] + "' />";
			}
			
			//Closing Chart Element
			strXML = strXML + "</chart>";
						
			//Get reference to chart object using Dom ID "FactoryDetailed"
			var chartObj = getChartFromId("FactoryDetailed");
			//Update it's XML
			chartObj.setDataXML(strXML);
		}
		</SCRIPT>
		<LINK href="../../../InfoSoftGlobal.css" type="text/css" rel="stylesheet">
	</HEAD>
	<body>
		<CENTER>
			<h2>FusionCharts Database + JavaScript Example</h2>
			<h4>Inter-connected charts - Click on any pie slice to see detailed chart below.</h4>
			<p>The charts in this page have been dynamically generated using data contained in 
				a database. We've NOT hard-coded the data in JavaScript.</p>
			<%=GetFactorySummayChartHtml()%>
			<BR>
			<%=GetFactoryDetailedChartHtml()%>
			<BR>
			<BR>
			<a href='../NoChart.html' target="_blank">Unable to see the charts above?</a>
		</CENTER>
		<form id='form1' name='form1' method='post' runat="server">
		</form>
	</body>
</HTML>
