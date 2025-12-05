<div class="pt-30 min-h-screen bg-cover bg-center" style="background-image: url('img/mesh.svg');">
    <div class="max-w-4xl mx-auto p-6 bg-white/70 backdrop-blur-md rounded-2xl shadow-2xl border border-white/50">
<?php
switch ($role) {
case "Entreprise":
    $quizzs = getAllQuizzs();
?>

<h2 class="text-5xl font-extrabold text-left mb-8 drop-shadow-lg text-[#a58ed0]">Créer un nouveau quizz</h2>
<form action="#" method="post" class="card bg-gray-300 shadow-xl p-6 mb-10 text-stone-900">
    <input type="hidden" name="function" value="createQuizz">
    <div class="form-control w-full max-w-xs">
        <label for="name" class="label">
            <span class="label-text font-semibold">Nom du Quizz :</span>
        </label>
        <input type="text" id="name" name="name" required class="input input-bordered w-full">
    </div>
    <button type="submit" class="btn btn-primary mt-4">Créer le Quizz</button>
</form>

<?php if ($quizzs): ?>
    <h3 class="text-3xl font-bold mb-6 text-[#F49CA0]">Quizz Existants</h3>

    <div class="space-y-8">
    <?php foreach ($quizzs as $quizz): ?>
    <?php if (isQuizzActive($quizz['ID'])): ?>
        <?php if (getRoleFromQuizzId($quizz['ID']) == 'Entreprise'): ?>
        <div class="quizz card bg-gray-300 text-stone-900 shadow-xl border border-gray-200">
            <div class="card-body p-6">
                <div class="flex justify-between items-start mb-4">
                    <h3 class="card-title text-2xl text-accent-content"><?php echo htmlspecialchars($quizz['Name']); ?></h3>
                    <div class="flex space-x-2 flex-row">
                        <form action="#" method="POST">
                            <input type="hidden" name="function" value="suppQuizz">
                            <input type="hidden" name="id" value="<?= $quizz['ID']; ?>">
                            <button type="submit" class="btn btn-error btn-sm">Supprimer le quizz</button>
                        </form>
                        <form action="#" method="POST">
                            <input type="hidden" name="function" value="activerDesactiverQuizz">
                            <input type="hidden" name="id" value="<?= $quizz['ID']; ?>">
                            <button type="submit" class="btn btn-<?php $statusLocal = isQuizzFinished($quizz['ID']); if (!$statusLocal) {echo "success";} else {echo "error";} ?> btn-sm"><?php if ($statusLocal) {echo "Retirer comme finit";} else {echo 'Marquer comme finit';} ?></button>
                        </form>
                    </div>
                </div>
                <h2 class="text-sm text-gray-500 mb-6">You can share the quizz with <a href="/quizz?quizz=<?php echo htmlspecialchars($quizz['ID']); ?>" class="link link-hover text-info font-medium">this link</a></h2>
    
                <div class="divider"><h4 class='underline'>Ajouter une Question</h4></div>
                <form method="POST" class="space-y-4">
                    <input type="hidden" name="id" value="<?= $quizz['ID']; ?>">
                    <input type="hidden" name="function" value="createQuestionEntreprise">
    
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Titre de la question :</span>
                        </label>
                        <input type="text" name="title" class="input input-bordered">
                    </div>
    
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text">Type :</span>
                        </label>
                        <select name="type"
                                class="question-type select select-bordered"
                                data-quizz="<?= $quizz['ID']; ?>">
                            <option value="libre" selected>Choix libre</option>
                            <option value="multiple">Choix multiple</option>
                        </select>
                    </div>
    
                    <div class="answers-container space-y-3"
                        data-container="<?= $quizz['ID']; ?>"
                        style="margin-top:10px;">
                        </div>
    
                    <button type="submit" class="btn btn-success w-full mt-6">Créer la question</button>
                </form>
            
                <div class="divider mt-8 underline">Questions Existantes</div>
                <div class="space-y-4">
                <?php $subArray = $questions[$quizz['ID']] ?? null; ?>
                <?php foreach($subArray as $question): ?>
                <?php if ($question): ?>
                    <div class="card bg-gray-100 p-4 shadow-md border-l-4 border-l-info">
                        <?php if ($question ['Type'] == 'libre'): ?>
                            <div class="flex flex-col space-y-3">
                                <form action="#" method="POST" class="space-y-2">
                                    <input type="hidden" name="function" value="updateQuestionLibreEntreprise">
                                    <input type="hidden" name="id" value="<?= $question['ID']; ?>">
                                    <input type="hidden" name="position" value="<?= $question['Position']; ?>">
                                    <label for="question" class="label-text font-medium">Titre de la question (Libre) :</label>
                                    <input type="text" name="question" value="<?php echo htmlspecialchars($question['Question']); ?>" class="input input-bordered input-sm w-full">
                                    <button type="submit" class="btn btn-info btn-sm">Mettre à jour</button>
                                </form>
                                <form action="#" method="POST">
                                    <input type="hidden" name="function" value="suppQuestionLibreEntreprise">
                                    <input type="hidden" name="id" value="<?= $question['ID']; ?>">
                                    <button type="submit" class="btn btn-warning btn-sm">Supprimer</button>
                                </form>
                            </div>
                        <?php endif; ?>
                        <?php if ($question['Type'] == 'checkbox'): ?>
                            <div class="flex flex-col space-y-3">
                                <form action="#" method="POST" class="space-y-2">
                                    <input type="hidden" name="function" value="updateQuestionMultiple">
                                    <input type="hidden" name="id" value="<?= $question['ID']; ?>">
                                    <input type="hidden" name="position" value="<?= $question['Position']; ?>">
                                    
                                    <label for="question" class="label-text font-medium">Titre de la question (Multiple) :</label>
                                    <input type="text" name="question" value="<?php echo htmlspecialchars($question['Question']); ?>" class="input input-bordered input-sm w-full mb-3">
                                    
                                    <div class="reponse-update-container space-y-2">
                                        <p class="font-semibold text-sm">Choix de réponses :</p>
                                        <?php foreach($reponses as $reponse): ?>
                                            <?php if ($reponse['Question_id'] == $question['ID']): ?>
                                                <div class="answer-field flex items-center space-x-2" style="margin-bottom:5px;">
                                                    <input type="hidden" name="answer_ids[]" value="<?php echo htmlspecialchars($reponse['ID']); ?>">
                                                    <input type="text" name="answers[]" value="<?php echo htmlspecialchars($reponse['Text']); ?>" class="input input-bordered input-xs flex-grow">
                                                    <button type="button" class="remove-answer btn btn-ghost btn-xs">❌</button>
                                                </div>
                                            <?php endif;?>
                                        <?php endforeach; ?>
                                    </div>
                                    <button type="button" class="add-answer btn btn-info btn-xs mt-3">Ajouter une réponse</button>
                                    <button type="submit" class="btn btn-info btn-sm w-full mt-4">Mettre à jour</button>
                                </form>
                                <form action="#" method="POST">
                                    <input type="hidden" name="function" value="suppQuestionMultiple">
                                    <input type="hidden" name="id" value="<?= htmlspecialchars($question['ID']); ?>">
                                    <button type="submit" class="btn btn-warning btn-sm">Supprimer</button>
                                </form>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
                <?php endforeach; ?>
                </div>
            </div>
            </div>
        <?php endif; ?>
    <?php endif; ?>
    <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php
break;
case 'Ecole':
    ?>
    <h2 class="text-5xl font-extrabold text-left mb-8 text-[#F49CA0] drop-shadow-lg">Créer un nouveau quizz</h2>
    <form action="#" method="post" class="card bg-gray-300 text-stone-900 shadow-xl p-6 mb-10">
        <input type="hidden" name="function" value="createQuizz">
        <div class="form-control w-full max-w-xs">
            <label for="name" class="label">
                <span class="label-text font-semibold">Nom du Quizz :</span>
            </label>
            <input type="text" id="name" name="name" required class="input input-bordered w-full">
        </div>
        <button type="submit" class="btn btn-primary mt-4">Créer le Quizz</button>
    </form>
    
    <?php if ($quizzs): ?>
        <h3 class="text-3xl font-bold mb-6 text-primary">Quizz Existants</h3>
        <div class="space-y-8">
        <?php foreach($quizzs as $quizz): ?>
        <?php if (isQuizzActive($quizz['ID'])): ?>
            <?php if (getRoleFromQuizzId($quizz['ID']) == 'Ecole'): ?>
                <div class="quizz card bg-gray-300 text-stone-900 shadow-xl border border-gray-200">
                    <div class="card-body p-6">
                        <div class="flex justify-between items-start mb-4">
                            <h3 class="card-title text-2xl text-accent-content"><?php echo htmlspecialchars($quizz['Name']); ?></h3>
                            <div class="flex space-x-2 flex-row">
                                <form action="#" method="POST">
                                    <input type="hidden" name="function" value="suppQuizz">
                                    <input type="hidden" name="id" value="<?= htmlspecialchars($quizz['ID']); ?>">
                                    <button type="submit" class="btn btn-error btn-sm">Supprimer le quizz</button>
                                </form>
                                <form action="#" method="POST">
                                    <input type="hidden" name="function" value="activerDesactiverQuizz">
                                    <input type="hidden" name="id" value="<?= htmlspecialchars($quizz['ID']); ?>">
                                    <button type="submit" class="btn btn-<?php $statusLocal = isQuizzFinished($quizz['ID']); if (!$statusLocal) {echo "success";} else {echo "error";} ?> btn-sm"><?php if ($statusLocal) {echo "Retirer comme finit";} else {echo 'Marquer comme finit';} ?></button>
                                </form>
                            </div>
                        </div>
                        <h2 class="text-sm text-gray-500 mb-6">You can share the quizz with <a href="/quizz?quizz=<?php echo $quizz['ID']; ?>" class="link link-hover text-info font-medium">this link</a></h2>
                    
                        <div class="divider"><h4 class="underline">Ajouter une Question</h4></div>
                        <form method="POST" class="space-y-4">
                            <input type="hidden" name="id" value="<?= htmlspecialchars($quizz['ID']); ?>">
                            <input type="hidden" name="function" value="createQuestionEcole">
                    
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text">Titre de la question :</span>
                                </label>
                                <input type="text" name="title" class="input input-bordered">
                            </div>
                    
                            <div class="form-control">
                                <label for="points" class="label">
                                    <span class="label-text">Nb de points :</span>
                                </label>
                                <input type="number" id="points" name="points" min="1" required class="input input-bordered w-full max-w-xs">
                            </div>
                                
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text">Type :</span>
                                </label>
                                <select name="type"
                                        class="question-type select select-bordered"
                                        data-quizz="<?= htmlspecialchars($quizz['ID']); ?>">
                                    <option value="libre" selected>Choix libre</option>
                                    <option value="multiple">Choix multiple</option>
                                </select>
                            </div>
                    
                            <div id='libre-answer-container' class="form-control">
                                </div>
                            
                            <div class="answers-container space-y-3"
                                data-container="<?= $quizz['ID']; ?>"
                                style="margin-top:10px;">
                                </div>
                    
                            <button type="submit" class="btn btn-success w-full mt-6">Créer la question</button>
                        </form>
                        
                        <div class="divider mt-8 underline">Questions Existantes</div>
                        <div class="space-y-4">
                            <?php $subArray = $questions[$quizz['ID']] ?? []; ?>
                            <?php foreach($subArray as $question): ?>
                            <?php if ($question): ?>
                                <div class="card bg-gray-100 p-4 shadow-md border-l-4 border-l-info">
                                    <?php if ($question ['Type'] == 'libre'): ?>
                                        <div class="flex flex-col space-y-3">
                                            <form action="#" method="POST" class="space-y-2">
                                                <input type="hidden" name="function" value="updateQuestionLibreEcole">
                                                <input type="hidden" name="id" value="<?= htmlspecialchars($question['ID']); ?>">
                                                <input type="hidden" name="position" value="<?= htmlspecialchars($question['Position']); ?>">
                                                <label for="question" class="label-text font-medium">Titre de la question (Libre) :</label>
                                                <input type="text" name="question" value="<?php echo htmlspecialchars($question['Question']); ?>" class="input input-bordered input-sm w-full">
                                                
                                                <label for="answer" class="label-text font-medium">Réponse correcte :</label>
                                                <?php
                                                $labelReponseReal = "";
                                                foreach ($reponsesLibres as $rep) {
                                                    if ($rep['ID'] == $question['ID']) {
                                                        $labelReponseReal = $rep['Reponse'];
                                                        break;
                                                    }
                                                }
                                                ?>
                                                <input type="text" name="answer" value="<?php echo htmlspecialchars($labelReponseReal); ?>" class="input input-bordered input-sm w-full">
                                                
                                                <label for="points" class="label-text font-medium">Points :</label>
                                                <input type="number" name="points" value="<?php echo $question['Points']; ?>" class="input input-bordered input-sm w-full max-w-xs">
                                                
                                                <button type="submit" class="btn btn-info btn-sm">Mettre à jour</button>
                                            </form>
                                            <form action="#" method="POST">
                                                <input type="hidden" name="function" value="suppQuestionLibreEcole">
                                                <input type="hidden" name="id" value="<?= htmlspecialchars($question['ID']); ?>">
                                                <button type="submit" class="btn btn-warning btn-sm">Supprimer</button>
                                            </form>
                                        </div>
                                    <?php endif; ?>
                                    <?php if ($question['Type'] == 'checkbox'): ?>
                                        <div class="flex flex-col space-y-3">
                                            <form action="#" method="POST" class="space-y-2">
                                                <input type="hidden" name="function" value="updateQuestionMultipleEcole">
                                                <input type="hidden" name="id" value="<?= htmlspecialchars($question['ID']); ?>">
                                                <input type="hidden" name="position" value="<?= $question['Position']; ?>">
                                            
                                                <label for="question" class="label-text font-medium">Titre de la question (Multiple) :</label>
                                                <input type="text" name="question" value="<?= htmlspecialchars($question['Question']); ?>" class="input input-bordered input-sm w-full mb-3">
                                            
                                                <label for="points" class="label-text font-medium">Points :</label>
                                                <input type="number" name="points" value="<?= htmlspecialchars($question['Points']); ?>" min="1" class="input input-bordered input-sm w-full max-w-xs">
                                            
                                                <div class="reponse-update-container space-y-2 mt-4">
                                                    <p class="font-semibold text-sm">Choix de réponses (Cochez la/les bonne(s)) :</p>
                                                    <?php 
                                                    $i = 0;
                                                    foreach ($reponses as $reponse):
                                                        if ($reponse['Question_id'] == $question['ID']):
                                                    ?>
                                                    <div class="answer-field flex items-center space-x-2" style="margin-bottom:5px;">
                                                        <input type="hidden" name="answer_ids[<?= $i ?>]" value="<?= htmlspecialchars($reponse['ID']); ?>">
                                                    
                                                        <input type="text" name="answers[<?= $i ?>]" value="<?= htmlspecialchars($reponse['Text']); ?>" class="input input-bordered input-xs flex-grow">
                                                    
                                                        <input type="hidden" name="isAnswer[<?= $i ?>]" value="0">
                                                        <input 
                                                            type="checkbox"
                                                            name="isAnswer[<?= $i ?>]"
                                                            value="1"
                                                            class="checkbox checkbox-primary checkbox-xs"
                                                            <?= $reponse['Is_answer'] ? "checked" : "" ?>
                                                        >
                                                    
                                                        <button type="button" class="remove-answer btn btn-ghost btn-xs">❌</button>
                                                    </div>
                                                    <?php 
                                                    $i++;
                                                    endif;
                                                    endforeach;
                                                    ?>
                                                </div>
                                            
                                                <button type="button" class="add-answer btn btn-info btn-xs mt-3">Ajouter une réponse</button>
                                                <button type="submit" class="btn btn-info btn-sm w-full mt-4">Mettre à jour</button>
                                            </form>
    
                                            <form action="#" method="POST">
                                                <input type="hidden" name="function" value="suppQuestionMultiple">
                                                <input type="hidden" name="id" value="<?= htmlspecialchars($question['ID']); ?>">
                                                <button type="submit" class="btn btn-warning btn-sm">Supprimer</button>
                                            </form>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        <?php endif; ?>
        <?php endforeach; ?>
        </div>
    <?php endif; ?>
    <?php
    break;
}?>
</div>
</div>
<?php if ($role == 'Entreprise'): ?>
<script>
document.addEventListener("DOMContentLoaded", () => {

  document.querySelectorAll(".question-type").forEach(select => {
  
          select.addEventListener("change", event => {
              // Find the parent form of the select element
              const parentForm = event.target.closest('form');
              
              // Search for the answers-container DIV *within* that specific form
              const container = parentForm.querySelector('.answers-container');
  
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
    btn.className = "btn btn-info btn-xs"; // DaisyUI/Tailwind class
    btn.onclick = () => addAnswerField(container);

    container.appendChild(btn);
}

function addAnswerField(container) {
    const div = document.createElement("div");
    div.style.marginTop = "5px";

    div.innerHTML = `
        <input type="text" name="answers[]" placeholder="Réponse possible" class="input input-bordered input-xs w-full max-w-xs">
        <button type="button" onclick="this.parentElement.remove()" class="btn btn-ghost btn-xs">❌</button>
    `;

    container.appendChild(div);
}

document.addEventListener("DOMContentLoaded", () => {
    // Ajout dynamique de réponses sur les formulaires de modification
    document.querySelectorAll(".add-answer").forEach(btn => {
        btn.addEventListener("click", function () {
            const container = btn.previousElementSibling;
            const field = document.createElement("div");
            field.className = "answer-field flex items-center space-x-2"; // Tailwind flex for alignment
            field.style.marginBottom = "5px";
            field.innerHTML = `
                <input type="text" name="answers[]" placeholder="Réponse possible" class="input input-bordered input-xs flex-grow">
                <button type="button" class="remove-answer btn btn-ghost btn-xs">❌</button>
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
<?php if ($role == 'Ecole'): ?>
<script>
document.addEventListener("DOMContentLoaded", () => {

    document.querySelectorAll(".add-answer").forEach(btn => {
        btn.addEventListener("click", function () {

            const container = btn.previousElementSibling;

            // index = nombre d'éléments existants
            let index = container.querySelectorAll(".answer-field").length;

            const field = document.createElement("div");
            field.className = "answer-field flex items-center space-x-2"; // Tailwind flex for alignment
            field.style.marginBottom = "5px";

            field.innerHTML = `
                <input type="hidden" name="answer_ids[${index}]" value="0">

                <input type="text" name="answers[${index}]" placeholder="Nouvelle réponse" class="input input-bordered input-xs flex-grow">

                <input type="hidden" name="isAnswer[${index}]" value="0">
                <input type="checkbox" name="isAnswer[${index}]" value="1" class="checkbox checkbox-primary checkbox-xs"> <button type="button" class="remove-answer btn btn-ghost btn-xs">❌</button> `;

            container.appendChild(field);
        });
    });

    // suppression dynamique
    document.querySelectorAll(".reponse-update-container").forEach(container => {
        container.addEventListener("click", e => {
            if (e.target.classList.contains("remove-answer")) {
                e.target.parentElement.remove();
            }
        });
    });

});

document.addEventListener("DOMContentLoaded", () => {
    addAnswerLibre(document.getElementById("libre-answer-container"));
    document.querySelectorAll(".question-type").forEach(select => {
    
            select.addEventListener("change", event => {
                // Find the parent form of the select element
                const parentForm = event.target.closest('form');
                
                // Search for the multiple-choice answers-container DIV *within* that form
                const container = parentForm.querySelector('.answers-container');
                
                // Search for the libre-choice answers-container DIV *within* that form
                const libreContainer = parentForm.querySelector('#libre-answer-container');
                
                container.innerHTML = ""; // reset multiple choice container
                libreContainer.innerHTML = ""; // reset libre choice container
    
                if (event.target.value === "multiple") {
                    addAnswerControls(container);
                } else if (event.target.value === "libre") {
                    addAnswerLibre(libreContainer); // Use the localized libreContainer
                }
            });
        });
});

function addAnswerLibre(container) {
  const input = document.createElement("input");
  input.type = "text";
  input.name = "answerLibre";
  input.placeholder = "Réponse a la question";
  input.className = "input input-bordered w-full"; // DaisyUI class
  container.appendChild(input);
}

function addAnswerControls(container) {
    const btn = document.createElement("button");
    btn.type = "button";
    btn.textContent = "Ajouter un choix";
    btn.className = "btn btn-info btn-xs"; // DaisyUI/Tailwind class
    btn.onclick = () => addAnswerField(container);

    container.appendChild(btn);
}

function addAnswerField(container) {
    const div = document.createElement("div");
    div.style.marginTop = "5px";
    let index = document.querySelector('.answers-container').querySelectorAll('div').length

    div.innerHTML = `
        <input type="text" name="answers[]" placeholder="Réponse possible" class="input input-bordered input-xs w-full max-w-xs">
        <input type="hidden" name="isAnswer[${index}]" value="0">
        <input type="checkbox" name="isAnswer[${index}]" value="1" class="checkbox checkbox-primary checkbox-xs">
        <button type="button" onclick="this.parentElement.remove()" class="btn btn-ghost btn-xs">❌</button>
    `;

    container.appendChild(div);
}
</script>
<?php endif; ?>
</body>
</html>