<?php

/**
 * Remove Byte Order Mark (BOM) from file
 * @param string $source
 * @param string $destination
 * @return bool|null
 *
 * @author netzzitrone
 */
function removeBOM($source, $destination = '') {
    if ('' === $destination) {
        $destination = $source;
    }
    $result = null;
    if (file_exists($source)) {
        $handle = fopen($source, "rb");
        if ($handle) {
            if (filesize($source) >=3) {
                $threeBytes = fread($handle, 3);
                $data = implode('',unpack("H*", $threeBytes));
                if ($data === 'efbbbf') {
                    $fileContent = fread($handle, filesize($source));
                    if ($handle) {
                        $handle = fopen($destination, "wb");
                        fwrite($handle, $fileContent);
                        fclose($handle);
                        return true;
                    }
                }
                fclose($handle);
                return false;
            }
        }
    }
    return null;
}
