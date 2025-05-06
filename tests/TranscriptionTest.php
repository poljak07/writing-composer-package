<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Transcriptions\Transcription;

class TranscriptionTest extends TestCase
{
    function testit_loads_a_vtt_file_as_a_string()
    {
        $file = __DIR__ . '/stubs/basic-example.vtt';

        $transcription = Transcription::load($file);

        $this->assertStringContainsString('Here is a', $transcription);
        $this->assertStringContainsString('example of a VTT file', $transcription);
    }

    function testit_can_convert_to_an_array_of_lines()
    {
        $file = __DIR__ . '/stubs/basic-example.vtt';

        $this->assertCount(4, Transcription::load($file)->lines());
    }

    function testit_discards_irrelevant_lines_from_the_vtt_file()
    {
        $transcription = Transcription::load(__DIR__ . '/stubs/basic-example.vtt');

        $this->assertStringNotContainsString('WEBVTT', $transcription);
        $this->assertCount(4, $transcription->lines());
    }
}