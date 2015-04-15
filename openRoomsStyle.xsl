<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:template match="/">
        <div>
            <table>
                <xsl:for-each select="rooms/room">
                    <tr>
                        <td><xsl:value-of select="owner"/></td>
                        <td>
                            <input type="button" value="join" name="openRooms">
                                <xsl:attribute name="id">
                                    <xsl:value-of select="id"/>
                                </xsl:attribute>
                            </input>
                        </td>
                    </tr>
                </xsl:for-each>
            </table>
        </div>
    </xsl:template>
</xsl:stylesheet>