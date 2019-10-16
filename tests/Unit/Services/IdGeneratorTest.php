<?php

namespace Tests\Unit\Services;

use Tests\TestCase;
use App\Services\IdGenerator;

class IdGeneratorTest extends TestCase
{
    /** @test */
    public function it_correctly_encodes_an_id()
    {
        $shardId = pow(2, IdGenerator::$shardBits) - 1;
        $localId = pow(2, IdGenerator::$localBits) - 1;

        $this->assertEquals(9223372036854775807, IdGenerator::encode($shardId, $localId));
    }

    /** @test */
    public function it_correctly_decodes_an_id()
    {
        $id = IdGenerator::decode(9223372036854775807);

        $this->assertEquals(8388607, $id['shard']);
        $this->assertEquals(1099511627775, $id['local']);
    }

    /** @test */
    public function it_correctly_encodes_and_decodes_small_ids()
    {
        $id = IdGenerator::decode(IdGenerator::encode(1, 1));

        $this->assertEquals(1, $id['shard']);
        $this->assertEquals(1, $id['local']);
    }
}
