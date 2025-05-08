<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Transcriptions\Line;
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

    function testit_can_convert_to_an_array_of_line_objects()
    {
        $file = __DIR__ . '/stubs/basic-example.vtt';

        $lines = Transcription::load($file)->lines();

        $this->assertCount(2, $lines);

        $this->assertContainsOnlyInstancesOf(Line::class, $lines);
    }

    function testit_discards_irrelevant_lines_from_the_vtt_file()
    {
        $transcription = Transcription::load(__DIR__ . '/stubs/basic-example.vtt');

        $this->assertStringNotContainsString('WEBVTT', $transcription);
        $this->assertCount(2, $transcription->lines());
    }

    function testit_renders_the_lines_as_html()
    {
        $transcription = Transcription::load(__DIR__ . '/stubs/basic-example.vtt');

        $expected = <<<EOT
        <a href="?time=00:03">Here is a</a>
        <a href="?time=00:04">example of a VTT file.</a>
        EOT;

        $this->assertEquals(
            $this->normalizeNewlines($expected),
            $this->normalizeNewlines($transcription->htmlLines())
        );
    }

    private function normalizeNewlines(string $text): string
    {
        return str_replace(["\r\n", "\r"], "\n", $text);
    }

}