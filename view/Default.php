	<script type="text/javascript">
	$(document).ready(function(){
		/* setup navigation, content boxes, etc... */
		Administry.setup();
		
		/* progress bar animations - setting initial values */
		Administry.progress("#progress1", 1, 5);
		Administry.progress("#progress2", 2, 5);
		Administry.progress("#progress3", 2, 5);
	
		/* flot graphs */
		var sales = [{
			label: 'Total Paid',
			data: [[1, 0],[2,0],[3,0],[4,0],[5,0],[6,0],[7,900],[8,0],[9,0],[10,0],[11,0],[12,0]]
		},{
			label: 'Total Due',
			data: [[1, 0],[2,0],[3,0],[4,0],[5,0],[6,422.10],[7,0],[8,0],[9,0],[10,0],[11,0],[12,0]]
		}
		];
	
		var plot = $.plot($("#placeholder"), sales, {
			bars: { show: true, lineWidth: 1 },
			legend: { position: "nw" },
			xaxis: { ticks: [[1, "Jan"], [2, "Feb"], [3, "Mar"], [4, "Apr"], [5, "May"], [6, "Jun"], [7, "Jul"], [8, "Aug"], [9, "Sep"], [10, "Oct"], [11, "Nov"], [12, "Dec"]] },
			yaxis: { min: 0, max: 1000 },
			grid: { color: "#666" },
			colors: ["#0a0", "#f00"]			
	    });
	
	
	});
	</script>

	<!-- Page title -->
	<div id="pagetitle">
		<div class="wrapper">
			<h1>Visão Geral</h1>
			<!-- Quick search box -->
			<form action="" method="get"><input class="" type="text" id="q" name="q" /></form>
		</div>
	</div>
	<!-- End of Page title -->
	
	<!-- Page content -->
	<div id="page">
		<!-- Wrapper -->
		<div class="wrapper">
				<!-- Left column/section -->
				<section class="column width8 first">
					<div class="colgroup leading">
						<div class="column width4 first">
							<h3>Próximos eventos</h3>
							<p>
								You are currently signed up to the <b>Free Trial Plan</b>.<br /><a href="#">Upgrade now?</a>
							</p>
						</div>
						<div class="column width4">
							<h4>Último login</h4>
							<p>
								<?php echo(ucfirst(Data::getDataHoraExtenso()) .', origem '. $_SERVER['REMOTE_ADDR']); ?>
							</p>
						</div>
					</div>

					<div class="colgroup leading">
						<div class="column width4 first">
							<hr/>
							<table class="no-style full">
								<tbody>
									<tr>
										<td>Total Invoices</td>
										<td class="ta-right"><a href="#">10</a></td>
										<td class="ta-right">1,322.10 &euro;</td>
									</tr>
									<tr>
										<td>Total Paid</td>
										<td class="ta-right"><a href="#">9</a></td>
										<td class="ta-right">900.00 &euro;</td>
									</tr>
									<tr>
										<td>Total Due</td>
										<td class="ta-right"><a href="#">1</a></td>
										<td class="ta-right">422.10 &euro;</td>
									</tr>
									<tr>
										<td>Total Overdue</td>
										<td class="ta-right">0</td>
										<td class="ta-right">0.00 &euro;</td>
									</tr>
								</tbody>
							</table>
						</div>

						<div class="column width4">
							<hr/>
							<h4>Sales: <a href="#">1</a></h4>
							<p><b>Sales this year</b></p>

							<hr/>
							<h4>Sales: <a href="#">1</a></h4>
							<p><b>Sales this year</b></p>

							<hr/>
							<h4>Sales: <a href="#">1</a></h4>
							<p><b>Sales this year</b></p>
						</div>
					</div>

					<div class="clear">&nbsp;</div>
				</section>
				<!-- End of Left column/section -->
		</div>
		<!-- End of Wrapper -->
	</div>
	<!-- End of Page content -->