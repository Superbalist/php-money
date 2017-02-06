<?php

namespace Superbalist\Money\Linter;

class FileIndex
{
    /**
     * @var array
     */
    protected $files;

    /**
     * @param array $files
     */
    public function __construct(array $files)
    {
        $this->files = $files;
    }

    /**
     * @return array
     */
    public function getFiles()
    {
        return $this->files;
    }

    /**
     * @param string $dir
     *
     * @return FileIndex
     */
    public static function make($dir)
    {
        $dirIterator = new \RecursiveDirectoryIterator($dir);
        $dirIterator->setFlags(\RecursiveDirectoryIterator::SKIP_DOTS);
        $recursiveIterator = new \RecursiveIteratorIterator($dirIterator, \RecursiveIteratorIterator::SELF_FIRST);
        $results = [];
        foreach ($recursiveIterator as $file) {
            /** @var \SplFileInfo $file */
            // ignore non files
            if (!$file->isFile()) {
                continue;
            }
            // ignore non php files
            $ext = strtolower($file->getExtension());
            if ($ext !== 'php') {
                continue;
            }
            $results[] = $file->getPathname();
        }

        return new self($results);
    }
}
