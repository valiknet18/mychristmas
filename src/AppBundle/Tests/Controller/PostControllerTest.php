<?php
namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PostControllerTest extends WebTestCase
{
    /**
     * @dataProvider providerTop
     */
    public function testTop($responseStatus, $url)
    {
        $client = static::createClient();

        $client->request('GET', $url);

        $this->assertEquals($responseStatus, $client->getResponse()->getStatusCode());
    }

    public function providerTop()
    {
        return [
            [
                200, "/post/top/like"
            ],
            [
                404, "/post/top/another"
            ],
            [
                200, "/post/top/dislike"
            ]
        ];
    }
}
