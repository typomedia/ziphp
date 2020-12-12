# ziphp

Simple PHP Console ZIP Packager for files and folders.

## Download

[ziphp.phar](https://github.com/typomedia/ziphp/raw/master/dist/ziphp.phar)

## Usage
    php ziphp.phar compress <source> <target.zip>
    php ziphp.phar extract <source.zip> <target>

## Help

    php ziphp.phar compress --help
    php ziphp.phar extract --help

## Compressing
    
    # command for compressing 'vendor'
    php ziphp.phar compress vendor/

    # command for compressing 'vendor' folder to 'example.zip' in target folder
    php ziphp.phar compress vendor/ ~/example.zip
    
## Extracting
    
    # command for extracting 'example.zip'
    php ziphp.phar extract ~/example.zip

    # command for extracting 'example.zip' to target folder
    php ziphp.phar extract ~/example.zip /tmp

---
© 2020 Typomedia Foundation. Created with ♥ in Heidelberg by Philipp Speck.