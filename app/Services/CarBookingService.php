<?php

namespace OnlyTeam\Services;

use Bitrix\Main\UserTable;
use DateTime;
use OnlyTeam\Models\CarBookingModel;
use OnlyTeam\Models\CarsModel;
use OnlyTeam\Models\ComfortCategoriesModel;

/**
 * Class CarBookingService.
 */
class CarBookingService
{
    /**
     * Возвращает все доступные текущему пользователю автомобили.
     *
     * @param \DateTime $timeStart
     * @param \DateTime $timeFinish
     *
     * @return array|null
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\ObjectPropertyException
     * @throws \Bitrix\Main\SystemException
     */
    public function getAvailableCars(DateTime $timeStart, DateTime $timeFinish): ?array
    {
        $bookedCars = (new CarBookingModel())->getBookedCars($timeStart, $timeFinish);
        $allAvailableCars = $this->getCars();

        if (!$allAvailableCars) {
            return null;
        }

        return $bookedCars ? array_diff($allAvailableCars, $bookedCars) : $allAvailableCars;
    }

    /**
     * Возвращает все автомобили, соответствующие категории комфорта текущего сотрудника.
     *
     * @return array|null
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\ObjectPropertyException
     * @throws \Bitrix\Main\SystemException
     */
    private function getCars(): ?array
    {
        $authUserComfortCategories = $this->getComfortCategories();
        return $authUserComfortCategories ? (new CarsModel())->getByComfortCategories(
            $authUserComfortCategories
        ) : null;
    }

    /**
     * Возвращает доступные текущему сотруднику категории комфорта.
     *
     * @return array|null
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\ObjectPropertyException
     * @throws \Bitrix\Main\SystemException
     */
    private function getComfortCategories(): ?array
    {
        $authUserWorkPosition = $this->getAuthUserWorkPosition();
        return $authUserWorkPosition ? (new ComfortCategoriesModel())->getByWorkPosition(
            $authUserWorkPosition
        ) : null;
    }

    /**
     * Возвращает должность авторизованного сотрудника.
     *
     * @return string|null
     * @throws \Bitrix\Main\ArgumentException
     * @throws \Bitrix\Main\ObjectPropertyException
     * @throws \Bitrix\Main\SystemException
     */
    private function getAuthUserWorkPosition(): ?string
    {
        global $USER;

        $user = UserTable::getList([
            'filter' => [
                'ID' => $USER->GetID()
            ],
            'select' => [
                'WORK_POSITION',
            ]
        ])->fetch();

        return !empty($user) ? $user['WORK_POSITION'] : null;
    }
}
