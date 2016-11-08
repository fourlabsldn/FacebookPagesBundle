<?php

namespace FL\FacebookPagesBundle\Action;

use FL\FacebookPagesBundle\Services\Facebook\V2_8\FacebookUserClient;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class AuthorizeFacebookTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @covers \FL\FacebookPagesBundle\Action\AuthorizeFacebook::__construct
     * @covers \FL\FacebookPagesBundle\Action\AuthorizeFacebook::__invoke
     */
    public function testInvoke()
    {
        $facebookUserClient = new FacebookUserClient('fakeAppId', 'fakeAppSecret');
        $authorizeAction = new AuthorizeFacebook($facebookUserClient, 'https://www.example.com/callbackurl', ['id', 'first_name', 'last_name']);

        /** @var RedirectResponse $response */
        $response = $authorizeAction(new Request());

        /*
         * $response->getTargetUrl() will return a url with a variable state query
         * E.g. ...'state=819273ab81238bcas7123'
         */
        $removeStateQueryFromURL = function (string $url) {
            return preg_replace('/state=.+?(&|$)/', 'state=1234&', $url);
        };

        $this->assertEquals(
            $removeStateQueryFromURL($response->getTargetUrl()),
            'https://www.facebook.com/v2.8/dialog/oauth?client_id=fakeAppId'.
            '&state=1234'.
            '&response_type=code&sdk=php-sdk-5.4.0&redirect_uri='.
            'https%3A%2F%2Fwww.example.com%2Fcallbackurl&scope=id%2Cfirst_name%2Clast_name');
    }
}
