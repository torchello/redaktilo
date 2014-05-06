<?php

/*
 * This file is part of the Redaktilo project.
 *
 * (c) Loïc Chardonnet <loic.chardonnet@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Gnugat\Redaktilo;

/**
 * A data source which contains:
 *
 * + the path to the file
 * + the raw content
 * + a pointer to the current line
 *
 * Its read and write methods provide a representation of the content:
 * an array of lines from which the newline character has been stripped.
 *
 * @author Loïc Chardonnet <loic.chardonnet@gmail.com>
 */
class File
{
    /** @var string */
    private $filename;

    /** @var string */
    private $content;

    /** @var integer */
    private $currentLineNumber = 0;

    /**
     * @param string $filename
     * @param string $content
     */
    public function __construct($filename, $content)
    {
        $this->filename = $filename;
        $this->content = $content;
    }

    /** @return string */
    public function getFilename()
    {
        return $this->filename;
    }

    /** @return string */
    public function getContent()
    {
        return $this->content;
    }

    /** @return array of lines stripped of the newline character */
    public function getLines()
    {
        return explode(PHP_EOL, $this->content);
    }

    /** @return integer */
    public function getCurrentLineNumber()
    {
        return $this->currentLineNumber;
    }

    /** @param integer $lineNumber */
    public function setCurrentLineNumber($lineNumber)
    {
        $this->currentLineNumber = $lineNumber;
    }

    /** @param string $newLine */
    public function insertBefore($newLine)
    {
        $lines = $this->getLines();
        $editedLines = array();
        foreach ($lines as $lineNumber => $line) {
            if ($this->currentLineNumber === $lineNumber) {
                $editedLines[] = $newLine;
            }
            $editedLines[] = $line;
        }
        $this->content = implode(PHP_EOL, $editedLines);
    }

    /** @param string $newLine */
    public function insertAfter($newLine)
    {
        $this->currentLineNumber++;
        $this->insertBefore($newLine);
    }

    /** @param array $lines */
    public function write(array $lines)
    {
        $this->content = implode(PHP_EOL, $lines);
    }
}
