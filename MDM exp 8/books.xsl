<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    
    <xsl:template match="/">
        <html>
        <head>
            <title>Book Catalog</title>
            <style>
                body { font-family: Arial, sans-serif; background-color: #f9f9f9; padding: 20px; }
                h2 { text-align: center; color: #333; }
                table { border-collapse: collapse; width: 60%; margin: 0 auto; background-color: white; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
                th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
                th { background-color: #007bff; color: white; }
                tr:nth-child(even) { background-color: #f2f2f2; }
                tr:hover { background-color: #ddd; }
            </style>
        </head>
        <body>
            <h2>Available Books</h2>
            <table>
                <tr>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Price (₹)</th>
                </tr>
                
                <xsl:for-each select="catalog/book">
                    <tr>
                        <td><xsl:value-of select="title"/></td>
                        <td><xsl:value-of select="author"/></td>
                        <td>₹<xsl:value-of select="price"/></td>
                    </tr>
                </xsl:for-each>
                
            </table>
        </body>
        </html>
    </xsl:template>

</xsl:stylesheet>