<?php

namespace ziphp\Service;

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

        if (is_dir($source) === true) {
            $files = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($source), \RecursiveIteratorIterator::SELF_FIRST);

            foreach ($files as $file) {
                $relativePath = substr($file, strlen($source));
                // Ignore "." and ".." folders
                if (in_array(substr($file, strrpos($file, '/') + 1), array('.', '..'))) {
                    continue;
                } else {
                    echo $file . PHP_EOL;
                }

                if (is_dir($file) === true) {
                    $zip->addEmptyDir($relativePath);
                } elseif (is_file($file) === true) {
                    $zip->addFromString($relativePath, file_get_contents($file));
                }
            }
        } elseif (is_file($source) === true) {
            $zip->addFromString(basename($source), file_get_contents($source));
        }

        return $zip->close();
    }
}
