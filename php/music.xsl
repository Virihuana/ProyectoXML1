<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">

  <xsl:template match="/">
  <html>
  <head>
  <link href="http://fonts.googleapis.com/css?family=Annie Use Your Telescope" rel="stylesheet"/>
  <link href="http://fonts.googleapis.com/css?family=Sofia" rel="stylesheet"/>
  <style>
    table {
        border-collapse: collapse;
        width: 50%;
    }
    th, td {
        text-align: left;
        padding: 5px;
    }
    tr:nth-child(even){background-color: #dae9e9}
    tr:nth-child(odd) {background: #de5d83;}

    th {
        background-color: #450045;
        color: white;
        height:20%;
    }
    td,th{
        font-family: 'Annie Use Your Telescope';font-size: 18px;
    }
    h2{
        font-family: 'Sofia';font-size: 30px;
    }
    
  </style>
  </head>
  <body>
    <h2>Songs Coldplay</h2>
    <table>
      <tr height="60">
        <th>Título</th>
        <th>Album</th>
        <th>Duración</th>
      </tr>
      <xsl:apply-templates/>
    </table>
  </body>
  </html>  
  </xsl:template>
  
<xsl:template match="cancion">
      <tr>
            <td><xsl:value-of select="titulo"/></td>
            <xsl:if test="album/@categoria='indie'">
                        <td>Nombre: <xsl:value-of select="album"/><br/>Categoría: Indie<br/>Año:<xsl:value-of select="album/@year"/></td>
            </xsl:if>
            <xsl:if test="album/@categoria='rock'">
                  <td>Nombre: <xsl:value-of select="album"/><br/>Categoría: Rock<br/>Año:<xsl:value-of select="album/@year"/></td>
            </xsl:if>
            <xsl:if test="album/@categoria='reggae'">
                  <td>Nombre: <xsl:value-of select="album"/><br/>Categoría: Reggae<br/>Año:<xsl:value-of select="album/@year"/></td>
            </xsl:if>
            <td><xsl:value-of select="duracion"/></td>
      </tr>
</xsl:template>

</xsl:stylesheet>