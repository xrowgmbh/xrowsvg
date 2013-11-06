{if $image}
<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="{$image.width}" height="{$image.height}">
    <defs id="svg-filter-shadow-{$attributeID}">
        <filter id="svgDropShadowOLK-{$attributeID}" height="130%">
            <feGaussianBlur in="SourceAlpha" stdDeviation="3"/>
            <feOffset dx="1" dy="1" result="offsetblur"/>
            <feMerge>
                <feMergeNode/>
                <feMergeNode in="SourceGraphic"/>
             </feMerge>
        </filter>
    </defs>
    <g>
        <title>Oben Links kurz</title>
        <image xlink:href="{$image.url|ezurl( 'no' )}" class="svg-background-image" id="svg-background-image-{$attributeID}" height="{$image.height}" width="{$image.width}" y="0" x="0"/>
        <text filter="url(#svgDropShadowOLK-{$attributeID})" font-size="50px" fill="#ffffff" font-family="AntennaExtraCond" id="svg-title-{$attributeID}" text-anchor="left" y="85" x="35" xml:space="preserve">Überschrift</text>
        <text filter="url(#svgDropShadowOLK-{$attributeID})" font-size="12px" fill="#76B928" font-family="Antenna-Black" font-weight="bold" id="svg-kicker-{$attributeID}" text-anchor="left" y="34" x="100" xml:space="preserve">DACHZEILE</text>
        <text filter="url(#svgDropShadowOLK-{$attributeID})" font-size="22px" fill="#ffffff" font-family="AntennaExtraCond" id="svg-subtitle-{$attributeID}" text-anchor="left" y="115" x="35" xml:space="preserve">Unterzeile</text>
    </g>
</svg>
{/if}