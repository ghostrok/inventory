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
    ''' Summary description for Combination.
    ''' </summary>
    Public Class Combination
        Inherits System.Web.UI.Page

        Protected LabelChart As System.Web.UI.WebControls.Literal

        Private Sub Page_Load(ByVal sender As Object, ByVal e As System.EventArgs)

        End Sub

        Public Function GetProductSalesChartHtml() As String
            'In this example, we plot a Combination chart from data contained
            'in an array. The array will have three columns - first one for Quarter Name
            'second one for sales figure and third one for quantity. 
            Dim arrData(4, 3)
            'Store Quarter Name
            arrData(0, 0) = "Quarter 1"
            arrData(1, 0) = "Quarter 2"
            arrData(2, 0) = "Quarter 3"
            arrData(3, 0) = "Quarter 4"
            'Store revenue data
            arrData(0, 1) = 576000
            arrData(1, 1) = 448000
            arrData(2, 1) = 956000
            arrData(3, 1) = 734000
            'Store Quantity
            arrData(0, 2) = 576
            arrData(1, 2) = 448
            arrData(2, 2) = 956
            arrData(3, 2) = 734
            'Now, we need to convert this data into combination XML. 
            'We convert using string concatenation.
            'strXML - Stores the entire XML
            'strCategories - Stores XML for the <categories> and child <category> elements
            'strDataRev - Stores XML for current year's sales
            'strDataQty - Stores XML for previous year's sales
            Dim strDataQty As String
            Dim strXML As String
            Dim strCategories As String
            Dim strDataRev As String
            'Initialize <chart> element
            strXML = "<chart palette='4' caption='Product A - Sales Details' PYAxisName='Revenue' SYAxisName='Quantity (in " & _
            "Units)' numberPrefix='$' formatNumberScale='0' showValues='0' decimals='0' >"
            'Initialize <categories> element - necessary to generate a multi-series chart
            strCategories = "<categories>"
            'Initiate <dataset> elements
            strDataRev = "<dataset seriesName='Revenue'>"
            strDataQty = "<dataset seriesName='Quantity' parentYAxis='S'>"
            'Iterate through the data    
            Dim i As Integer = 0
            Do While (i < arrData.GetUpperBound(0))
                'Append <category name='...' /> to strCategories
                strCategories = (strCategories & ("<category name='" _
                            & (arrData(i, 0) & "' />")))
                'Add <set value='...' /> to both the datasets
                strDataRev = (strDataRev & ("<set value='" _
                            & (arrData(i, 1) & "' />")))
                strDataQty = (strDataQty & ("<set value='" _
                            & (arrData(i, 2) & "' />")))
                i = (i + 1)
            Loop
            'Close <categories> element
            strCategories = (strCategories & "</categories>")
            'Close <dataset> elements
            strDataRev = (strDataRev & "</dataset>")
            strDataQty = (strDataQty & "</dataset>")
            'Assemble the entire XML now
            strXML = (strXML _
                        & (strCategories _
                        & (strDataRev _
                        & (strDataQty & "</chart>"))))
            'Create the chart - MS Column 3D Line Combination Chart with data contained in strXML
            Return FusionCharts.RenderChart("../../FusionCharts/MSColumn3DLineDY.swf", "", strXML, "productSales", "600", "300", False, False)
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