<%@ Page language="c#" Codebehind="Default.aspx.cs" AutoEventWireup="false" Inherits="InfoSoftGlobal.GeneralPages.ASP.NET.DB_JS_dataURL._Default" %>
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
		
		/** 
		 * updateChart method is invoked when the user clicks on a pie slice.
		 * In this method, we get the index of the factory after which we request for XML data
		 * for that that factory from FactoryData.aspx, and finally
		 * update the Column Chart.
		 *	@param	factoryIndex	Sequential Index of the factory.
		*/		
		function updateChart(factoryIndex){		
			//DataURL for the chart
			var strURL = "FactoryData.aspx?factoryId=" + factoryIndex;
			
			//Sometimes, the above URL and XML data gets cached by the browser.
			//If you want your charts to get new XML data on each request,
			//you can add the following line:
			//strURL = strURL + "&currTime=" + getTimeForURL();
			//getTimeForURL method is defined below and needs to be included
			//This basically adds a ever-changing parameter which bluffs
			//the browser and forces it to re-load the XML data every time.
						
			//URLEncode it - NECESSARY.
			strURL = escape(strURL);
			
			var chartObj = new FusionCharts('../../FusionCharts/Column2D.swf', 'FactoryDetailed', '600', '250', '0', '0');
			
			
			//Get reference to chart object using Dom ID "FactoryDetailed"
			var chartObj = getChartFromId("FactoryDetailed");
			
			//Send request for XML
			
			chartObj.setDataURL(strURL);
			
			
		}
		/**
		 * getTimeForURL method returns the current time 
		 * in a URL friendly format, so that it can be appended to
		 * dataURL for effective non-caching.
		*/
		function getTimeForURL(){
			var dt = new Date();
			var strOutput = "";
			strOutput = dt.getHours() + "_" + dt.getMinutes() + "_" + dt.getSeconds() + "_" + dt.getMilliseconds();
			return strOutput;
		}
		</SCRIPT>
		<LINK href="../../../InfoSoftGlobal.css" type="text/css" rel="stylesheet">
	</HEAD>
	<body>
		<CENTER>
			<h2>FusionCharts Database + JavaScript (dataURL method) Example</h2>
			<h4>Inter-connected charts - Click on any pie slice to see detailed chart below.</h4>
			<p>The charts in this page have been dynamically generated using data contained in 
				a database.</p>
			<%=GetFactorySummaryChartHtml()%>
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
