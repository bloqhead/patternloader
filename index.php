<?php

require "vendor/autoload.php";

use Michelf\Markdown;

/**
 * Loads up a pattern and parses out any "@varname value" comments, removing those lines.
 *
 * @param  string $filename
 * @access public
 * @return void
 */
function load_pattern($filename)
{
    $data = array();
    $file_contents = file_get_contents($filename);
    $mustache = new Mustache_Engine;
    $datafile = dirname($filename) . '/' . basename($filename, '.mustache') . '.json';
    if (file_exists($datafile)) {
        // TODO: Multiple data files
        $datacontents = file_get_contents($datafile);
        $data = json_decode(file_get_contents($datafile));
        if (is_array($data)) {
            $rendered = array();
            foreach ($data as $item) {
                $rendered[] = $mustache->render($file_contents, $item);
            }
        }
    }
    if (!isset($rendered)) {
        $rendered = $mustache->render($file_contents, $data);
    }

    return array( $file_contents, $data, $rendered );
}

?><!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="description" content="A design pattern library experiment.">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Design Pattern Loader</title>

    <!-- Highlight.js theme -->
    <link rel="stylesheet" href="system/css/highlight.css">

    <!-- Custom app styles -->
    <link rel="stylesheet" href="public/assets/css/styles.css">

    <!-- Pattern Library Loader base theme - DON'T REMOVE THIS! -->
    <link rel="stylesheet" href="system/css/pattern-library.css">

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="system/assets/js/jquery-1.10.2.min.js"><\/script>')</script>
    <script type="text/javascript" src="system/js/highlight.pack.js"></script>
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
    $json = json_decode(file_get_contents('project.json'), true);
    $patterns = glob('public/patterns/*.mustache');
    ?>

    <div id="patternContainer">
      <header>
        <div class="inner">

          <h1>
            Pattern Library<?php if (!empty($json['name'])) { echo ' for ' . $json['name']; }; ?>
          <?php if (!empty($json['website'])) : ?>
              &mdash; <a href="<?php echo $json['website']; ?>">View website</a>
          <?php endif; ?>
          </h1>

          <div class="controls">
            <select class="pattern-jump-nav">
        <?php foreach ($patterns as $filename) :
            $anchor = str_replace('.mustache', '', strtolower(str_replace('public/patterns/', '', $filename)));
        ?>
              <option value="<?= $anchor ?>"><?= $anchor ?></option>
        <?php endforeach; ?>
            </select>
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
    foreach ($patterns as $filename) {
        list( $contents, $vars, $rendered ) = load_pattern($filename);
        $id = str_replace('public/patterns/', '', $filename);
        $anchor = str_replace('.mustache', '', strtolower($id));
        ?>
     <div class="patternWrap" id="<?php echo $anchor; ?>">
          <header>
            <a class="show-code" href="#">Toggle Code</a>
            <h2><a href="<?php echo '#' . $anchor; ?>"><?php echo '#' . $anchor; ?></a> &mdash; <code><?php echo $id; ?></code></h2>
          </header>
          <div class="codeDrawer">
            <pre><code><?php echo htmlspecialchars($contents); ?></code></pre>
          </div>
        <?php if (!is_array($rendered)) {
            $rendered = array($rendered);
} ?>
        <?php foreach ($rendered as $render) : ?>
          <div class="patternItem">
        <?php
        // output the contents
        echo $render;
        ?>
          </div>
        <?php endforeach; ?>

        <?php
        // load up the notes file for the pattern if it exists
        $docfile = 'public/patterns/' . $anchor . '.md';
        if (file_exists($docfile)) {
            $docs = file_get_contents($docfile);
            $processed = Markdown::defaultTransform($docs); ?>
        <div class="patternDocs">
         <h3>Notes on this pattern:</h3>
            <?= $processed ?>
        </div>
        <?php
        } // docfile exists?>

     </div>
    <?php
    } ?>

    </div>

    <script type="text/javascript">
    jQuery( function($) {
      /**
       * Highlight.js
       */
      $('pre code').each( function(i,e) {
          hljs.highlightBlock(e);
      });

      /**
       * Raw toggler
       */
      $('.show-code').on( 'click', function(e) {
        $(this).parents('.patternWrap').find('.codeDrawer').toggleClass('is_open');
        e.stopPropagation();
        return false;
      });

      /**
       * Pattern numb nav
       */
      $('.pattern-jump-nav').on('change', function() {
        var position = $( '#' + $(this).val() ).offset().top;
        window.scroll(0, position - 60);
      });

    });
    </script>

        <!-- Your custom scripts -->
    <script src="public/assets/js/build.js"></script>

  </body>
</html>
