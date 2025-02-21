<?php

class RankManager {
    /**
     * Summary of ranksById
     *
     * @var array
     */
    private array $ranksById;

    /**
     * Summary of __construct
     * 
     * @param array $config
     */
    public function __construct(
        private array $config
    )
    {
        $this->loadRanks();
    }

    /**
     * Summary of loadRanks
     *
     * @return void
     */
    private function loadRanks(): void
    {
        $ranksData       = json_decode(file_get_contents($this->config['paths']['ranks_json']), true);
        $this->ranksById = [];

        foreach ($ranksData['7e7c7320-a742-11ef-9cf7-1388dafd02fd']['ranks'] as $rank) {
            $this->ranksById[$rank['id']] = $rank;
        }
    }

    /**
     * Summary of getRankClass
     *
     * @param int $xp
     *
     * @return string
     */
    public function getRankClass(int $xp): string
    {
        foreach ($this->config['xp_thresholds'] as $level => $threshold) {
            if ($xp >= $threshold) {
                return "rank-$level";
            }
        }
        return 'rank-0';
    }

    /**
     * Summary of formatTitle
     * 
     * @param string $title
     * @param int    $civility
     * 
     * @return array<string, string>
     */
    public function formatTitle(string $title, int $civility): array {
        $parts = array_map('trim', explode('(', $title));
        $level = str_replace(')', '', $parts[1]);

        if (
            isset($civility) &&
            $civility > 0 &&
            false !== strpos($title, '/')
        ) {
            $parts = array_map('trim', explode('/', $parts[0]));

            return [
                'title' => ($civility == 1) ? $parts[0] : $parts[1],
                'level' => $level,
            ];
        }

        return [
            'title' => $parts[0],
            'level' => $level,
        ];
    }

    /**
     * Summary of estimateTimeToNextLevel
     *
     * @param int $xpRemaining
     *
     * @return string
     */
    public function estimateTimeToNextLevel(int $xpRemaining): string
    {
        $xpPerMinute    = $this->config['xp_rates']['per_minute'];
        $xpPer10Minutes = $this->config['xp_rates']['per_10_minutes'];
        
        $timeMinutes   = ceil($xpRemaining / $xpPerMinute);
        $time10Minutes = ceil($xpRemaining / $xpPer10Minutes) * 10;

        $totalMinutes = min($timeMinutes, $time10Minutes);

        $days    = floor($totalMinutes / 1440);
        $hours   = floor(($totalMinutes % 1440) / 60);
        $minutes = $totalMinutes % 60;
        
        return trim(
            ($days > 0 ? $days.'j ' : '') .
            ($hours > 0 ? $hours.'h ' : '') .
            $minutes.'min'
        );
    }

    /**
     * Summary of getRankById
     *
     * @param string $id
     *
     * @return array|null
     */
    public function getRankById(string $id): ?array
    {
        return $this->ranksById[$id] ?? null;
    }
}
