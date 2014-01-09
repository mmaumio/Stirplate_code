		<ul class="breadcrumb" style="padding-left:0;margin-bottom:0">
			<li><a href="/study/list">Studies</a> <span class="divider">/</span></li>
			<li><a href="/study/index/<?php echo $study->id ?>"><?php echo $study->title ?></a> <span class="divider">/</span></li>
			<li><a href="/project/index/<?php echo $project->id ?>"><?php echo $project->name ?></a> <span class="divider">/</span></li>
			<li><a href="/experiment/index/<?php echo $experiment->id ?>"><?php echo $experiment->name ?></a> <span class="divider">/</span></li>
		 	<li class="active">Results</li> 
		</ul>

		<div class="row-fluid">
			<div class="span12 projects" style="position:relative;">
				<h1 id="studyTitle" contenteditable="true" style="float:left;width:100%;">Results for: <?php echo $experiment->name ?></h1>
				<div class="clear"></div>
			</div>
		</div>

		<div class="clear">&nbsp;</div>

		<div class="row-fluid">
			<div class="span12 experiments">
				<div class="experiments-add">
					<h3 style="float:left">Summary</h3>
					<div class="clear"></div>
				</div>
			</div>
		</div>

		<div class="clear">&nbsp;</div>

		<div class="row-fluid">
			<div class="span4" style="position:relative;background-color:#fff;box-shadow: 0px 1px 5px lightgray;padding:10px;">
				<h3>Genes</h3>
				<ul>
					<?php foreach ($qpcr->genes as $gene => $value) { ?>
						<li><?php echo $gene ?></li>
					<?php } ?>
				</ul>
				<h3>Number of Samples</h3>
				<ul>
					<?php foreach ($qpcr->numSamples as $sample => $count) { ?>
						<li><?php echo $sample . ' ' . $count ?></li>
					<?php } ?>
				</ul>
				<h3>Samples Ommitted</h3>
				<ul>
					<?php foreach ($qpcr->ommittedSamples as $id => $value) { ?>
						<li><?php echo $id . ' ' . $value ?></li>
					<?php } ?>
				</ul>
			</div>


		<!--
		<a href="#" id="pieGraphLink">
            <div class="threegraph" style="margin-left:0">
                <div class="threegraph-inner"  style="margin-left:0;">
                    <div id="pieGraph" class="chartWrap" style="height:200px">
                        <svg></svg>
                    </div>
                </div>
            </div>
        </a>
    	-->
        	<div class="span8" style="position:relative;background-color:#fff;box-shadow: 0px 1px 5px lightgray;">
	            <div class="threegraph">
	                <div class="threegraph-inner">
	                    <div id="barGraph" class="chartWrap" style="height:300px;width:600px">
	                        <svg></svg>
	                    </div>
	                </div>
	            </div>

	            <div class="clear"></div>

	            <div class="threegraph">
	                <div class="threegraph-inner">
	                    <div id="scatterGraph" class="chartWrap" style="height:300px;width:600px">
	                        <svg></svg>
	                    </div>
	                </div>
	            </div>

        	</div>
        	
    	</div>


<script>
	$(document).ready(function() {

		var scatterChart,
		        barGraph,
		        pieChart;


		var jsondata = <?php echo $qpcr->resultsByBothJsonJson ?>;

		    nv.addGraph(function() {

		        scatterChart = nv.models.scatterChart()

		        	.showLegend(false)
		            .showDistX(true)
		            .showDistY(true)
		            .forceX([0,5])
		            .color(d3.scale.category10().range());


		        scatterChart.xAxis.tickValues([0,1,2,3,4,5]).tickFormat(function(d) {return '';});
		        scatterChart.yAxis.tickFormat(d3.format('.02f'))

				d3.select('#scatterGraph svg')
			        .datum(jsondata.data)
				    .transition().duration(500)
				    .call(scatterChart);

        		scatterChart.dispatch.on('stateChange', function(e) { nv.log('New State:', JSON.stringify(e)); });

        		return scatterChart;
    		});     

        	var jsondata2 = <?php echo $qpcr->avgByGenderGroupJson ?>;

   			nv.addGraph(function() {
        		
        		barGraph = nv.models.multiBarChart()
        			.showLegend(false);

        		barGraph.xAxis.tickValues(['Control', 'Stress']).tickFormat(function(d) {return d;});
	      
	      		d3.select('#barGraph svg')
	              .datum(jsondata2.data)
	              .transition().duration(500)
	              .call(barGraph);
	        
	        	return barGraph;
	    	});

	    	nv.addGraph(function() {
    		
	    		barGraph = nv.models.multiBarChart()
	    			.showLegend(false)
	    			.width(600)
	    			.height(350);

	    		barGraph.xAxis.tickFormat(function(d) {return d;});
	      
	      		d3.select('#bigBarGraph svg')
	              .datum(jsondata2.data)
	              .transition().duration(500)
	              .call(barGraph);
	        
	        	return barGraph;
    		});
     	
/*
		jsondata3 = <?php echo $qpcr->sumByBothJson; ?>;

			nv.addGraph(function() {

			    pieChart = nv.models.pieChart()
			    	.showLegend(false)
			        .x(function(d) { return d.key })
			        //.y(function(d) { return d.value })
			        .values(function(d) { return d })
			        //.labelThreshold(.08)
			        .showLabels(false)
			        .color(d3.scale.category10().range())
			        .donut(true);

			    //pieChart.pie
			    //    .startAngle(function(d) { return d.startAngle/2 -Math.PI/2 })
			    //    .endAngle(function(d) { return d.endAngle/2 -Math.PI/2 });

	      //chart.pie.donutLabelsOutside(true).donut(true);

	      		d3.select("#pieGraph svg")
	          //.datum(historicalBarChart)
	          		.datum([jsondata3.data])
	        		.transition().duration(1200)
	          		.call(pieChart);

	    		return pieChart;
			});
*/		


    });

</script>

<style>

		.experiments {
			margin:0;
		}
		.collaborators, .experiments-add{
			background: white;
		padding: 1%;
		box-sizing: border-box;
		box-shadow: 1px 1px 1px gray;
		border-radius: 2px;
		-webkit-box-shadow: 0 1px 0 1px #e4e6eb;
		-moz-box-shadow: 0 1px 0 1px #e4e6eb;
		box-shadow: 0 1px 0 1px #e4e6eb;
		}

</style>