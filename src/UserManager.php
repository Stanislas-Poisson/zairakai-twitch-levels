<?php

class UserManager {
    /**
     * Summary of users
     *
     * @var array
     */
    private array $users = [];
    
    /**
     * Summary of rankings
     *
     * @var array
     */
    private array $rankings = [];

    /**
     * Summary of rankingsVIP
     *
     * @var array
     */
    private array $rankingsVIP = [];

    /**
     * Summary of __construct
     *
     * @param array       $config
     * @param RankManager $rankManager
     */
    public function __construct(
        private array $config,
        private RankManager $rankManager
    )
    {
        $this->loadUsers();
        $this->processRankings();
        $this->addStateofPrevious();
    }

    /**
     * Summary of showNewPrevious
     * 
     * @return void
     */
    public function showNewPrevious(): void
    {
        $i = 1;
        foreach($this->rankings as $viewer => $data) {
            echo $i . ' => \'' . $viewer.'\',<br>';
            $i++;
        }
        die();
    }

    /**
     * Summary of addStateofPrevious
     * 
     * @return void
     */
    public function addStateofPrevious(): void
    {
        $i = 1;
        foreach ($this->rankings as $viewer => $data) {
            $previousPlace = array_search($viewer, $this->config['previous']);
            if (false === $previousPlace) {
                $this->rankings[$viewer]['fromPrevious']['img'] = 'up';
                $this->rankings[$viewer]['fromPrevious']['nbr'] = '+'.($this->config['top']['all'] + 1 - $i);
            }
            else if ($i < $previousPlace) {
                $this->rankings[$viewer]['fromPrevious']['img'] = 'up';
                $this->rankings[$viewer]['fromPrevious']['nbr'] = '+'.$previousPlace - $i;
            }
            else if($i == $previousPlace) {
                $this->rankings[$viewer]['fromPrevious']['img'] = 'stay';
                $this->rankings[$viewer]['fromPrevious']['nbr'] = 0;
            }
            else {
                $this->rankings[$viewer]['fromPrevious']['img'] = 'down';
                $this->rankings[$viewer]['fromPrevious']['nbr'] = '-'.$i - $previousPlace;
            }
            $i++;
        }
    }

    /**
     * Summary of loadUsers
     *
     * @return void
     */
    private function loadUsers(): void
    {
        $usersData   = file_get_contents($this->config['paths']['users_db']);
        $this->users = array_map(
            fn($line) => json_decode($line, true),
            array_filter(explode("\n", $usersData))
        );
    }

    /**
     * Summary of getUserRoles
     *
     * @param array $user
     *
     * @return array
     */
    private function getUserRoles(array $user): array
    {
        $roles = [];
        
        // Process Twitch roles
        if (! empty($user['twitchRoles'])) {
            foreach ($user['twitchRoles'] as $role) {
                switch ($role) {
                    case 'vip':
                        $roles[1] = 'vip';
                        break;
                    case 'mod':
                        $roles[1] = 'mod';
                        break;
                    case 'sub':
                        $roles[4] = 'sub';
                        break;
                }
            }
        }
        
        // Process custom roles
        $username    = strtolower($user['username']);
        $displayName = strtolower($user['displayName']);
        
        foreach ($this->config['user_groups'] as $group => $members) {
            if (
                in_array($username, array_map('strtolower', $members)) || 
                in_array($displayName, array_map('strtolower', $members))
            ) {
                switch ($group) {
                    case 'vips':
                        if (! isset($roles[1])) { $roles[1] = 'vip'; }
                        break;

                    case 'vips_trimestre':
                        if (! isset($roles[1])) { $roles[1] = 'vip-trimestre'; }
                        break;

                    case 'vips_trimestre_sound':
                        $roles[2] = 'music';
                        break;

                    case 'vips_honoraires':
                        $roles[1] = 'vip-honorific';
                        break;

                    case 'mods':
                        $roles[1] = 'mod';
                        $roles[2] = 'music';
                        break;

                    case 'artistes':
                        $roles[3] = 'art';
                        break;

                    case 'subs':
                        $roles[4] = 'sub';
                        break;
                }
            }
        }

        ksort($roles);

        return $roles;
    }

