<?php

namespace FL\FacebookPagesBundle\Action;

use FL\FacebookPagesBundle\Services\Facebook\V2_8\FacebookUserClient;
use FL\FacebookPagesBundle\Tests\Util\Url\ManipulateUrl;
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
         * Keep in mind $client->generateAuthorizationUrl will return a url that has a query,
         * with a changing state parameter. E.g. ...'state=819273ab81238ba7123' or ...'state=21f371ce23bac6123'
         */
        $this->assertEquals(
            ManipulateUrl::removeParametersFromQueryInUrl($response->getTargetUrl(), ['state']),
            'https://www.facebook.com/v2.8/dialog/oauth?client_id=fakeAppId'.
            '&response_type=code&sdk=php-sdk-5.4.0&redirect_uri='.
            'https%3A%2F%2Fwww.example.com%2Fcallbackurl&scope=id%2Cfirst_name%2Clast_name');
    }
}
