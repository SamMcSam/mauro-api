<?php


namespace App\Importer;


class SiteFetcher
{
    public function getCurrentWeekFromSite($refresh = true) {
        try {
            if ($refresh) {
                $client = new Client();
                $request = $client->get($this->url);
                $this->response = $request->send();
            }

            if (is_null($this->response)) {
                throw new \Exception("No response given.");
            }

            $crawler = new Crawler((string)$this->response->getBody());

            $title = $crawler
                ->filter('td:first-child')
            ;

            $titleString = $title->text();

            preg_match("#.*du .* au (.*)\r.*#", $titleString, $dates);

            // @todo IntlDateFormatter not working??
            $find = array('janvier', 'février', 'mars', 'avril', 'mai', 'juin', 'juillet', 'août', 'septembre', 'octobre', 'novembre', 'décembre');
            $replace = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
            $day = new \DateTime(str_replace($find, $replace, strtolower($dates[1])));

            $sunday = $day->sub(new \DateInterval('P'.$day->format('w').'D'));

            return $sunday;
        } catch (\Exception $e) {
            $this->logger->critical("[SITEFETCHER-weekdate] : " . $e->getMessage());
        }

        return null;
    }
}