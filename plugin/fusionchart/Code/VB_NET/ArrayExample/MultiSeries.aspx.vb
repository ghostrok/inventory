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
    ''' Summary description for MultiSeries.
    ''' </summary>
    Public Class MultiSeries
        Inherits System.Web.UI.Page

        Protected LiteralChart As System.Web.UI.WebControls.Literal

        Private Sub Page_Load(ByVal sender As Object, ByVal e As System.EventArgs)

        End Sub

        Public Function GetProductSalesChartHtml() As String
            'In this example, we plot a multi series chart from data contained
            'in an array. The array will have three columns - first one for data label (product)
            'and the next two for data values. The first data value column would store sales information
            'for current year and the second one for previous year.
            'Let//s store the sales data for 6 products in our array. We also store
            'the name of products. 
            Dim arrData(6, 3)
            'Store Name of Products
            arrData(0, 0) = "Product A"
            arrData(1, 0) = "Product B"
            arrData(2, 0) = "Product C"
            arrData(3, 0) = "Product D"
            arrData(4, 0) = "Product E"
            arrData(5, 0) = "Product F"
            'Store sales data for current year
            arrData(0, 1) = 567500
            arrData(1, 1) = 815300
            arrData(2, 1) = 556800
            arrData(3, 1) = 734500
            arrData(4, 1) = 676800
            arrData(5, 1) = 648500
            'Store sales data for previous year
            arrData(0, 2) = 547300
            arrData(1, 2) = 584500
            arrData(2, 2) = 754000
            arrData(3, 2) = 456300
            arrData(4, 2) = 754500
            arrData(5, 2) = 437600
            'Now, we need to convert this data into multi-series XML. 
            'We convert using string concatenation.
            'xmlData - Stores the entire XML
            'categories - Stores XML for the <categories> and child <category> elements
            'currentYear - Stores XML for current year's sales
            'previousYear - Stores XML for previous year's sales
            Dim previousYear As String
            Dim xmlData As String
            Dim categories As String
            Dim currentYear As String
            'Initialize <chart> element
            xmlData = "<chart caption='Sales by Product' numberPrefix='$' formatNumberScale='1' rotateValues='1' placeValues" & _
            "Inside='1' decimals='0' >"
            'Initialize <categories> element - necessary to generate a multi-series chart
            categories = "<categories>"
            'Initiate <dataset> elements
            currentYear = "<dataset seriesName='Current Year'>"
            previousYear = "<dataset seriesName='Previous Year'>"
            'Iterate through the data    
            Dim i As Integer = 0
            Do While (i < arrData.GetUpperBound(0))
                'Append <category name='...' /> to strCategories
                categories = (categories & ("<category name='" _
                            & (arrData(i, 0) & "' />")))
                'Add <set value='...' /> to both the datasets
                currentYear = (currentYear & ("<set value='" _
                            & (arrData(i, 1) & "' />")))
                previousYear = (previousYear & ("<set value='" _
                            & (arrData(i, 2) & "' />")))
                i = (i + 1)
            Loop
            'Close <categories> element
            categories = (categories & "</categories>")
            'Close <dataset> elements
            currentYear = (currentYear & "</dataset>")
            previousYear = (previousYear & "</dataset>")
            'Assemble the entire XML now
            xmlData = (xmlData _
                        & (categories _
                        & (currentYear _
                        & (previousYear & "</chart>"))))
            'Create the chart - MS Column 3D Chart with data contained in xmlData
            Return FusionCharts.RenderChart("../../FusionCharts/MSColumn3D.swf", "", xmlData, "productSales", "600", "300", False, False)
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