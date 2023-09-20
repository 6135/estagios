<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>{{ config('app.title') }}</title>
    @include('emails.style')

    <style type="text/css">
        /* Take care of image borders and formatting, client hacks */
        img {
            max-width: 600px;
            outline: none;
            text-decoration: none;
            -ms-interpolation-mode: bicubic;
        }

        a img {
            border: none;
        }

        table {
            border-collapse: collapse !important;
        }

        #outlook a {
            padding: 0;
        }

        .ReadMsgBody {
            width: 100%;
        }

        .ExternalClass {
            width: 100%;
        }

        .backgroundTable {
            margin: 0 auto;
            padding: 0;
            width: 100% !important;
        }

        table td {
            border-collapse: collapse;
        }

        .ExternalClass * {
            line-height: 115%;
        }

        .container-for-gmail-android {
            min-width: 600px;
        }


        /* General styling */
        * {
            font-family: Helvetica, Arial, sans-serif;
        }

        body {
            -webkit-font-smoothing: antialiased;
            -webkit-text-size-adjust: none;
            width: 100% !important;
            margin: 0 !important;
            height: 100%;
            color: #676767;
        }

        td {
            font-family: Helvetica, Arial, sans-serif;
            font-size: 14px;
            color: #777777;
            text-align: center;
            line-height: 21px;
        }

        a {
            color: #676767;
            text-decoration: none !important;
        }

        .pull-left {
            text-align: left;
        }

        .pull-right {
            text-align: right;
        }

        .header-lg,
        .header-md,
        .header-sm {
            font-size: 32px;
            font-weight: 700;
            line-height: normal;
            padding: 35px 0 0;
            color: #4d4d4d;
        }

        .header-md {
            font-size: 24px;
        }

        .header-sm {
            padding: 5px 0;
            font-size: 18px;
            line-height: 1.3;
        }

        .content-padding {
            padding: 20px 0 5px;
        }

        .mobile-header-padding-right {
            width: 290px;
            text-align: right;
            padding-left: 10px;
        }

        .mobile-header-padding-left {
            width: 290px;
            text-align: left;
            padding-left: 10px;
        }

        .free-text {
            width: 100% !important;
            padding: 10px 60px 0px;
        }

        .button {
            padding: 30px 0;
        }


        .mini-block {
            border: 1px solid #e5e5e5;
            border-radius: 5px;
            background-color: #ffffff;
            padding: 12px 15px 15px;
            text-align: left;
            width: 253px;
        }

        .mini-container-left {
            width: 278px;
            padding: 10px 0 10px 15px;
        }

        .mini-container-right {
            width: 278px;
            padding: 10px 14px 10px 15px;
        }

        .product {
            text-align: left;
            vertical-align: top;
            width: 175px;
        }

        .total-space {
            padding-bottom: 8px;
            display: inline-block;
        }

        .item-table {
            padding: 50px 20px;
            width: 560px;
        }

        .item {
            width: 300px;
        }

        .mobile-hide-img {
            text-align: left;
            width: 125px;
        }

        .mobile-hide-img img {
            border: 1px solid #e6e6e6;
            border-radius: 4px;
        }

        .title-dark {
            text-align: left;
            border-bottom: 1px solid #cccccc;
            color: #4d4d4d;
            font-weight: 700;
            padding-bottom: 5px;
        }

        .item-col {
            padding-top: 20px;
            text-align: left;
            vertical-align: top;
        }

        .force-width-gmail {
            min-width: 600px;
            height: 0px !important;
            line-height: 1px !important;
            font-size: 1px !important;
        }
    </style>

    <style type="text/css" media="screen">
        @import url(http://fonts.googleapis.com/css?family=Oxygen:400,700);
    </style>

    <style type="text/css" media="screen">
        @media screen {

            /* Thanks Outlook 2013! */
            * {
                font-family: 'Oxygen', 'Helvetica Neue', 'Arial', 'sans-serif' !important;
            }
        }
    </style>

    <style type="text/css" media="only screen and (max-width: 480px)">
        /* Mobile styles */
        @media only screen and (max-width: 480px) {

            table[class*="container-for-gmail-android"] {
                min-width: 290px !important;
                width: 100% !important;
            }

            img[class="force-width-gmail"] {
                display: none !important;
                width: 0 !important;
                height: 0 !important;
            }

            table[class="w320"] {
                width: 320px !important;
            }


            td[class*="mobile-header-padding-left"] {
                width: 160px !important;
                padding-left: 0 !important;
            }

            td[class*="mobile-header-padding-right"] {
                width: 160px !important;
                padding-right: 0 !important;
            }

            td[class="header-lg"] {
                font-size: 24px !important;
                padding-bottom: 5px !important;
            }

            td[class="content-padding"] {
                padding: 5px 0 5px !important;
            }

            td[class="button"] {
                padding: 5px 5px 30px !important;
            }

            td[class*="free-text"] {
                padding: 10px 18px 30px !important;
            }

            td[class~="mobile-hide-img"] {
                display: none !important;
                height: 0 !important;
                width: 0 !important;
                line-height: 0 !important;
            }

            td[class~="item"] {
                width: 140px !important;
                vertical-align: top !important;
            }

            td[class~="quantity"] {
                width: 50px !important;
            }

            td[class~="price"] {
                width: 90px !important;
            }

            td[class="item-table"] {
                padding: 30px 20px !important;
            }

            td[class="mini-container-left"],
            td[class="mini-container-right"] {
                padding: 0 15px 15px !important;
                display: block !important;
                width: 290px !important;
            }
        }
    </style>
</head>

<body bgcolor="#f7f7f7" class="vh-100 h-100">
    <table align="center" cellpadding="0" cellspacing="0" class="container-for-gmail-android vh-100 h-100" width="100%" >
        <tr>
            <td align="center" valign="top" width="100%" style="background-color: #f7f7f7;" class="content-padding">
                <center>
                    <table cellspacing="0" cellpadding="0" width="600" class="w320">
                        <tr>
                            <td class="header-lg">
                                <strong style="color: rgb(8, 161, 227)">{{__('static.emails.account.confirmation.title')}}</strong>
                                <div class="header-md pt-0 mt-0 pb-5" style="color: rgb(8, 161, 227)">{{__('static.emails.account.confirmation.subtitle')}}</div>
                            </td>
                        </tr>
                        <tr>
                            <td class="free-text">
                                {{__('static.emails.account.confirmation.body')}}
                                <br /><br /><br />
                                {{__('static.emails.account.confirmation.conclusion')}}
                        </td>
                    </tr>
                    <tr>
                        <td class="button">
                            <div>
                                <a href="{{$url ?? ''}}"
                                    style="accent-color: auto;
                                    align-content: normal;
                                    align-items: normal;
                                    align-self: auto;
                                    animation-delay: 0s;
                                    animation-direction: normal;
                                    animation-duration: 0s;
                                    animation-fill-mode: none;
                                    animation-iteration-count: 1;
                                    animation-name: none;
                                    animation-play-state: running;
                                    animation-timing-function: ease;
                                    appearance: none;
                                    aspect-ratio: auto;
                                    backdrop-filter: none;
                                    backface-visibility: visible;
                                    background-attachment: scroll;
                                    background-blend-mode: normal;
                                    background-clip: border-box;
                                    background-color: rgb(8, 161, 227);
                                    background-image: none;
                                    background-origin: padding-box;
                                    background-position-x: 0%;
                                    background-position-y: 0%;
                                    background-repeat: repeat;
                                    background-size: auto;
                                    block-size: 35.2px;
                                    border-block-end-color: rgb(8, 161, 227);
                                    border-block-end-style: solid;
                                    border-block-end-width: 0.8px;
                                    border-block-start-color: rgb(8, 161, 227);
                                    border-block-start-style: solid;
                                    border-block-start-width: 0.8px;
                                    border-bottom-color: rgb(8, 161, 227);
                                    border-bottom-left-radius: 6px;
                                    border-bottom-right-radius: 6px;
                                    border-bottom-style: solid;
                                    border-bottom-width: 0.8px;
                                    border-collapse: collapse;
                                    border-end-end-radius: 6px;
                                    border-end-start-radius: 6px;
                                    border-image-outset: 0;
                                    border-image-repeat: stretch;
                                    border-image-slice: 100%;
                                    border-image-source: none;
                                    border-image-width: 1;
                                    border-inline-end-color: rgb(8, 161, 227);
                                    border-inline-end-style: solid;
                                    border-inline-end-width: 0.8px;
                                    border-inline-start-color: rgb(8, 161, 227);
                                    border-inline-start-style: solid;
                                    border-inline-start-width: 0.8px;
                                    border-left-color: rgb(8, 161, 227);
                                    border-left-style: solid;
                                    border-left-width: 0.8px;
                                    border-right-color: rgb(8, 161, 227);
                                    border-right-style: solid;
                                    border-right-width: 0.8px;
                                    border-spacing: 0px 0px;
                                    border-start-end-radius: 6px;
                                    border-start-start-radius: 6px;
                                    border-top-color: rgb(8, 161, 227);
                                    border-top-left-radius: 6px;
                                    border-top-right-radius: 6px;
                                    border-top-style: solid;
                                    border-top-width: 0.8px;
                                    bottom: auto;
                                    box-decoration-break: slice;
                                    box-shadow: none;
                                    box-sizing: border-box;
                                    break-after: auto;
                                    break-before: auto;
                                    break-inside: auto;
                                    caption-side: bottom;
                                    caret-color: rgb(255, 255, 255);
                                    clear: none;
                                    clip: auto;
                                    clip-path: none;
                                    clip-rule: nonzero;
                                    color: rgb(255, 255, 255);
                                    color-interpolation: srgb;
                                    color-interpolation-filters: linearrgb;
                                    color-scheme: normal;
                                    column-count: auto;
                                    column-fill: balance;
                                    column-gap: normal;
                                    column-rule-color: rgb(255, 255, 255);
                                    column-rule-style: none;
                                    column-rule-width: 0px;
                                    column-span: none;
                                    column-width: auto;
                                    contain: none;
                                    contain-intrinsic-block-size: none;
                                    contain-intrinsic-height: none;
                                    contain-intrinsic-inline-size: none;
                                    contain-intrinsic-width: none;
                                    container-name: none;
                                    container-type: normal;
                                    content: normal;
                                    counter-increment: none;
                                    counter-reset: none;
                                    counter-set: none;
                                    cursor: pointer;
                                    cx: 0px;
                                    cy: 0px;
                                    d: none;
                                    direction: ltr;
                                    display: inline-block;
                                    dominant-baseline: auto;
                                    empty-cells: show;
                                    fill: rgb(0, 0, 0);
                                    fill-opacity: 1;
                                    fill-rule: nonzero;
                                    filter: none;
                                    flex-basis: auto;
                                    flex-direction: row;
                                    flex-grow: 0;
                                    flex-shrink: 1;
                                    flex-wrap: nowrap;
                                    float: none;
                                    flood-color: rgb(0, 0, 0);
                                    flood-opacity: 1;
                                    font-family: 'Oxygen', 'Helvetica Neue', 'Arial', 'sans-serif';
                                    font-feature-settings: normal;
                                    font-kerning: auto;
                                    font-language-override: normal;
                                    font-optical-sizing: auto;
                                    font-palette: normal;
                                    font-size: 14.4px;
                                    font-size-adjust: none;
                                    font-stretch: 100%;
                                    font-style: normal;
                                    font-synthesis-small-caps: auto;
                                    font-synthesis-style: auto;
                                    font-synthesis-weight: auto;
                                    font-variant-alternates: normal;
                                    font-variant-caps: normal;
                                    font-variant-east-asian: normal;
                                    font-variant-ligatures: normal;
                                    font-variant-numeric: normal;
                                    font-variant-position: normal;
                                    font-variation-settings: normal;
                                    font-weight: 400;
                                    forced-color-adjust: auto;
                                    grid-auto-columns: auto;
                                    grid-auto-flow: row;
                                    grid-auto-rows: auto;
                                    grid-column-end: auto;
                                    grid-column-start: auto;
                                    grid-row-end: auto;
                                    grid-row-start: auto;
                                    grid-template-areas: none;
                                    grid-template-columns: none;
                                    grid-template-rows: none;
                                    height: 35.2px;
                                    hyphenate-character: auto;
                                    hyphens: manual;
                                    image-orientation: from-image;
                                    image-rendering: auto;
                                    ime-mode: auto;
                                    inline-size: 88.85px;
                                    inset-block-end: auto;
                                    inset-block-start: auto;
                                    inset-inline-end: auto;
                                    inset-inline-start: auto;
                                    isolation: auto;
                                    justify-content: normal;
                                    justify-items: normal;
                                    justify-self: auto;
                                    left: auto;
                                    letter-spacing: normal;
                                    lighting-color: rgb(255, 255, 255);
                                    line-break: auto;
                                    line-height: 21.6px;
                                    list-style-image: none;
                                    list-style-position: outside;
                                    list-style-type: disc;
                                    margin-block-end: 0px;
                                    margin-block-start: 0px;
                                    margin-bottom: 0px;
                                    margin-inline-end: 0px;
                                    margin-inline-start: 0px;
                                    margin-left: 0px;
                                    margin-right: 0px;
                                    margin-top: 0px;
                                    marker-end: none;
                                    marker-mid: none;
                                    marker-start: none;
                                    mask-clip: border-box;
                                    mask-composite: add;
                                    mask-image: none;
                                    mask-mode: match-source;
                                    mask-origin: border-box;
                                    mask-position-x: 0%;
                                    mask-position-y: 0%;
                                    mask-repeat: repeat;
                                    mask-size: auto;
                                    mask-type: luminance;
                                    max-block-size: none;
                                    max-height: none;
                                    max-inline-size: none;
                                    max-width: none;
                                    min-block-size: 0px;
                                    min-height: 0px;
                                    min-inline-size: 0px;
                                    min-width: 0px;
                                    mix-blend-mode: normal;
                                    object-fit: fill;
                                    object-position: 50% 50%;
                                    offset-anchor: auto;
                                    offset-distance: 0px;
                                    offset-path: none;
                                    offset-rotate: auto;
                                    opacity: 1;
                                    order: 0;
                                    outline-color: rgb(255, 255, 255);
                                    outline-offset: 0px;
                                    outline-style: none;
                                    outline-width: 0px;
                                    overflow-anchor: auto;
                                    overflow-block: visible;
                                    overflow-clip-margin: 0px;
                                    overflow-inline: visible;
                                    overflow-wrap: normal;
                                    overflow-x: visible;
                                    overflow-y: visible;
                                    overscroll-behavior-block: auto;
                                    overscroll-behavior-inline: auto;
                                    overscroll-behavior-x: auto;
                                    overscroll-behavior-y: auto;
                                    padding-block-end: 6px;
                                    padding-block-start: 6px;
                                    padding-bottom: 6px;
                                    padding-inline-end: 12px;
                                    padding-inline-start: 12px;
                                    padding-left: 12px;
                                    padding-right: 12px;
                                    padding-top: 6px;
                                    page: auto;
                                    paint-order: normal;
                                    perspective: none;
                                    perspective-origin: 44.425px 17.6px;
                                    pointer-events: auto;
                                    position: static;
                                    print-color-adjust: economy;
                                    quotes: auto;
                                    r: 0px;
                                    resize: none;
                                    right: auto;
                                    rotate: none;
                                    row-gap: normal;
                                    ruby-align: space-around;
                                    ruby-position: alternate;
                                    rx: auto;
                                    ry: auto;
                                    scale: none;
                                    scroll-behavior: auto;
                                    scroll-margin-block-end: 0px;
                                    scroll-margin-block-start: 0px;
                                    scroll-margin-bottom: 0px;
                                    scroll-margin-inline-end: 0px;
                                    scroll-margin-inline-start: 0px;
                                    scroll-margin-left: 0px;
                                    scroll-margin-right: 0px;
                                    scroll-margin-top: 0px;
                                    scroll-padding-block-end: auto;
                                    scroll-padding-block-start: auto;
                                    scroll-padding-bottom: auto;
                                    scroll-padding-inline-end: auto;
                                    scroll-padding-inline-start: auto;
                                    scroll-padding-left: auto;
                                    scroll-padding-right: auto;
                                    scroll-padding-top: auto;
                                    scroll-snap-align: none;
                                    scroll-snap-stop: normal;
                                    scroll-snap-type: none;
                                    scrollbar-color: auto;
                                    scrollbar-gutter: auto;
                                    scrollbar-width: auto;
                                    shape-image-threshold: 0;
                                    shape-margin: 0px;
                                    shape-outside: none;
                                    shape-rendering: auto;
                                    stop-color: rgb(0, 0, 0);
                                    stop-opacity: 1;
                                    stroke: none;
                                    stroke-dasharray: none;
                                    stroke-dashoffset: 0px;
                                    stroke-linecap: butt;
                                    stroke-linejoin: miter;
                                    stroke-miterlimit: 4;
                                    stroke-opacity: 1;
                                    stroke-width: 1px;
                                    tab-size: 8;
                                    table-layout: auto;
                                    text-align: center;
                                    text-align-last: auto;
                                    text-anchor: start;
                                    text-combine-upright: none;
                                    text-decoration-color: rgb(255, 255, 255);
                                    text-decoration-line: none;
                                    text-decoration-skip-ink: auto;
                                    text-decoration-style: solid;
                                    text-decoration-thickness: auto;
                                    text-emphasis-color: rgb(255, 255, 255);
                                    text-emphasis-position: over;
                                    text-emphasis-style: none;
                                    text-indent: 0px;
                                    text-justify: auto;
                                    text-orientation: mixed;
                                    text-overflow: clip;
                                    text-rendering: auto;
                                    text-shadow: none;
                                    text-transform: none;
                                    text-underline-offset: auto;
                                    text-underline-position: auto;
                                    top: auto;
                                    touch-action: auto;
                                    transform: none;
                                    transform-box: border-box;
                                    transform-origin: 44.425px 17.6px;
                                    transform-style: flat;
                                    transition-delay: 0s, 0s, 0s, 0s;
                                    transition-duration: 0.15s, 0.15s, 0.15s, 0.15s;
                                    transition-property: color, background-color, border-color, box-shadow;
                                    transition-timing-function: ease-in-out, ease-in-out, ease-in-out, ease-in-out;
                                    translate: none;
                                    unicode-bidi: normal;
                                    user-select: none;
                                    vector-effect: none;
                                    vertical-align: middle;
                                    visibility: visible;
                                    white-space: normal;
                                    width: 88.85px;
                                    will-change: auto;
                                    word-break: normal;
                                    word-spacing: 0px;
                                    writing-mode: horizontal-tb;
                                    x: 0px;
                                    y: 0px;
                                    z-index: auto;
                                    -moz-box-align: stretch;
                                    -moz-box-direction: normal;
                                    -moz-box-flex: 0;
                                    -moz-box-ordinal-group: 1;
                                    -moz-box-orient: horizontal;
                                    -moz-box-pack: start;
                                    -moz-float-edge: content-box;
                                    -moz-force-broken-image-icon: 0;
                                    -moz-orient: inline;
                                    -moz-text-size-adjust: none;
                                    -moz-user-focus: none;
                                    -moz-user-input: auto;
                                    -moz-user-modify: read-only;
                                    -moz-window-dragging: default;
                                    -webkit-line-clamp: none;
                                    -webkit-text-fill-color: rgb(255, 255, 255);
                                    -webkit-text-stroke-color: rgb(255, 255, 255);
                                    -webkit-text-stroke-width: 0px;">{{__('static.emails.account.confirmation.button')}}</a>
                            </div>
                        </td>
                    </tr>
                </table>
            </center>
        </td>
    </tr>
</table>
</body>

</html>
