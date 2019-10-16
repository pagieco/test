<?php

namespace Tests\Unit\Compilers\Dom;

use Tests\TestCase;
use App\Compilers\Dom\DomCompiler;

class DomCompilerTest extends TestCase
{
    /** @test */
    public function it_compiles()
    {
        $compiler = new DomCompiler;

        $dom = $compiler->compile([
            'uuid' => faker()->uuid,
            'nodeType' => '--empty-root-node--',
            'children' => [
                [
                    'uuid' => 1,
                    'nodeType' => 'body',
                    'nodeAttributes' => [
                        'test' => 'value',
                    ],
                    'children' => [
                        [
                            'uuid' => 2,
                            'nodeType' => 'div',
                            'textContent' => 'lipsum',
                        ],
                    ],
                ],
            ],
        ]);

        $this->assertEquals('<body data-id="1" test="value"><div data-id="2">lipsum</div></body>', trim($dom));
    }
}
