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
    ''' Summary description for FactoryData.
    ''' </summary>
    Public Class FactoryData
        Inherits System.Web.UI.Page

        Private Sub Page_Load(ByVal sender As Object, ByVal e As System.EventArgs)
            If Not IsPostBack Then
                'This page is invoked from Default.asp. When the user clicks on a pie
                'slice in Default.asp, the factory Id is passed to this page. We need
                'to get that factory id, get information from database and then write XML.
                'First, get the factory Id
                Dim factoryId As String
                'Request the factory Id from Querystring
                factoryId = Request.QueryString("FactoryId")
                'xmlData will be used to store the entire XML document generated
                Dim xmlData As String
                Dim query As String = ("select * from Factory_Output where FactoryId=" & factoryId)
                xmlData = ("<chart palette='2' caption='Factory " _
                            & (factoryId & " Output ' subcaption='(In Units)' xAxisName='Date' showValues='1' labelStep='2' >"))
                Dim connection As OdbcConnection = DbHelper.Connection(DbHelper.ConnectionStringFactory)
                Dim command As OdbcCommand = New OdbcCommand(query, connection)
                Dim reader As OdbcDataReader = command.ExecuteReader

                While reader.Read
                    xmlData = (xmlData & ("<set label='" _
                                & (CType(reader("DatePro"), DateTime).Day.ToString & ("/" _
                                & (CType(reader("DatePro"), DateTime).Month.ToString & ("' value='" _
                                & (reader("Quantity").ToString & "'/>")))))))

                End While
                connection.Close()
                xmlData = (xmlData & "</chart>")
                Response.Clear()
                Response.ContentType = "text/xml"
                'Just write out the XML data
                'NOTE THAT THIS PAGE DOESN'T CONTAIN ANY HTML TAG, WHATSOEVER
                Response.Output.Write(xmlData)
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