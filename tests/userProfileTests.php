<?php
namespace tests;

class UserProfileTests extends \PHPUnit_Framework_TestCase
{

    const URI = 'http://localhost:8050';

    public function testPOST()
    {
        // create a http client with Guzzle
        $client = new \GuzzleHttp\Client(
            array(
                'base_uri' => self::URI,
                'request.options' => array(
                    'exceptions' => false
                )
            ));
        
        $name = 'UserProfileTest' . rand(1, 999);
        
        switch (rand(1, 5)) {
            case 1:
                $email = $name . '@hotmail.com';
                $image = 'http://someserver/images/' . $name . '.jpg';
                break;
            case 2:
                $email = $name . '@gmail.com';
                $image = 'http://someserver/images/' . $name . '.jpeg';
                break;
            case 3:
                $email = $name . '@yahoo.com';
                $image = 'http://someserver/images/' . $name . '.gif';
                break;
            case 4:
                $email = $name . '@msn.com';
                $image = 'http://someserver/images/' . $name . '.bmp';
                break;
            case 5:
                $email = $name . '@hotmail.com';
                $image = 'http://someserver/images/' . $name . '.png';
                break;
        }
        
        $data = array(
            'name' => $name,
            'email' => $email,
            'Image' => $image
        );
        
        $response = $client->request('POST', '/api/userProfile', 
            [
                'json' => $data
            ]);
        
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue($response->hasHeader('Content-Type'));
        $contentType = $response->getHeader('Content-Type');
        $this->assertContains('application/json', $contentType[0]);
        $data = json_decode($response->getBody()->getContents());
        // validates if API inserts data
        $this->assertEquals('Successful insert', $data[0]);
    }

    public function testGET()
    {
        // create a http client with Guzzle
        $client = new \GuzzleHttp\Client(
            array(
                'base_uri' => self::URI,
                'request.options' => array(
                    'exceptions' => false
                )
            ));
        
        $response = $client->request('GET', '/api/userProfile');
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue($response->hasHeader('Content-Type'));
        $contentType = $response->getHeader('Content-Type');
        $this->assertContains('application/json', $contentType[0]);
        $data = json_decode($response->getBody()->getContents());
        // validates if API returns results
        $this->assertObjectHasAttribute('id', $data[0]);
    }

    public function testDELETE()
    {
        // create a http client with Guzzle
        $client = new \GuzzleHttp\Client(
            array(
                'base_uri' => self::URI,
                'request.options' => array(
                    'exceptions' => false
                )
            ));
        
        // choose the id to delete
        $id = rand(1, 30);
        
        $response = $client->request('DELETE', '/api/userProfile/' . $id);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue($response->hasHeader('Content-Type'));
        $contentType = $response->getHeader('Content-Type');
        $this->assertContains('application/json', $contentType[0]);
        $data = json_decode($response->getBody()->getContents());
        // validates if API deletes data
        $this->assertEquals('Successful delete', $data[0]);
    }

    public function testPUT()
    {
        // create a http client with Guzzle
        $client = new \GuzzleHttp\Client(
            array(
                'base_uri' => self::URI,
                'request.options' => array(
                    'exceptions' => false
                )
            ));
        
        // choose the id to update
        $id = rand(1, 30);
        $name = 'UserProfileTestPUT' . rand(1, 999);
        
        switch (rand(1, 5)) {
            case 1:
                $email = $name . '@hotmail.com';
                $image = 'http://someserver/images/' . $name . '.jpg';
                break;
            case 2:
                $email = $name . '@gmail.com';
                $image = 'http://someserver/images/' . $name . '.jpeg';
                break;
            case 3:
                $email = $name . '@yahoo.com';
                $image = 'http://someserver/images/' . $name . '.gif';
                break;
            case 4:
                $email = $name . '@msn.com';
                $image = 'http://someserver/images/' . $name . '.bmp';
                break;
            case 5:
                $email = $name . '@hotmail.com';
                $image = 'http://someserver/images/' . $name . '.png';
                break;
        }
        
        $data = array(
            'id' => $id,
            'name' => $name,
            'email' => $email,
            'Image' => $image
        );
        
        $response = $client->request('PUT', '/api/userProfile', 
            [
                'json' => $data
            ]);
        
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertTrue($response->hasHeader('Content-Type'));
        $contentType = $response->getHeader('Content-Type');
        $this->assertContains('application/json', $contentType[0]);
        $data = json_decode($response->getBody()->getContents());
        // validates if API updates data
        $this->assertEquals('Successful update', $data[0]);
    }
}
