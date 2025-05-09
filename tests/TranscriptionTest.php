<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Transcriptions\Line;
use Transcriptions\Transcription;

class TranscriptionTest extends TestCase
{
    protected Transcription $transcription;

    protected function setUp(): void
    {
        $this->transcription = Transcription::load(
            __DIR__ . '/stubs/basic-example.vtt'
        );
    }

    function testit_loads_a_vtt_file_as_a_string()
    {
        $this->assertStringContainsString('Here is a', $this->transcription);
        $this->assertStringContainsString('example of a VTT file', $this->transcription);
    }

    function testit_can_convert_to_an_array_of_line_objects()
    {
        $lines = $this->transcription->lines();

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

        $expected = <<<EOT
            <a href="?time=00:03">Here is a</a>
            <a href="?time=00:04">example of a VTT file.</a>
        EOT;

        $expected = $this->normalizeNewlines($expected);
        $actual = $this->normalizeNewlines($this->transcription->lines()->asHtml());

        $this->assertEquals($expected, $actual);
    }

    private function normalizeNewlines(string $text): string
    {
        return str_replace(["\r\n", "\r"], "\n", $text);
    }

}