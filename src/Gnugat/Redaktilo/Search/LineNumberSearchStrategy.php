<?php

/*
 * This file is part of the Redaktilo project.
 *
 * (c) Loïc Chardonnet <loic.chardonnet@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Gnugat\Redaktilo\Search;

use Gnugat\Redaktilo\Text;

/**
 * Moves x lines above or under the current one.
 */
class LineNumberSearchStrategy implements SearchStrategy
{
    /** {@inheritdoc} */
    public function findAbove(Text $text, $pattern, $location = null)
    {
        $foundLineNumber = ($location ?: $text->getCurrentLineNumber()) - $pattern;
        $lines = $text->getLines();
        $totalLines = count($lines);
        if (0 > $foundLineNumber || $foundLineNumber >= $totalLines) {
            return false;
        }

        return $foundLineNumber;
    }

    /** {@inheritdoc} */
    public function findUnder(Text $text, $pattern, $location = null)
    {
        $foundLineNumber = ($location ?: $text->getCurrentLineNumber()) + $pattern;
        $lines = $text->getLines();
        $totalLines = count($lines);
        if (0 > $foundLineNumber || $foundLineNumber >= $totalLines) {
            return false;
        }

        return $foundLineNumber;
    }

    /** {@inheritdoc} */
    public function supports($pattern)
    {
        return (is_int($pattern) && $pattern >= 0);
    }
}
