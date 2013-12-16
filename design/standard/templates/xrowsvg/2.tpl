{if $image}
<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="{$image.width}" height="{$image.height}">
    <defs id="svg-filter-shadow-{$attributeID}">
        <filter id="svgDropShadowUMK-{$attributeID}" height="130%">
            <feGaussianBlur in="SourceAlpha" stdDeviation="3"/>
            <feOffset dx="1" dy="1" result="offsetblur"/>
            <feMerge>
                <feMergeNode/>
                <feMergeNode in="SourceGraphic"/>
             </feMerge>
        </filter>
    </defs>
    <defs id="svg-linear-gradient-{$attributeID}">
        <linearGradient id="svgGradientUMK-{$attributeID}" spreadMethod="pad" x1="1" y1="1" x2="1" y2="0">
            <stop stop-color="#76b928" offset="0"/>
            <stop stop-color="#ffffff" offset="1" stop-opacity="0"/>
        </linearGradient>
    </defs>
    <g>
        <title>Unten Mitte kurz</title>
        <image xlink:href="{$image.url|ezurl( 'no' )}" class="svg-background-image" id="svg-background-image-{$attributeID}" height="{$image.height}" width="{$image.width}" y="0" x="0"/>
        <rect fill="url(#svgGradientUMK-{$attributeID})" x="0" y="185" width="505" height="95" id="svg-gradient-{$attributeID}" />
        <text filter="url(#svgDropShadowUMK-{$attributeID})" font-size="60px" fill="#ffffff" font-family="AntennaExtraCond" id="svg-title-{$attributeID}" text-anchor="middle" y="222" x="252.5" xml:space="preserve">Überschrift</text>
        <text filter="url(#svgDropShadowUMK-{$attributeID})" font-size="12px" fill="#76B928" font-family="Antenna-Black" font-weight="bold" id="svg-kicker-{$attributeID}" text-anchor="middle" y="175" x="252.5" xml:space="preserve">DACHZEILE</text>
        <text filter="url(#svgDropShadowUMK-{$attributeID})" font-size="22px" fill="#ffffff" font-family="AntennaExtraCond" id="svg-subtitle-{$attributeID}" text-anchor="middle" y="254" x="252.5" xml:space="preserve">Unterzeile</text>
    </g>
</svg>
{/if}