<?php

declare(strict_types=1);

namespace Tests\ChiTeck\Stopwatch\Formatter;

use ChiTeck\Stopwatch\Data\Report;
use ChiTeck\Stopwatch\Formatter\Json;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Tests\ChiTeck\Stopwatch\Fixture\ReportSet;

/**
 * {@selfdoc}
 */
#[CoversClass(Json::class)]
final class JsonTest extends TestCase
{
    /**
     * {@selfdoc}
     */
    #[Test]
    #[DataProvider('formatterDataProvider')]
    public function formatter(Report $report, int $options, string $expected_result): void
    {
        $formatter = new Json($options);
        $output = $formatter->format($report);
        self::assertTrue(\json_validate($output));
        self::assertSame($expected_result, $output);
    }

    /**
     * {@selfdoc}
     */
    public static function formatterDataProvider(): \Generator
    {
        yield [
            ReportSet::GAMMA->build(),
            0,
            '{"context":{"id":"103","label":"Gamma","createdAt":"2024-04-12T03:00:00+00:00"},"ticks":[{"name":"Tick #1","timestamp":12345,"memory":123,"location":{"file":"example.php","line":10,"function":"example","class":"Tests\\\ChiTeck\\\Stopwatch\\\Fixture\\\ReportSet","type":"->"},"data":["\u041a\u0438\u0440\u0438\u043b\u043b\u0438\u0446\u0430"]}]}',
        ];

        yield [
            ReportSet::GAMMA->build(),
            \JSON_PRETTY_PRINT,
            <<< 'JSON'
                {
                    "context": {
                        "id": "103",
                        "label": "Gamma",
                        "createdAt": "2024-04-12T03:00:00+00:00"
                    },
                    "ticks": [
                        {
                            "name": "Tick #1",
                            "timestamp": 12345,
                            "memory": 123,
                            "location": {
                                "file": "example.php",
                                "line": 10,
                                "function": "example",
                                "class": "Tests\\ChiTeck\\Stopwatch\\Fixture\\ReportSet",
                                "type": "->"
                            },
                            "data": [
                                "\u041a\u0438\u0440\u0438\u043b\u043b\u0438\u0446\u0430"
                            ]
                        }
                    ]
                }
                JSON,
        ];

        yield [
            ReportSet::GAMMA->build(),
            \JSON_UNESCAPED_UNICODE,
            '{"context":{"id":"103","label":"Gamma","createdAt":"2024-04-12T03:00:00+00:00"},"ticks":[{"name":"Tick #1","timestamp":12345,"memory":123,"location":{"file":"example.php","line":10,"function":"example","class":"Tests\\\ChiTeck\\\Stopwatch\\\Fixture\\\ReportSet","type":"->"},"data":["Кириллица"]}]}',
        ];

        yield [
            ReportSet::DELTA->build(),
            0,
            '{"context":{"id":"104","label":"Delta","createdAt":"2024-04-12T04:00:00+00:00"},"ticks":[]}',
        ];
    }
}
