<?php

namespace Website;

class HomeTest extends \PHPUnit\Framework\TestCase
{
    use \Minz\Tests\InitializerHelper;
    use \Minz\Tests\ApplicationHelper;
    use \Minz\Tests\ResponseAsserts;

    public function testIndexRendersCorrectly()
    {
        $request = new \Minz\Request('GET', '/');

        $response = self::$application->run($request);

        $this->assertResponse($response, 200, 'Flus, média social citoyen');
        $pointer = $response->output()->pointer();
        $this->assertSame('home/index.phtml', $pointer);
    }

    public function testCreditsRendersCorrectly()
    {
        $request = new \Minz\Request('GET', '/credits');

        $response = self::$application->run($request);

        $this->assertResponse($response, 200, 'Crédits');
        $pointer = $response->output()->pointer();
        $this->assertSame('home/credits.phtml', $pointer);
    }

    public function testLegalRendersCorrectly()
    {
        $request = new \Minz\Request('GET', '/mentions-legales');

        $response = self::$application->run($request);

        $this->assertResponse($response, 200, 'Mentions légales');
        $pointer = $response->output()->pointer();
        $this->assertSame('home/legal.phtml', $pointer);
    }

    public function testCgvRendersCorrectly()
    {
        $request = new \Minz\Request('GET', '/cgv');

        $response = self::$application->run($request);

        $this->assertResponse($response, 200, 'Conditions Générales de Vente');
        $pointer = $response->output()->pointer();
        $this->assertSame('home/cgv.phtml', $pointer);
    }

    public function testFundingRendersCorrectly()
    {
        $request = new \Minz\Request('GET', '/financement');

        $response = self::$application->run($request);

        $this->assertResponse($response, 200);
        $pointer = $response->output()->pointer();
        $this->assertSame('home/funding.phtml', $pointer);
    }

    public function testRobotsRendersCorrectly()
    {
        $request = new \Minz\Request('GET', '/robots.txt');

        $response = self::$application->run($request);

        $this->assertResponse($response, 200);
    }

    public function testSitemapRendersCorrectly()
    {
        $request = new \Minz\Request('GET', '/sitemap.xml');

        $response = self::$application->run($request);

        $this->assertResponse($response, 200);
    }
}
