<?php

/*
 * Footer scripts
 * Speedmaster Optimizer
 *
 * Move <script></script> tags found in HTML to footer below scripts.
*/

add_filter('speedmaster__buffer', function ($html) {

  $buffer = $html;
  preg_match_all('#<!--(.*?)-->#is', $buffer, $matches);
  foreach($matches[0] as $comment) {
    $buffer = str_replace($comment, '', $buffer);
  }

  preg_match_all('#<script(.*?)</script>#is', $buffer, $matches);

  $speedmaster_script_tags_in_footer = "";
  $embed = "";
  $scripts = "";
  foreach ($matches[0] as $string) {
    if (strpos($string, "src=") !== false) {
      $embed .= $string;
    } else {
      $scripts .= $string;
    }

    $html = str_replace($string, '', $html);
  }

  $html = str_replace('</body>', $embed . "\n" . $scripts . "\n</body>", $html);

  return $html;
});