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

        $this->assertFalse($listener('date'));
        $this->assertFalse($listener('link_url::42'));
    }

    public function testItReplacesCO2Inserttags(): void
    {
        $listener = new InserttagsListener();

        $this->assertEquals('CO<sub>2</sub>', $listener('co2'));
        $this->assertEquals('CO<sub>2</sub>', $listener('CO2'));
        $this->assertEquals('CO<sub>2</sub>', $listener('Co2'));

        $this->assertEquals('CO<sub>2</sub>', $listener('CO2::some-discarded-input'));
    }
}
