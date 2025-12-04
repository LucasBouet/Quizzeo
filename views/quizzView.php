<div class="pt-30 min-h-screen bg-cover bg-center" style="background-image: url('img/mesh.svg');">
    <div class="max-w-4xl mx-auto p-6 bg-white/70 backdrop-blur-md rounded-2xl shadow-2xl border border-white/50">

        <?php if ($creatorRole == 'Entreprise'): ?>
            <form method="post" action="#" class="card bg-gray-300 shadow-xl p-8 space-y-6 text-stone-800">
                <h1 class="text-4xl font-extrabold text-primary mb-2"><?php echo $quizzData['Name']; ?></h1>
                <h2 class="text-sm text-gray-500 mb-6">You can share the quizz with <a href="/quizz?quizz=<?php echo $quizzData['ID']; ?>" class="link link-hover text-info font-medium">this link</a></h2>
                <input type="hidden" name="userId" value="<?php echo $userId; ?>">
                <input type="hidden" name="quizzId" value="<?= $quizz ?>">
                <?php foreach($questions as $question): ?>
                    <?php if (is_array($question)): ?>
                        <?php if ($question['Type'] == "libre"): ?>
                            <div class="question p-4 bg-gray-200 rounded-lg border border-gray-200">
                                <label for="answer-<?php echo $question['Position']; ?>" class="label-text font-semibold text-lg mb-2 block"><?php echo $question['Question']; ?></label>
                                <input type="text" name="answer[<?php echo $question['Position']; ?>]" id="answer-<?php echo $question['Position']; ?>" required class="input input-bordered w-full">
                            </div>
                        <?php endif; ?>
                        <?php if ($question['Type'] == "checkbox"): ?>
                            <div class="question p-4 bg-gray-200 rounded-lg border border-gray-200">
                                <label for="answer-<?php echo $question['Position']; ?>" class="label-text font-semibold text-lg mb-4 block"><?php echo $question['Question']; ?></label>
                                <div class="space-y-2">
                                    <?php foreach($reponses[$question['Position']] as $answer): ?>
                                        <div class="form-control flex-row items-center space-x-3">
                                            <input type="checkbox" name="answer[<?php echo $question['Position']; ?>][]" value="<?php echo $answer['ID']; ?>" id="answer-<?php echo $question['Position']; ?>-<?php echo $answer['ID']; ?>" class="checkbox checkbox-primary">
                                            <label for="answer-<?php echo $question['Position']; ?>-<?php echo $answer['ID']; ?>" class="label cursor-pointer">
                                                <span class="label-text"><?php echo $answer['Text']; ?></span>
                                            </label>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                <?php endforeach; ?>
                <button type="submit" class="btn btn-primary w-full mt-8">Submit</button>
            </form>
        <?php endif; ?>

        <?php if ($creatorRole == 'Ecole'): ?>
            <form action="#" method="POST" class="card bg-gray-300 shadow-xl p-8 space-y-6 text-stone-800">
                <h1 class="text-4xl font-extrabold text-primary mb-2"><?php echo $quizzData['Name']; ?></h1>
                <h2 class="text-sm text-gray-500 mb-6">You can share the quizz with <a href="/quizz?quizz=<?php echo $quizzData['ID']; ?>" class="link link-hover text-info font-medium">this link</a></h2>
                <input type="hidden" name="userId" value="<?php echo $userId; ?>">
                <input type="hidden" name="quizzId" value="<?= $quizz ?>">
                <?php foreach($questions as $question): ?>
                    <?php if (is_array($question)): ?>
                        <?php if ($question['Type'] == 'libre'): ?>
                            <div class="question p-4 bg-gray-200 rounded-lg border border-gray-200">
                                <input type="hidden" name="questionId[<?php echo $question['Position']; ?>]" value="<?php echo $question['ID']; ?>">
                                <label for="answer-<?php echo $question['Position']; ?>" class="label-text font-semibold text-lg mb-2 block"><?php echo $question['Question']; ?> <span class="text-accent font-normal text-sm">-- <?= $question['Points'] ?> Points</span></label>
                                <input type="text" name="answer[<?php echo $question['Position']; ?>]" id="answer-<?php echo $question['Position']; ?>" required class="input input-bordered w-full">
                            </div>
                        <?php endif; ?>
                        <?php if ($question['Type'] == 'checkbox'): ?>
                            <div class="question p-4 bg-gray-200 rounded-lg border border-gray-200">
                                <label for="answer-<?php echo $question['Position']; ?>" class="label-text font-semibold text-lg mb-4 block"><?php echo $question['Question']; ?> <span class="text-accent font-normal text-sm">-- <?= $question['Points'] ?> Points</span></label>
                                <div class="space-y-2">
                                    <?php foreach($reponses[$question['Position']] as $answer): ?>
                                        <div class="form-control flex-row items-center space-x-3">
                                            <input type="hidden" name="questionId[<?php echo $question['Position'] ?>]" value="<?php echo $question['ID']; ?>">
                                            <input type="checkbox" name="answer[<?php echo $question['Position']; ?>][]" value="<?php echo $answer['ID']; ?>" id="answer-<?php echo $question['Position']; ?>-<?php echo $answer['ID']; ?>" class="checkbox checkbox-primary">
                                            <label for="answer-<?php echo $question['Position']; ?>-<?php echo $answer['ID']; ?>" class="label cursor-pointer">
                                                <span class="label-text"><?php echo $answer['Text']; ?></span>
                                            </label>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                <?php endforeach; ?>
                <button type="submit" class="btn btn-primary w-full mt-8">Submit</button>
            </form>
        <?php endif; ?>
        </div>
</div>
</body>
</html>