<h1> Neo Feed </h1>

<form action="/get-neo-feed" method="GET">
    <div class="row col-md-12">
			<div class="form-group">
				<label for="from_date">From:</label>
				<input type="date" id="from_date" name="from_date">
			</div>
			<div class="form-group">
				<label for="to_date">To:</label>
				<input type="date" id="to_date" name="to_date">
			</div>   
    	<button class="btn btn-danger" type="submit">Submit</button>
	</div>
</form>

-> Fastest Asteroid in km/h : {{ $max_speed }} in km/h
<br><br>
-> Closest Asteroid in kilometers : {{ $nearest }} in km
<br><br>
-> Average Size of the Asteroids in kilometers : {{ $avg_size }} in km
<br><br><br><br><br><br>


<h5>Graph:  Total number of asteroids for each day for the given date range.</h5>
<div class="col-md-6">
    <div id="linechart_material" style="width: 425px; height: 300px;"></div>
</div>




<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">

google.charts.load('current', {'packages':['bar']});
google.charts.setOnLoadCallback(drawChart1);    

function drawChart1() 
{    
    var values = [ {{ $dates }} ];    
                
    //values.push([value.month, value.boys, value.girls, value.total]);
                    

    var data1 = new google.visualization.arrayToDataTable(
                	 
        [ values ],
        // [value['month'], value['boys'] , value['girls'], value['total']],
        [30.9, 69.5, 32.4],
        

    );


    var options1 = {
    chart: {
      title: '',
      subtitle: ''
    },
    legend: { position: 'none', 
                alignment: 'end',   
            },
    colors: ['#e67300','#3BB300','red'],  

    vAxis: {
                gridlines: {
                    color: '#eee6ff', count: 1,
                }
            },        
    };

    var chart1 = new google.charts.Bar(document.getElementById('linechart_material'));
    chart1.draw(data1, google.charts.Bar.convertOptions(options1));   
}

</script> 
