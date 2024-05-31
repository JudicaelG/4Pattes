<?php

namespace App\Tests\Service;

use App\Enum\enumNextRecall;
use App\Service\DisplayColorForNextRecall;
use DateTime;
use PHPUnit\Framework\TestCase;

class TestColorNextRecallTest extends TestCase
{
    public function testReturnGreenColorIfTheDateIsGood(): void
    {
        $DisplayColor = new DisplayColorForNextRecall();
        $date = new DateTime('2025-12-12');
        $color = $DisplayColor->DisplayColor($date);

        $this->assertEquals(enumNextRecall::green, $color);
    }

    public function testReturnOrangeColorIfTheMonthIsOne(): void{
        $DisplayColor = new DisplayColorForNextRecall();
        $date = new DateTime();
        $color = $DisplayColor->DisplayColor($date->modify('+1 Month'));

        $this->assertEquals(enumNextRecall::orange, $color);
    }

    public function testReturnOrangeColorIfTheMonthIsOneAndDayIsMoreThanZero(): void{
        $DisplayColor = new DisplayColorForNextRecall();
        $date = new DateTime();
        $finalDate = $date->modify('+1 Month');
        $color = $DisplayColor->DisplayColor($finalDate->modify('+1 Day'));

        $this->assertEquals(enumNextRecall::green, $color);
    }

    public function testReturnOrangeColorIfTheMonthIs0AndDayIsMoreThanFifteen(): void{
        $DisplayColor = new DisplayColorForNextRecall();
        $date = new DateTime();
        $color = $DisplayColor->DisplayColor($date->modify('+17 Day'));

        $this->assertEquals(enumNextRecall::orange, $color);
    }

    public function testReturnRedColorIfTheDayIsEqualThanFifteen(): void {
        $DisplayColor = new DisplayColorForNextRecall();
        $date = new DateTime();
        $color = $DisplayColor->DisplayColor($date->modify('+15 Day'));
        $this->assertEquals(enumNextRecall::red, $color);
    }

    public function testReturnRedColorIfTheDayIsLessThanFifteen(): void{
        $DisplayColor = new DisplayColorForNextRecall();
        $date = new DateTime();
        $color = $DisplayColor->DisplayColor($date->modify('+10 Day'));
        $this->assertEquals(enumNextRecall::red, $color);
    }
}
