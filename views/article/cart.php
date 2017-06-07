<!--<!DOCTYPE html>-->
<!--<head>-->
<!--    <meta charset="utf-8">-->
<!--    <title>ECharts</title>-->
<!--</head>-->
<!--<body>-->
<!--<!-- 为ECharts准备一个具备大小（宽高）的Dom -->-->
<!--<div id="main" style="height:400px"></div>-->
<!--<!-- ECharts单文件引入 -->-->
<!--<script src="http://echarts.baidu.com/build/dist/echarts.js"></script>-->
<!--<script type="text/javascript">-->
<!--    // 路径配置-->
<!--        require.config({-->
<!--            paths: {-->
<!--                echarts: 'http://echarts.baidu.com/build/dist'-->
<!--            }-->
<!--        });-->
<!---->
<!--        // 使用-->
<!--        require(-->
<!--            [-->
<!--                'echarts',-->
<!--                //'echarts/chart/bar' // 使用柱状图就加载bar模块，按需加载-->
<!--                'echarts/chart/line'-->
<!--            ],-->
<!--            function (ec) {-->
<!--                // 基于准备好的dom，初始化echarts图表-->
<!--                var myChart = ec.init(document.getElementById('main'));-->
<!---->
<!--                var option = {-->
<!--                    tooltip: {-->
<!--                        show: true-->
<!--                    },-->
<!--                    legend: {-->
<!--                        data: ['销量']-->
<!--                    },-->
<!--                    xAxis: [-->
<!--                        {-->
<!--                            type: 'category',-->
<!--                            data: ["衬衫", "羊毛衫", "雪纺衫", "裤子", "高跟鞋", "袜子"]-->
<!--                        }-->
<!--                    ],-->
<!--                    yAxis: [-->
<!--                        {-->
<!--                            type: 'value'-->
<!--                        }-->
<!--                    ],-->
<!--                    series: [-->
<!--                        {-->
<!--                            "name": "销量",-->
<!--                            "type": "line",-->
<!--                            "data": [5, 20, 40, 10, 10, 20]-->
<!--                        }-->
<!--                    ]-->
<!--                };-->

<!--                // 为echarts对象加载数据-->
<!--                myChart.setOption(option);-->
<!--            }-->
<!--        );-->
<!--</script>-->
<!--</body>-->
<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <title>ECharts</title>
</head>
<body>
<!-- 为ECharts准备一个具备大小（宽高）的Dom -->
<div id="main" style="height:400px"></div>
<br>
<hr>
<div id="main1" style="height:400px"></div>
<!-- ECharts单文件引入 -->
<script type="text/javascript">
    // 基于准备好的dom，初始化echarts图表
    var myChart = echarts.init(document.getElementById('main'));
    var myChart1 = echarts.init(document.getElementById('main1'));
    option = {
        title : {
            text: '预算 vs 开销（Budget vs spending）',
            subtext: '纯属虚构'
        },
        tooltip : {
            trigger: 'axis'
        },
        legend: {
            orient : 'vertical',
            x : 'right',
            y : 'bottom',
            data:['预算分配（Allocated Budget）','实际开销（Actual Spending）']
        },
        toolbox: {
            show : true,
            feature : {
                mark : {show: true},
                dataView : {show: true, readOnly: false},
                restore : {show: true},
                saveAsImage : {show: true}
            }
        },
        polar : [
            {
                indicator : [
                    { text: '销售（sales）', max: 6000},
                    { text: '管理（Administration）', max: 16000},
                    { text: '信息技术（Information Techology）', max: 30000},
                    { text: '客服（Customer Support）', max: 38000},
                    { text: '研发（Development）', max: 52000},
                    { text: '市场（Marketing）', max: 25000}
                ]
            }
        ],
        calculable : true,
        series : [
            {
                name: '预算 vs 开销（Budget vs spending）',
                type: 'radar',
                data : [
                    {
                        value : [4300, 10000, 28000, 35000, 50000, 19000],
                        name : '预算分配（Allocated Budget）'
                    },
                    {
                        value : [5000, 14000, 28000, 31000, 42000, 21000],
                        name : '实际开销（Actual Spending）'
                    }
                ]
            }
        ]
    };
    myChart.setOption(option);

    option1 = {
        title : {
            text: '未来一周气温变化',
            subtext: '纯属虚构'
        },
        tooltip : {
            trigger: 'axis'
        },
        legend: {
            data:['最高气温','最低气温']
        },
        toolbox: {
            show : true,
            feature : {
                mark : {show: true},
                dataView : {show: true, readOnly: false},
                magicType : {show: true, type: ['line', 'bar']},
                restore : {show: true},
                saveAsImage : {show: true}
            }
        },
        calculable : true,
        xAxis : [
            {
                type : 'category',
                boundaryGap : false,
                data : ['周一','周二','周三','周四','周五','周六','周日']
            }
        ],
        yAxis : [
            {
                type : 'value',
                axisLabel : {
                    formatter: '{value} °C'
                }
            }
        ],
        series : [
            {
                name:'最高气温',
                type:'line',
                data:[11, 11, 15, 13, 12, 13, 10],
                markPoint : {
                    data : [
                        {type : 'max', name: '最大值'},
                        {type : 'min', name: '最小值'}
                    ]
                },
                markLine : {
                    data : [
                        {type : 'average', name: '平均值'}
                    ]
                }
            },
            {
                name:'最低气温',
                type:'line',
                data:[1, -2, 2, 5, 3, 2, 0],
                markPoint : {
                    data : [
                        {name : '周最低', value : -2, xAxis: 1, yAxis: -1.5}
                    ]
                },
                markLine : {
                    data : [
                        {type : 'average', name : '平均值'}
                    ]
                }
            }
        ]
    };

    // 为echarts对象加载数据
    myChart1.setOption(option1);

</script>
</body>