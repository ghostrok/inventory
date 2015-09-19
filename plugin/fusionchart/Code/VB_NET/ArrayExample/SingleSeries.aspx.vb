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

Namespace InfoSoftGlobal.GeneralPages.ASP.NET.ArrayExample

    ''' <summary>
    ''' Summary description for SingleSeries.
    ''' </summary>
    Public Class SingleSeries
        Inherits System.Web.UI.Page

        Protected LiteralChart As System.Web.UI.WebControls.Literal

        Private Sub Page_Load(ByVal sender As Object, ByVal e As System.EventArgs)

        End Sub

        Public Function GetProductSalesChartHtml() As String
            'In this example, we plot a single series chart from data contained
            'in an array. The array will have two columns - first one for data label
            'and the next one for data values.
            'Let's store the sales data for 6 products in our array). We also store
            'the name of products. 
            Dim arrData(6, 3)
            'Store Name of Products
            arrData(0, 0) = "Product A"
            arrData(1, 0) = "Product B"
            arrData(2, 0) = "Product C"
            arrData(3, 0) = "Product D"
            arrData(4, 0) = "Product E"
            arrData(5, 0) = "Product F"
            'Store sales data
            arrData(0, 1) = 567500
            arrData(1, 1) = 815300
            arrData(2, 1) = 556800
            arrData(3, 1) = 734500
            arrData(4, 1) = 676800
            arrData(5, 1) = 648500
            'Now, we need to convert this data into XML. We convert using string concatenation.
            Dim xmlData As String
            'Initialize <chart> element
            xmlData = "<chart caption='Sales by Product' numberPrefix='$' formatNumberScale='0'>"
            'Convert data to XML and append
            Dim i As Integer = 0
            Do While (i < arrData.GetUpperBound(0))
                xmlData = (xmlData & ("<set label='" _
                            & (arrData(i, 0) & ("' value='" _
                            & (arrData(i, 1) & "' />")))))
                i = (i + 1)
            Loop
            'Close <chart> element
            xmlData = (xmlData & "</chart>")
            'Create the chart - Column 3D Chart with data contained in xmlData
            Return FusionCharts.RenderChart("../../FusionCharts/Column3D.swf", "", xmlData, "productSales", "600", "300", False, False)
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