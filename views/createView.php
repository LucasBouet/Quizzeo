<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create</title>
    <style>
        .quizz { border: 1px solid #ccc; padding: 12px; margin-bottom: 12px; }
        .question { margin: 8px 0; padding: 6px; background: #f9f9f9; }
        .answers-section { margin-top: 8px; }
        details { margin-top: 8px; }
    </style>
</head>
<body>
<?php switch ($role) {
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
                    <h3><?php echo $quizz['Name']; ?></h3>
                    <form method="POST" action="#">
                        <input type="hidden" name="id" value="<?php echo $quizz['ID']; ?>">
                        <input type='hidden' name='function' value='createQuestion'>
                    
                        <label for="title">Titre de la question :</label>
                        <input type="text" name="title" id="title">
                    
                        <label for="type">Type : </label>
                        <select name="type" id="type">
                            <option value="libre">Choix libre</option>
                            <option value="multiple">Choix multiple</option>
                        </select>
                    
                        <div id="answers-container" style="margin-top: 10px;"></div>
                    
                        <button type="submit">Créer la question</button>
                    </form>
                    
                    <script>
                      const typeSelect = document.getElementById("type");
                      const answersContainer = document.getElementById("answers-container");
                      
                      typeSelect.addEventListener("change", function () {
                          answersContainer.innerHTML = "";
                      
                          if (this.value === "multiple") {
                              addAnswerControls();
                          }
                      });
                      
                      function addAnswerControls() {
                          const btn = document.createElement("button");
                          btn.type = "button";
                          btn.textContent = "Ajouter un choix";
                          btn.onclick = addAnswerField;
                      
                          answersContainer.appendChild(btn);
                      }
                      
                      function addAnswerField() {
                          const div = document.createElement("div");
                          div.style.marginTop = "5px";
                      
                          div.innerHTML = `
                              <input type="text" name="answers[]" placeholder="Réponse possible">
                              <button type="button" onclick="this.parentElement.remove()">❌</button>
                          `;
                      
                          answersContainer.appendChild(div);
                      }
                    </script>

                </div>
            <?php endforeach; ?>
        <?php endif; ?>
        <?php break;
    case "Ecole":
        echo "<br/>Hello Ecole!<br/>";
        break;
    case "Admin":
        echo "<br/>Hello Admin!<br/>";
        break;
    default:
        echo "<br/>Your role does not allow you to access this page.<br/>";
} ?>
</body>
</html>
