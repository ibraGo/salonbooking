<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

class SLN_Admin_Reports_GoogleGraph {


	/**
	 * Data to graph
	 *
	 * @var array
	 */
	protected $data;


	/**
	 * Get things started
	 *
	 */
	public function __construct( $_data ) {

		$this->data = $_data;
	}

	/**
	 * Get graph data
	 *
	 */
	public function get_data() {
		return $this->data;
	}

	/**
	 * Load the graphing library script
	 *
	 */
	public static function enqueue_scripts() {
		wp_enqueue_script('google-charts', SLN_PLUGIN_URL.'/js/google.charts.loader.js');
	}

	/**
	 * Build the line graph and return it as a string
	 *
	 * @return string
	 */
	public function build_line_graph() {

		$data = $this->get_data();

		$labels_js = array();
		foreach ( array_merge($data['labels']['x'], $data['labels']['y']) as $label => $type ) {
			$labels_js[] = "data.addColumn('$type', '$label');";
		}

		$axes_js = array();
		$axes_i = 0;
		foreach ( $data['labels']['y'] as $label => $type ) {
			$axes_js[] = "$axes_i: {label: '$label'},";
			$axes_i++;
		}

		$series_js = array();
		$series_i = 0;
		foreach ( $data['labels']['y'] as $label => $type ) {
			$series_js[] = "$series_i: {axis: '$series_i'},";
			$series_i++;
		}

		$data_js = array();
		foreach ( $data['data'] as $item ) {
			$data_js[] = "['{$item[0]}',  {$item[1]},  {$item[2]}],";
		}

		ob_start();
		?>
		<script type="text/javascript">

			google.charts.load('current', {'packages':['line', 'corechart']});
			google.charts.setOnLoadCallback(drawChart);

			function drawChart() {
				var data = new google.visualization.DataTable();
				<?php echo implode(PHP_EOL, $labels_js) ?>

				data.addRows([
				<?php echo implode(PHP_EOL, $data_js) ?>
				]);

				var materialOptions = {
					chart: {
						title: '<?php echo $data['title'] ?>',
						subtitle: '<?php echo $data['subtitle'] ?>'
					},
					width: 900,
					height: 500,
					series: {
						// Gives each series an axis name that matches the Y-axis below.
						<?php echo implode(PHP_EOL, $series_js) ?>
					},
					axes: {
						// Adds labels to each axis; they don't have to match the axis names.
						y: {
							<?php echo implode(PHP_EOL, $axes_js) ?>
						}
					}
				};

				var materialChart = new google.charts.Line(document.getElementById('chart_div'));
				materialChart.draw(data, materialOptions);
			}

		</script>
		<div id="chart_div" style="width: 900px; height: 500px"></div>
		<?php
		return ob_get_clean();
	}

	public function build_bar_graph() {

		$data = $this->get_data();

		$axes_js = array();
		$axes_i = 0;
		foreach ( $data['labels']['x'] as $label => $type ) {
			$axes_options = $axes_i % 2 ? "" : "side: 'top'";
			$axes_js[] = "$axes_i: {label: '$label', $axes_options},";
			$axes_i++;
		}

		$series_js = array();
		$series_i = 0;
		foreach ( $data['labels']['x'] as $label => $type ) {
			$series_js[] = "$series_i: {axis: '$series_i'},";
			$series_i++;
		}


		$labels_js = array();
		foreach ( array_merge($data['labels']['y'], $data['labels']['x']) as $label => $type ) {
			$labels_js[] = "'$label'";
		}

		$data_js = array();
		$data_js[] = '[' . implode(',', $labels_js) . '],';
		foreach ( $data['data'] as $item ) {
			$data_js[] = "['{$item[0]}',  {$item[1]},  {$item[2]}],";
		}

		ob_start();
		?>
		<script type="text/javascript">
			google.charts.load('current', {'packages':['bar']});
			google.charts.setOnLoadCallback(drawStuff);

			function drawStuff() {
				var data = new google.visualization.arrayToDataTable([
					<?php echo implode(PHP_EOL, $data_js) ?>
				]);

				var options = {
					chart: {
						title: '<?php echo $data['title'] ?>',
						subtitle: '<?php echo $data['subtitle'] ?>'
					},
					bars: 'horizontal', // Required for Material Bar Charts.
					series: {
						<?php echo implode(PHP_EOL, $series_js) ?>
					},
					axes: {
						x: {
							<?php echo implode(PHP_EOL, $axes_js) ?>
						}
					}
				};

				var chart = new google.charts.Bar(document.getElementById('dual_x_div'));
				chart.draw(data, options);
			};

		</script>
		<div id="dual_x_div" style="width: 900px; height: 500px"></div>
		<?php
		return ob_get_clean();
	}

	/**
	 * Output the final line graph
	 *
	 */
	public function display_line() {
		echo $this->build_line_graph();
	}

	/**
	 * Output the final bar graph
	 *
	 */
	public function display_bar() {
		echo $this->build_bar_graph();
	}

}
