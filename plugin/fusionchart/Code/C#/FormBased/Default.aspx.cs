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

namespace InfoSoftGlobal.GeneralPages.ASP.NET.FormBased
{
	/// <summary>
	/// Summary description for _Default.
	/// </summary>
	public class _Default : System.Web.UI.Page
	{
		protected System.Web.UI.WebControls.TextBox TextboxSalads;
		protected System.Web.UI.WebControls.TextBox TextboxSandwiches;
		protected System.Web.UI.WebControls.TextBox TextboxBeverages;
		protected System.Web.UI.WebControls.TextBox TextboxDesserts;
		protected System.Web.UI.WebControls.Button ButtonChart;
		protected System.Web.UI.WebControls.Literal LiteralChart;
		protected System.Web.UI.HtmlControls.HtmlGenericControl DivSubmission;
		protected System.Web.UI.HtmlControls.HtmlGenericControl DivFormParameters;
		protected System.Web.UI.WebControls.TextBox TextBoxSoups;
	
		private void Page_Load(object sender, System.EventArgs e)
		{
			if (!IsPostBack)
			{
				DivSubmission.Visible = false;
				DivFormParameters.Visible = true;
			}
			else
			{
				DivSubmission.Visible = true;
				DivFormParameters.Visible = false;
			}
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
			this.ButtonChart.Click += new System.EventHandler(this.ButtonChart_Click);
			this.Load += new System.EventHandler(this.Page_Load);

		}
		#endregion

		private void ButtonChart_Click(object sender, System.EventArgs e)
		{
			//We first request the data from the form (Default.asp)
			int soups, salads, sandwiches, beverages, desserts;
			soups = int.Parse(TextBoxSoups.Text);
			salads = int.Parse(TextboxSalads.Text);
			sandwiches = int.Parse(TextboxSandwiches.Text);
			beverages = int.Parse(TextboxBeverages.Text);
			desserts   = int.Parse(TextboxDesserts.Text);
	
			//In this example, we're directly showing this data back on chart.
			//In your apps, you can do the required processing and then show the 
			//relevant data only.
	
			//Now that we've the data in variables, we need to convert this into XML.
			//The simplest method to convert data into XML is using string concatenation.	
			string xmlData = String.Empty;
			//Initialize <chart> element
			xmlData = "<chart caption='Sales by Product Category' subCaption='For this week' showPercentValues='1' pieSliceDepth='30' showBorder='1'>";
			//Add all data
			xmlData += "<set label='Soups' value='" + soups + "' />";
			xmlData += "<set label='Salads' value='" + salads + "' />";
			xmlData += "<set label='Sandwiches' value='" + sandwiches + "' />";
			xmlData += "<set label='Beverages' value='" + beverages + "' />";
			xmlData += "<set label='Desserts' value='" + desserts + "' />";
			//Close <chart> element
			xmlData += "</chart>";
	
			//Create the chart - Pie 3D Chart with data from xmlData
			LiteralChart.Text = FusionCharts.RenderChart("../../FusionCharts/Pie3D.swf", "", xmlData, "Sales", "500", "300", false, false);
		}
	}
}
