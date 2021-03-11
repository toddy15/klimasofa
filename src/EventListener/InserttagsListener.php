<?php

declare(strict_types=1);

namespace Klimasofa\InserttagsBundle\EventListener;

use DateTime;

class InserttagsListener
{
    private DateTime $now;

    public function __construct(DateTime $givenDate = null)
    {
        $this->now = $givenDate ?? new DateTime();
    }

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

        if ("current_age" === $key) {
            if (isset($elements[1])) {
                return $this->calculateCurrentAge($elements[1]);
            }
        }

        return false;
    }

    /**
     * The tag {{current_age::*}} returns the current age
     * in years, calculated from the given birthday to today.
     *
     * @param  string  $date
     * @return string|false
     */
    private function calculateCurrentAge(string $date)
    {
        // Make sure there is something sane to parse.
        if (!preg_match('/[0-9]{4}-[01]?[0-9]-[0123]?[0-9]/', $date) and
            !preg_match('/[0123]?[0-9]\.[01]?[0-9]\.[0-9]{4}/', $date)) {
            return false;
        }

        try {
            // Calculate the difference between now and the given date.
            $start_date = new DateTime($date);
            return $start_date->diff($this->now)->format('%y');
        } catch (\Exception $exception) {
            // If the given date cannot be parsed correctly,
            // give up handling this.
            return false;
        }
    }
}
