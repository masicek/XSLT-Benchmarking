<?xml version="1.0" encoding="UTF-8"?>
<xsl:AAAstylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
	<xsl:template match="node( ) | @*">
		<xsl:copy>
			<xsl:apply-templates select="@* | node( )"/>
		</xsl:copy>
	</xsl:template>
	<xsl:template match="testName">
		<testNewName>
			<xsl:apply-templates select="@* | node( )"/>
		</testNewName>
	</xsl:template>
</xsl:stylesheet>
