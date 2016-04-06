$(function () {
    $('#profile-column').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: 'Monthly Point Totals'
        },
        subtitle: {
            text: "Monthly Goal: "+points_goal+" points"
        },        
        xAxis: {
            categories: ytd_months  
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
                //label: {
                //    text: 'Points Goal - '+points_goal,
                //    style: {
                //        size: '14px',
                //        color: 'white',
                //        fontWeight: 'bold'
                //    }
                //}
            }]
        },
        tooltip: {
            formatter: function() {
                    return ''+
                        this.x +': '+ this.y +' points';
                }
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            }
        },
        series: [{
            name: $('.navbar-nav .badge').text(),
            data: consistency_series
        
        }]
            
    });
});

//[350,559,631,735,1081,1431,1087,564,1592,1726,316,30]