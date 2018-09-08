<?php
declare(strict_types = 1);

use PHPUnit\Framework\TestCase;
use OrangeShadow\PastebinApi\Exceptions\EmptyPasteCodeException;
use OrangeShadow\PastebinApi\Exceptions\WrongEncodingException;
use OrangeShadow\PastebinApi\Exceptions\EmptyUserKeyException;
use OrangeShadow\PastebinApi\Exceptions\BadApiRequestException;

use OrangeShadow\PastebinApi\PastebinApi;

final class PastebinApiTest extends TestCase
{
    private $api_dev_key  = "SET_YOUR_DEV_API_KEY";
    private $api_user_key = "SET_YOUR_USER_API_KEY";

    public function testShouldCatchEmptyPasteCodeException(): void
    {
        $pastebin_api = new PastebinApi($this->api_dev_key);

        $this->expectException(EmptyPasteCodeException::class);

        $pastebin_api->createPaste('');
    }

    public function testShouldCatchWrongEncodingException(): void
    {
        $pastebin_api = new PastebinApi($this->api_dev_key);

        $this->expectException(WrongEncodingException::class);

        $pastebin_api->createPaste(mb_convert_encoding('Привет Мир', "Windows-1251", "UTF-8"));
    }

    public function testCreateNewPaste(): void
    {
        $pastebin_api = new PastebinApi($this->api_dev_key);

        $response = $pastebin_api->createPaste('<?php
                        declare(strict_types=1);

                        use PHPUnit\Framework\TestCase;

                        use OrangeShadow\PastebinApi\PastebinApi;

                        final class RequestApiTest extends TestCase
                        {
                            public function test(): void
                            {
                            }
                        }', 'Test Paste', $this->api_user_key, 'php', '1D');

        $this->assertRegexp('#^https://pastebin.com/\w#i', $response);
    }

    public function testShouldCatchEmptyUserKeyExceptionOnGetPastListWithEmptyString(): void
    {
        $pastebin_api = new PastebinApi($this->api_dev_key);

        $this->expectException(EmptyUserKeyException::class);

        $pastebin_api->getPasteList('');
    }

    public function testShouldCatchBadApiRequestOnGetPastListWithWrongApiUserKeyString(): void
    {
        $pastebin_api = new PastebinApi($this->api_dev_key);

        $this->expectException(BadApiRequestException::class);

        $pastebin_api->getPasteList('dsf3434');
    }

    public function testShouldReturnArrayOnGetPastList(): void
    {
        $pastebin_api = new PastebinApi($this->api_dev_key);

        $list = $pastebin_api->getPasteList($this->api_user_key);

        $this->assertTrue(is_array($list));
    }

    public function testShouldRemoveCreatedPasteAndReturnTrue(): void
    {
        $pastebin_api = new PastebinApi($this->api_dev_key);

        $list = $pastebin_api->getPasteList($this->api_user_key);

        $result = $pastebin_api->deletePaste($this->api_user_key, $list[0]->key);

        $this->assertTrue($result);
    }

    public function testShouldTryToRemoveNotExistPasteAndThrowExceptionBadApiRequest(): void
    {
        $pastebin_api = new PastebinApi($this->api_dev_key);

        $this->expectException(BadApiRequestException::class,'Bad API request, invalid permission to remove paste');

        $pastebin_api->deletePaste($this->api_user_key, 'sdfsdfdsfdsfsdf');

    }

    public function testShouldGetUsersPasteRawByPasteCode(): void
    {
        $pastebin_api = new PastebinApi($this->api_dev_key);
        $rawOrigin = '<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;

use OrangeShadow\PastebinApi\PastebinApi;

final class RequestApiTest extends TestCase
{
    public function test(): void
    {
    }
}';
        $pastebin_api->createPaste($rawOrigin, 'Test Paste', $this->api_user_key, 'php', '1D');

        $list = $pastebin_api->getPasteList($this->api_user_key);

        $rawResponse= $pastebin_api->getPastesRaw($this->api_user_key, $list[0]->key);

        $this->assertEquals($rawResponse, $rawOrigin);

        $this->assertInternalType('string', $rawResponse, "Got a " . gettype($rawResponse) . " instead of a string");

    }

}