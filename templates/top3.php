<section id="top3">
<?php
    $count = 0;

    foreach ($top3 as $rank) {
        ++$count;
        $formatTitle     = $rankManager->formatTitle($rank['rankInfo']['name'], $rank['civility']);
        $formatNextTitle = $rankManager->formatTitle($rank['nextRank']['name'], $rank['civility']);
?>
        <a
            href="https://www.twitch.tv/<? echo $rank['username']; ?>"
            target="_blank"
            data-rank="<? echo $count; ?>"
        >
            <div class="avatar">
                <img src="<? echo $rank['profilePicUrl']; ?>">

                <div class="level">
                    <span class="<? echo $rankManager->getRankClass($rank['xp']); ?>">
                        <? echo $formatTitle['level'] . ' ' . $formatTitle['title']; ?>
                    </span>
                </div>
            </div>

            <div class="username">
            <?
                if (!empty($rank['roles'])) {
                    foreach ($rank['roles'] as $role) {
                        echo '<img src="assets/images/' . $role . '.png" class="role">';
                    }
                }
                echo $rank['username'];
            ?>
            </div>
            <div class="nextLevel">
                <? echo $formatNextTitle['level'] . ' d\'ici ' . $rank['xpEstimation']; ?>
            </div>
        </a>
    <? } ?>
</section>
