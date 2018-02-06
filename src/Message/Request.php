<?php declare(strict_types=1);

/**
 * @author Lukáš Piják 2018 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

namespace BulkGate\Message;

use BulkGate;

class Request
{
    use BulkGate\Strict;

    public const CONTENT_TYPE_JSON = 'application/json';

    public const CONTENT_TYPE_ZIP = 'application/zip';

    /** @var string */
    private $action;

    /** @var array */
    private $data = [];

    /** @var string */
    private $content_type;

    public function __construct(string $action, array $data = array(), bool $compress = false)
    {
        $this->setAction($action);
        $this->setData($data, $compress);
    }

    public function setData(array $data = array(), bool $compress = false): self
    {
        $this->data = (array) $data;
        $this->content_type = $compress ? self::CONTENT_TYPE_ZIP : self::CONTENT_TYPE_JSON;

        return $this;
    }

    public function setAction(string $action): self
    {
        $this->action = (string) $action;

        return $this;
    }

    public function getData()
    {
        try
        {
            if($this->content_type === self::CONTENT_TYPE_ZIP)
            {
                return BulkGate\Utils\Compress::compress(BulkGate\Utils\Json::encode($this->data));
            }
            else
            {
                return BulkGate\Utils\Json::encode($this->data);
            }
        }
        catch (BulkGate\Utils\JsonException $e)
        {
            throw new InvalidRequestException;
        }
    }

    public function getRawData(): array
    {
        return (array) $this->data;
    }

    public function getAction(): string
    {
        return (string) $this->action;
    }

    public function getContentType(): string
    {
        return (string) $this->content_type;
    }
}
