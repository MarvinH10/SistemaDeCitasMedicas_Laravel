<?php
    if (!function_exists('wrapBrTags')) {
        function wrapBrTags($description) {
            return preg_replace('/<br\s*\/?>/', '<span class="br-tag"></span>', $description);
        }
    }
?>
