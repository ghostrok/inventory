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

using System.Data.Odbc;

namespace InfoSoftGlobal.GeneralPages.ASP.NET.DB_JS_dataURL
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

		public string GetFactorySummaryChartHtml()
		{
			//xmlData will be used to store the entire XML document generated
			string xmlData;
	
			//Generate the chart element
			xmlData = "<chart caption='Factory Output report' subCaption='By Quantity' pieSliceDepth='30' showBorder='1' formatNumberScale='0' numberSuffix=' Units' >";

			using ( OdbcConnection connection = DbHelper.Connection(DbHelper.ConnectionStringFactory))
			{
				string factoryQuery = "select * from Factory_Master";
				using (OdbcCommand factoryCommand = new OdbcCommand(factoryQuery, connection))
				{
					using (OdbcDataAdapter factoryAdapter = new OdbcDataAdapter(factoryCommand))
					{
						DataTable factoryTable = new DataTable();
						factoryAdapter.Fill ( factoryTable );
						foreach (DataRow factoryRow in factoryTable.Rows)
						{
							string quantityQuery =  "select FactoryId as TotOutput, sum(Quantity) from Factory_Output where FactoryId=" + factoryRow["FactoryId"] + " Group By FactoryId";

							using (OdbcCommand quantityCommand = new OdbcCommand(quantityQuery, connection))
							{
								xmlData += "<set label='" + factoryRow["FactoryName"] + "' value='" +
									quantityCommand.ExecuteScalar().ToString() + "' link='javaScript:updateChart(" +
									factoryRow["FactoryId"] + ")'/>";
							}
						}
					}
				}

				connection.Close();
			}

			xmlData += "</chart>";

			System.Text.StringBuilder chartBuilder = new System.Text.StringBuilder();
	
			//Create the chart - Pie 3D Chart with data from xmlData
			chartBuilder.Append(FusionCharts.RenderChart("../../FusionCharts/Pie3D.swf", "", xmlData, "FactorySum", "500", "250", false, true));

			return chartBuilder.ToString();
		}

		public string GetFactoryDetailedChartHtml()
		{
			System.Text.StringBuilder chartBuilder = new System.Text.StringBuilder();
	
			//Column 2D Chart with changed "No data to display" message
			//We initialize the chart with <chart></chart>
			chartBuilder.Append(FusionCharts.RenderChart("../../FusionCharts/Column2D.swf?ChartNoDataText=Please select a factory from pie chart above to view detailed data.", "", "<chart></chart>", "FactoryDetailed", "600", "250", false, true));

			return chartBuilder.ToString();
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
