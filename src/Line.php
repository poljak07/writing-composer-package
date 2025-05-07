<?php

namespace Transcriptions;

class Line
{

    public function __construct(public string $timestamp, public string $body)
    {

    }


    public static function valid($line)
    {
        return $line !== 'WEBVTT' && $line !== '' && ! is_numeric($line);
    }
}