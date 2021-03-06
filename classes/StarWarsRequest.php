<?php

class StarWarsRequest {

    private $url = 'https://swapi.dev/api/';
    private $response;

    /**
     * @param $req
     * @param null $nextPage
     * @return mixed
     */
    public function executeRequest($req, $nextPage = null) {

        $fullUrl = is_null($nextPage) ? $this->url.$req : $nextPage;

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL,$fullUrl);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true );
        curl_setopt($curl,CURLOPT_USERAGENT, $this->getRandomUserAgent());
        $this->response = curl_exec($curl);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        if ($httpCode !== 200){
            die('Request blocked!'. $fullUrl);
        }

        return json_decode($this->response, true);
    }


    /**
     * @return mixed
     */
    public function getRandomUserAgent()
    {
        $userAgents=array(
            "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-GB; rv:1.8.1.6) Gecko/20070725 Firefox/2.0.0.6",
            "Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1)",
            "Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; .NET CLR 1.1.4322; .NET CLR 2.0.50727; .NET CLR 3.0.04506.30)",
            "Opera/9.20 (Windows NT 6.0; U; en)",
            "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; en) Opera 8.50",
            "Mozilla/4.0 (compatible; MSIE 6.0; MSIE 5.5; Windows NT 5.1) Opera 7.02 [en]",
            "Mozilla/5.0 (Macintosh; U; PPC Mac OS X Mach-O; fr; rv:1.7) Gecko/20040624 Firefox/0.9",
            "Mozilla/5.0 (Macintosh; U; PPC Mac OS X; en) AppleWebKit/48 (like Gecko) Safari/48"
        );
        $random = rand(0,count($userAgents)-1);

        return $userAgents[$random];
    }


}
