Imports System
Imports System.Data.Odbc

Namespace InfoSoftGlobal

    ''' <summary>
    ''' Summary description for DbHelper.
    ''' </summary>
    Public Class DbHelper

        Public Shared ReadOnly Property ConnectionStringFactory() As String
            Get
                Return System.Configuration.ConfigurationSettings.AppSettings("ConnectionStringFactory")
            End Get
        End Property

        Public Shared ReadOnly Property ConnectionStringFisionChart() As String
            Get
                Return System.Configuration.ConfigurationSettings.AppSettings("ConnectionStringFusionChart")
            End Get
        End Property

        Public Shared Function Connection(ByVal connectionString As String) As OdbcConnection
            'In this page, we open the connection to the Database
            'Our Access database is contained in ../DB/FactoryDB.mdb
            'It's a very simple database with just 2 tables (for the sake of demo)    
            Dim mConnection As OdbcConnection = New OdbcConnection
            'Connect
            mConnection.ConnectionString = connectionString
            mConnection.Open()
            Return mConnection
        End Function
    End Class
End Namespace