Imports System
Imports System.Data
Imports System.Text
Imports System.Data.Odbc

Namespace InfoSoftGlobal
    ''' <summary>
    ''' Summary description for InfoSoftGlobal.FusionCharts.
    ''' </summary>
    Public Class FusionCharts

        ''' <summary>
        ''' Encodes dataURL before it's served to FusionCharts
        ''' If you have parameters in your dataURL, you necessarily need to encode it
        ''' </summary>
        ''' <param name="dataURL">dataURL to be fed to chart</param>
        ''' <param name="noCacheStr">Whether to add aditional string to URL to disable caching of data</param>
        ''' <returns>the encoded Url address</returns>
        Public Shared Function EncodeDataURL(ByVal dataURL As String, ByVal noCacheStr As Boolean) As String
            Dim result As String = dataURL
            If noCacheStr Then
                If dataURL.IndexOf("?") <> -1 Then
                    result &= "&"
                Else
                    result &= "?"
                End If
                result = (result & ("FCCurrTime=" & DateTime.Now.ToString.Replace(":", "_")))
            End If
            Return System.Web.HttpUtility.UrlEncode(result)
        End Function

        ''' <summary>
        ''' Generate html code for rendering the chart
        ''' This function assumes that you've already included the FusionCharts JavaScript class in your page
        ''' </summary>
        ''' <param name="chartSWF">SWF File Name (and Path) of the chart which you intend to plot</param>
        ''' <param name="strURL">If you intend to use dataURL method for this chart, pass the URL as this parameter. Else, set it to "" (in case of dataXML method)</param>
        ''' <param name="strXML">If you intend to use dataXML method for this chart, pass the XML data as this parameter. Else, set it to "" (in case of dataURL method)</param>
        ''' <param name="chartId">Id for the chart, using which it will be recognized in the HTML page. Each chart on the page needs to have a unique Id.</param>
        ''' <param name="chartWidth">Intended width for the chart (in pixels)</param>
        ''' <param name="chartHeight">Intended height for the chart (in pixels)</param>
        ''' <param name="debugMode">Whether to start the chart in debug mode</param>
        ''' <param name="registerWithJS">Whether to ask chart to register itself with JavaScript</param>
        ''' <returns>JavaScript & HTML code required to embed a chart</returns>
        Public Shared Function RenderChart(ByVal chartSWF As String, ByVal strURL As String, ByVal strXML As String, ByVal chartId As String, ByVal chartWidth As String, ByVal chartHeight As String, ByVal debugMode As Boolean, ByVal registerWithJS As Boolean) As String
            Dim builder As StringBuilder = New StringBuilder
            builder.AppendFormat(("<div id='{0}Div' align='center'>" & Environment.NewLine), chartId)
            builder.Append(("Chart." & Environment.NewLine))
            builder.Append(("</div>" & Environment.NewLine))
            builder.Append(("<script type=""text/javascript"">" & Environment.NewLine))
            builder.AppendFormat(("var chart_{0} = new FusionCharts(""{1}"", ""{0}"", ""{2}"", ""{3}"", ""{4}"", ""{5}"");" & Environment.NewLine), chartId, chartSWF, chartWidth, chartHeight, boolToNum(debugMode), boolToNum(registerWithJS))
            If (strXML.Length = 0) Then
                builder.AppendFormat(("chart_{0}.setDataURL(""{1}"");" & Environment.NewLine), chartId, strURL)
            Else
                builder.AppendFormat(("chart_{0}.setDataXML(""{1}"");" & Environment.NewLine), chartId, strXML)
            End If
            builder.AppendFormat(("chart_{0}.render(""{1}Div"");" & Environment.NewLine), chartId, chartId)
            builder.Append(("</script>" & Environment.NewLine))
            Return builder.ToString
        End Function

        ''' <summary>
        ''' Renders the HTML code for the chart. This
        ''' method does NOT embed the chart using JavaScript class. Instead, it uses
        ''' direct HTML embedding. So, if you see the charts on IE 6 (or above), you'll
        ''' see the "Click to activate..." message on the chart.
        ''' </summary>
        ''' <param name="chartSWF">SWF File Name (and Path) of the chart which you intend to plot</param>
        ''' <param name="strURL">If you intend to use dataURL method for this chart, pass the URL as this parameter. Else, set it to "" (in case of dataXML method)</param>
        ''' <param name="strXML">If you intend to use dataXML method for this chart, pass the XML data as this parameter. Else, set it to "" (in case of dataURL method)</param>
        ''' <param name="chartId">Id for the chart, using which it will be recognized in the HTML page. Each chart on the page needs to have a unique Id.</param>
        ''' <param name="chartWidth">Intended width for the chart (in pixels)</param>
        ''' <param name="chartHeight">Intended height for the chart (in pixels)</param>
        ''' <param name="debugMode">Whether to start the chart in debug mode</param>
        ''' <returns></returns>
        Public Shared Function RenderChartHTML(ByVal chartSWF As String, ByVal strURL As String, ByVal strXML As String, ByVal chartId As String, ByVal chartWidth As String, ByVal chartHeight As String, ByVal debugMode As Boolean) As String
            'Generate the FlashVars string based on whether dataURL has been provided
            'or dataXML.
            Dim strFlashVars As StringBuilder = New StringBuilder
            Dim flashVariables As String = String.Empty
            If (strXML.Length = 0) Then
                'DataURL Mode
                flashVariables = String.Format("&chartWidth={0}&chartHeight={1}&debugMode={2}&dataURL={3}", chartWidth, chartHeight, boolToNum(debugMode), strURL)
            Else
                flashVariables = String.Format("&chartWidth={0}&chartHeight={1}&debugMode={2}&dataXML={3}", chartWidth, chartHeight, boolToNum(debugMode), strXML)
            End If
            strFlashVars.AppendFormat(("<!-- START Code Block for Chart {0} -->" & Environment.NewLine), chartId)
            strFlashVars.AppendFormat(("<object classid=""clsid:d27cdb6e-ae6d-11cf-96b8-444553540000"" codebase=""http://fpdownload.macromedi" & _
                "a.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0"" width=""{0}"" height=""{1}"" name=""{2}" & _
                """>" & Environment.NewLine), chartWidth, chartHeight, chartId)
            strFlashVars.Append(("<param name=""allowScriptAccess"" value=""always"" />" & Environment.NewLine))
            strFlashVars.AppendFormat(("<param name=""movie"" value=""{0}""/>" & Environment.NewLine), chartSWF)
            strFlashVars.AppendFormat(("<param name=""FlashVars"" value=""{0}"" />" & Environment.NewLine), flashVariables)
            strFlashVars.Append(("<param name=""quality"" value=""high"" />" & Environment.NewLine))
            strFlashVars.AppendFormat(("<embed src=""{0}"" FlashVars=""{1}"" quality=""high"" width=""{2}"" height=""{3}"" name=""{4}""  allo" & _
                "wScriptAccess=""always"" type=""application/x-shockwave-flash"" pluginspage=""http://www.macromedia." & _
                "com/go/getflashplayer"" />" & Environment.NewLine), chartSWF, flashVariables, chartWidth, chartHeight, chartId)
            strFlashVars.Append(("</object>" & Environment.NewLine))
            strFlashVars.AppendFormat(("<!-- END Code Block for Chart {0} -->" & Environment.NewLine), chartId)
            Return strFlashVars.ToString
        End Function

        ''' <summary>
        ''' Convert boolean value to integer value
        ''' </summary>
        ''' <param name="value">true/false value to be transformed</param>
        ''' <returns>1 if the value is true, 0 if the value is false</returns>
        Private Shared Function boolToNum(ByVal value As Boolean) As Integer
            If value Then
                Return 1
            Else
                Return 0
            End If
        End Function
    End Class

End Namespace