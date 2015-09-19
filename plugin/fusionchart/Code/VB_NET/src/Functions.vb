Imports System

Namespace InfoSoftGlobal
    ''' <summary>
    ''' Summary description for InfoSoftGlobal.Functions.
    ''' </summary>
    Public Class Functions

        'If you've UTF-8 characters in your XML, you'll need to use the Streamwriter 
        'object to convey the XML to chart.        
        Private writer As New System.IO.StreamWriter(System.Web.HttpContext.Current.Response.OutputStream, System.Text.Encoding.UTF8)

        'getCaptionFontColor function returns a color code for caption. Basic
        'idea to use this is to demonstrate how to centralize your cosmetic 
        'attributes for the chart
        Public Shared ReadOnly Property getCaptionFontColor() As String
            Get
                'Return a hex color code without #
                Return "666666"
                'FFC30C - Yellow Color
            End Get
        End Property
        
        'escapeXML function helps you escape special characters in XML
        Public Shared Function EscapeXML(ByVal item As String, ByVal forDataURL As Boolean) As String
            'Convert ' to &apos; if dataURL
            If forDataURL Then
                item = item.Replace("'", "&apos;")
            Else
                'Else for dataXML         
                'Convert % to %25
                item = item.Replace("%", "%25")
                'Convert ' to %26apos;
                item = item.Replace("'", "%26apos;")
                'Convert & to %26
                item = item.Replace("&", "%26")
            End If
            'Common replacements
            item = item.Replace("<", "<")
            item = item.Replace(">", ">")
            'We've not considered any special characters here. 
            'You can add them as per your language and requirements.
            'Return
            Return item
        End Function

        'getPalette method returns a value between 1-5 depending on which
        'paletter the user wants to plot the chart with. 
        'Here, we just read from Session variable and show it
        'In your application, you could read this configuration from your 
        'User Configuration Manager, database, or global application settings
        Public Shared Function GetPalette() As String
            Dim palette As String = String.Empty
            If ((System.Web.HttpContext.Current.Session("palette") = Nothing) _
                        OrElse (System.Web.HttpContext.Current.Session("palette").ToString = String.Empty)) Then
                palette = "2"
            Else
                palette = System.Web.HttpContext.Current.Session("palette").ToString
            End If
            Return palette
        End Function

        'getAnimationState returns 0 or 1, depending on whether we've to
        'animate chart. Here, we just read from Session variable and show it
        'In your application, you could read this configuration from your 
        'User Configuration Manager, database, or global application settings
        Public Shared Function GetAnimationState() As String
            Dim animation As String = String.Empty
            If ((Not (System.Web.HttpContext.Current.Session("animation")) Is Nothing) _
                        AndAlso (System.Web.HttpContext.Current.Session("animation").ToString <> "0")) Then
                animation = "1"
            Else
                animation = "0"
            End If
            Return animation
        End Function

        Public Shared Function GetDecimal(ByVal value As Decimal) As String
            Dim result As String = value.ToString("F")
            If (result.IndexOf(",") > -1) Then
                result = result.Replace(",", ".")
            End If
            Return result
        End Function

        Public Shared Function GetMonthName(ByVal monthNumber As Integer) As String
            Dim result As String = String.Empty
            Select Case (monthNumber)
                Case 1
                    result = "January"
                Case 2
                    result = "February"
                Case 3
                    result = "March"
                Case 4
                    result = "April"
                Case 5
                    result = "May"
                Case 6
                    result = "June"
                Case 7
                    result = "July"
                Case 8
                    result = "August"
                Case 9
                    result = "September"
                Case 10
                    result = "October"
                Case 11
                    result = "November"
                Case 12
                    result = "December"
            End Select
            Return result
        End Function
        
        'Use this method to write XML data documents to output stream
        'if you've UTF-8 characters in your XML.
        Public Sub Write(ByVal stringForOutput As String)
            writer.Write(stringForOutput)
            writer.Flush()
        End Sub
    End Class
End Namespace

