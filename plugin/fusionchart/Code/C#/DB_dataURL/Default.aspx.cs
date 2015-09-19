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

namespace InfoSoftGlobal.GeneralPages.ASP.NET.DB_dataURL
{
	/// <summary>
	/// Summary description for _Default.
	/// </summary>
	public class _Default : System.Web.UI.Page
	{
		protected System.Web.UI.WebControls.Literal LiteralChart;
	
		private void Page_Load(object sender, System.EventArgs e)
		{
		}

		public string GetQuantityChartHtml()
		{
			//In this example, we show how to connect FusionCharts to a database 
			//using dataURL method. In our other examples, we've used dataXML method
			//where the XML is generated in the same page as chart. Here, the XML data
			//for the chart would be generated in PieData.asp.
	
			//To illustrate how to pass additional data as querystring to dataURL, 
			//we've added an animate	property, which will be passed to PieData.aspx. 
			//PieData.aspx would handle this animate property and then generate the 
			//XML accordingly.
	
			//For the sake of ease, we've used an Access database which is present in
			//../DB/FactoryDB.mdb. It just contains two tables, which are linked to each
			//other.
		
			//Variable to contain dataURL
			//Set DataURL with animation property to 1
			//NOTE: It's necessary to encode the dataURL if you've added parameters to it
			String dataURL = FusionCharts.EncodeDataURL("PieData.aspx?animate=1", false);
	
			//Create the chart - Pie 3D Chart with dataURL as strDataURL
			return FusionCharts.RenderChart("../../FusionCharts/Pie3D.swf", dataURL, "", "FactorySum", "600", "300", false, false);
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
