<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="description" content="A design pattern library experiment.">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<title>Design Pattern Library Autoloader</title>

		<link rel="stylesheet" href="assets/css/highlight-mono-blue.css">
		<link rel="stylesheet" href="assets/css/pattern-library.css">

		<!-- Add your custom stylesheet below -->
		<!-- <link rel="stylesheet" href="assets/css/custom/style.css"> -->

		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
		<script>window.jQuery || document.write('<script src="js/vendor/jquery-1.10.2.min.js"><\/script>')</script>
		<script type="text/javascript" src="assets/js/highlight.pack.js"></script>
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
			foreach ( glob( 'patterns/*.html' ) as $filename ) { ?>
				<div class="patternWrap">
					<div class="patternItem">
						<?php include $filename; ?>
					</div>
					<pre><code><?php echo htmlspecialchars( file_get_contents( $filename ) ); ?></code></pre>
				</div>
			<?php } ?>

		</div>

		<script type="text/javascript">
		$( function() {
			$('pre code').each( function( i, e ) { hljs.highlightBlock(e) } );
		});
		</script>
	</body>
</html>