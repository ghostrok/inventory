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

namespace InfoSoftGlobal.GeneralPages.ASP.NET.ArrayExample
{
	/// <summary>
	/// Summary description for SingleSeries.
	/// </summary>
	public class SingleSeries : System.Web.UI.Page
	{
		protected System.Web.UI.WebControls.Literal LiteralChart;
	
		private void Page_Load(object sender, System.EventArgs e)
		{
		}

		public string GetProductSalesChartHtml()
		{
			//In this example, we plot a single series chart from data contained
			//in an array. The array will have two columns - first one for data label
			//and the next one for data values.
	
			//Let's store the sales data for 6 products in our array). We also store
			//the name of products. 
			object[,] arrData = new object[6,2];
			//Store Name of Products
			arrData[0,0] = "Product A";
			arrData[1,0] = "Product B";
			arrData[2,0] = "Product C";
			arrData[3,0] = "Product D";
			arrData[4,0] = "Product E";
			arrData[5,0] = "Product F";
			//Store sales data
			arrData[0,1] = 567500;
			arrData[1,1] = 815300;
			arrData[2,1] = 556800;
			arrData[3,1] = 734500;
			arrData[4,1] = 676800;
			arrData[5,1] = 648500;

			//Now, we need to convert this data into XML. We convert using string concatenation.
			string xmlData;
			//Initialize <chart> element
			xmlData = "<chart caption='Sales by Product' numberPrefix='$' formatNumberScale='0'>";
			//Convert data to XML and append
			for(int i=0; i < arrData.GetLength(0); i++)
			{
				xmlData += "<set label='" + arrData[i,0] + "' value='" + arrData[i,1] + "' />";
			}
			//Close <chart> element
			xmlData += "</chart>";
	
			//Create the chart - Column 3D Chart with data contained in xmlData
			return FusionCharts.RenderChart("../../FusionCharts/Column3D.swf", "", xmlData, "productSales", "600", "300", false, false);
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
