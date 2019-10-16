<?php

namespace App\Compilers\Dom;

use DOMDocument;
use App\Compilers\CompilerInterface;

class DomCompiler implements CompilerInterface
{
    public function compile($source)
    {
        $document = new DOMDocument;

        foreach ((new DomNode($source))->getChildren() as $child) {
            $document->appendChild($this->createDomElement($child, $document));
        }

        return $document->saveHTML();
    }

    protected function createDomElement($node, $document)
    {
        $node = new DomNode($node);

        $element = $node->toDomElement($document);

        foreach ($node->getChildren() as $child) {
            $element->appendChild($this->createDomElement($child, $document));
        }

        return $element;
    }
}
