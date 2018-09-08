<?php
declare(strict_types = 1);

namespace OrangeShadow\PastebinApi;

class Paste
{

    private $key;
    private $date;
    private $title;
    private $size;
    private $expire_date;
    private $private;
    private $format_long;
    private $format_short;
    private $url;
    private $hits;

    /**
     * Paste constructor.
     *
     * @param $key
     * @param $date
     * @param $title
     * @param $size
     * @param $expire_date
     * @param $private
     * @param $format_long
     * @param $format_short
     * @param $url
     * @param $hits
     */
    public function __construct(string $key, int $date, string $title, int $size, int $expire_date, int $private,
                                string $format_long, string $format_short, string $url, int $hits)
    {
        $this->key = $key;
        $this->date = $date;
        $this->title = $title;
        $this->size = $size;
        $this->expire_date = $expire_date;
        $this->private = $private;
        $this->format_long = $format_long;
        $this->format_short = $format_short;
        $this->url = $url;
        $this->hits = $hits;
    }

    public function __get($name)
    {
        if(isset($this->$name))
            return $this->$name;

        throw new \InvalidArgumentException();
    }


    /**
     * Generate paste list from response xml
     *
     * @param string $xml
     * @return array
     */
    public static function generatePasteListFromXml(string $xml)
    {
        $content = '<list>' . $xml . '</list>';

        $xmlObject = new \SimpleXMLElement($content);

        $result = [];

        foreach ($xmlObject->children() as $node) {
            array_push($result, new self(
                    (string)$node->paste_key,
                    (int)$node->paste_date,
                    (string)$node->paste_title,
                    (int)$node->paste_size,
                    (int)$node->paste_expire_date,
                    (int)$node->paste_private,
                    (string)$node->paste_format_long,
                    (string)$node->paste_format_short,
                    (string)$node->paste_url,
                    (int)$node->paste_hits
                )
            );
        }

        return $result;
    }
}