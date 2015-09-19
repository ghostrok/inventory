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
	/// Summary description for MultiChart.
	/// </summary>
	public class MultiChart : System.Web.UI.Page
	{
		protected System.Web.UI.WebControls.Literal LiteralChart;
	
		private void Page_Load(object sender, System.EventArgs e)
		{
		}

		public string GetMonthlySales3DChartHtml()
		{
			StringBuilder htmlData = new StringBuilder();
	
			//This page demonstrates how you can show multiple charts on the same page.
			//For this example, all the charts use the pre-built Data.xml (contained in /Data/ folder)
			//However, you can very easily change the data source for any chart. 
	
			//IMPORTANT NOTE: Each chart necessarily needs to have a unique ID on the page.
			//If you do not provide a unique Id, only the last chart might be visible.
			//Here, we've used the ID chart1, chart2 and chart3 for the 3 charts on page.
	
			//Create the chart - Column 3D Chart with data from Data/Data.xml
			htmlData.Append(FusionCharts.RenderChart("../../FusionCharts/Column3D.swf", "Data/Data.xml", "", "chart1", "600", "300", false, false));

			return htmlData.ToString();
		}

		public string GetMonthlySales2DChartHtml()
		{
			StringBuilder htmlData = new StringBuilder();
	
			//This page demonstrates how you can show multiple charts on the same page.
			//For this example, all the charts use the pre-built Data.xml (contained in /Data/ folder)
			//However, you can very easily change the data source for any chart. 
	
			//IMPORTANT NOTE: Each chart necessarily needs to have a unique ID on the page.
			//If you do not provide a unique Id, only the last chart might be visible.
			//Here, we've used the ID chart1, chart2 and chart3 for the 3 charts on page.

			//Now, create a Column 2D Chart
			htmlData.Append(FusionCharts.RenderChart("../../FusionCharts/Column2D.swf", "Data/Data.xml", "", "chart2", "600", "300", false, false));
			
			return htmlData.ToString();
		}

		public string GetMonthlySalesLineChartHtml()
		{
			StringBuilder htmlData = new StringBuilder();
	
			//This page demonstrates how you can show multiple charts on the same page.
			//For this example, all the charts use the pre-built Data.xml (contained in /Data/ folder)
			//However, you can very easily change the data source for any chart. 
	
			//IMPORTANT NOTE: Each chart necessarily needs to have a unique ID on the page.
			//If you do not provide a unique Id, only the last chart might be visible.
			//Here, we've used the ID chart1, chart2 and chart3 for the 3 charts on page.

			//Now, create a Line 2D Chart
			htmlData.Append(FusionCharts.RenderChart("../../FusionCharts/Line.swf", "Data/Data.xml", "", "chart3", "600", "300", false, false));

			return htmlData.ToString();
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
