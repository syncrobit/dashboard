<?php
/**
 * Created by SyncroBit.
 * Author: George Partene
 * Version: 0.1
 */

class ApiClient{
    const CURL_TIMEOUT = 3600;
    const CONNECT_TIMEOUT = 30;

    /** @var resource CURL handler. Reused every time for optimization purposes */
    private $ch;
    /** @var string URL for API. Calculated at creating object for optimization purposes */
    private $url;

    public function __construct()
    {
        $uri = SB_CORE::getSetting('helium_api');
        $uri_simp = str_replace(array("https://". "/v1/"), "", $uri);

        $this->url = $uri;
                                // Micro-optimization: every concat operation takes several milliseconds
                                // But for millions sequential requests it can save a few seconds
        $host = [implode(':', [ // $host stores information for domain names resolving (like /etc/hosts file)
            $uri_simp, // Host that will be stored in our "DNS-cache"
            443, // Default port for HTTPS, can be 80 for HTTP
            gethostbyname($uri_simp), // IPv4-address where to point our domain name (Host)
        ])];
        $this->ch = curl_init();
        curl_setopt($this->ch, CURLOPT_ENCODING, '');  // This will use server's gzip (compress data)
                                                       // Depends on server. On some servers can not work
        curl_setopt($this->ch, CURLOPT_RESOLVE, $host); // This will cut all requests for domain name resolving
        curl_setopt($this->ch, CURLOPT_TIMEOUT, self::CURL_TIMEOUT); // To not wait extra time if we know
                                                            // that api-call cannot be longer than CURL_TIMEOUT
        curl_setopt($this->ch, CURLOPT_CONNECTTIMEOUT, self::CONNECT_TIMEOUT); // Close connection if server doesn't response after CONNECT_TIMEOUT
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true); // To return output in `curl_exec`
    }

    /** @throws \Exception */
    public function requestEntity($endpoint){
        $url = $this->url . $endpoint;

        curl_setopt($this->ch, CURLOPT_URL, $url);

        $data = curl_exec($this->ch);

        if (curl_error($this->ch)) {
            throw new \Exception('cURL error (' . curl_errno($this->ch) . '): ' . curl_error($this->ch));
        }

        return json_decode($data, true);
    }

    public function __destruct()
    {
        curl_close($this->ch);
    }
}

//Define one ApiCall
$apiCall = new ApiClient();
?>