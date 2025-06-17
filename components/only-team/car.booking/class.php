<?php

use Bitrix\Main\Application;
use OnlyTeam\Services\CarBookingService;

/**
 * Class CarBookingComponent.
 */
class CarBookingComponent extends CBitrixComponent
{
    /**
     * @param $component
     */
    public function __construct($component = null)
    {
        parent::__construct($component);
    }

    /**
     * @return void
     */
    public function executeComponent(): void
    {
        parent::executeComponent();

        $this->arResult['AVAILABLE_CAR_IDS'] = $this->getAvailableCarIds();

        $this->includeComponentTemplate();
    }

    /**
     * Формирует данные доступных для бронирования автомобилей.
     *
     * @return array
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\ObjectPropertyException
     * @throws \Bitrix\Main\SystemException
     */
    private function getAvailableCarIds(): array
    {
        $request = Application::getInstance()->getContext()->getRequest();

        $availableCars = (new CarBookingService())->getAvailableCars(
            new DateTime($request->getQuery('timeStart')),
            new DateTime($request->getQuery('timeFinish'))
        );

        return $availableCars ?: [];
    }
}
