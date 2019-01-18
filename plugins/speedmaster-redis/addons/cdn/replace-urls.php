<?php
namespace Speedmaster;

function replace_host($hosts, $url) {
  if (!defined('SPEEDMASTER__CDN_ENDPOINT')) 
    return $url;

  $cdn_url = SPEEDMASTER__CDN_ENDPOINT;

  if ($url[0] == '/') {
    $url = $cdn_url . $url;
    return $url;
  }

  foreach($hosts as $host) {
    $url = str_replace($host, $cdn_url, $url);
  }

  return $url;
}

function array_match($matches, $haystack) {
  foreach ($matches as $needle) {
    if (strpos($haystack, $needle) !== false) {
      return true;
    }
  }
  return false;
}

function array_matches($links, $attr = 'src') {
  $include = array('wp-content/uploads');
  $exclude = array();
  $hosts = array(site_url());

  $matches = [];

  foreach ($links as $link){
    $url = $link->getAttribute($attr);

    if (!array_match($include, $url)) {
      continue;
    }

    if (array_match($exclude, $url)) {
      continue;
    }

    if ($url[0] != '/' && !array_match($hosts, $url)) {
      continue;
    }

    $matches[] = array(
      'find' => $url,
      'replace' => replace_host($hosts, $url)
    );
  }

  return $matches;
}

add_filter('speedmaster__buffer', function($html) {
  if (!defined('SPEEDMASTER__CDN_ENDPOINT')) 
    return $html;

  $dom = new \DOMDocument;
  @$dom->loadHTML($html);

  $matches = [];
  $matches = array_merge($matches, array_matches($dom->getElementsByTagName('img'), 'src'));
  $matches = array_merge($matches, array_matches($dom->getElementsByTagName('link'), 'href'));
  $matches = array_merge($matches, array_matches($dom->getElementsByTagName('script'), 'src'));
  
  foreach ($matches as $match) {
    $html = str_replace('"'.$match['find'].'"', '"'.$match['replace'].'"', $html);
    $html = str_replace("'".$match['find']."'", "'".$match['replace']."'", $html);
  }

  // echo "<pre>";
  // print_r($matches);
  // die();

  return $html;
});
