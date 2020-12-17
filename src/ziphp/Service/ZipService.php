<?php

namespace ziphp\Service;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use \ZipArchive;

/**
 * Class ZipService
 * @package ziphp\Service
 */
class ZipService extends ZipArchive
{
    /**
     * @param string $source
     * @param string $destination
     * @return bool
     */
    public function addFolder($source, $destination)
    {
        if (!file_exists($source)) {
            echo "source doesn't exist";
            return false;
        }

        if (!extension_loaded('zip')) {
            echo "zip extension not loaded in php";
            return false;
        }

        $zip = new ZipArchive();

        if (!$zip->open($destination, ZIPARCHIVE::CREATE)) {
            echo "failed to create zip file on destination";
            return false;
        }

        if (is_dir($source)) {

            $dir = rtrim($source, DIRECTORY_SEPARATOR);
            $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir), RecursiveIteratorIterator::SELF_FIRST);

            foreach ($files as $file) {

                $local = substr($file, strlen($dir));

                // Skip dots
                if (in_array($file->getFilename(), ['.', '..'])) {
                    continue;
                }

                print $file . PHP_EOL;

                $file->isDir() ? $zip->addEmptyDir($local) : null;
                $file->isFile() ? $zip->addFile($file, $local) : null;
            }
            
        } elseif (is_file($source)) {
            $local = basename($source);
            $zip->addFile($source, $local);
        }

        return $zip->close();
    }
}
