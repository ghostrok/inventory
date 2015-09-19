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
	/// Summary description for Stacked.
	/// </summary>
	public class Stacked : System.Web.UI.Page
	{
		protected System.Web.UI.WebControls.Literal LiteralChart;
	
		private void Page_Load(object sender, System.EventArgs e)
		{
		}

		public string GetProductSalesChartHtml()
		{
			//In this example, we plot a Stacked chart from data contained
			//in an array. The array will have three columns - first one for Quarter Name
			//and the next two for data values. The first data value column would store sales information
			//for Product A and the second one for Product B.
		
			object[,] arrData = new object[4,3];
			//Store Name of Products
			arrData[0,0] = "Quarter 1";
			arrData[1,0] = "Quarter 2";
			arrData[2,0] = "Quarter 3";
			arrData[3,0] = "Quarter 4";
			//Sales data for Product A
			arrData[0,1] = 567500;
			arrData[1,1] = 815300;
			arrData[2,1] = 556800;
			arrData[3,1] = 734500;
			//Sales data for Product B
			arrData[0,2] = 547300;
			arrData[1,2] = 594500;
			arrData[2,2] = 754000;
			arrData[3,2] = 456300;	

			//Now, we need to convert this data into multi-series XML. 
			//We convert using string concatenation.
			//xmlData - Stores the entire XML
			//strCategories - Stores XML for the <categories> and child <category> elements
			//strDataProdA - Stores XML for current year's sales
			//strDataProdB - Stores XML for previous year's sales
			string xmlData, categories, strDataProdA, strDataProdB;
	
			//Initialize <chart> element
			xmlData = "<chart caption='Sales' numberPrefix='$' formatNumberScale='0'>";
	
			//Initialize <categories> element - necessary to generate a stacked chart
			categories = "<categories>";
	
			//Initiate <dataset> elements
			strDataProdA = "<dataset seriesName='Product A'>";
			strDataProdB = "<dataset seriesName='Product B'>";
	
			//Iterate through the data	
			for(int i=0; i < arrData.GetLength(0); i++)
			{
				//Append <category name='...' /> to strCategories
				categories += "<category name='" + arrData[i,0] + "' />";
				//Add <set value='...' /> to both the datasets
				strDataProdA = strDataProdA + "<set value='" + arrData[i,1] + "' />";
				strDataProdB = strDataProdB + "<set value='" + arrData[i,2] + "' />";
			}
	
			//Close <categories> element
			categories += "</categories>";
	
			//Close <dataset> elements
			strDataProdA = strDataProdA + "</dataset>";
			strDataProdB = strDataProdB + "</dataset>";
	
			//Assemble the entire XML now
			xmlData += categories + strDataProdA + strDataProdB + "</chart>";
	
			//Create the chart - Stacked Column 3D Chart with data contained in xmlData
			return FusionCharts.RenderChart("../../FusionCharts/StackedColumn3D.swf", "", xmlData, "productSales", "500", "300", false, false);
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
