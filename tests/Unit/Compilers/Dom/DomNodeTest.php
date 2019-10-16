<?php

namespace Tests\Unit\Compilers\Dom;

use Tests\TestCase;
use InvalidArgumentException;
use App\Compilers\Dom\DomNode;

class DomNodeTest extends TestCase
{
    /** @test */
    public function it_will_throw_an_exception_when_input_wont_validate()
    {
        $this->expectException(InvalidArgumentException::class);

        new DomNode([]);
    }

    /** @test */
    public function it_can_get_the_uuid()
    {
        $node = new DomNode([
            'uuid' => $uuid = faker()->uuid,
            'nodeType' => 'div',
        ]);

        $this->assertEquals($uuid, $node->getUuid());
    }

    /** @test */
    public function it_can_get_the_type()
    {
        $node = new DomNode([
            'uuid' => faker()->uuid,
            'nodeType' => 'div',
        ]);

        $this->assertEquals('div', $node->getType());
    }

    /** @test */
    public function it_can_get_the_text_contents()
    {
        $node = new DomNode([
            'uuid' => faker()->uuid,
            'nodeType' => 'div',
            'textContent' => $text = faker()->text,
        ]);

        $this->assertEquals($text, $node->getTextContent());
    }

    /** @test */
    public function it_will_strip_empty_values_from_the_node_attributes_list()
    {
        $node = new DomNode([
            'uuid' => faker()->uuid,
            'nodeType' => 'div',
            'nodeAttributes' => [
                'attribute' => '',
            ],
        ]);

        $this->assertEmpty($node->getAttributes());
    }

    /** @test */
    public function it_will_strip_the_reserved_attributes_from_the_node_attributes_list()
    {
        $node = new DomNode([
            'uuid' => faker()->uuid,
            'nodeType' => 'div',
            'nodeAttributes' => [
                'contenteditable' => true,
            ],
        ]);

        $this->assertEmpty($node->getAttributes());
    }

    /** @test */
    public function it_can_get_the_node_attributes()
    {
        $node = new DomNode([
            'uuid' => faker()->uuid,
            'nodeType' => 'div',
            'nodeAttributes' => [
                'attribute' => 'value',
            ],
        ]);

        $this->assertNotEmpty($node->getAttributes());
    }

    /** @test */
    public function it_can_get_the_node_children()
    {
        $node = new DomNode([
            'uuid' => faker()->uuid,
            'nodeType' => 'div',
            'children' => [
                'a', 'b', 'c',
            ],
        ]);

        $this->assertCount(3, $node->getChildren());
    }

    /** @test */
    public function it_will_return_an_empty_array_when_no_children_are_present()
    {
        $node = new DomNode([
            'uuid' => faker()->uuid,
            'nodeType' => 'div',
            'children' => [
                // ...
            ],
        ]);

        $this->assertEmpty($node->getChildren());
    }
}
