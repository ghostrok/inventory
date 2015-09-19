using System;
using System.Collections;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Web;
using System.Web.SessionState;
using System.Web.UI;
using System.Web.UI.WebControls;
using System.Web.UI.HtmlControls;
using System.Text;

namespace InfoSoftGlobal.GeneralPages.ASP.NET.BasicExample
{
	/// <summary>
	/// Summary description for dataXML.
	/// </summary>
	public class dataXML : System.Web.UI.Page
	{
		protected System.Web.UI.WebControls.Literal LiteralChart;
	
		private void Page_Load(object sender, System.EventArgs e)
		{
		}

		public string GetMonthlySalesChartHtml()
		{
			//This page demonstrates the ease of generating charts using FusionCharts.
			//For this chart, we've used a string variable to contain our entire XML data.
	
			//Ideally, you would generate XML data documents at run-time, after interfacing with
			//forms or databases etc.Such examples are also present.
			//Here, we've kept this example very simple.
	
			//Create an XML data document in a string variable
			StringBuilder xmlData = new StringBuilder();
			xmlData.Append("<chart caption='Monthly Unit Sales' xAxisName='Month' yAxisName='Units' showValues='0' formatNumberScale='0' showBorder='1'>");
			xmlData.Append("<set label='Jan' value='462' />");
			xmlData.Append("<set label='Feb' value='857' />");
			xmlData.Append("<set label='Mar' value='671' />");
			xmlData.Append("<set label='Apr' value='494' />");
			xmlData.Append("<set label='May' value='761' />");
			xmlData.Append("<set label='Jun' value='960' />");
			xmlData.Append("<set label='Jul' value='629' />");
			xmlData.Append("<set label='Aug' value='622' />");
			xmlData.Append("<set label='Sep' value='376' />");
			xmlData.Append("<set label='Oct' value='494' />");
			xmlData.Append("<set label='Nov' value='761' />");
			xmlData.Append("<set label='Dec' value='960' />");
			xmlData.Append("</chart>");

			//Create the chart - Column 3D Chart with data from xmlData variable using dataXML method
			return FusionCharts.RenderChart("../../FusionCharts/Column3D.swf", "", xmlData.ToString(), "myNext", "600", "300", false, false);
		}

		#region Web Form Designer generated code
		override protected void OnInit(EventArgs e)
		{
			//
			// CODEGEN: This call is required by the ASP.NET Web Form Designer.
			//
			InitializeComponent();
			base.OnInit(e);
		}
		
		/// <summary>
		/// Required method for Designer support - do not modify
		/// the contents of this method with the code editor.
		/// </summary>
		private void InitializeComponent()
		{    
			this.Load += new System.EventHandler(this.Page_Load);

		}
		#endregion
	}
}
