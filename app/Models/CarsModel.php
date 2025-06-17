<?php

namespace OnlyTeam\Models;

/**
 * Class CarsModel.
 */
class CarsModel extends AbstractHighloadblockEntityModel
{
    /**
     * Возвращает массив id автомобилей для указанных категорий комфорта.
     *
     * @param array $comfortCategories
     *
     * @return array|null
     */
    public function getByComfortCategories(array $comfortCategories): ?array
    {
        $cars = $this->highloadblockEntity::getList(
            [
                'filter' => [
                    'UF_COMFORT_CATEGORIES' => $comfortCategories,
                ],
                'select' => [
                    'ID'
                ],
                'cache'  => [
                    'ttl'         => 3600 * 24,
                    'cache_joins' => true
                ]
            ]
        )->fetchAll();

        foreach ($cars as $car) {
            $result[] = (int) $car['ID'];
        }

        return !empty($result) ? array_unique($result) : null;
    }

    /**
     * Возвращает название Highloadblock.
     *
     * @return string
     */
    protected function getHighloadblockName(): string
    {
        return 'Cars';
    }
}