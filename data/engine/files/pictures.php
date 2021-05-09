<?php

$converts = file($converts_file);
for ($i = 0; $i < count($converts); $i++)
    list ($pic_phrases[$i], $pic_urls[$i]) = explode("\t", trim($converts[$i]));
unset($converts);