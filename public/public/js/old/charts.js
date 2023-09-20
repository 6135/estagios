var amChartsChartsDemo = function() {
    var chartpr;
    var chartprmm;

    var init = function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    }

    /*
                "dataProvider": [
                {
                    "country": "Lithuania",
                    "litres": 50
                },
                {
                    "country": "Czech Republic",
                    "litres": 50
                }
            ],
     */

    var demo12 = function() {
        chartpr = AmCharts.makeChart("m_amcharts_12", {
            "type": "pie",
            "theme": "light",
            "dataProvider": getPieData(),
            "valueField": "estagios",
            "titleField": "ano",
            "balloon": {
                "fixedPosition": true
            },
            "export": {
                "enabled": true
            }
        });
    }

    var demo13 = function() {
        chartpr = AmCharts.makeChart("m_amcharts_13", {
            "type": "pie",
            "theme": "light",
            "dataProvider": getPieDataEstagiosPorCurso(),
            "valueField": "estagios",
            "titleField": "curso",
            "balloon": {
                "fixedPosition": true
            },
            "export": {
                "enabled": true
            }
        });
    }

    function getData2() {
        $.ajax({
            type: "POST",
            url: "/su/json/chartprmm",
            data: JSON.stringify(''),
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            success: function(data) {
                console.log('Received data:');
                console.log(data);
                return data;
            },
            error: function(errMsg) {
                console.log('Received errMsg:');
                console.log(errMsg);
            }
        });
    }

    var chartData = [];

    var demo2 = function() {
        chartprmm = AmCharts.makeChart("m_amcharts_2", {
            "dataProvider": getData(),
            //"dataProvider": loadEstagiosChartData(),
            //"dataProvider": [],
            "type": "serial",
            "addClassNames": true,
            "theme": "light",
            "autoMargins": false,
            "marginLeft": 30,
            "marginRight": 8,
            "marginTop": 10,
            "marginBottom": 26,
            "balloon": {
                "adjustBorderColor": false,
                "horizontalPadding": 10,
                "verticalPadding": 8,
                "color": "#ffffff"
            },
            "valueAxes": [{
                "axisAlpha": 0,
                "position": "left"
            }],
            "startDuration": 1,
            "graphs": [{
                "alphaField": "alpha",
                "balloonText": "<span style='font-size:12px;'>[[title]] in [[category]]:<br><span style='font-size:20px;'>[[value]]</span> [[additional]]</span>",
                "fillAlphas": 1,
                "title": "Income",
                "type": "column",
                "valueField": "income",
                "dashLengthField": "dashLengthColumn"
            }, {
                "id": "graph2",
                "balloonText": "<span style='font-size:12px;'>[[title]] in [[category]]:<br><span style='font-size:20px;'>[[value]]</span> [[additional]]</span>",
                "bullet": "round",
                "lineThickness": 3,
                "bulletSize": 7,
                "bulletBorderAlpha": 1,
                "bulletColor": "#FFFFFF",
                "useLineColorForBulletBorder": true,
                "bulletBorderThickness": 3,
                "fillAlphas": 0,
                "lineAlpha": 1,
                "title": "Expenses",
                "valueField": "expenses",
                "dashLengthField": "dashLengthLine"
            }],
            "categoryField": "year",
            "categoryAxis": {
                "gridPosition": "start",
                "axisAlpha": 0,
                "tickLength": 0
            },
            "export": {
                "enabled": true
            }
        });
    }

    var loadChartData = function() {
        $.ajax({
            type: "POST",
            url: "/su/json/chartpr",
            data: JSON.stringify(''),
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            success: function (data) {
                console.log('Received data (chartpr) :');
                console.log(data);
                chartpr.dataProvider = data;
                chartpr.validateData();
            },
            error: function (errMsg) {
                console.log('Received errMsg:');
                console.log(errMsg);
            }
        });

    }

    var loadEstagiosChartData = function() {

        $.ajax({
            type: "POST",
            url: "/su/json/chartprmm",
            data: JSON.stringify(''),
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            success: function(data) {
                chartData = [];
                var aux = "";

                $.each(data , function(index, val) {
                    console.log(index, val)
                });

                console.log(chartData);

                chartprmm.validateData();
            },
            error: function(errMsg) {
                console.log('Received errMsg:');
                console.log(errMsg);
            }
        });
    }

    return {
        init: function() {
            init();
            demo12();
            demo13();
            demo2();

            setInterval(function() {
                loadEstagiosChartData();
            }, 2500);
        }
    };
}();

jQuery(document).ready(function() {
    amChartsChartsDemo.init();
});