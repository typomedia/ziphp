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

            $source = rtrim($source, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;

            $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($source), RecursiveIteratorIterator::SELF_FIRST);

            foreach ($files as $file) {
                $local = substr($file, strlen($source));

                // Ignore "." and ".." folders
                if (in_array(substr($file, strrpos($file, DIRECTORY_SEPARATOR) + 1), ['.', '..'])) {
                    continue;
                } else {
                    echo $file . PHP_EOL;
                }

                if (is_dir($file)) {
                    $zip->addEmptyDir($local);
                }

                if (is_file($file)) {
                    $zip->addFile($file, $local);
                }
            }
            
        } elseif (is_file($source)) {
            $local = basename($source);
            $zip->addFile($source, $local);
        }

        return $zip->close();
    }
}