    /**
     * Summary of processRankings
     *
     * @return void
     */
    private function processRankings(): void
    {
        foreach ($this->users as $user) {
            if ($this->shouldExcludeUser($user)) {
                continue;
            }

            $xp = $user['currency']['2a16e460-a6a6-11ef-a2ff-2fe7b0ff25b8'] ?? 0;

            if ($xp < 3719) {
                continue;
            }

            $roles                             = $this->getUserRoles($user);
            $rankData                          = $this->processUserRankData($user, $xp, $roles);
            $this->rankings[$user['username']] = $rankData;

            if (
                ! $this->isModerator($roles) &&
                ! $this->isVipTrimestre($roles)
            ) {
                $this->rankingsVIP[$user['username']] = $rankData;
            }
        }
        
        $this->sortRankings();
    }

    /**
     * Summary of shouldExcludeUser
     *
     * @param array $user
     *
     * @return bool
     */
    private function shouldExcludeUser(array $user): bool
    {
        return
            in_array($user['displayName'], $this->config['user_groups']['excluded']) || 
            in_array($user['username'], $this->config['user_groups']['excluded']);
    }

    /**
     * Summary of isModerator
     *
     * @param array $roles
     *
     * @return bool
     */
    private function isModerator(array $roles): bool
    {
        return
            isset($roles[1]) &&
            'mod' === $roles[1];
    }

    /**
     * Summary of isModerator
     *
     * @param array $roles
     *
     * @return bool
     */
    private function isVipTrimestre(array $roles): bool
    {
        return
            isset($roles[1]) &&
            'vip-honorific' === $roles[1];
    }

    /**
     * Summary of processUserRankData
     *
     * @param array $user
     * @param int   $xp
     * @param array $roles
     *
     * @return array<string, string|int|null|array<string, string>>
     */
    private function processUserRankData(array $user, int $xp, array $roles): array
    {
        $rankId   = $user['ranks']['7e7c7320-a742-11ef-9cf7-1388dafd02fd'] ?? '';
        $rankInfo = $this->rankManager->getRankById($rankId);
        $nextRank = null;
        $xpNeeded = 0;
        
        // Calculate next rank and XP needed
        $ranksData = json_decode(file_get_contents($this->config['paths']['ranks_json']), true);

        foreach ($ranksData['7e7c7320-a742-11ef-9cf7-1388dafd02fd']['ranks'] as $rank) {
            if ($rank['value'] <= $xp) {
                break;
            }

            $nextRank = $rank;
            $xpNeeded = $rank['value'] - $xp;
        }
        
        return [
            'displayName'   => $user['username'],
            'username'      => $user['displayName'],
            'profilePicUrl' => $user['profilePicUrl'],
            'xp'            => $xp,
            'rankInfo'      => $rankInfo,
            'roles'         => $roles,
            'civility'      => $user['metadata']['civility'] ?? 0,
            'nextRank'      => $nextRank,
            'xpNeeded'      => $xpNeeded,
            'xpEstimation'  => $this->rankManager->estimateTimeToNextLevel($xpNeeded)
        ];
    }

    /**
     * Summary of sortRankings
     *
     * @return void
     */
    private function sortRankings(): void
    {
        $sortFunc = fn($a, $b) => $b['xp'] - $a['xp'];

        uasort($this->rankings, $sortFunc);
        uasort($this->rankingsVIP, $sortFunc);
        
        $this->rankings = array_slice($this->rankings, 0, $this->config['top']['all']);
    }

    /**
     * Summary of gettopHead
     *
     * @return array
     */
    public function gettopHead(): array
    {
        return array_slice($this->rankings, 0, $this->config['top']['head']);
    }

    /**
     * Summary of gettopVIP
     *
     * @return array
     */
    public function gettopVIP(): array
    {
        return array_slice($this->rankingsVIP, 0, $this->config['top']['vip']);
    }

    /**
     * Summary of getRankings
     *
     * @return array
     */
    public function getRankings(): array
    {
        return array_slice($this->rankings, 3);
    }

    /**
     * Number of people who get the sound command.
     * 
     * @return int
     */
    public function vipSounded(): int
    {
        return ceil($this->config['top']['vip'] / 2);
    }
}
