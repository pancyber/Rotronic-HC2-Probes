<html lang="en">

<?php 
	$url = "http://" . $_SERVER['SERVER_NAME'] . "/data.php";
	$chart_title = 'Rotronic HC2 Probe';
?>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
  <script src="https://code.highcharts.com/highcharts.js"></script>
  <script src="https://code.highcharts.com/modules/data.js"></script>
  <script src="https://code.highcharts.com/modules/no-data-to-display.js"></script>
  <script src="https://code.highcharts.com/modules/exporting.js"></script>
  <script src="https://code.highcharts.com/modules/export-data.js"></script>
  
  <title><?php echo $chart_title ?></title>
</head>
  <body>
    	<div id="container"></div>
  
    <script>
    var data_url = '<?php echo $url ?>';
    function createChart() {
        Highcharts.setOptions({
            time: {
                timezoneOffset: 0
            }
        });
        
    	Highcharts.chart('container', {
        	chart: {
           		type: 'line'
        	},
        	title: {text: '<?php echo $chart_title ?>'},
        	yAxis: [{
                index: 0,
      			title: {text: "<strong>Relative Humidity</strong>", useHTML:true},
            	labels: {format: "{value} %"},            
            	opposite: false
        	}, {
                index: 1,
      			title: {text: "<strong>Temperature, Dew Point</strong>", useHTML:true},
            	labels: {format: "{value} °C"},  
            	opposite: true
        	}],
        	data: {
            	rowsURL: data_url,
            	enablePolling: true,
            	dataRefreshRate:30,
            	firstRowAsNames: false
            	},
        	series: [{
        	    yAxis:0,
        	    type: "area",
            	name: "Relative Humidity",
            	marker: {enabled: false},
            	color: "#33cc3322"
            },{
                yAxis:1,
            	name: "Temperature",
            	marker: {enabled: false},
            	color: "#ff0000"
            }, {
                yAxis:1,
            	name: 'Dew Point', 
            	marker: {enabled: false},
            	color: "#0000ff"
            }],
            exporting: {
                buttons: {
                    contextButton: {
                        menuItems: ["printChart",
                                    "separator",
                                    "downloadPNG",
                                    "downloadJPEG",
                                    "downloadPDF",
                                    "downloadSVG",
                                    "separator",
                                    "downloadCSV",
                                    "downloadXLS",
                                    //"viewData",
                                    "openInCloud"]
      }
    }
  },
        	plotOptions: {
        		column: {
            		stacking: 'normal',
            		dataLabels: {enabled: false}
        		}
            }});    
	}
// Create the chart
	createChart();
  </script>
  </body>
</html>
