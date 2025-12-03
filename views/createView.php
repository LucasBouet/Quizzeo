<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--<link rel="stylesheet" href="assets/styles/home.css">-->
    <title>Create</title>
    <style>
        .quizz { border: 1px solid #ccc; padding: 12px; margin-bottom: 12px; }
        .question { margin: 8px 0; padding: 6px; background: #f9f9f9; }
        .answers-section { margin-top: 8px; }
        details { margin-top: 8px; }
    </style>
</head>
<body>

<?php
switch ($role) {
case "Entreprise":

    echo "<br/>Hello Entreprise!<br/>";
    $quizzs = getAllQuizzs();
?>

<h2>Create new quizz</h2>
<form action="#" method="post">
    <input type="hidden" name="function" value="createQuizz">
    <label for="name">Name:</label>
    <input type="text" id="name" name="name" required>
    <button type="submit">Submit</button>
</form>

<?php if ($quizzs): ?>
    <h2>Existing Quizzes</h2>

    <?php foreach ($quizzs as $quizz): ?>
    <div class="quizz">
        <div>
        <h3><?php echo $quizz['Name']; ?></h3>

        <form method="POST">
            <input type="hidden" name="id" value="<?= $quizz['ID']; ?>">
            <input type="hidden" name="function" value="createQuestionEntreprise">

            <label>Titre de la question :</label>
            <input type="text" name="title">

            <label>Type :</label>
            <select name="type"
                    class="question-type"
                    data-quizz="<?= $quizz['ID']; ?>">
                <option value="libre" selected>Choix libre</option>
                <option value="multiple">Choix multiple</option>
            </select>

            <div class="answers-container"
                 data-container="<?= $quizz['ID']; ?>"
                 style="margin-top:10px;"></div>

            <button type="submit">Créer la question</button>
        </form>
        <form action="#" method="POST">
            <input type="hidden" name="function" value="suppQuizz">
            <input type="hidden" name="id" value="<?= $quizz['ID']; ?>">
            <button type="submit">Supprimer le quizz</button>
        </form>
        </div>
        <div>
            <?php $subArray = $questions[$quizz['ID']]; ?>
            <?php foreach($subArray as $question): ?>
            <?php if ($question): ?>
                <?php if ($question ['Type'] == 'libre'): ?>
                    <div>
                        <form action="#" method="POST">
                            <input type="hidden" name="function" value="updateQuestionLibreEntreprise">
                            <input type="hidden" name="id" value="<?= $question['ID']; ?>">
                            <input type="hidden" name="position" value="<?= $question['Position']; ?>">
                            <label for="question">Titre de la question :</label>
                            <input type="text" name="question" value="<?php echo $question['Question']; ?>">
                            <button type="submit">Mettre à jour</button>
                        </form>
                        <form action="#" method="POST">
                            <input type="hidden" name="function" value="suppQuestionLibreEntreprise">
                            <input type="hidden" name="id" value="<?= $question['ID']; ?>">
                            <button type="submit">Supprimer</button>
                        </form>
                    </div>
                <?php endif; ?>
                <?php if ($question['Type'] == 'checkbox'): ?>
                    <div>
                        <form action="#" method="POST">
                            <input type="hidden" name="function" value="updateQuestionMultiple">
                            <input type="hidden" name="id" value="<?= $question['ID']; ?>">
                            <input type="hidden" name="position" value="<?= $question['Position']; ?>">
                            <label for="question">Titre de la question :</label>
                            <input type="text" name="question" value="<?php echo $question['Question']; ?>">
                            <div class="reponse-update-container">
                                <?php foreach($reponses as $reponse): ?>
                                    <?php if ($reponse['Question_id'] == $question['ID']): ?>
                                        <div class="answer-field" style="margin-bottom:5px;">
                                            <input type="hidden" name="answer_ids[]" value="<?php echo $reponse['ID']; ?>">
                                            <input type="text" name="answers[]" value="<?php echo htmlspecialchars($reponse['Text']); ?>">
                                            <button type="button" class="remove-answer">❌</button>
                                        </div>
                                    <?php endif;?>
                                <?php endforeach; ?>
                            </div>
                            <button type="button" class="add-answer">Ajouter une réponse</button>
                            <button type="submit">Submit</button>
                        </form>
                        <form action="#" method="POST">
                            <input type="hidden" name="function" value="suppQuestionMultiple">
                            <input type="hidden" name="id" value="<?= $question['ID']; ?>">
                            <button type="submit">Supprimer</button>
                        </form>
                    </div>
                <?php endif; ?>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endforeach; ?>

<?php endif; ?>

<?php 
break; 
case 'Ecole':
    echo "Welcome Ecole";
    ?>
    <h2>Create new quizz</h2>
    <form action="#" method="post">
        <input type="hidden" name="function" value="createQuizz">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>
        <button type="submit">Submit</button>
    </form>
    
    <?php if ($quizzs): ?>
        <?php foreach($quizzs as $quizz): ?>
            <div class="quizz">
                <h3><?php echo $quizz['Name']; ?></h3>
                
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
    <?php
    break;
}?>
<?php if ($role == 'Entreprise'): ?>
<script>
document.addEventListener("DOMContentLoaded", () => {

    document.querySelectorAll(".question-type").forEach(select => {

        select.addEventListener("change", event => {
            const quizzId = event.target.dataset.quizz;
            const container = document.querySelector(`.answers-container[data-container="${quizzId}"]`);

            container.innerHTML = ""; // reset

            if (event.target.value === "multiple") {
                addAnswerControls(container);
            }
        });
    });
});

function addAnswerControls(container) {
    const btn = document.createElement("button");
    btn.type = "button";
    btn.textContent = "Ajouter un choix";
    btn.onclick = () => addAnswerField(container);

    container.appendChild(btn);
}

function addAnswerField(container) {
    const div = document.createElement("div");
    div.style.marginTop = "5px";

    div.innerHTML = `
        <input type="text" name="answers[]" placeholder="Réponse possible">
        <button type="button" onclick="this.parentElement.remove()">❌</button>
    `;

    container.appendChild(div);
}

document.addEventListener("DOMContentLoaded", () => {
    // Ajout dynamique de réponses sur les formulaires de modification
    document.querySelectorAll(".add-answer").forEach(btn => {
        btn.addEventListener("click", function () {
            const container = btn.previousElementSibling;
            const field = document.createElement("div");
            field.className = "answer-field";
            field.style.marginBottom = "5px";
            field.innerHTML = `
                <input type="text" name="answers[]" placeholder="Réponse possible">
                <button type="button" class="remove-answer">❌</button>
            `;
            container.appendChild(field);
        });
    });

    // Suppression dynamique des réponses
    document.querySelectorAll(".reponse-update-container").forEach(container => {
        container.addEventListener("click", function (e) {
            if (e.target.classList.contains("remove-answer")) {
                e.target.parentElement.remove();
            }
        });
    });
});
</script>
<?php endif; ?>
</body>
</html>
