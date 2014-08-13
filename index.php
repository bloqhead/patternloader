<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="description" content="A design pattern library experiment.">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Pattern Library</title>
		<link rel="stylesheet" href="pattern-library.css">
		<!-- Add your custom stylesheet below -->
		<!-- <link rel="stylesheet" href="assets/css/style.css"> -->
	</head>
	<body id="patternLib">

		<?php
		/**
		 * Project Info
		 */
		$json = json_decode( file_get_contents( 'project.json' ), true );
		?>

		<div id="patternContainer">

			<header>
				<h1>
					<?php echo $json['name']; ?> Pattern Library
					<?php if( !empty( $json['website'] ) ) : ?>
						&mdash; <a href="<?php echo $json['website']; ?>">View website</a>
					<?php endif; ?>
				</h1>
			</header>

			<?php
			/**
			 * Pattern Loader
			 */
			foreach ( glob( 'patterns/*.html' ) as $filename ) {
				echo '<div class="patternItem">';
				include $filename;
				echo '</div>';
			}
			?>

		</div>

	</body>
</html>