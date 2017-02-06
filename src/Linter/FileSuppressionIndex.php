<?php

namespace Superbalist\Money\Linter;

class FileSuppressionIndex implements SuppressionIndexInterface
{
    /**
     * @var array
     */
    protected $index;

    /**
     * @param string $filename
     */
    public function __construct($filename)
    {
        $this->filename = $filename;
        $this->load();
    }

    /**
     * @param string $filename
     * @param int $number
     * @param string $line
     *
     * @return bool
     */
    public function isSuppressed($filename, $number, $line)
    {
        $hash = $this->generateSuppressionHash($filename, $number, $line);
        return isset($this->index[$hash]);
    }

    /**
     * @param string $filename
     * @param int $number
     * @param string $line
     */
    public function add($filename, $number, $line)
    {
        $hash = $this->generateSuppressionHash($filename, $number, $line);
        $this->index[$hash] = [
            'filename' => $filename,
            'number' => $number,
            'line' => $line,
        ];
        $this->save();
    }

    /**
     * @param string $filename
     * @param int $number
     * @param string $line
     *
     * @return string
     */
    protected function generateSuppressionHash($filename, $number, $line)
    {
        return md5($filename . $number . $line);
    }

    /**
     *
     */
    public function wipe()
    {
        $this->index = [];
        $this->save();
    }

    /**
     *
     */
    protected function load()
    {
        if (file_exists($this->filename)) {
            $content = file_get_contents($this->filename);
            $this->index = unserialize($content);
        } else {
            $this->index = [];
        }
    }

    /**
     *
     */
    protected function save()
    {
        file_put_contents($this->filename, serialize($this->index));
    }
}
