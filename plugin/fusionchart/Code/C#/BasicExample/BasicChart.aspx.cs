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

namespace InfoSoftGlobal.GeneralPages.ASP.NET.BasicExample
{
	/// <summary>
	/// Summary description for BasicChart.
	/// </summary>
	public class BasicChart : System.Web.UI.Page
	{
		protected System.Web.UI.WebControls.Literal LiteralChart;
	
		private void Page_Load(object sender, System.EventArgs e)
		{
		}

		public string GetMonthlySalesChartHtml()
		{
			//This page demonstrates the ease of generating charts using FusionCharts.
			//For this chart, we've used a pre-defined Data.xml (contained in /Data/ folder)
			//Ideally, you would NOT use a physical data file. Instead you'll have 
			//your own ASP.NET scripts virtually relay the XML data document. Such examples are also present.
			//For a head-start, we've kept this example very simple.
	
	
			//'Create the chart - Column 3D Chart with data from Data/Data.xml
			return FusionCharts.RenderChartHTML("../../FusionCharts/Column3D.swf", "Data/Data.xml", "", "myFirst", "600", "300", false);
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
