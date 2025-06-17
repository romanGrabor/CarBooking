<?php

namespace OnlyTeam\Models;

use Bitrix\Highloadblock\HighloadBlockTable;
use Bitrix\Main\Loader;

abstract class AbstractHighloadblockEntityModel
{
    protected string $highloadblockEntity;

    /**
     * Constructor.
     *
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\LoaderException
     * @throws \Bitrix\Main\ObjectPropertyException
     * @throws \Bitrix\Main\SystemException
     */
    public function __construct()
    {
        Loader::includeModule('highloadblock');

        $this->highloadblockEntity = (string) HighloadBlockTable::compileEntity(
            HighloadBlockTable::getList(['filter' => ['=NAME' => $this->getHighloadblockName()]])->fetch()
        )->getDataClass();
    }

    /**
     * Возвращает название Highloadblock.
     *
     * @return string
     */
    abstract protected function getHighloadblockName(): string;
}
