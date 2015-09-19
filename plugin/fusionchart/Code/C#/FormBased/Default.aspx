<%@ Page language="c#" Codebehind="Default.aspx.cs" AutoEventWireup="false" Inherits="InfoSoftGlobal.GeneralPages.ASP.NET.FormBased._Default" %>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" >
<HTML>
	<HEAD>
		<TITLE>FusionCharts - Form Based Data Charting Example </TITLE>
		<meta name="GENERATOR" Content="Microsoft Visual Studio .NET 7.1">
		<meta name="CODE_LANGUAGE" Content="C#">
		<meta name="vs_defaultClientScript" content="JavaScript">
		<meta name="vs_targetSchema" content="http://schemas.microsoft.com/intellisense/ie5">
		<LINK href="../../../InfoSoftGlobal.css" type="text/css" rel="stylesheet">
		<SCRIPT LANGUAGE="Javascript" SRC="../../FusionCharts/FusionCharts.js"></SCRIPT>
	</HEAD>
	<body>
		<form id='form1' name='form1' method='post' runat="server">
			<CENTER>
				<div id="DivSubmission" runat="server">
					<h2>FusionCharts Form-Based Data Example</h2>
					<h4>Restaurant Sales Chart below</h4>
					<p class='text'>Click on any pie slice to see slicing effect. Or, right click on 
						chart and choose "Enable Rotation", and then drag and rotate the chart.</p>
					<a href='javascript:history.go(-1);'>Enter data again</a>
					<asp:Literal ID="LiteralChart" Runat="server"></asp:Literal>
					<BR>
					<BR>
					<a href='../NoChart.html' target="_blank">Unable to see the chart above?</a>
			</CENTER>
			</div>
			<div id="DivFormParameters" runat="server">
				<CENTER>
					<h2>FusionCharts Form-Based Data Example</h2>
					<p class='text'>Please enter how many items of each category you sold within this 
						week. We'll plot this data on a Pie chart.
					</p>
					<p class='text'>To keep things simple, we're not validating for non-numeric data 
						here. So, please enter valid numeric values only. In your real-world 
						applications, you can put your own validators.</p>
					<table width='50%' align='center' cellpadding='2' cellspacing='1' border='0' class='text'>
						<tr>
							<td width='50%' align='right'>
								<B>Soups:</B> &nbsp;
							</td>
							<td width='50%'>
								<asp:TextBox ID="TextBoxSoups" Runat="server" Width="60">108</asp:TextBox>
								bowls
							</td>
						</tr>
						<tr>
							<td width='50%' align='right'>
								<B>Salads:</B> &nbsp;
							</td>
							<td width='50%'>
								<asp:TextBox ID="TextboxSalads" Runat="server" Width="60">162</asp:TextBox>
								plates
							</td>
						</tr>
						<tr>
							<td width='50%' align='right'>
								<B>Sandwiches:</B> &nbsp;
							</td>
							<td width='50%'>
								<asp:TextBox ID="TextboxSandwiches" Runat="server" Width="60">360</asp:TextBox>
								pieces
							</td>
						</tr>
						<tr>
							<td width='50%' align='right'>
								<B>Beverages:</B> &nbsp;
							</td>
							<td width='50%'>
								<asp:TextBox ID="TextboxBeverages" Runat="server" Width="60">171</asp:TextBox>
								cans
							</td>
						</tr>
						<tr>
							<td width='50%' align='right'>
								<B>Desserts:</B> &nbsp;
							</td>
							<td width='50%'>
								<asp:TextBox ID="TextboxDesserts" Runat="server" Width="60">99</asp:TextBox>
								plates
							</td>
						</tr>
						<tr>
							<td width='50%' align='right'>
								&nbsp;
							</td>
							<td width='50%'>
								<asp:Button ID="ButtonChart" Runat="server" Text="Chart it!"></asp:Button>
							</td>
						</tr>
					</table>
					<table>
				</CENTER>
			</div>
		</form>
		</TABLE>
	</body>
</HTML>
