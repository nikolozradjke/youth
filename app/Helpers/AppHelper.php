<?php
namespace App\Helpers;

class AppHelper
{
      public static function shortenURLs($url, $limit=50)
      {
            if(strlen($url) > 50)
                  return substr($url, 0, $limit) . "...";
             return $url;
      }

      public static function formatUrl($url)
      {
            if (!$url) {
                  return null;
            }
            if (substr($url, 0, 7) !== "http://" && substr($url, 0, 8) !== "https://") {
                  $url = "http://" . $url;
            }
            return $url;
      }
}