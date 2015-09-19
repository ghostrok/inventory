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

namespace InfoSoftGlobal.GeneralPages.ASP.NET.DB_dataURL
{
	/// <summary>
	/// Summary description for PieData.
	/// </summary>
	public class PieData : System.Web.UI.Page
	{
		protected System.Web.UI.WebControls.Literal LiteralChart;
	
		private void Page_Load(object sender, System.EventArgs e)
		{
			if (!IsPostBack)
			{
				//This page generates the XML data for the Pie Chart contained in
				//Default.aspx. 	
	
				//For the sake of ease, we've used an Access database which is present in
				//../DB/FactoryDB.mdb. It just contains two tables, which are linked to each
				//other. 
		
				//Database Objects - Initialization
				string query;
				//xmlData will be used to store the entire XML document generated
				string xmlData = String.Empty;
				
	
				//Default.asp has passed us a property animate. We request that.
				string animateChart;
				animateChart = Request.QueryString["animate"];
				//Set default value of 1
				if (animateChart != null && animateChart.Length == 0)
				{
					animateChart = "1";
				}
	
				//Create the recordset to retrieve data
	

				//Generate the chart element
				xmlData = "<chart caption='Factory Output report' subCaption='By Quantity' pieSliceDepth='30' showBorder='1' formatNumberScale='0' numberSuffix=' Units' animation=' " + animateChart + "'>";
	
				//Iterate through each factory
				query = "select * from Factory_Master";
				using (OdbcConnection connection = DbHelper.Connection(DbHelper.ConnectionStringFactory))
				{
					OdbcCommand command = new OdbcCommand(query, connection);
					DataTable factoryTable = new DataTable();
				
					using (OdbcDataAdapter factoryAdapter = new OdbcDataAdapter(command))
					{
					
						factoryAdapter.Fill(factoryTable);
					}

					foreach(DataRow row in factoryTable.Rows)
					{
						string outputQuery = "select sum(Quantity) as TotOutput from Factory_Output where FactoryId=" + row["FactoryId"].ToString();
						using (OdbcCommand outputCommand = new OdbcCommand(outputQuery, connection))
						{
							xmlData += "<set label='" + row["FactoryName"].ToString() +
								"' value='" + outputCommand.ExecuteScalar().ToString() + "' />";
						}
					}
				}
				//Finally, close <chart> element
				xmlData += "</chart>";
		
				//Set Proper output content-type
				Response.ContentType = "text/xml";
	
				//Just write out the XML data
				//NOTE THAT THIS PAGE DOESN'T CONTAIN ANY HTML TAG, WHATSOEVER
				Response.Write( xmlData );
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
			this.Load += new System.EventHandler(this.Page_Load);

		}
		#endregion
	}
}
