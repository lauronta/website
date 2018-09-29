<?php
namespace Tests\Framework;

use Framework\App;
use GuzzleHttp\Psr7\ServerRequest;
use PHPUnit\Framework\TestCase;

class AppTest extends TestCase {

    public function testRedirectTrailingSlash(){
        $app =new App();
        $request = new ServerRequest('GET', '/azeazeaze/');
        $response = $app->run($request);
        $this->assertContains('/azeazeaze', $response->getHeader('Location'));
        $this->assertEquals('301', $response->getStatusCode());
    }

    public function testBlog(){
      $app = new App() ;
      $request = new ServerRequest('GET', '/blog');
      $response = $app->run($request);
      $this->assertContains('<h2>Blog</h2>', (string) $response->getBody());
      $this->assertEquals('200', $response->getStatusCode());
    }

    public function testError404(){
        $app = new App() ;
        $request = new ServerRequest('GET', '/asesae');
        $response = $app->run($request);
        $this->assertContains('<h2>Erreur 404</h2>', (string) $response->getBody());
        $this->assertEquals('404', $response->getStatusCode());
    }

}