$(function() {
    "use strict";

    $('.sparkbar-small').sparkline('html', { type: 'bar', height: '47px', barWidth: 5 });    
    
    setTimeout(function(){
        // Rainfall and Evaporation
        var option = {};
        var rainFall = getChart("echart-rainfall");
        option = {
            legend: {
                data:['Revenue','Profit'],
                bottom: '0',
            },
            tooltip : {
                trigger: 'axis'
            },        
            calculable : true,

            xAxis : {
                type : 'category',
                data : ['Jan','Feb','Mar','Apr','May','Jun','July','Aug','Sept','Oct','Nov','Dec'],
                axisLine:{
                    lineStyle:{
                        color: ArrOwlite.colors["gray-100"],
                    }
                },
                axisLabel: {
                    color: ArrOwlite.colors["gray-700"],
                }
            },
            yAxis : {
                type : 'value',
                splitLine: {
                    lineStyle:{
                        color: ArrOwlite.colors["gray-100"],
                    }
                },
                axisLine:{
                    lineStyle:{
                        color: ArrOwlite.colors["gray-100"],
                    }
                },
                axisLabel: {
                    color: ArrOwlite.colors["gray-700"],
                }
            },
            series : [
                {
                    name:'Revenue',
                    type:'bar',
                    color: '#0b4eb1',
                    data:[2.0, 4.9, 7.0, 23.2, 25.6, 76.7, 135.6, 162.2, 32.6, 20.0, 6.4, 3.3],
                    markPoint : {
                        data : [
                            {type : 'max', name: 'Max'},
                            {type : 'min', name: 'Min'}
                        ]
                    },
                    markLine : {
                        data : [
                            {type : 'average', name: 'Average'}
                        ]
                    }
                },
                {
                    name:'Profit',
                    type:'bar',
                    color: '#288cff',
                    data:[2.6, 5.9, 9.0, 26.4, 28.7, 70.7, 175.6, 182.2, 48.7, 18.8, 6.0, 2.3],
                    markPoint : {
                        data : [
                            {name : 'Highest', value : 182.2, xAxis: 7, yAxis: 183},
                            {name : 'Minimum', value : 2.3, xAxis: 11, yAxis: 3}
                        ]
                    },
                    markLine : {
                        data : [
                            {type : 'average', name : 'Average'}
                        ]
                    }
                }
            ]
        };
        if (option && typeof option === "object") {
            rainFall.setOption(option, true);
        }
        $(window).on('resize', function(){
            rainFall.resize();
        });
        
        $(document).ready(function(){
            var chart = c3.generate({
                bindto: '#chart-pie', // id of chart wrapper
                data: {
                    columns: [
                        // each columns data
                        ['data1', 55],
                        ['data2', 25],
                        ['data3', 20],
                    ],
                    type: 'pie', // default type of chart
                    colors: {
                        'data1': ArrOwlite.colors["blue-dark"],
                        'data2': ArrOwlite.colors["blue-darkest"],
                        'data3': ArrOwlite.colors["blue"],
                    },
                    names: {
                        // name of each serie
                        'data1': 'Arizona',
                        'data2': 'Florida',
                        'data3': 'Texas',
                    }
                },
                axis: {
                },
                legend: {
                    show: true, //hide legend
                },
                padding: {
                    bottom: 0,
                    top: 0
                },
            });
        });

        function getChart(id){
            var dom = document.getElementById(id);
            return echarts.init(dom);
        }
    }, 100);

    setTimeout(function(){
        "use strict";
        var mapData = {
            "US": 298,
            "SA": 200,
            "AU": 760,
            "IN": 2000000,
            "GB": 120,        
        };	
        if( $('#world-map-markers').length > 0 ){
            $('#world-map-markers').vectorMap({
                map: 'world_mill_en',
                backgroundColor: 'transparent',
                borderColor: '#fff',
                borderOpacity: 0.25,
                borderWidth: 0,
                color: '#e6e6e6',
                regionStyle : {
                    initial : {
                    fill : '#e6e6e6'
                    }
                },
    
                markerStyle: {
                initial: {
                            r: 5,
                            'fill': '#fff',
                            'fill-opacity':1,
                            'stroke': '#000',
                            'stroke-width' : 1,
                            'stroke-opacity': 0.4
                        },
                    },
            
                markers : [{
                    latLng : [21.00, 78.00],
                    name : 'INDIA : 350'
                
                },
                {
                    latLng : [-33.00, 151.00],
                    name : 'Australia : 250'
                    
                },
                {
                    latLng : [36.77, -119.41],
                    name : 'USA : 250'
                
                },
                {
                    latLng : [55.37, -3.41],
                    name : 'UK   : 250'
                
                },
                {
                    latLng : [25.20, 55.27],
                    name : 'UAE : 250'
                
                }],
    
                series: {
                    regions: [{
                        values: {
                            "US": '#0b4eb1',
                            "SA": '#FF9948',
                            "AU": '#FF9948',
                            "IN": '#0b4eb1',
                            "GB": '#FF9948',
                        },
                        attribute: 'fill'
                    }]
                },
                hoverOpacity: null,
                normalizeFunction: 'linear',
                zoomOnScroll: false,
                scaleColors: ['#000000', '#000000'],
                selectedColor: '#000000',
                selectedRegions: [],
                enableZoom: false,
                hoverColor: '#fff',
            });
        }
    }, 100);
});
