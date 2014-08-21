<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="description" content="A design pattern library experiment.">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<title>Design Pattern Loader</title>

		<!-- Highlight.js theme -->
		<link rel="stylesheet" href="assets/css/highlight/monoblue.css">

		<!-- Add your custom stylesheet(s) below -->
		<!-- <link rel="stylesheet" href="assets/css/custom/your-styles-here.css"> -->

		<!-- Pattern Library Loader base theme - DON'T REMOVE THIS! -->
		<link rel="stylesheet" href="assets/css/pattern-library.css">

		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
		<script>window.jQuery || document.write('<script src="assets/js/jquery-1.10.2.min.js"><\/script>')</script>
		<script type="text/javascript" src="assets/js/highlight.pack.js"></script>
	</head>
	<body id="patternLib">

		<?php
		/**
		 * Project Info
		 *
		 * Change this based on your project details.
		 * This is a cosmetic thing to customize on
		 * a per-project basis.
		 */
		$json = json_decode( file_get_contents( 'project.json' ), true );
		?>

		<div id="patternContainer">

			<header>
				<div class="inner">
					<h1>
						Pattern Library<?php if( !empty( $json['name'] ) ) { echo ' for ' . $json['name']; }; ?>
						<?php if( !empty( $json['website'] ) ) : ?>
							&mdash; <a href="<?php echo $json['website']; ?>">View website</a>
						<?php endif; ?>
					</h1>
					<div class="controls">
						<a class="toggle-raw">Toggle Raw</a>
					</div>
				</div>
			</header>

			<?php
			/**
			 * Pattern Loader
			 *
			 * This will automatically load in any
			 * patterns that are dumped into the
			 * /patterns/ directory.
			 */
			foreach ( glob( 'patterns/*.html' ) as $filename ) {
				$id = str_replace( 'patterns/', '', $filename );
				$anchor = str_replace( '.html', '', strtolower( $id ) );
				?>
				<div class="patternWrap" id="<?php echo $anchor; ?>">
					<header>
						<h2><a href="<?php echo '#' . $anchor; ?>"><?php echo '#' . $anchor; ?></a> &mdash; <code><?php echo $id; ?></code></h2>
					</header>
					<div class="patternItem">
						<?php include $filename; ?>
					</div>
					<pre><code><?php echo htmlspecialchars( file_get_contents( $filename ) ); ?></code></pre>
				</div>
			<?php } ?>

		</div>

		<script type="text/javascript">
		$( function() {
			/**
			 * Highlight.js
			 */
			$('pre code').each(
				function( i, e ) {
					hljs.highlightBlock(e)
				}
			);

			/**
			 * Raw toggler
			 */
			$('.controls .toggle-raw').on( 'click', function() {
				$('.patternWrap').each( function() {
					$(this).find('pre').toggleClass('inactive');
					$(this).find('.patternItem').toggleClass('fullWidth');
				});
			});
		});
		</script>

	</body>
</html>