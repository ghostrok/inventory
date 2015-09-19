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
	/// Summary description for Combination.
	/// </summary>
	public class Combination : System.Web.UI.Page
	{
		protected System.Web.UI.WebControls.Literal LabelChart;
	
		private void Page_Load(object sender, System.EventArgs e)
		{
		}

		public string GetProductSalesChartHtml()
		{
			//In this example, we plot a Combination chart from data contained
			//in an array. The array will have three columns - first one for Quarter Name
			//second one for sales figure and third one for quantity. 
		
			object[,] arrData = new object[4,3];
			//Store Quarter Name
			arrData[0,0] = "Quarter 1";
			arrData[1,0] = "Quarter 2";
			arrData[2,0] = "Quarter 3";
			arrData[3,0] = "Quarter 4";
			//Store revenue data
			arrData[0,1] = 576000;
			arrData[1,1] = 448000;
			arrData[2,1] = 956000;
			arrData[3,1] = 734000;	
			//Store Quantity
			arrData[0,2] = 576;
			arrData[1,2] = 448;
			arrData[2,2] = 956;
			arrData[3,2] = 734;
	
			//Now, we need to convert this data into combination XML. 
			//We convert using string concatenation.
			//strXML - Stores the entire XML
			//strCategories - Stores XML for the <categories> and child <category> elements
			//strDataRev - Stores XML for current year's sales
			//strDataQty - Stores XML for previous year's sales
			String strXML, strCategories, strDataRev, strDataQty;
	
			//Initialize <chart> element
			strXML = "<chart palette='4' caption='Product A - Sales Details' PYAxisName='Revenue' SYAxisName='Quantity (in Units)' numberPrefix='$' formatNumberScale='0' showValues='0' decimals='0' >";
	
			//Initialize <categories> element - necessary to generate a multi-series chart
			strCategories = "<categories>";
	
			//Initiate <dataset> elements
			strDataRev = "<dataset seriesName='Revenue'>";
			strDataQty = "<dataset seriesName='Quantity' parentYAxis='S'>";
	
			//Iterate through the data	
			for(int i=0; i < arrData.GetLength(0); i++)
			{
				//Append <category name='...' /> to strCategories
				strCategories = strCategories + "<category name='" + arrData[i,0] + "' />";
				//Add <set value='...' /> to both the datasets
				strDataRev = strDataRev + "<set value='" + arrData[i,1] + "' />";
				strDataQty = strDataQty + "<set value='" + arrData[i,2] + "' />";	
			}
	
			//Close <categories> element
			strCategories = strCategories + "</categories>";
	
			//Close <dataset> elements
			strDataRev = strDataRev + "</dataset>";
			strDataQty = strDataQty + "</dataset>";
	
			//Assemble the entire XML now
			strXML = strXML + strCategories + strDataRev + strDataQty + "</chart>";
	
			//Create the chart - MS Column 3D Line Combination Chart with data contained in strXML
			return FusionCharts.RenderChart("../../FusionCharts/MSColumn3DLineDY.swf", "", strXML, "productSales", "600", "300", false, false);
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
