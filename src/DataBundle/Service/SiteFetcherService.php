<?php

namespace DataBundle\Service;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Guzzle\Http\Client;
use Symfony\Component\DomCrawler\Crawler;

/**
 * Crawls to the site and fetches entries
 */
class SiteFetcherService extends Controller
{
  protected $url;

  protected $logger;

  function __construct($url, $logger) {
    $this->url = $url;
    $this->logger = $logger;
  }

  function getCurrentMenuFromSite() {
    try {
      $client = new Client();
      $request = $client->get("asda".$this->url);
      $response = $request->send();

      $crawler = new Crawler((string)$response->getBody());

      $tds = $crawler
        ->filter('td:not(:first-child):not(:last-child)')
      ;

      $daySelections = [];

      // each day
      foreach ($tds as $domElement) {
          // @TODO parse p
          $daySelections[] = $domElement->nodeValue;
      }

      return $daySelections;
    } catch (\Exception $e) {
      $this->logger->critical("[SITEFETCHER] : " . $e->getMessage());
    }

    return null;
  }
}
