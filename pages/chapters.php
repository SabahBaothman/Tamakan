<?php 
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../../style.css">
    <!-- Favicon icon-->
	<link rel="shortcut icon" type="images/x-icon" href="../images/blueLogo.ico" />
    <title>Chapters</title>
</head>
<?php include('../backend/fetchChapters.php'); ?>
<?php include('./nav.php'); ?>

<body>
    <div class="paddContainer">

        <!-- HEADER -->
        <div class="header">
            <h2 class="pageTitle">Chapters</h2>
            <div class="pageSubtitle">
                <p><span><?php echo htmlspecialchars($course['name']); ?> / <?php echo htmlspecialchars($course_id); ?></span></p>
                <?php if ($user_type == 't'): ?>
                    <form action="../backend/goToAddChapter.php" method="post" class="chaptersBtn">
                        <input type="hidden" name="course_id" value="<?php echo htmlspecialchars($course_id); ?>">
                        <button type="submit" class="button">Add Chapter</button>
                    </form>
                <?php endif; ?>
            </div>
        </div>

        <!-- CHAPTERS -->
        <?php if (count($chapters) > 0): ?>
            <div id="chapters">
                <?php foreach ($chapters as $chapter): ?>
                    <form action="lessons.php" method="POST" class="chapterCard">
                        <input type="hidden" name="course_id" value="<?php echo htmlspecialchars($course_id); ?>">
                        <input type="hidden" name="chapter_title" value="<?php echo htmlspecialchars($chapter['title']); ?>">
                        <input type="hidden" name="chapter_number" value="<?php echo htmlspecialchars($chapter['number']); ?>">
                        <a href="#" onclick="this.closest('form').submit(); return false;">
                            <h1>CH<?php echo htmlspecialchars($chapter['number']); ?></h1>
                            <div>
                                <p><?php echo htmlspecialchars($chapter['title']); ?></p>
                            </div>
                        </a>
                    </form>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="no-content">
                <img src="../images/noContent.png" alt="No Content" width="400">
                <h2>No Content Found</h2>
            </div>
        <?php endif; ?>

    </div>
</body>
</html>
