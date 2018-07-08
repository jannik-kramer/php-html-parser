<?php
namespace PHPHtmlParser;

use PHPHtmlParser\Exceptions\CurlException;

/**
 * Class Curl
 *
 * @package PHPHtmlParser
 */
class Curl implements CurlInterface
{

    /**
     * The status code of the response.
     *
     * @var int
     */
    public $statusCode;

    /**
     * A simple curl implementation to get the content of the url.
     *
     * @param string $url
     * @return string
     * @throws CurlException
     */
    public function get($url)
    {
        $ch = curl_init($url);

        if ( ! ini_get('open_basedir')) {
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        }

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);

        $content = curl_exec($ch);
        if ($content === false) {
            // there was a problem
            $error = curl_error($ch);
            throw new CurlException('Error retrieving "'.$url.'" ('.$error.')');
        }

        $this->statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        return $content;
    }
}
