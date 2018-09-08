<?php
declare(strict_types = 1);

use PHPUnit\Framework\TestCase;

use OrangeShadow\PastebinApi\Repositories\PastebinRepository;

final class PastebinRepositoryTest extends TestCase
{
    private $api_dev_key  = "SET_YOUR_DEV_API_KEY";

    private $object ;
    private $reflection;

    public function setUp()
    {
        parent::setUp();

        $this->object= new PastebinRepository($this->api_dev_key);
        $this->reflection = new \ReflectionClass(get_class($this->object));
    }

    /**
     * Set private method to accessible
     *
     * @param $method_name
     *
     */
    private function setPrivateMethodToAccessible(string $method_name)
    {
        $method = $this->reflection->getMethod($method_name);
        $method->setAccessible(true);

        return $method;
    }


    /**
     * Set private field different value
     *
     * @param string $field
     * @param $value
     */
    private function setPrivateFieldDifferentValue(string $field, $value):void
    {
        $property = $this->reflection->getProperty($field);
        $property->setAccessible(true);
        $property->setValue($this->object, $value);

    }


    public function testForSendRequest()
    {
        $this->setPrivateFieldDifferentValue('pastebin_host','http://httpbin.org/');
        $method = $this->setPrivateMethodToAccessible('sendRequest');
        $result = $method->invokeArgs($this->object, ['POST','post',['hello'=>'world']]);

        $this->assertRegExp('#"hello": "world"#',$result);
    }

}