$(function () {
    $('#public-column').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: 'H&W Points'
        },
        subtitle: {
            text: "Monthly Goal: "+points_goal+" points"
        },
        labels: {
            style: {
                    color: "#3E576F"
            }
        },
        xAxis: {
            type: 'category',
            showEmpty: false
        },
        yAxis: {
            
            min: 0,
            title: {
                text: 'Points'
            },
            plotLines: [{
                color: 'grey',
                dashStyle: 'longDash',
                value: points_goal,
                width: 2
            }]
        },
        tooltip: {
            formatter: function() {
                    return this.key + ": " + this.y +' points';
                }
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            },
            series: {
                borderWidth: 0,
                dataLabels: {
                    enabled: true,
                    color: 'gray'
                }
            }
        },
        series: [{
            name: 'Monthly Point Averages',
            //colorByPoint: true,
            data: year_view
        
        }],
       drilldown: {
          series: month_view
          
       } 
    });
});