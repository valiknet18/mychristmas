<?php
namespace AppBundle\Tests\Service;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PostServiceTest extends WebTestCase
{
    /**
     * @dataProvider provider1
     */
    public function testIndex($needed, $theme)
    {
        $client = static::createClient();

        $result = $client->getContainer()->get('appbundle.service.post_service')->themeConvert($theme);

        $this->assertEquals($needed, $result);
    }

    public function provider1()
    {
        return [
            [
                "HelloWorld", "hello    wOrld"
            ],
            [
                "HelloWorld", "hello world"
            ],
            [
                "HelloWorld", "HELLO WORLD"
            ],
            [
                "HELLOWORLD", "h  e   l l o w o R L    d"
            ]
        ];
    }

    /**
     * @dataProvider provider2
     */
    public function testIndex2($needed, $theme)
    {
        $client = static::createClient();

        $result = $client->getContainer()->get('appbundle.service.post_service')->themeConvert($theme);

        $this->assertNotEquals($needed, $result);
    }

    public function provider2()
    {
        return [
            [
                "HelloWorld", "hallo    wOrld"
            ],
            [
                "HelloWorld", "hell o world"
            ],
            [
                "HelloWorld", "HELL-O-WORLD"
            ],
            [
                "H A L L O W O R L D", "H A LL o W Or L D"
            ]
        ];
    }
}
