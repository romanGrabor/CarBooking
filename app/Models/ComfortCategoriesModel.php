<?php

namespace OnlyTeam\Models;

/**
 * Class ComfortCategoriesModel.
 */
class ComfortCategoriesModel extends AbstractHighloadblockEntityModel
{
    /**
     * Возвращает массив id категории комфорта для указанной должности.
     *
     * @param string $workPosition
     *
     * @return array|null
     */
    public function getByWorkPosition(string $workPosition): ?array
    {
        $comfortCategories = $this->highloadblockEntity::getList(
            [
                'filter' => [
                    'UF_WORK_POSITION' => (int) \CUserFieldEnum::GetList([], ['VALUE' => $workPosition])->Fetch()['ID'],
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

        foreach ($comfortCategories as $category) {
            $result[] = (int) $category['ID'];
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
        return 'ComfortCategories';
    }
}
