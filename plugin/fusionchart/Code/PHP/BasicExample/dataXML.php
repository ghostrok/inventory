<?php ?>
<HTML>
<HEAD>
	<TITLE>
	FusionCharts - Simple Column 3D Chart using dataXML method
	</TITLE>
	<?php
	//You need to include the following JS file, if you intend to embed the chart using JavaScript.
	//Embedding using JavaScripts avoids the "Click to Activate..." issue in Internet Explorer
	//When you make your own charts, make sure that the path to this JS file is correct. Else, you would get JavaScript errors.
	?>	
	<SCRIPT LANGUAGE="Javascript" SRC="../../FusionCharts/FusionCharts.js"></SCRIPT>
	<style type="text/css">
	<!--
	body {
		font-family: Arial, Helvetica, sans-serif;
		font-size: 12px;
	}
	-->
	</style>
</HEAD>
	<?php
	//We've included ../Includes/FusionCharts.php, which contains functions
	//to help us easily embed the charts.
    include("../Includes/FusionCharts.php");
	?>
<BODY>

<CENTER>
<h2>FusionCharts Examples</h2>
<h4>Basic example using dataXML method (with XML data hard-coded in PHP page itself)</h4>
<p>If you view the source of this page, you'll see that the XML data is present in this same page (inside HTML code). We're not calling any external XML (or script) files to serve XML data. dataXML method is ideal when you've to plot small amounts of data.</p>
<?php
	
	//This page demonstrates the ease of generating charts using FusionCharts.
	//For this chart, we've used a string variable to contain our entire XML data.
	
	//Ideally, you would generate XML data documents at run-time, after interfacing with
	//forms or databases etc.Such examples are also present.
	//Here, we've kept this example very simple.
	
	//Create an XML data document in a string variable
	$strXML  = "<chart caption='Monthly Unit Sales' xAxisName='Month' yAxisName='Units' showValues='0' formatNumberScale='0' showBorder='1'>";
	$strXML .= "<set label='Jan' value='462' />";
	$strXML .= "<set label='Feb' value='857' />";
	$strXML .= "<set label='Mar' value='671' />";
	$strXML .= "<set label='Apr' value='494' />";
	$strXML .= "<set label='May' value='761' />";
	$strXML .= "<set label='Jun' value='960' />";
	$strXML .= "<set label='Jul' value='629' />";
	$strXML .= "<set label='Aug' value='622' />";
	$strXML .= "<set label='Sep' value='376' />";
	$strXML .= "<set label='Oct' value='494' />";
	$strXML .= "<set label='Nov' value='761' />";
	$strXML .= "<set label='Dec' value='960' />";
	$strXML .= "</chart>";
	
	//Create the chart - Column 3D Chart with data from strXML variable using dataXML method
	echo renderChart("../../FusionCharts/Column3D.swf", "", $strXML, "myNext", 600, 300, false, false);
?>
<BR><BR>
<a href='../NoChart.html' target="_blank">Unable to see the chart above?</a>
</CENTER>
</BODY>
</HTML>