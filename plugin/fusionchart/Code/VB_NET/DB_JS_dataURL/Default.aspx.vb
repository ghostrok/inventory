Imports System
Imports System.Collections
Imports System.ComponentModel
Imports System.Data
Imports System.Drawing
Imports System.Web
Imports System.Web.SessionState
Imports System.Web.UI
Imports System.Web.UI.WebControls
Imports System.Web.UI.HtmlControls
Imports System.Data.Odbc

Namespace InfoSoftGlobal.GeneralPages.ASP.NET.DB_JS_dataURL

    ''' <summary>
    ''' Summary description for _Default.
    ''' </summary>
    Public Class _Default
        Inherits System.Web.UI.Page

        Protected LiteralChart As System.Web.UI.WebControls.Literal

        Private Sub Page_Load(ByVal sender As Object, ByVal e As System.EventArgs)

        End Sub

        Public Function GetFactorySummaryChartHtml() As String
            'xmlData will be used to store the entire XML document generated
            Dim xmlData As String
            'Generate the chart element
            xmlData = "<chart caption='Factory Output report' subCaption='By Quantity' pieSliceDepth='30' showBorder='1' for" & _
            "matNumberScale='0' numberSuffix=' Units' >"
            Dim connection As OdbcConnection = DbHelper.Connection(DbHelper.ConnectionStringFactory)
            Dim factoryQuery As String = "select * from Factory_Master"
            Dim factoryCommand As OdbcCommand = New OdbcCommand(factoryQuery, connection)
            Dim factoryAdapter As OdbcDataAdapter = New OdbcDataAdapter(factoryCommand)
            Dim factoryTable As DataTable = New DataTable
            factoryAdapter.Fill(factoryTable)
            For Each factoryRow As DataRow In factoryTable.Rows
                Dim quantityQuery As String = ("select FactoryId as TotOutput, sum(Quantity) from Factory_Output where FactoryId=" _
                            & (factoryRow("FactoryId") & " Group By FactoryId"))
                Dim quantityCommand As OdbcCommand = New OdbcCommand(quantityQuery, connection)
                xmlData = (xmlData & ("<set label='" _
                            & (factoryRow("FactoryName") & ("' value='" _
                            & (quantityCommand.ExecuteScalar.ToString & ("' link='javaScript:updateChart(" _
                            & (factoryRow("FactoryId") & ")'/>")))))))
            Next
            connection.Close()
            xmlData = (xmlData & "</chart>")            
            'Create the chart - Pie 3D Chart with data from xmlData
            Return FusionCharts.RenderChart("../../FusionCharts/Pie3D.swf", "", xmlData, "FactorySum", "500", "250", False, True)            
        End Function

        Public Function GetFactoryDetailedChartHtml() As String        
            'Column 2D Chart with changed "No data to display" message
            'We initialize the chart with <chart></chart>
            Return FusionCharts.RenderChart("../../FusionCharts/Column2D.swf?ChartNoDataText=Please select a factory from pie chart above to view " & _
                    "detailed data.", "", "<chart></chart>", "FactoryDetailed", "600", "250", False, True)
        End Function

        Protected Overrides Sub OnInit(ByVal e As EventArgs)
            '
            ' CODEGEN: This call is required by the ASP.NET Web Form Designer.
            '
            InitializeComponent()
            MyBase.OnInit(e)
        End Sub

        ''' <summary>
        ''' Required method for Designer support - do not modify
        ''' the contents of this method with the code editor.
        ''' </summary>
        Private Sub InitializeComponent()
            AddHandler Load, AddressOf Me.Page_Load
        End Sub
    End Class
End Namespace