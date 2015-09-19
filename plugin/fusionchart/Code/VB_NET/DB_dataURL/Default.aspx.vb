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

Namespace InfoSoftGlobal.GeneralPages.ASP.NET.DB_dataURL

    ''' <summary>
    ''' Summary description for _Default.
    ''' </summary>
    Public Class _Default
        Inherits System.Web.UI.Page

        Protected LiteralChart As System.Web.UI.WebControls.Literal

        Private Sub Page_Load(ByVal sender As Object, ByVal e As System.EventArgs)

        End Sub

        Public Function GetQuantityChartHtml() As String
            'In this example, we show how to connect FusionCharts to a database 
            'using dataURL method. In our other examples, we've used dataXML method
            'where the XML is generated in the same page as chart. Here, the XML data
            'for the chart would be generated in PieData.asp.
            'To illustrate how to pass additional data as querystring to dataURL, 
            'we've added an animate    property, which will be passed to PieData.asp. 
            'PieData.asp would handle this animate property and then generate the 
            'XML accordingly.
            'For the sake of ease, we've used an Access database which is present in
            '../DB/FactoryDB.mdb. It just contains two tables, which are linked to each
            'other.
            'Variable to contain dataURL
            'Set DataURL with animation property to 1
            'NOTE: It's necessary to encode the dataURL if you've added parameters to it
            Dim dataURL As String = FusionCharts.EncodeDataURL("PieData.aspx?animate=1", False)
            'Create the chart - Pie 3D Chart with dataURL as strDataURL
            Return FusionCharts.RenderChart("../../FusionCharts/Pie3D.swf", dataURL, "", "FactorySum", "600", "300", False, False)
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