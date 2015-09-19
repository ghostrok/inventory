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
    ''' Summary description for Stacked.
    ''' </summary>
    Public Class Stacked
        Inherits System.Web.UI.Page

        Protected LiteralChart As System.Web.UI.WebControls.Literal

        Private Sub Page_Load(ByVal sender As Object, ByVal e As System.EventArgs)

        End Sub

        Public Function GetProductSalesChartHtml() As String
            'In this example, we plot a Stacked chart from data contained
            'in an array. The array will have three columns - first one for Quarter Name
            'and the next two for data values. The first data value column would store sales information
            'for Product A and the second one for Product B.
            Dim arrData(4, 3)
            'Store Name of Products
            arrData(0, 0) = "Quarter 1"
            arrData(1, 0) = "Quarter 2"
            arrData(2, 0) = "Quarter 3"
            arrData(3, 0) = "Quarter 4"
            'Sales data for Product A
            arrData(0, 1) = 567500
            arrData(1, 1) = 815300
            arrData(2, 1) = 556800
            arrData(3, 1) = 734500
            'Sales data for Product B
            arrData(0, 2) = 547300
            arrData(1, 2) = 594500
            arrData(2, 2) = 754000
            arrData(3, 2) = 456300
            'Now, we need to convert this data into multi-series XML. 
            'We convert using string concatenation.
            'xmlData - Stores the entire XML
            'strCategories - Stores XML for the <categories> and child <category> elements
            'strDataProdA - Stores XML for current year's sales
            'strDataProdB - Stores XML for previous year's sales
            Dim strDataProdB As String
            Dim xmlData As String
            Dim categories As String
            Dim strDataProdA As String
            'Initialize <chart> element
            xmlData = "<chart caption='Sales' numberPrefix='$' formatNumberScale='0'>"
            'Initialize <categories> element - necessary to generate a stacked chart
            categories = "<categories>"
            'Initiate <dataset> elements
            strDataProdA = "<dataset seriesName='Product A'>"
            strDataProdB = "<dataset seriesName='Product B'>"
            'Iterate through the data    
            Dim i As Integer = 0
            Do While (i < arrData.GetUpperBound(0))
                'Append <category name='...' /> to strCategories
                categories = (categories & ("<category name='" _
                            & (arrData(i, 0) & "' />")))
                'Add <set value='...' /> to both the datasets
                strDataProdA = (strDataProdA & ("<set value='" _
                            & (arrData(i, 1) & "' />")))
                strDataProdB = (strDataProdB & ("<set value='" _
                            & (arrData(i, 2) & "' />")))
                i = (i + 1)
            Loop
            'Close <categories> element
            categories = (categories & "</categories>")
            'Close <dataset> elements
            strDataProdA = (strDataProdA & "</dataset>")
            strDataProdB = (strDataProdB & "</dataset>")
            'Assemble the entire XML now
            xmlData = (xmlData _
                        & (categories _
                        & (strDataProdA _
                        & (strDataProdB & "</chart>"))))
            'Create the chart - Stacked Column 3D Chart with data contained in xmlData
            Return FusionCharts.RenderChart("../../FusionCharts/StackedColumn3D.swf", "", xmlData, "productSales", "500", "300", False, False)
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