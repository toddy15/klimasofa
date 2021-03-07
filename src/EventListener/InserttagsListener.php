<?php

declare(strict_types=1);

namespace Klimasofa\InserttagsBundle\EventListener;

use Contao\CoreBundle\ServiceAnnotation\Hook;

/**
 * @Hook("replaceInsertTags")
 */
class InserttagsListener
{
    public function __invoke(string $tag)
    {
        $elements = explode('::', $tag);
        $key = strtolower($elements[0]);

        if ("co2" === $key) {
            return "CO<sub>2</sub>";
        }

        return false;
    }
}
