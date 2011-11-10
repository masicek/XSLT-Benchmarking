<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">

	<xsl:template match="node( ) | @*">
		<xsl:copy>
			<xsl:apply-templates select="@* | node( )"/>
		</xsl:copy>
	</xsl:template>

	<xsl:template match="testName">
		{if $action == 'rename'}
			<{$newName}>
				<xsl:apply-templates select="@* | node( )"/>
			</{$newName}>
		{/if}
	</xsl:template>

</xsl:stylesheet>
