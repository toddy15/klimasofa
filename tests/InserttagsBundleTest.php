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

use Klimasofa\InserttagsBundle\InserttagsBundle;
use PHPUnit\Framework\TestCase;

class InserttagsBundleTest extends TestCase
{
    public function testCanBeInstantiated(): void
    {
        $bundle = new InserttagsBundle();

        $this->assertInstanceOf('Klimasofa\InserttagsBundle\InserttagsBundle', $bundle);
    }
}
