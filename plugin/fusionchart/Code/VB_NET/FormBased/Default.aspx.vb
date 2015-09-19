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

Namespace InfoSoftGlobal.GeneralPages.ASP.NET.FormBased

    ''' <summary>
    ''' Summary description for _Default.
    ''' </summary>
    Public Class _Default
        Inherits System.Web.UI.Page

        Protected TextboxSalads As System.Web.UI.WebControls.TextBox

        Protected TextboxSandwiches As System.Web.UI.WebControls.TextBox

        Protected TextboxBeverages As System.Web.UI.WebControls.TextBox

        Protected TextboxDesserts As System.Web.UI.WebControls.TextBox

        Protected ButtonChart As System.Web.UI.WebControls.Button

        Protected LiteralChart As System.Web.UI.WebControls.Literal

        Protected DivSubmission As System.Web.UI.HtmlControls.HtmlGenericControl

        Protected DivFormParameters As System.Web.UI.HtmlControls.HtmlGenericControl

        Protected TextBoxSoups As System.Web.UI.WebControls.TextBox

        Private Sub Page_Load(ByVal sender As Object, ByVal e As System.EventArgs)
            If Not IsPostBack Then
                DivSubmission.Visible = False
                DivFormParameters.Visible = True
            Else
                DivSubmission.Visible = True
                DivFormParameters.Visible = False
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
            AddHandler ButtonChart.Click, AddressOf Me.ButtonChart_Click
            AddHandler Load, AddressOf Me.Page_Load
        End Sub

        Private Sub ButtonChart_Click(ByVal sender As Object, ByVal e As System.EventArgs)
            'We first request the data from the form
            Dim desserts As Integer
            Dim soups As Integer
            Dim salads As Integer
            Dim sandwiches As Integer
            Dim beverages As Integer
            soups = Integer.Parse(TextBoxSoups.Text)
            salads = Integer.Parse(TextboxSalads.Text)
            sandwiches = Integer.Parse(TextboxSandwiches.Text)
            beverages = Integer.Parse(TextboxBeverages.Text)
            desserts = Integer.Parse(TextboxDesserts.Text)
            'In this example, we're directly showing this data back on chart.
            'In your apps, you can do the required processing and then show the 
            'relevant data only.
            'Now that we've the data in variables, we need to convert this into XML.
            'The simplest method to convert data into XML is using string concatenation.    
            Dim xmlData As String = String.Empty
            'Initialize <chart> element
            xmlData = "<chart caption='Sales by Product Category' subCaption='For this week' showPercentValues='1' pieSliceD" & _
            "epth='30' showBorder='1'>"
            'Add all data
            xmlData = (xmlData & ("<set label='Soups' value='" _
                        & (soups & "' />")))
            xmlData = (xmlData & ("<set label='Salads' value='" _
                        & (salads & "' />")))
            xmlData = (xmlData & ("<set label='Sandwiches' value='" _
                        & (sandwiches & "' />")))
            xmlData = (xmlData & ("<set label='Beverages' value='" _
                        & (beverages & "' />")))
            xmlData = (xmlData & ("<set label='Desserts' value='" _
                        & (desserts & "' />")))
            'Close <chart> element
            xmlData = (xmlData & "</chart>")
            'Create the chart - Pie 3D Chart with data from xmlData
            LiteralChart.Text = FusionCharts.RenderChart("../../FusionCharts/Pie3D.swf", "", xmlData, "Sales", "500", "300", False, False)
        End Sub
    End Class
End Namespace