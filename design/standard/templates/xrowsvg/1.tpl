{if $image}
<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="{$image.width}" height="{$image.height}">
    <defs id="svg-filter-shadow-{$attributeID}">
        <filter id="svgDropShadowUML-{$attributeID}" height="130%">
            <feGaussianBlur in="SourceAlpha" stdDeviation="3"/>
            <feOffset dx="1" dy="1" result="offsetblur"/>
            <feMerge>
                <feMergeNode/>
                <feMergeNode in="SourceGraphic"/>
             </feMerge>
        </filter>
    </defs>
    <g>
        <title>Unten Mitte lang</title>
        <image xlink:href="{$image.url|ezurl( 'no' )}" id="svg-background-image-{$attributeID}" class="svg-background-image" height="{$image.height}" width="{$image.width}" y="0" x="0"/>
        <text filter="url(#svgDropShadowUML-{$attributeID})" font-size="50px" fill="#ffffff" font-family="AntennaExtraCond" id="svg-title1-{$attributeID}" text-anchor="middle" y="175" x="252.5" xml:space="preserve">Überschrift1</text>
        <text filter="url(#svgDropShadowUML-{$attributeID})" font-size="50px" fill="#ffffff" font-family="AntennaExtraCond" id="svg-title2-{$attributeID}" text-anchor="middle" y="221" x="252.5" xml:space="preserve">Überschrift2</text>
        <text filter="url(#svgDropShadowUML-{$attributeID})" font-size="12px" fill="#76B928" font-family="Antenna-Black" font-weight="bold" id="svg-kicker-{$attributeID}" text-anchor="middle" y="131" x="252.5" xml:space="preserve">DACHZEILE</text>
        <text filter="url(#svgDropShadowUML-{$attributeID})" font-size="22px" fill="#ffffff" font-family="AntennaExtraCond" id="svg-subtitle-{$attributeID}" text-anchor="middle" y="252" x="252.5" xml:space="preserve">Unterzeile</text>
    </g>
</svg>
{/if}