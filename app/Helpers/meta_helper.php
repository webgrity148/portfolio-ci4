<?php

use App\Models\MetaData;

function getMetaData($key)
{
    $metaModel = new MetaData();
    return $metaModel->getData($key);
}
