<?php
declare(strict_types = 1);

use PHPUnit\Framework\TestCase;

final class PasteTest extends TestCase
{
    public function testShouldGenerateArrayFromXmlList()
    {
        $content = '<paste>
	<paste_key>0b42rwhf</paste_key>
	<paste_date>1297953260</paste_date>
	<paste_title>javascript test</paste_title>
	<paste_size>15</paste_size>
	<paste_expire_date>1297956860</paste_expire_date>
	<paste_private>0</paste_private>
	<paste_format_long>JavaScript</paste_format_long>
	<paste_format_short>javascript</paste_format_short>
	<paste_url>https://pastebin.com/0b42rwhf</paste_url>
	<paste_hits>15</paste_hits>
</paste>
<paste>
	<paste_key>0C343n0d</paste_key>
	<paste_date>1297694343</paste_date>
	<paste_title>Welcome To Pastebin V3</paste_title>
	<paste_size>490</paste_size>
	<paste_expire_date>0</paste_expire_date>
	<paste_private>0</paste_private>
	<paste_format_long>None</paste_format_long>
	<paste_format_short>text</paste_format_short>
	<paste_url>https://pastebin.com/0C343n0d</paste_url>
	<paste_hits>65</paste_hits>
</paste>';


        $this->assertTrue(is_array(\OrangeShadow\PastebinApi\Paste::generatePasteListFromXml($content)));
    }

}