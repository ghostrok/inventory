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

Namespace InfoSoftGlobal.GeneralPages.ASP.NET.DB_dataURL

    ''' <summary>
    ''' Summary description for PieData.
    ''' </summary>
    Public Class PieData
        Inherits System.Web.UI.Page

        Protected LiteralChart As System.Web.UI.WebControls.Literal

        Private Sub Page_Load(ByVal sender As Object, ByVal e As System.EventArgs)
            If Not IsPostBack Then
                'This page generates the XML data for the Pie Chart contained in
                'Default.asp.     
                'For the sake of ease, we've used an Access database which is present in
                '../DB/FactoryDB.mdb. It just contains two tables, which are linked to each
                'other. 
                'Database Objects - Initialization
                Dim query As String
                'xmlData will be used to store the entire XML document generated
                Dim xmlData As String = String.Empty
                'Default.asp has passed us a property animate. We request that.
                Dim animateChart As String
                animateChart = Request.QueryString("animate")
                'Set default value of 1
                If ((Not (animateChart) Is Nothing) _
                            AndAlso (animateChart.Length = 0)) Then
                    animateChart = "1"
                End If
                'Create the recordset to retrieve data
                'Generate the chart element
                xmlData = ("<chart caption='Factory Output report' subCaption='By Quantity' pieSliceDepth='30' showBorder='1' for" & _
                "matNumberScale='0' numberSuffix=' Units' animation=' " _
                            & (animateChart & "'>"))
                'Iterate through each factory
                query = "select * from Factory_Master"
                Dim connection As OdbcConnection = DbHelper.Connection(DbHelper.ConnectionStringFactory)
                Dim command As OdbcCommand = New OdbcCommand(query, connection)
                Dim factoryTable As DataTable = New DataTable
                Dim factoryAdapter As OdbcDataAdapter = New OdbcDataAdapter(command)
                factoryAdapter.Fill(factoryTable)
                For Each row As DataRow In factoryTable.Rows
                    Dim outputQuery As String = ("select sum(Quantity) as TotOutput from Factory_Output where FactoryId=" & row("FactoryId").ToString)
                    Dim outputCommand As OdbcCommand = New OdbcCommand(outputQuery, connection)
                    xmlData = (xmlData & ("<set label='" _
                                & (row("FactoryName").ToString & ("' value='" _
                                & (outputCommand.ExecuteScalar.ToString & "' />")))))
                Next
                'Finally, close <chart> element
                xmlData = (xmlData & "</chart>")
                'Set Proper output content-type
                Response.ContentType = "text/xml"
                'Just write out the XML data
                'NOTE THAT THIS PAGE DOESN'T CONTAIN ANY HTML TAG, WHATSOEVER
                Response.Write(xmlData)
            End If
        End Sub

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