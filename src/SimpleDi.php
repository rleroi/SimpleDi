<?php

declare(strict_types=1);

namespace App\Domain\Traits;

use Illuminate\Support\Facades\Log;
use Jasny\PhpdocParser\PHPDocParser;
use Jasny\PhpdocParser\Set\PhpDocumentor;
use ReflectionClass;

trait SimpleDi
{
    /**
     * @return mixed|void
     */
    public function __get(string $property)
    {
        if (property_exists($this, $property)) {
            return $this->$property;
        }

        // get docblock
        $doc = (new ReflectionClass($this))->getDocComment();

        // parse docblock
        $tags = PhpDocumentor::tags();
        $parser = new PHPDocParser($tags);
        $meta = $parser->parse($doc);

        if (
            !isset($meta['properties'][$property])
            || !isset($meta['properties'][$property]['type'])
            || !class_exists($meta['properties'][$property]['type'])
        ) {
            Log::error('invalid @property ' . $property . ' ' . $meta['properties'][$property]['type']);

            return;
        }
        $class = $meta['properties'][$property]['type'];

        return SimpleDiService::make($class);
    }
}
