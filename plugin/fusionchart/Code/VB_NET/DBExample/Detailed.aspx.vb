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

Namespace InfoSoftGlobal.GeneralPages.ASP.NET.DBExample

    ''' <summary>
    ''' Summary description for Detailed.
    ''' </summary>
    Public Class Detailed
        Inherits System.Web.UI.Page

        Protected LiteralChart As System.Web.UI.WebControls.Literal

        Private Sub Page_Load(ByVal sender As Object, ByVal e As System.EventArgs)

        End Sub

        Public Function GetFactoryDetailedChartHtml() As String
            'This page is invoked from Default.asp. When the user clicks on a pie
            'slice in Default.aspx, the factory Id is passed to this page. We need
            'to get that factory id, get information from database and then show
            'a detailed chart.
            'First, get the factory Id
            Dim factoryId As String
            'Request the factory Id from Querystring
            factoryId = Request.QueryString("FactoryId")
            'xmlData will be used to store the entire XML document generated
            Dim xmlData As String
            'Generate the chart element string
            xmlData = ("<chart palette='2' caption='Factory " _
                        & (factoryId & " Output ' subcaption='(In Units)' xAxisName='Date' showValues='1' labelStep='2' >"))
            'Now, we get the data for that factory
            Dim query As String = ("select * from Factory_Output where FactoryId=" & factoryId)
            Dim connection As OdbcConnection = DbHelper.Connection(DbHelper.ConnectionStringFactory)
            Dim command As OdbcCommand = New OdbcCommand(query, connection)
            Dim reader As OdbcDataReader = command.ExecuteReader

            While reader.Read
                xmlData = (xmlData & ("<set label='" _
                            & (CType(reader("DatePro"), DateTime).Day.ToString & ("/" _
                            & (CType(reader("DatePro"), DateTime).Month.ToString & ("' value='" _
                            & (reader("Quantity").ToString & "'/>")))))))

            End While
            reader.Close()
            'Close <chart> element
            xmlData = (xmlData & "</chart>")
            'Create the chart - Column 2D Chart with data from xmlData
            Return FusionCharts.RenderChart("../../FusionCharts/Column2D.swf", "", xmlData, "FactoryDetailed", "600", "300", False, False)
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