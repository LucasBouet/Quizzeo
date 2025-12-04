<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quizz</title>
</head>
<body>
    <?php if ($creatorRole == 'Entreprise'): ?>
        <form method="post" action="#">
            <h1>Quizz '<?php echo $quizzData['Name']; ?>'</h1>
            <h2>You can share the quizz with <a href="/quizz?quizz=<?php echo $quizzData['ID']; ?>">this link</a></h2>
            <input type="hidden" name="userId" value="<?php echo $userId; ?>">
            <input type="hidden" name="quizzId" value="<?= $quizz ?>">
            <?php foreach($questions as $question): ?>
                <?php if (is_array($question)): ?>
                    <?php if ($question['Type'] == "libre"): ?>
                        <div class="question">
                            <label for="answer-<?php echo $question['Position']; ?>"><?php echo $question['Question']; ?></label>
                            <input type="text" name="answer[<?php echo $question['Position']; ?>]" id="answer-<?php echo $question['Position']; ?>" required>
                        </div>
                    <?php endif; ?>
                    <?php if ($question['Type'] == "checkbox"): ?>
                        <div class="question">
                            <label for="answer-<?php echo $question['Position']; ?>"><?php echo $question['Question']; ?></label>
                            <?php foreach($reponses[$question['Position']] as $answer): ?>
                                <div>
                                    <input type="checkbox" name="answer[<?php echo $question['Position']; ?>][]" value="<?php echo $answer['ID']; ?>" id="answer-<?php echo $question['Position']; ?>-<?php echo $answer['ID']; ?>">
                                    <label for="answer-<?php echo $question['Position']; ?>-<?php echo $answer['ID']; ?>"><?php echo $answer['Text']; ?></label>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            <?php endforeach; ?>
            <button type="submit">Submit</button>
        </form>
    <?php endif; ?>
    <?php if ($creatorRole == 'Ecole'): ?>
        <form action="#" method="POST">
            <h1>Quizz '<?php echo $quizzData['Name']; ?>'</h1>
            <h2>You can share the quizz with <a href="/quizz?quizz=<?php echo $quizzData['ID']; ?>">this link</a></h2>
            <input type="hidden" name="userId" value="<?php echo $userId; ?>">
            <input type="hidden" name="quizzId" value="<?= $quizz ?>">
            <?php foreach($questions as $question): ?>
                <?php if (is_array($question)): ?>
                    <?php if ($question['Type'] == 'libre'): ?>
                        <div class="question">
                            <input type="hidden" name="questionId[<?php echo $question['Position']; ?>]" value="<?php echo $question['ID']; ?>">
                            <label for="answer-<?php echo $question['Position']; ?>"><?php echo $question['Question']; ?> -- <?= $question['Points'] ?> Points</label>
                            <input type="text" name="answer[<?php echo $question['Position']; ?>]" id="answer-<?php echo $question['Position']; ?>" required>
                        </div>
                    <?php endif; ?>
                    <?php if ($question['Type'] == 'checkbox'): ?>
                        <div class="question">
                            <label for="answer-<?php echo $question['Position']; ?>"><?php echo $question['Question']; ?> -- <?= $question['Points'] ?> Points</label>
                            <?php foreach($reponses[$question['Position']] as $answer): ?>
                                <div>
                                    <input type="hidden" name="questionId[<?php echo $question['Position'] ?>]" value="<?php echo $question['ID']; ?>">
                                    <input type="checkbox" name="answer[<?php echo $question['Position']; ?>][]" value="<?php echo $answer['ID']; ?>" id="answer-<?php echo $question['Position']; ?>-<?php echo $answer['ID']; ?>">
                                    <label for="answer-<?php echo $question['Position']; ?>-<?php echo $answer['ID']; ?>"><?php echo $answer['Text']; ?></label>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            <?php endforeach; ?>
            <button type="submit">Submit</button>
        </form>
    <?php endif; ?>
</body>
</html>