<section id="list">
<?php
    $count = 3;

    foreach ($rankings as $rank) {
        ++$count;
        $formatTitle     = $rankManager->formatTitle($rank['rankInfo']['name'], $rank['civility']);
        $formatNextTitle = $rankManager->formatTitle($rank['nextRank']['name'], $rank['civility']);
?>
        <a
            href="https://www.twitch.tv/<? echo $rank['username']; ?>"
            target="_blank"
            data-rank="<? echo $count; ?>"
        >
            <div class="rank">
                # <? echo $count; ?>
            </div>

            <div class="avatar">
                <img src="<? echo $rank['profilePicUrl']; ?>">
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

            <div class="level">
                <? echo $formatTitle['level']; ?>
            </div>

            <div class="title">
                <span class="<? echo $rankManager->getRankClass($rank['xp']); ?>">
                    <? echo $formatTitle['title']; ?>
                </span>
            </div>
            
            <div class="nextLevel">
                <? echo $formatNextTitle['level'] . ' d\'ici ' . $rank['xpEstimation']; ?>
            </div>
        </a>
    <? }?>
</section>
