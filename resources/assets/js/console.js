/*
 |--------------------------------------------------------------------------
 | Custom messages in the Browser Console.
 |--------------------------------------------------------------------------
 */
var width = "padding:5px 0;",
    infoPrimaryBackground = "background:#5ccc5c;",
    infoCornerBackground = "background:#a3f5a3;",
    infoTitle = "color:#a3f5a3;background:#2f4052;font-weight:bold;",
    messageInfo = [
        "\n %c  %c HELLO ! %c  %c  Don't forget that this website is open-source ! https://github.com/XetaIO/Xetaravel  %c  \n\n",
        infoPrimaryBackground + width,
        infoTitle + width,
        infoCornerBackground + width,
        "color:#fff;" + infoPrimaryBackground + width,
        infoCornerBackground + width
    ];

var warnPrimaryBackground = "background:#c22;",
    warnCornerBackground = "background:#e44;",
    warnTitle = "color:#e44;background:#2f4052;font-weight:bold;",
    messageWarn = [
        "\n %c  %c ATTENTION %c  %c  DONT RUN ANY SCRIPT HERE ! IT WILL HAVE FULL ACCESS TO YOUR BROWSER AND YOUR ACCOUNT ! https://en.wikipedia.org/wiki/Self-XSS  %c  \n\n",
        warnPrimaryBackground + width,
        warnTitle + width,
        warnCornerBackground + width,
        "color:#fff;" + warnPrimaryBackground + width,
        warnCornerBackground + width
    ];
console.log.apply(console, messageInfo);
console.log.apply(console, messageWarn);
