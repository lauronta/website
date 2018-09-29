<?php
namespace Tests\Framework;

use App\Blog\BlogModule;
use Framework\App;
use GuzzleHttp\Psr7\ServerRequest;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Tests\Framework\Modules\ErroredModule;
use Tests\Framework\Modules\StringModule;

class AppTest extends TestCase {

    public function testRedirectTrailingSlash(){
        $app =new App();
        $request = new ServerRequest('GET', '/azeazeaze/');
        $response = $app->run($request);
        $this->assertContains('/azeazeaze', $response->getHeader('Location'));
        $this->assertEquals('301', $response->getStatusCode());
    }

    public function testBlog(){
      $app = new App([
          BlogModule::class
      ]) ;
      $request = new ServerRequest('GET', '/blog');
      $response = $app->run($request);
      $this->assertContains('<h1>Bienvenue sur le blog</h1>', (string) $response->getBody());
      $this->assertEquals('200', $response->getStatusCode());

      $requestsingle = new ServerRequest('GET', '/blog/article-de-test');
      $responsesingle = $app->run($requestsingle);
      $this->assertContains('<h1>Bienvenue sur l\'article article-de-test</h1>', (string) $responsesingle->getBody());
    }

    public function testThrowExceptionIfNoResponseSet(){
        $app = new App([
            ErroredModule::class
        ]);
        $request = new ServerRequest('GET', '/demo');
        $this->expectException(\Exception::class);
        $app->run($request);
    }

    public function testConvertStringToResponse(){
        $app = new App([
            StringModule::class
        ]);
        $request = new ServerRequest('GET', '/demo');
        $response = $app->run($request);
        $this->assertInstanceOf(ResponseInterface::class, $response);
        $this->assertEquals('DEMO', (string)$response->getBody());
    }

    public function testError404(){
        $app = new App() ;
        $request = new ServerRequest('GET', '/asesae');
        $response = $app->run($request);
        $this->assertContains('<h2>Erreur 404</h2>', (string) $response->getBody());
        $this->assertEquals('404', $response->getStatusCode());
    }

}