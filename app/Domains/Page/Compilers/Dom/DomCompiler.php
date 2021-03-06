<?php

namespace App\Domains\Page\Compilers\Dom;

use DOMElement;
use DOMDocument;
use App\Domains\Page\Compilers\CompilerInterface;

class DomCompiler implements CompilerInterface
{
    public function compile($source): string {
        $document = new DOMDocument;

        foreach ((new DomNode($source))->getChildren() as $child) {
            $document->appendChild($this->createDomElement($child, $document));
        }

        return $document->saveHTML();
    }

    protected function createDomElement($node, $document): DOMElement
    {
        $node = new DomNode($node);

        $element = $node->toDomElement($document);

        foreach ($node->getChildren() as $child) {
            $element->appendChild($this->createDomElement($child, $document));
        }

        return $element;
    }
}
