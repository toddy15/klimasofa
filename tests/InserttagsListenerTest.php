<?php

declare(strict_types=1);

/*
 * This file is part of klimasofa inserttags.
 *
 * © Dr. Tobias Quathamer
 *
 * @license MIT
 */

namespace Klimasofa\InserttagsBundle\Tests;

use DateTime;
use Klimasofa\InserttagsBundle\EventListener\InserttagsListener;
use PHPUnit\Framework\TestCase;

class InserttagsListenerTest extends TestCase
{
    public function testCanBeInstantiated(): void
    {
        $listener = new InserttagsListener();

        $this->assertInstanceOf('Klimasofa\InserttagsBundle\EventListener\InserttagsListener', $listener);
    }

    public function testItReturnsFalseIfNoTagsAreHandled(): void
    {
        $listener = new InserttagsListener();

        $this->assertFalse($listener->onReplaceInsertTags('date'));
        $this->assertFalse($listener->onReplaceInsertTags('link_url::42'));
    }

    public function testItReplacesCO2Inserttags(): void
    {
        $listener = new InserttagsListener();

        $this->assertEquals('CO<sub>2</sub>', $listener->onReplaceInsertTags('co2'));
        $this->assertEquals('CO<sub>2</sub>', $listener->onReplaceInsertTags('CO2'));
        $this->assertEquals('CO<sub>2</sub>', $listener->onReplaceInsertTags('Co2'));

        $this->assertEquals('CO<sub>2</sub>', $listener->onReplaceInsertTags('CO2::some-discarded-input'));
    }

    public function testItDoesNotReplaceInvalidCurrentAgeTags(): void
    {
        $listener = new InserttagsListener();

        $this->assertFalse($listener->onReplaceInsertTags('current_age'));
        $this->assertFalse($listener->onReplaceInsertTags('current_age::'));
        $this->assertFalse($listener->onReplaceInsertTags('current_age::not-a-date'));
        $this->assertFalse($listener->onReplaceInsertTags('current_age::2014-07'));
        $this->assertFalse($listener->onReplaceInsertTags('current_age::2014.07'));
        $this->assertFalse($listener->onReplaceInsertTags('current_age::14-7-16'));
        $this->assertFalse($listener->onReplaceInsertTags('current_age::14-7-16'));
        $this->assertFalse($listener->onReplaceInsertTags('current_age::16.07.14'));
        $this->assertFalse($listener->onReplaceInsertTags('current_age::16.7.14'));
    }

    public function testItReplacesCurrentAgeTags(): void
    {
        $listener = new InserttagsListener(new DateTime("2021-03-09"));

        $this->assertEquals('6', $listener->onReplaceInsertTags('current_age::2014-07-16'));
        $this->assertEquals('6', $listener->onReplaceInsertTags('current_age::2014-7-16'));
        $this->assertEquals('6', $listener->onReplaceInsertTags('current_age::2014-07-06'));
        $this->assertEquals('6', $listener->onReplaceInsertTags('current_age::2014-07-6'));
        $this->assertEquals('6', $listener->onReplaceInsertTags('current_age::2014-7-06'));
        $this->assertEquals('6', $listener->onReplaceInsertTags('current_age::2014-7-6'));

        $this->assertEquals('6', $listener->onReplaceInsertTags('current_age::16.07.2014'));
        $this->assertEquals('6', $listener->onReplaceInsertTags('current_age::16.7.2014'));
        $this->assertEquals('6', $listener->onReplaceInsertTags('current_age::06.07.2014'));
        $this->assertEquals('6', $listener->onReplaceInsertTags('current_age::6.07.2014'));
        $this->assertEquals('6', $listener->onReplaceInsertTags('current_age::06.7.2014'));
        $this->assertEquals('6', $listener->onReplaceInsertTags('current_age::6.7.2014'));
    }

    public function testItHandlesTheBirthdayCorrectly(): void
    {
        $listener = new InserttagsListener(new DateTime("2021-03-08"));
        $this->assertEquals('39', $listener->onReplaceInsertTags('current_age::1981-03-09'));

        $listener = new InserttagsListener(new DateTime("2021-03-09"));
        $this->assertEquals('40', $listener->onReplaceInsertTags('current_age::1981-03-09'));

        $listener = new InserttagsListener(new DateTime("2021-03-10"));
        $this->assertEquals('40', $listener->onReplaceInsertTags('current_age::1981-03-09'));
    }

    public function testItHandlesLeapYearsCorrectly(): void
    {
        $listener = new InserttagsListener(new DateTime("2020-02-28"));
        $this->assertEquals('39', $listener->onReplaceInsertTags('current_age::1980-02-29'));

        $listener = new InserttagsListener(new DateTime("2020-02-29"));
        $this->assertEquals('40', $listener->onReplaceInsertTags('current_age::1980-02-29'));

        $listener = new InserttagsListener(new DateTime("2020-03-01"));
        $this->assertEquals('40', $listener->onReplaceInsertTags('current_age::1980-02-29'));
    }

    public function testItHandlesLeapYearBirthdaysInANormalYearsCorrectly(): void
    {
        $listener = new InserttagsListener(new DateTime("2021-02-28"));
        $this->assertEquals('40', $listener->onReplaceInsertTags('current_age::1980-02-29'));

        $listener = new InserttagsListener(new DateTime("2021-03-01"));
        $this->assertEquals('41', $listener->onReplaceInsertTags('current_age::1980-02-29'));
    }
}
