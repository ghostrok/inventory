<%@ Page language="vb" Codebehind="SimpleChart.aspx.vb" AutoEventWireup="false" Inherits="InfoSoftGlobal.InfoSoftGlobal.GeneralPages.ASP.NET.BasicExample.SimpleChart" %>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" >
<HTML>
	<HEAD>
		<TITLE>FusionCharts - Simple Column 3D Chart </TITLE>
		<meta name="GENERATOR" Content="Microsoft Visual Studio .NET 7.1">
		<meta name="CODE_LANGUAGE" Content="C#">
		<meta name="vs_defaultClientScript" content="JavaScript">
		<meta name="vs_targetSchema" content="http://schemas.microsoft.com/intellisense/ie5">
		<SCRIPT LANGUAGE="Javascript" SRC="../../FusionCharts/FusionCharts.js"></SCRIPT>
		<LINK href="../../../InfoSoftGlobal.css" type="text/css" rel="stylesheet">
	</HEAD>
	<body>
		<form id='form1' name='form1' method='post' runat="server">
			<CENTER>
				<h2>FusionCharts Examples</h2>
				<h4>Basic example using pre-built Data.xml</h4>
				<%=GetMonthlyalesChartHtml()%>
				<BR>
				<BR>
				<a href='../NoChart.html' target="_blank">Unable to see the chart above?</a>
			</CENTER>
		</form>
	</body>
</HTML>
