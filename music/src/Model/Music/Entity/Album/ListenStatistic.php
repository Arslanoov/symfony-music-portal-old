<?php

declare(strict_types=1);

namespace App\Model\Music\Entity\Album;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class ListenStatistic
 * @package App\Model\Music\Entity\Album
 * @ORM\Embeddable()
 */
class ListenStatistic
{
    /**
     * @var int
     * @ORM\Column(type="integer", name="all")
     */
    public int $listens;
    /**
     * @var int
     * @ORM\Column(type="integer", name="today")
     */
    public int $listensToday;
    /**
     * @var int
     * @ORM\Column(type="integer", name="week")
     */
    public int $listensWeek;
    /**
     * @var int
     * @ORM\Column(type="integer", name="month")
     */
    public int $listensMonth;

    ### create

    /**
     * ListenStatistic constructor.
     * @param int $listens
     * @param int $listensToday
     * @param int $listensWeek
     * @param int $listensMonth
     */
    public function __construct(int $listens, int $listensToday, int $listensWeek, int $listensMonth)
    {
        $this->listens = $listens;
        $this->listensToday = $listensToday;
        $this->listensWeek = $listensWeek;
        $this->listensMonth = $listensMonth;
    }

    public static function clean(): self
    {
        return new self(0, 0, 0, 0);
    }

    public static function emptyTodayListens(int $listens, int $listensWeek, int $listensMonth): self
    {
        return new self($listens, 0, $listensWeek, $listensMonth);
    }

    public static function emptyWeekListens(int $listens, int $listensToday, int $listensMonth): self
    {
        return new self($listens, $listensToday, 0, $listensMonth);
    }

    public static function emptyMonthListens(int $listens, int $listensToday, int $listensWeek): self
    {
        return new self($listens, $listensToday, $listensWeek, 0);
    }

    ### getters

    /**
     * @return int
     */
    public function getListens(): int
    {
        return $this->listens;
    }

    /**
     * @return int
     */
    public function getListensToday(): int
    {
        return $this->listensToday;
    }

    /**
     * @return int
     */
    public function getListensWeek(): int
    {
        return $this->listensWeek;
    }

    /**
     * @return int
     */
    public function getListensMonth(): int
    {
        return $this->listensMonth;
    }
}