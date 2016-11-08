<?php

namespace FL\FacebookPagesBundle\Tests\Util\Url;

class ManipulateUrl
{
    /**
     * @param string   $url
     * @param string[] $parameters
     *
     * @return string
     */
    public static function removeParametersFromQueryInUrl(string $url, array $parameters)
    {
        $parsedUrl = parse_url($url);
        parse_str($parsedUrl['query'], $queryParts);
        foreach ($parameters as $parameter) {
            unset($queryParts[$parameter]);
        }
        $parsedUrl['query'] = http_build_query($queryParts);

        return http_build_url($parsedUrl);
    }
}
