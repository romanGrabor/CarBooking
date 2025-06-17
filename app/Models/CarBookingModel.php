<?php

namespace OnlyTeam\Models;

use DateTime;

/**
 * Class CarBookingModel.
 */
class CarBookingModel extends AbstractHighloadblockEntityModel
{
    private const BITRIX_DATETIME_FORMAT = 'd.m.Y\TH:i:s';

    /**
     * Возвращает забронированные автомобили в указанный диапазон времени.
     *
     * @param \DateTime $timeStart
     * @param \DateTime $timeFinish
     *
     * @return array|null
     */
    public function getBookedCars(DateTime $timeStart, DateTime $timeFinish): ?array
    {
        $carsBooking = $this->highloadblockEntity::getList(
            [
                'filter' => [
                    'LOGIC' => 'OR',
                    [
                        '><UF_START_BOOKING' => [
                            $timeStart->format(self::BITRIX_DATETIME_FORMAT),
                            $timeFinish->format(self::BITRIX_DATETIME_FORMAT)
                        ],
                    ],
                    [
                        '><UF_FINISH_BOOKING' => [
                            $timeStart->format(self::BITRIX_DATETIME_FORMAT),
                            $timeFinish->format(self::BITRIX_DATETIME_FORMAT)
                        ],
                    ]
                ],
                'select' => [
                    'UF_CAR'
                ],
                'cache'  => [
                    'ttl' => 3600 * 24,
                    'cache_joins' => true
                ]
            ]
        )->fetchAll();

        foreach ($carsBooking as $booking) {
            $result[] = (int) $booking['UF_CAR'];
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
        return 'CarBooking';
    }
}
