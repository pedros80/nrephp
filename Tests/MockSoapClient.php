<?php

declare(strict_types=1);

namespace Tests;

use function array_filter;

use const ARRAY_FILTER_USE_KEY;

use function array_key_exists;
use function array_keys;
use function array_reduce;

use ArrayIterator;

use function func_get_args;

use InfiniteIterator;

use function is_callable;
use function is_numeric;

use SoapClient;
use SoapFault;

use SoapHeader;

final class MockSoapClient extends SoapClient
{
    /**
     * @var array<int|string, InfiniteIterator<int|string, mixed, ArrayIterator<int|string, mixed>>>
     */
    private array $iterators;

    /**
     * @param mixed $responses
     */
    public function __construct($responses)
    {
        $this->iterators = $this->buildIterators((array) $responses);
    }

    /**
     * @param array<mixed> $arguments
     *
     * @throws SoapFault
     */
    public function __call(string $function_name, array $arguments = []): mixed
    {
        try {
            $response = $this->__soapCall($function_name, $arguments);
        } catch (SoapFault $exception) {
            throw $exception;
        }

        return $response;
    }

    /**
     * @param array<mixed> $arguments
     * @param array<mixed>|null $options
     * @param array<mixed>|SoapHeader|null $input_headers
     * @param array<mixed>|null $output_headers
     *
     * @throws SoapFault
     */
    public function __soapCall(
        string $function_name,
        array $arguments,
        ?array $options = null,
        $input_headers = null,
        &$output_headers = null
    ): mixed {
        $iterator = array_key_exists($function_name, $this->iterators)
            ? $this->iterators[$function_name]
            : $this->iterators['*'];

        $response = $iterator->current();
        $iterator->next();

        if ($response instanceof SoapFault) {
            throw $response;
        }

        return is_callable($response)
            ? ($response)(...func_get_args())
            : $response;
    }

    /**
     * Build a simple Infinite iterator.
     *
     * @param array<mixed> $data
     *
     * @return InfiniteIterator<int|string, mixed, ArrayIterator<int|string, mixed>>
     */
    private function buildIterator(array $data): InfiniteIterator
    {
        $iterator = new InfiniteIterator(new ArrayIterator($data));
        $iterator->rewind();

        return $iterator;
    }

    /**
     * Build the structure of iterators.
     *
     * @param array<callable|mixed> $data
     *
     * @return array<int|string, InfiniteIterator<int|string, mixed, ArrayIterator<int|string, mixed>>>
     */
    private function buildIterators(array $data): array
    {
        return array_reduce(
            array_keys($data),
            /**
             * @param array<int|string, InfiniteIterator<int|string, mixed, ArrayIterator<int|string, mixed>>> $iterators
             * @param int|string $key
             *
             * @return array<int|string, InfiniteIterator<int|string, mixed, ArrayIterator<int|string, mixed>>>
             */
            function (array $iterators, $key) use ($data): array {
                if (!is_numeric($key)) {
                    $iterators[$key] = $this->buildIterator((array) $data[$key]);
                }

                return $iterators;
            },
            [
                '*' => $this->buildIterator(array_filter($data, 'is_numeric', ARRAY_FILTER_USE_KEY)),
            ]
        );
    }
}
