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

Namespace InfoSoftGlobal.GeneralPages.ASP.NET.BasicExample

    ''' <summary>
    ''' Summary description for SimpleChart.
    ''' </summary>
    Public Class SimpleChart
        Inherits System.Web.UI.Page

        Protected LiteralChart As System.Web.UI.WebControls.Literal

        Private Sub Page_Load(ByVal sender As Object, ByVal e As System.EventArgs)

        End Sub

        Public Function GetMonthlyalesChartHtml() As String
            'This page demonstrates the ease of generating charts using FusionCharts.
            'For this chart, we've used a pre-defined Data.xml (contained in /Data/ folder)
            'Ideally, you would NOT use a physical data file. Instead you'll have 
            'your own ASP.NET scripts virtually relay the XML data document. Such examples are also present.
            'For a head-start, we've kept this example very simple.
            'Create the chart - Column 3D Chart with data from Data/Data.xml
            Return FusionCharts.RenderChart("../../FusionCharts/Column3D.swf", "Data/Data.xml", "", "myFirst", "600", "300", False, False)
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