{if $image}
<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="{$image.width}" height="{$image.height}">
    <defs id="svg-filter-shadow-{$attributeID}">
        <filter id="svgDropShadowULK-{$attributeID}" height="130%">
            <feGaussianBlur in="SourceAlpha" stdDeviation="3"/>
            <feOffset dx="1" dy="1" result="offsetblur"/>
            <feMerge>
                <feMergeNode/>
                <feMergeNode in="SourceGraphic"/>
             </feMerge>
        </filter>
    </defs>
    <g>
        <title>Unten Links kurz</title>
        <image xlink:href="{$image.url|ezurl( 'no' )}" class="svg-background-image" id="svg-background-image-{$attributeID}" height="{$image.height}" width="{$image.width}" y="0" x="0"/>
        <text filter="url(#svgDropShadowULK-{$attributeID})" font-size="60px" fill="#ffffff" font-family="AntennaExtraCond" id="svg-title-{$attributeID}" text-anchor="left" y="220" x="15" xml:space="preserve">Überschrift</text>
        <text filter="url(#svgDropShadowULK-{$attributeID})" font-size="12px" fill="#76B928" font-family="Antenna-Black" font-weight="bold" id="svg-kicker-{$attributeID}" text-anchor="left" y="169" x="100" xml:space="preserve">DACHZEILE</text>
        <text filter="url(#svgDropShadowULK-{$attributeID})" font-size="22px" fill="#ffffff" font-family="AntennaExtraCond" id="svg-subtitle-{$attributeID}" text-anchor="left" y="252" x="15" xml:space="preserve">Unterzeile</text>
    </g>
</svg>
{/if}