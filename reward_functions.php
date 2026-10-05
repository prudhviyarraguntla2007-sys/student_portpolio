<?php

function addXP($conn, $student_id, $earnedXP)
{
    // Get current reward data
    $sql = "SELECT xp, level FROM rewards WHERE student_id = ?";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $student_id);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    $reward = mysqli_fetch_assoc($result);

    if (!$reward) {
        return;
    }

    $newXP = $reward['xp'] + $earnedXP;
    $newLevel = $reward['level'];

    // Level up while XP reaches 100
    while ($newXP >= 100) {
        $newXP -= 100;
        $newLevel++;
    }

    // Decide badge
    if ($newLevel == 1) {
        $badge = "Beginner";
    } elseif ($newLevel == 2) {
        $badge = "Explorer";
    } elseif ($newLevel == 3) {
        $badge = "Consistent Student";
    } elseif ($newLevel == 4) {
        $badge = "Academic Star";
    } else {
        $badge = "Top Performer";
    }

    // Update rewards table
    $sql = "UPDATE rewards
            SET xp = ?, level = ?, badge = ?
            WHERE student_id = ?";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param(
        $stmt,
        "iisi",
        $newXP,
        $newLevel,
        $badge,
        $student_id
    );

    mysqli_stmt_execute($stmt);
}

?>