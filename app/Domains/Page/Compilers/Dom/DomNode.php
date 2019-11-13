<?php

namespace App\Domains\Page\Compilers\Dom;

use DOMElement;
use DOMDocument;
use Illuminate\Support\Arr;
use InvalidArgumentException;

class DomNode
{
    protected $node;

    protected $reservedAttributes = [
        'contenteditable',
    ];

    public function __construct($node)
    {
        $this->node = $node;

        $this->validateInput($node);
    }

    public function getUuid()
    {
        return $this->node['uuid'];
    }

    public function getType()
    {
        return $this->node['nodeType'];
    }

    public function getTextContent()
    {
        return Arr::get($this->node, 'textContent');
    }

    public function getAttributes(): array
    {
        $attributes = Arr::get($this->node, 'nodeAttributes', []);

        return array_filter($attributes, function ($value, $attribute) {
            return ! empty($value)
                && ! in_array($attribute, $this->reservedAttributes, true);
        }, ARRAY_FILTER_USE_BOTH);
    }

    public function getChildren()
    {
        return Arr::get($this->node, 'children', []);
    }

    public function toDomElement(DOMDocument $document): DOMElement
    {
        $element = $document->createElement($this->getType());

        $element->textContent = $this->getTextContent();

        $element->setAttribute('data-id', $this->getUuid());

        foreach ($this->getAttributes() as $key => $value) {
            $element->setAttribute($key, $value);
        }

        return $element;
    }

    protected function validateInput($input): void
    {
        $requiredAttributes = ['uuid', 'nodeType'];

        if ($diff = array_diff($requiredAttributes, array_keys($input))) {
            throw new InvalidArgumentException(implode(', ', $diff));
        }
    }
}
