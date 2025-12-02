<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Explosion Finale</title>
  <style>
    body, html {
      margin: 0;
      padding: 0;
      height: 100%;
      background-color: white;
      overflow: hidden;
      transition: background-color 0.1s linear;
    }

    .container {
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      height: 100vh;
      text-align: center;
    }

    img {
      width: 150px;
      height: auto;
    }

    #timer {
      margin-top: 20px;
      font-size: 30px;
      font-weight: bold;
      color: black;
    }

    .explode {
      animation: explodeFlash 0.6s ease-out, explodeShake 0.6s ease-out;
    }

    @keyframes explodeFlash {
      0% { background-color: white; }
      20% { background-color: yellow; }
      40% { background-color: orange; }
      60% { background-color: red; }
      100% { background-color: black; }
    }

    @keyframes explodeShake {
      0% { transform: translateX(0); }
      20% { transform: translateX(-15px); }
      40% { transform: translateX(15px); }
      60% { transform: translateX(-10px); }
      80% { transform: translateX(10px); }
      100% { transform: translateX(0); }
    }

    /* Explosion géante FIXE */
    #megaExplosion {
      position: fixed;
      width: 80vw;
      left: 50%;
      top: 50%;
      transform: translate(-50%, -50%);
      display: none;
      z-index: 900;
    }

    /* Petites explosions */
    .miniBoom {
      position: absolute;
      width: 120px;
      opacity: 0;
      pointer-events: none;
      transition: opacity 0.2s ease-out;
      z-index: 999;
    }
  </style>
</head>
<body>
  <div class="container" id="content">
    <img id="gif" src="img/chargement.gif" alt="Chargement">
    <div id="timer"></div>
  </div>

  <!-- Explosion géante -->
  <img id="megaExplosion" src="img/boum.gif" alt="Explosion géante">

  <!-- Son en boucle -->
  <audio id="boomSound" src="img/boum_musique.mp3" loop></audio>

  <script>
    const boomSound = document.getElementById("boomSound");
    let soundUnlocked = false;

    // Débloque le son au premier clic
    document.addEventListener("click", () => {
      if (!soundUnlocked) {
        boomSound.play().then(() => {
          boomSound.pause();
          boomSound.currentTime = 0;
        });
        soundUnlocked = true;
      }
    });

    let timeLeft = Math.floor(Math.random() * 11) + 5;
    const timerDisplay = document.getElementById("timer");
    const gif = document.getElementById("gif");
    const mega = document.getElementById("megaExplosion");

    timerDisplay.textContent = timeLeft;

    const countdown = setInterval(() => {
      timeLeft--;
      timerDisplay.textContent = timeLeft;

      if (timeLeft <= 0) {
        clearInterval(countdown);
        timerDisplay.style.display = "none"; // 🎯 Timer disparaît
        triggerExplosion();
        startFlashSequence();
      }
    }, 1000);

    function triggerExplosion() {
      gif.style.opacity = "0";
      document.body.classList.add("explode");
    }

    // 3 cycles => 6 changements
    function startFlashSequence() {
      let isRed = false;
      let flashes = 0;

      const flash = setInterval(() => {
        document.body.style.backgroundColor = isRed ? "black" : "red";
        isRed = !isRed;
        flashes++;

        if (flashes >= 6) {
          clearInterval(flash);
          launchMegaExplosion();
        }
      }, 1100);
    }

    function launchMegaExplosion() {
      mega.style.display = "block";

      if (soundUnlocked) {
        boomSound.currentTime = 0;
        boomSound.play(); // 🎵 Son en boucle OK
      }

      // Début du spam d'explosions par dessus
      setInterval(spawnMiniExplosion, 200);
    }

    function spawnMiniExplosion() {
      const boom = document.createElement("img");
      boom.src = "img/boum.gif";
      boom.className = "miniBoom";

      boom.style.left = Math.random() * window.innerWidth + "px";
      boom.style.top = Math.random() * window.innerHeight + "px";

      document.body.appendChild(boom);

      setTimeout(() => boom.style.opacity = 1, 20);

      setTimeout(() => {
        boom.style.opacity = 0;
        setTimeout(() => boom.remove(), 200);
      }, 300);
    }
  </script>
</body>
</html>
