<%
    Option Explicit
    On Error Resume Next
    Dim sc, cn, rs
    Function APRI()
        sc = "driver={Microsoft Access Driver (*.mdb)};dbq="
        Set cn = Server.CreateObject("ADODB.Connection")
        cn.Open sc & Server.Mappath("database.mdb")
        Set rs = Server.CreateObject("ADODB.recordset")
    End Function
    Function CHIUDI()
        rs.Close
        Set rs = Nothing
        cn.Close
        Set cn = Nothing
    End Function
%>