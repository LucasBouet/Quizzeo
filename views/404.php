<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Non Trouvée - Erreur 404</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        }
        
        body {
            background-color: #fefefe;
            color: #5a5a5a;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 30px 20px;
            text-align: center;
            line-height: 1.6;
        }
        
        .container {
            max-width: 800px;
            width: 100%;
            background-color: #ffffff;
            border-radius: 24px;
            padding: 50px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.05);
            border: 1px solid #f0f0f0;
        }
        
        .logo-container {
            margin-bottom: 30px;
        }
        
        .logo {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            font-size: 24px;
            font-weight: 700;
            color: #8B93FF;
            padding: 12px 24px;
            background-color: #f8f9ff;
            border-radius: 16px;
        }
        
        .error-code {
            font-size: 120px;
            font-weight: 800;
            color: #FFB6C1;
            line-height: 1;
            margin-bottom: 10px;
            text-shadow: 0 4px 12px rgba(255, 182, 193, 0.15);
        }
        
        .error-title {
            font-size: 32px;
            margin-bottom: 20px;
            color: #7a7a7a;
            font-weight: 600;
        }
        
        .error-message {
            font-size: 18px;
            margin-bottom: 40px;
            color: #8a8a8a;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }
        
        .connection-assistant {
            background-color: #fafafa;
            border-radius: 20px;
            padding: 30px;
            margin-bottom: 30px;
            text-align: left;
            border: 1px solid #f0f0f0;
        }
        
        .connection-assistant h3 {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 20px;
            color: #7a7a7a;
            font-weight: 600;
            font-size: 20px;
        }
        
        .connection-assistant h3 i {
            color: #8B93FF;
            font-size: 22px;
        }
        
        .dropdown-container {
            position: relative;
            width: 100%;
        }
        
        .dropdown-btn {
            background-color: #f5f7ff;
            color: #5a5a5a;
            padding: 18px 24px;
            border: 2px solid #e6e9ff;
            border-radius: 14px;
            width: 100%;
            text-align: left;
            font-size: 17px;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: all 0.25s ease;
        }
        
        .dropdown-btn:hover {
            background-color: #f0f3ff;
            border-color: #d5dbff;
        }
        
        .dropdown-content {
            display: none;
            background-color: #ffffff;
            border-radius: 14px;
            padding: 20px;
            margin-top: 12px;
            color: #5a5a5a;
            box-shadow: 0 8px 24px rgba(139, 147, 255, 0.1);
            border: 1px solid #f0f0f0;
        }
        
        .dropdown-content.show {
            display: block;
            animation: fadeIn 0.3s ease;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .problem-item {
            padding: 16px;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.2s;
            margin-bottom: 8px;
            border: 1px solid transparent;
        }
        
        .problem-item:hover {
            background-color: #fafafa;
            border-color: #f0f0f0;
        }
        
        .problem-item:last-child {
            margin-bottom: 0;
        }
        
        .problem-item h4 {
            color: #7a7a7a;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 600;
            font-size: 17px;
        }
        
        .problem-item p {
            color: #8a8a8a;
            font-size: 15px;
            line-height: 1.6;
        }
        
        .solution {
            display: none;
            margin-top: 16px;
            padding: 18px;
            background-color: #f9fbff;
            border-radius: 12px;
            border-left: 4px solid #8B93FF;
        }
        
        .solution.show {
            display: block;
            animation: slideDown 0.3s ease;
        }
        
        @keyframes slideDown {
            from { opacity: 0; max-height: 0; }
            to { opacity: 1; max-height: 500px; }
        }
        
        .loading-container {
            display: none;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 30px;
            background-color: #fafafa;
            border-radius: 16px;
            margin-top: 20px;
            border: 1px dashed #e0e0e0;
        }
        
        .loading-container.show {
            display: flex;
        }
        
        .loading-text {
            font-size: 17px;
            color: #8a8a8a;
            margin-top: 20px;
        }
        
        .action-buttons {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 30px;
            flex-wrap: wrap;
        }
        
        .btn {
            padding: 16px 32px;
            border-radius: 14px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.25s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            border: none;
        }
        
        .btn-primary {
            background-color: #8B93FF;
            color: white;
            box-shadow: 0 4px 12px rgba(139, 147, 255, 0.25);
        }
        
        .btn-primary:hover {
            background-color: #7a83f0;
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(139, 147, 255, 0.35);
        }
        
        .btn-secondary {
            background-color: white;
            color: #8B93FF;
            border: 2px solid #e6e9ff;
        }
        
        .btn-secondary:hover {
            background-color: #f8f9ff;
            transform: translateY(-3px);
            border-color: #d5dbff;
        }
        
        .footer {
            margin-top: 50px;
            color: #b0b0b0;
            font-size: 14px;
        }
        
        /* Animation du spinner pastel */
        .spinner {
            width: 60px;
            height: 60px;
            position: relative;
        }
        
        .spinner:before {
            content: '';
            box-sizing: border-box;
            position: absolute;
            top: 0;
            left: 0;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            border: 4px solid #f0f0f0;
            border-top-color: #FFB6C1;
            border-bottom-color: #8B93FF;
            animation: spinner 1.2s ease infinite;
        }
        
        @keyframes spinner {
            to {
                transform: rotate(360deg);
            }
        }
        
        /* Icônes colorées pour chaque problème */
        .fa-wifi { color: #8B93FF; }
        .fa-key { color: #FFB6C1; }
        .fa-window-restore { color: #A6E3E9; }
        .fa-server { color: #C9CBFF; }
        
        /* Responsive */
        @media (max-width: 768px) {
            .container {
                padding: 30px;
            }
            
            .error-code {
                font-size: 80px;
            }
            
            .error-title {
                font-size: 26px;
            }
            
            .connection-assistant {
                padding: 24px;
            }
            
            .action-buttons {
                flex-direction: column;
                gap: 16px;
            }
            
            .btn {
                width: 100%;
            }
        }
        
        /* Petites améliorations esthétiques */
        .problem-item h4 i {
            width: 28px;
            text-align: center;
        }
        
        .solution p {
            color: #666;
            line-height: 1.7;
        }
        
        .solution strong {
            color: #8B93FF;
        }
        
        /* Effet de focus pour accessibilité */
        .dropdown-btn:focus,
        .problem-item:focus,
        .btn:focus {
            outline: 2px solid #8B93FF;
            outline-offset: 2px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo-container">
            <div class="logo">
                <i class="fas fa-palette"></i>
                <span>PastelSoft</span>
            </div>
        </div>
        
        <div class="error-code">404</div>
        <h1 class="error-title">Page non trouvée</h1>
        <p class="error-message">
            La page que vous recherchez semble avoir été déplacée, supprimée ou n'existe pas.<br>
            Vous pouvez retourner à l'accueil ou utiliser notre assistant pour résoudre d'éventuels problèmes.
        </p>
        
        <div class="connection-assistant">
            <h3><i class="fas fa-hands-helping"></i> Assistant de connexion</h3>
            <div class="dropdown-container">
                <button class="dropdown-btn" id="dropdownBtn">
                    <span>Sélectionnez un problème de connexion</span>
                    <i class="fas fa-chevron-down" id="dropdownIcon"></i>
                </button>
                <div class="dropdown-content" id="dropdownContent">
                    <div class="problem-item" data-problem="wifi">
                        <h4><i class="fas fa-wifi"></i> Problème de Wi-Fi</h4>
                        <p>Connexion instable ou réseau indisponible</p>
                        <div class="solution" id="solutionWifi">
                            <p><strong>Solution :</strong> Vérifiez que votre Wi-Fi est activé et que vous êtes connecté au bon réseau. Redémarrez votre routeur en le débranchant pendant 30 secondes puis en le rebranchant. Si le problème persiste, contactez votre fournisseur d'accès.</p>
                        </div>
                    </div>
                    
                    <div class="problem-item" data-problem="password">
                        <h4><i class="fas fa-key"></i> Mot de passe incorrect</h4>
                        <p>Impossible de se connecter avec vos identifiants</p>
                        <div class="solution" id="solutionPassword">
                            <p><strong>Solution :</strong> Utilisez la fonction "Mot de passe oublié" pour réinitialiser votre mot de passe. Vérifiez que le CAPS LOCK n'est pas activé. Si vous venez de changer votre mot de passe, assurez-vous d'utiliser le nouveau.</p>
                        </div>
                    </div>
                    
                    <div class="problem-item" data-problem="browser">
                        <h4><i class="fas fa-window-restore"></i> Problème de navigateur</h4>
                        <p>Le site ne s'affiche pas correctement</p>
                        <div class="solution" id="solutionBrowser">
                            <p><strong>Solution :</strong> Essayez de vider le cache de votre navigateur (Ctrl+Shift+Suppr sur Windows, Cmd+Shift+Suppr sur Mac). Mettez à jour votre navigateur vers la dernière version. Essayez avec un autre navigateur (Chrome, Firefox, Edge).</p>
                        </div>
                    </div>
                    
                    <div class="problem-item" data-problem="server">
                        <h4><i class="fas fa-server"></i> Problème de serveur</h4>
                        <p>Le site semble inaccessible</p>
                        <div class="solution" id="solutionServer">
                            <p><strong>Solution :</strong> Le problème peut venir de notre côté. Vérifiez notre statut de service sur notre page Twitter @SupportSociété. Réessayez dans quelques minutes. Si le problème persiste, contactez notre support technique.</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="loading-container" id="loadingContainer">
                <div class="spinner"></div>
                <p class="loading-text" id="loadingText">Diagnostic en cours...</p>
            </div>
        </div>
        
        <div class="action-buttons">
            <a href="/" class="btn btn-primary">
                <i class="fas fa-home"></i> Retour à l'accueil
            </a>
            <button class="btn btn-secondary" id="diagnosticBtn">
                <i class="fas fa-search"></i> Diagnostic automatique
            </button>
            <a href="mailto:support@pastelsoft.com" class="btn btn-secondary">
                <i class="fas fa-envelope"></i> Contacter le support
            </a>
        </div>
    </div>
    
    <div class="footer">
        <p>&copy; 2023 PastelSoft. Tous droits réservés. | <a href="/privacy" style="color: #b0b0b0; text-decoration: underline;">Politique de confidentialité</a></p>
    </div>

    <script>
        // Gestion du menu déroulant
        const dropdownBtn = document.getElementById('dropdownBtn');
        const dropdownIcon = document.getElementById('dropdownIcon');
        const dropdownContent = document.getElementById('dropdownContent');
        const loadingContainer = document.getElementById('loadingContainer');
        const loadingText = document.getElementById('loadingText');
        const diagnosticBtn = document.getElementById('diagnosticBtn');
        
        dropdownBtn.addEventListener('click', function() {
            dropdownContent.classList.toggle('show');
            dropdownIcon.classList.toggle('fa-chevron-down');
            dropdownIcon.classList.toggle('fa-chevron-up');
        });
        
        // Gestion des problèmes de connexion
        const problemItems = document.querySelectorAll('.problem-item');
        
        problemItems.forEach(item => {
            item.addEventListener('click', function() {
                const problemType = this.getAttribute('data-problem');
                const solution = document.getElementById(`solution${problemType.charAt(0).toUpperCase() + problemType.slice(1)}`);
                
                // Fermer toutes les autres solutions
                document.querySelectorAll('.solution').forEach(sol => {
                    if (sol !== solution) {
                        sol.classList.remove('show');
                    }
                });
                
                // Ouvrir/fermer la solution cliquée
                solution.classList.toggle('show');
            });
        });
        
        // Gestion du diagnostic
        diagnosticBtn.addEventListener('click', function() {
            // Afficher l'animation de chargement
            loadingContainer.classList.add('show');
            loadingText.textContent = "Diagnostic en cours...";
            
            // Désactiver le bouton pendant le diagnostic
            diagnosticBtn.disabled = true;
            diagnosticBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Diagnostic en cours';
            
            // Simuler un diagnostic
            const steps = [
                "Vérification de la connexion Internet...",
                "Test de la connectivité au serveur...",
                "Analyse des paramètres navigateur...",
                "Vérification des services en ligne...",
                "Diagnostic terminé !"
            ];
            
            let step = 0;
            const interval = setInterval(() => {
                if (step < steps.length) {
                    loadingText.textContent = steps[step];
                    step++;
                } else {
                    clearInterval(interval);
                    
                    // Ouvrir automatiquement le menu déroulant
                    dropdownContent.classList.add('show');
                    dropdownIcon.classList.remove('fa-chevron-down');
                    dropdownIcon.classList.add('fa-chevron-up');
                    
                    // Simuler un problème détecté (Wi-Fi)
                    setTimeout(() => {
                        document.getElementById('solutionWifi').classList.add('show');
                        loadingText.textContent = "Problème Wi-Fi détecté. Voir les solutions ci-dessus.";
                        
                        // Réactiver le bouton
                        diagnosticBtn.disabled = false;
                        diagnosticBtn.innerHTML = '<i class="fas fa-search"></i> Diagnostic automatique';
                    }, 800);
                }
            }, 1200);
        });
        
        // Fermer le menu déroulant si on clique en dehors
        window.addEventListener('click', function(event) {
            if (!dropdownBtn.contains(event.target) && !dropdownContent.contains(event.target)) {
                dropdownContent.classList.remove('show');
                dropdownIcon.classList.remove('fa-chevron-up');
                dropdownIcon.classList.add('fa-chevron-down');
            }
        });
        
        // Animation douce au chargement de la page
        document.addEventListener('DOMContentLoaded', function() {
            document.body.style.opacity = '0';
            document.body.style.transition = 'opacity 0.5s ease';
            
            setTimeout(() => {
                document.body.style.opacity = '1';
            }, 100);
        });
    </script>
</body>
</html>