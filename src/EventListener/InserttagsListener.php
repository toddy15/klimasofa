<?php

declare(strict_types=1);

namespace Klimasofa\InserttagsBundle\EventListener;

class InserttagsListener
{
    /**
     * Replaces the Klimasofa insert tags.
     *
     * @param  string  $tag
     * @return string|false
     */
    public function onReplaceInsertTags(string $tag)
    {
        $elements = explode('::', $tag);
        $key = strtolower($elements[0]);

        if ("co2" === $key) {
            return "CO<sub>2</sub>";
        }

        return false;
    }
}
