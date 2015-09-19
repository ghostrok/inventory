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
	/// Summary description for FactoryData.
	/// </summary>
	public class FactoryData : System.Web.UI.Page
	{
		private void Page_Load(object sender, System.EventArgs e)
		{
			if (!IsPostBack)
			{
				//This page is invoked from Default.asp. When the user clicks on a pie
				//slice in Default.asp, the factory Id is passed to this page. We need
				//to get that factory id, get information from database and then write XML.
	
				//First, get the factory Id
				string factoryId;
				//Request the factory Id from Querystring
				factoryId = Request.QueryString["FactoryId"];
	
				//xmlData will be used to store the entire XML document generated
				string xmlData;

				string query = "select * from Factory_Output where FactoryId=" + factoryId;
				xmlData = "<chart palette='2' caption='Factory " + factoryId +" Output ' subcaption='(In Units)' xAxisName='Date' showValues='1' labelStep='2' >";
				using (OdbcConnection connection = DbHelper.Connection(DbHelper.ConnectionStringFactory))
				{
					using (OdbcCommand command = new OdbcCommand(query, connection))
					{
						using (OdbcDataReader reader = command.ExecuteReader())
						{
							while (reader.Read())
							{
								xmlData += "<set label='" + ((DateTime)reader["DatePro"]).Day.ToString() + "/" + 
									((DateTime)reader["DatePro"]).Month.ToString() + "' value='" + reader["Quantity"].ToString() + "'/>";
								
							}
						}
					}

					connection.Close();
				}

				xmlData += "</chart>";

				Response.Clear();
				Response.ContentType = "text/xml";
				//Just write out the XML data
				//NOTE THAT THIS PAGE DOESN'T CONTAIN ANY HTML TAG, WHATSOEVER
				Response.Output.Write (xmlData);			}
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
