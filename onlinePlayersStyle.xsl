<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:template match="/">
        <div>
            <table>
                <xsl:for-each select="users/user">
                    <tr>
                        <td><xsl:value-of select="username"/></td>
                    </tr>
                </xsl:for-each>
            </table>
        </div>
    </xsl:template>
</xsl:stylesheet>