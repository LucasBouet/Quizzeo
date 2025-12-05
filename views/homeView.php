
    <div class="pt-32 min-h-screen bg-cover bg-center" style="background-image: url('img/mesh.svg');">
        <div class="max-w-4xl mx-auto p-6 bg-white/70 backdrop-blur-md rounded-2xl shadow-2xl border border-white/50">
            <?php if ($jwt['body']['role'] == 'Admin'): ?>
                <h2 class="text-[#BCA5E3] drop-shadow text-3xl font-bold mb-5">Listes des utilisateurs :</h2>
                <?php $users = getAllUsers(); ?>
                <div class="text-stone-800">
                <?php foreach ($users as $user): ?>
                    <div class="mb-4 p-4 bg-gray-300 rounded-lg shadow">
                        <p><strong>Username:</strong> <?= htmlspecialchars($user['Username']) ?></p>
                        <p><strong>Role:</strong> <?= htmlspecialchars($user['Role']) ?></p>
                        <p><strong>Status:</strong> <?= $user['Active'] ? 'Active' : 'Inactive' ?></p>
                        <?php if ($user['Role'] !== 'Admin'): ?>
                            <?php if ($user['Active']): ?>
                                <form method="POST" action="#" class="inline">
                                    <input type="hidden" name="function" value="deactivateUser">
                                    <input type="hidden" name="userId" value="<?= htmlspecialchars($user['ID']); ?>">
                                    <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Deactivate</button>
                                </form>
                            <?php else: ?>
                                <form method="POST" action="#" class="inline">
                                    <input type="hidden" name="function" value="activateUser">
                                    <input type="hidden" name="userId" value="<?= htmlspecialchars($user['ID']); ?>">
                                    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Activate</button>
                                </form>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
                </div>
                <h2 class="text-[#BCA5E3] drop-shadow text-3xl font-bold mb-5">Listes des Quizzs :</h2>
                <?php $quizzs = getAllQuizzs(); ?>
                <div class="text-stone-800">
                <?php foreach ($quizzs as $quizz): ?>
                    <div class="mb-4 p-4 bg-gray-300 rounded-lg shadow">
                        <p><strong>Name:</strong> <?= htmlspecialchars($quizz['Name']) ?></p>
                        <p><strong>Creator:</strong> <?= htmlspecialchars(getUserFromId($quizz['Creator_id'])['Username']) ?></p>
                        <p><strong>Status:</strong> <?= $quizz['Finished'] ? 'Finished' : 'In progress...' ?></p>
                        <p><strong>Status:</strong> <?= $quizz['Active'] ? 'Active' : 'Inactive' ?></p>
                        <?php if ($quizz['Active']): ?>
                            <form method="POST" action="#" class="inline">
                                <input type="hidden" name="function" value="deactivateQuizz">
                                <input type="hidden" name="quizzId" value="<?= htmlspecialchars($quizz['ID']); ?>">
                                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Deactivate</button>
                            </form>
                        <?php else: ?>
                            <form method="POST" action="#" class="inline">
                                <input type="hidden" name="function" value="activateQuizz">
                                <input type="hidden" name="quizzId" value="<?= htmlspecialchars($quizz['ID']) ?>">
                                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Activate</button>
                            </form>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
                </div>
            <?php endif; ?>
            <?php if ($jwt['body']['role'] == 'Ecole'): ?>
                <h2 class="text-[#BCA5E3] drop-shadow text-3xl font-bold mb-5">Vos quizzs :</h2>
                <?php $quizzs = getQuizzByCreatorId($jwt['body']['user_id']); ?>
                <?php foreach($quizzs as $quizz): ?>
                    <div class="mb-4 p-4 bg-gray-300 rounded-lg shadow text-stone-800">
                        <p><strong>Name:</strong> <?= htmlspecialchars($quizz['Name']) ?></p>
                        <p><strong>Status:</strong> <?= $quizz['Finished'] ? 'Finished' : 'In progress...' ?></p>
                        <p><strong>Status:</strong> <?= $quizz['Active'] ? 'Active' : 'Inactive' ?></p>
                        <p><strong>Nombre participations:</strong> <?= getNumberParticipationByQuizzId($quizz['ID']); ?></p>
                        <p><strong>Moyenne:</strong> <?= getAverageNoteByQuizzId($quizz['ID']); ?></p>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
            <?php if ($jwt['body']['role'] == 'Entreprise'): ?>
                <h2 class="text-[#BCA5E3] drop-shadow text-3xl font-bold mb-5">Vos quizzs :</h2>
            
                <?php $quizzs = getQuizzByCreatorId($jwt['body']['user_id']); ?>
                <?php foreach($quizzs as $quizz): ?>
                    <div class="mb-4 p-4 bg-gray-300 rounded-lg shadow text-stone-800">
            
                        <p><strong>Name:</strong> <?= htmlspecialchars($quizz['Name']) ?></p>
                        <p><strong>Status:</strong> <?= $quizz['Finished'] ? 'Finished' : 'In progress...' ?></p>
                        <p><strong>Status:</strong> <?= $quizz['Active'] ? 'Active' : 'Inactive' ?></p>
                        <p><strong>Nombre participations:</strong> <?= getNumberParticipationByQuizzId($quizz['ID']); ?></p>
                        <br/>
            
                        <?php 
                        $maxPosition = getMaxPositionEntreprise($quizz['ID']);
                        for ($i = 1; $i <= $maxPosition; $i++):
                            $question = getQuestionEntrepriseByQuizzAndPosition($quizz['ID'], $i);
            
                            if (is_array($question)): ?>
                                <div class="mb-4 p-4 bg-gray-200 rounded-lg shadow text-stone-800">
            
                                    <h2 class="font-bold mb-3"><?= htmlspecialchars($question['Question']); ?></h2>
            
                                    <!--<pre><?php //var_dump($question); ?></pre>-->
            
                                    <?php if ($question['Type'] == 'libre'): ?>
                                        <?php $reponsesLibres = getReponseLibreEntrepriseById($question['ID']); ?>
                                        
                                        <?php if (is_array($reponsesLibres)): ?>
                                            <?php foreach ($reponsesLibres as $reponse): ?>
                                                <div class="ml-4 mb-3 p-2 bg-white rounded shadow">
                                                    <p><?= htmlspecialchars($reponse['Text']); ?></p>
                                                </div>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                    <?php if ($question['Type'] == 'checkbox'): ?>
                                        <?php $reponses = getReponseQcmEntrepriseByQuestionId($question['ID']); ?>
                                        <?php if (is_array($reponses)): ?>
                                            <?php foreach($reponses as $reponse): ?>
                                                <div class="ml-4 mb-3 p-2 bg-white rounded shadow">
                                                    <p><?= htmlspecialchars($reponse['Text']); ?> -- <?= htmlspecialchars($reponse['Answered']); ?> reponses</p>
                                                </div>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                        <?php endfor; ?>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
            <?php if ($jwt['body']['role'] == 'Default'): ?>
                <h2 class="text-[#BCA5E3] drop-shadow text-3xl font-bold mb-5">Bienvenue, <?= htmlspecialchars($username); ?> !</h2>
                <p class="text-stone-800">Vous avez pour le moment repondu a <?= getNumberOfQuizzDoneByUserId($jwt['body']['user_id']) ?> quizz(s)</p>
                <?php $quizzsAnswered = getAnsweredQuizzByUserId($jwt["body"]['user_id']); ?>
                <?php if (count($quizzsAnswered) > 0): ?>
                    <h3 class="text-2xl font-bold mt-6 mb-4 text-stone-800">Vos réponses :</h3>
                    <div class="text-stone-800">
                        <?php foreach ($quizzsAnswered as $quizz): ?>
                            <div class="mb-4 p-4 bg-gray-300 rounded-lg shadow">
                                <p><strong>Quizz Name:</strong> <?= htmlspecialchars($quizz['Name']) ?></p>
                                <?php $userNoteForQuizz = getUserNoteForQuizz($jwt['body']['user_id'], $quizz['ID']); ?>
                                <?php if ($userNoteForQuizz) : ?>
                                    <p><strong>Votre note:</strong> <?= $userNoteForQuizz; ?></p>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>