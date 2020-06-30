<?php

declare(strict_types=1);

namespace App\Model\Music\Entity\Album;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class DownloadStatistic
 * @package App\Model\Music\Entity\Album
 * @ORM\Embeddable()
 */
class DownloadStatistic
{
    /**
     * @var int
     * @ORM\Column(type="integer", name="all")
     */
    public int $downloads;
    /**
     * @var int
     * @ORM\Column(type="integer", name="today")
     */
    public int $downloadsToday;
    /**
     * @var int
     * @ORM\Column(type="integer", name="week")
     */
    public int $downloadsWeek;
    /**
     * @var int
     * @ORM\Column(type="integer", name="month")
     */
    public int $downloadsMonth;

    /**
     * ListenStatistic constructor.
     * @param int $downloads
     * @param int $downloadsToday
     * @param int $downloadsWeek
     * @param int $downloadsMonth
     */
    public function __construct(int $downloads, int $downloadsToday, int $downloadsWeek, int $downloadsMonth)
    {
        $this->downloads = $downloads;
        $this->downloadsToday = $downloadsToday;
        $this->downloadsWeek = $downloadsWeek;
        $this->downloadsMonth = $downloadsMonth;
    }

    public static function clean(): self
    {
        return new self(0, 0, 0, 0);
    }

    public static function emptyTodayDownloads(int $downloads, int $downloadsWeek, int $downloadsMonth): self
    {
        return new self($downloads, 0, $downloadsWeek, $downloadsMonth);
    }

    public static function emptyWeekDownloads(int $downloads, int $downloadsToday, int $downloadsMonth): self
    {
        return new self($downloads, $downloadsToday, 0, $downloadsMonth);
    }

    public static function emptyMonthDownloads(int $downloads, int $downloadsToday, int $downloadsWeek): self
    {
        return new self($downloads, $downloadsToday, $downloadsWeek, 0);
    }

    /**
     * @return int
     */
    public function getDownloads(): int
    {
        return $this->downloads;
    }

    /**
     * @return int
     */
    public function getDownloadsToday(): int
    {
        return $this->downloadsToday;
    }

    /**
     * @return int
     */
    public function getDownloadsWeek(): int
    {
        return $this->downloadsWeek;
    }

    /**
     * @return int
     */
    public function getDownloadsMonth(): int
    {
        return $this->downloadsMonth;
    }
}