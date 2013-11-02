<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">


<xsl:template match="/">
  <html>
  <head>
    <title>My Cookbook</title>
    <style type="text/css">
      body {font: 16pt/18pt Arial,"DejaVu Sans",Helvetica,Verdana,sans-serif;}
      p, td, li{font: 13px Georgia,"DejaVu Serif","Trebuchet MS",Times,serif;}
      h1 { font-style: italic ; color: #111111}
      td.prep { font-style: italic ; bgcolor: orange ; colspan: 2}
      td.name {text-transform:capitalize;}
      th {background-color: #111111; color:#FFFFFF;}
    </style>

  </head>
  <body>
    <h2>My Recipe Collection</h2>
    <div style="width: 456px; overflow: hidden">
    <table border="1">

    <xsl:for-each select="cookbook/recipe">
        
      <xsl:if test="(position()) != 1">
      <tr><td colspan="2">&#160;</td></tr>
      </xsl:if>
      <tr>
        <th colspan="2"><xsl:value-of select="name"/></th>
      </tr>

      <tr><td colspan="2" class="prep"><b>Ingredients:</b></td></tr>
      <xsl:for-each select="ingredient">
      <tr>
        <td class="name"><xsl:value-of select="name"/></td>
        <td><xsl:value-of select="amount"/><b>&#160;
            <xsl:value-of select="unit"/></b></td>
      </tr>
      </xsl:for-each>
      <tr>
          <td class="prep" colspan="2"><b>Preparation: </b><br/>
                <xsl:value-of select="preparation"/></td>
      </tr>

      <tr>
          <td class="prep" colspan="2"><b>How to cook: </b><br/>
              <xsl:value-of select="cooking"/></td>
      </tr>
    </xsl:for-each>
    </table>
    </div>
  </body>
  </html>
</xsl:template>

</xsl:stylesheet>


