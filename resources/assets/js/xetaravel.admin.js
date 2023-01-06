require('./bootstrap');

$(document).ready(function () {
    "use strict";

    /**
     * Console
     */
    let consoleGreenTitle = 'color:#a3f5a3;background:#2f4052;font-weight:bold;';
    let consoleGreenMessage = "\n %c  %c HELLO ! %c  %c  Don't forget that this website is open-source ! https://github.com/XetaIO/Xetaravel  %c  \n\n";
    let consoleGreenWidth = 'padding:5px 0;';
    let consoleGreenColor = 'color:#fff;';
    let consoleGreenPrimaryBackground = 'background:#5ccc5c;';
    let consoleGreenCornerBackground = 'background:#a3f5a3;';

    console.log.apply(console, [
        consoleGreenMessage,
        consoleGreenPrimaryBackground + consoleGreenWidth,
        consoleGreenTitle + consoleGreenWidth,
        consoleGreenCornerBackground + consoleGreenWidth,
        consoleGreenColor + consoleGreenPrimaryBackground + consoleGreenWidth,
        consoleGreenCornerBackground + consoleGreenWidth
    ]);

    let consoleRedTitle = 'color:#e44;background:#2f4052;font-weight:bold;';
    let consoleRedMessage = "\n %c  %c ATTENTION %c  %c  DONT RUN ANY SCRIPT HERE ! IT WILL HAVE FULL ACCESS TO YOUR BROWSER AND YOUR ACCOUNT ! https://en.wikipedia.org/wiki/Self-XSS  %c  \n\n";
    let consoleRedWidth = 'padding:5px 0;';
    let consoleRedColor = 'color:#fff;';
    let consoleRedPrimaryBackground = 'background:#c22;';
    let consoleRedCornerBackground = 'background:#e44;';

    console.log.apply(console, [
        consoleRedMessage,
        consoleRedPrimaryBackground + consoleRedWidth,
        consoleRedTitle + consoleRedWidth,
        consoleRedCornerBackground + consoleRedWidth,
        consoleRedColor + consoleRedPrimaryBackground + consoleRedWidth,
        consoleRedCornerBackground + consoleRedWidth
    ]);

    /**
     * Bootstrap
     */
    $("body").tooltip({
        selector: "[data-toggle=tooltip]"
    });

    $('[data-toggle="popover"]').popover({
        template: '<div class="popover" role="tooltip"><div class="popover-arrow"></div><h3 class="popover-title text-body-primary"></h3><div class="popover-content text-body-primary"></div></div>'
    });

    /**
     * ScrollUp.
     */
    $.scrollUp({
        scrollName: "scrollUp",
        scrollDistance: 300,
        scrollFrom: "top",
        scrollSpeed: 1000,
        easingType: "easeInOutCubic",
        animation: "fade",
        animationInSpeed: 200,
        animationOutSpeed: 200,
        scrollText: '<i class="fa fa-chevron-up"></i>',
        scrollTitle: " ",
        scrollImg: 0,
        activeOverlay: 0,
        zIndex: 1001
    });
});

