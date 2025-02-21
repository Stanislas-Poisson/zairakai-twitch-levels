<section id="top10">
    <h2>Les futurs VIP <i>Ou pas ;)</i></h2>
<?php
    $count = 0;

    foreach ($top10 as $rank) {
        ++$count;
        $formatTitle = $rankManager->formatTitle($rank['rankInfo']['name'], $rank['civility']);
?>
        <a
            href="https://www.twitch.tv/<? echo $rank['username']; ?>"
            target="_blank"
            data-rank="<? echo $count; ?>"
        >
            <div class="rank">
                # <? echo $count; ?>
            </div>

            <div>
                <? if (5 >= $count): ?>
                    <img src="assets/images/music.png" class="role">
                <? endif; ?>
            </div>

            <div class="avatar">
                <img src="<? echo $rank['profilePicUrl']; ?>">
            </div>

            <div class="username">
            <?
                if (! empty($rank['roles'])) {
                    foreach ($rank['roles'] as $role) {
                        echo '<img src="assets/images/' . $role . '.png" class="role">';
                    }
                }
                echo $rank['username'];
            ?>
            </div>
        </a>
    <? } ?>
</section>
