{if $image}
<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="{$image.width}" height="{$image.height}">
    <defs id="svg-filter-shadow-{$attributeID}">
        <filter id="svgDropShadowULL-{$attributeID}" height="130%">
            <feGaussianBlur in="SourceAlpha" stdDeviation="3"/>
            <feOffset dx="1" dy="1" result="offsetblur"/>
            <feMerge>
                <feMergeNode/>
                <feMergeNode in="SourceGraphic"/>
             </feMerge>
        </filter>
    </defs>
    <g>
        <title>Unten Links lang</title>
        <image xlink:href="{$image.url|ezurl( 'no' )}" class="svg-background-image" id="svg-background-image-{$attributeID}" height="{$image.height}" width="{$image.width}" y="0" x="0"/>
        <text filter="url(#svgDropShadowULL-{$attributeID})" font-size="50px" fill="#ffffff" font-family="AntennaExtraCond" id="svg-title1-{$attributeID}" text-anchor="left" y="178" x="15" xml:space="preserve">Überschrift1</text>
        <text filter="url(#svgDropShadowULL-{$attributeID})" font-size="50px" fill="#ffffff" font-family="AntennaExtraCond" id="svg-title2-{$attributeID}" text-anchor="left" y="223" x="15" xml:space="preserve">Überschrift2</text>
        <text filter="url(#svgDropShadowULL-{$attributeID})" font-size="12px" fill="#76B928" font-family="Antenna-Black" font-weight="bold" id="svg-kicker-{$attributeID}" text-anchor="left" y="125" x="100" xml:space="preserve">DACHZEILE</text>
        <text filter="url(#svgDropShadowULL-{$attributeID})" font-size="22px" fill="#ffffff" font-family="AntennaExtraCond" id="svg-subtitle-{$attributeID}" text-anchor="left" y="255" x="15" xml:space="preserve">Unterzeile</text>
    </g>
</svg>
{/if}