var getMonthName = function(a) {
    var b = [];
    return b[0] = "Jan", b[1] = "Feb", b[2] = "Mar", b[3] = "Apr", b[4] = "May", b[5] = "Jun", b[6] = "Jul", b[7] = "Aug", b[8] = "Sep", b[9] = "Oct", b[10] = "Nov", b[11] = "Dec", b[a]
};
global.VisitorsLineCharts = function(data) {
    "use strict";

    // Colors
    var a = "#00acac",
        b = "#f4645f",
        e = "rgba(0,0,0,0.6)",
        f = "rgba(255,255,255,0.4)";

    // Morris
    Morris.Line({
        element: "visitors-line-chart",
        data: data,
        xkey: "x",
        ykeys: ["y", "z"],
        xLabels: "day",
        labels: ["Visitors", "Page Views"],
        lineColors: [a, b],
        pointFillColors: [a, b],
        lineWidth: "2px",
        pointStrokeColors: [e, e],
        resize: !0,
        gridTextFamily: "Arial",
        gridTextColor: f,
        gridTextWeight: "normal",
        gridTextSize: "11px",
        gridLineColor: "rgba(0,0,0,0.5)",
        hideHover: "auto"
    });
};
global.BrowsersDonutChart = function(data) {
    "use strict";

    // Colors
    var a = "#00acac",
        b = "#f4645f",
        c = "#727cb6",
        d = "#348fe2",
        e = "#75e376";

    // Morris
    Morris.Donut({
        element: "browsers-donut-chart",
        data: data,
        colors: [a, b, c, d, e],
        labelFamily: "Arial",
        labelColor: "rgba(255,255,255,0.4)",
        labelTextSize: "12px",
        backgroundColor: "#373a3c"
    });
};
global.VisitorsVectorMap = function(data) {
    "use strict";

    0 !== $("#visitors-map").length && $("#visitors-map").vectorMap({
        map: "world_merc_en",
        container: $("#visitors-map"),
        normalizeFunction: "linear",
        hoverOpacity: .5,
        hoverColor: !1,
        zoomAnimate: true,
        markerStyle: {
            initial: {
                fill: "#4cabc7",
                stroke: "transparent",
                r: 3
            }
        },
        regions: [{
            attribute: "fill"
        }],
        regionStyle: {
            initial: {
                fill: "rgb(97,109,125)",
                "fill-opacity": 1,
                stroke: "none",
                "stroke-width": .4,
                "stroke-opacity": 1
            },
            hover: {
                "fill-opacity": .8
            },
            selected: {
                fill: "yellow"
            },
            selectedHover: {}
        },
        regionLabelStyle: {
            initial: {
                'font-family': 'sans-serif',
                'font-size': '12',
                'font-weight': 'bold',
                cursor: 'default',
                fill: 'rgba(0, 0, 0, 0.4)'
            },
            hover: {
                cursor: 'pointer'
            }
        },
        series: {
            regions: [{
                scale: ['#ffd4d0', '#e74c3c'],
                values: data,
                attribute: "fill",
            }]
        },
        focusOn: {
            x: .5,
            y: .5,
            scale: 2
        },
        backgroundColor: "#2d353c",
        onRegionTipShow: function(event, label, code) {
            label.html(
              '<p class="mb-0 text-xs-center">'+label.html()+'</p>' +
              '<b>Page Views: </b>' + data[code]
            );
        }
    })
};
global.DevicesAreaChart = function(data) {
    "use strict";

    Morris.Area({
        element: "devices-line-chart",
        data: data,
        xkey: "period",
        ykeys: ["Apple", "Samsung", "Google", "HTC", "Microsoft"],
        labels: ["Apple", "Samsung", "Google", "HTC", "Microsoft"],
        xLabelFormat: function (a) {
            var month = getMonthName(a.getMonth());
            var year = a.getFullYear();

            return month + ' ' + year;
        },
        pointSize: 2,
        hideHover: "auto",
        resize: true,
        lineColors: ['#00acac', '#e74c3c', '#727cb6', '#348fe2', '#75e376']
    })
};
global.OperatingSystemBarChart = function(data) {
    "use strict";

    Morris.Bar({
        element: "operating-system-bar-chart",
        data: data,
        xkey: "period",
        ykeys: ["Windows", "Macintosh", "Linux", "(not set)"],
        labels: ["Windows", "Macintosh", "Linux", "Others"],
        barRatio: .4,
        xLabelAngle: 35,
        hideHover: "auto",
        resize: true,
        stacked: true,
        barColors: ['#00acac', '#e74c3c', '#727cb6', '#348fe2'],
        xLabelFormat: function (a) {
            a = new Date(a.label);
            var month = getMonthName(a.getMonth());
            var year = a.getFullYear();

            return month + ' ' + year;
        }
    })
};
