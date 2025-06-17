<?php
/**
 * @var array $arResult
 */

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
} ?>

<h2>Id доступных автомобилей</h2>

<?php
foreach ($arResult['AVAILABLE_CAR_IDS'] as $id) {
    echo "<p>$id</p>";
}
