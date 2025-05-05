<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Transcriptions\Transcription;

class TranscriptionTest extends TestCase
{

    function testit_loads_a_vtt_file()
    {
        $transcription = Transcription::load(__DIR__ .'/stubs/basic-example.vtt');

        $expected = file_get_contents(__DIR__ .'/stubs/basic-example.vtt');

        $this->assertEquals($expected, $transcription);
    }

}