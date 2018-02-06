<?php declare(strict_types=1);

/**
 * @author Lukáš Piják 2018 TOPefekt s.r.o.
 * @link https://www.bulkgate.com/
 */

namespace BulkGate\Message;

interface IConnection
{
    public function send(Request $request): Response;

    public function getInfo(bool $delete = false): array;
}
