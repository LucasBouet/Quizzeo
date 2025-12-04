<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/styles/home.css">
    <title><?php $titleNav = explode('?', $_SERVER['REQUEST_URI'])[0]; if ($titleNav == "/") {$titleNav = 'home';} else {$titleNav = str_replace('/', '', $titleNav);} echo $titleNav; ?></title>
</head>
<body>
    <nav class="navbar bg-white shadow-md px-6 py-4 border-b border-[#f7e4e4] fixed top-0 left-0 w-full z-50">
      <div class="navbar-start">
        <a href="/" class="flex items-center gap-2">
          <img src="img/logo.png" class="h-12" alt="Quizzeo Logo" />
          <!-- Optional text if you want -->
          <!-- <span class="text-3xl font-extrabold tracking-wide text-[#F49CA0] drop-shadow">Quizzeo</span> -->
        </a>
      </div>
    
      <div class="navbar-center hidden lg:flex">
        <ul class="menu menu-horizontal px-1 text-lg font-semibold">
            <li class='mx-5'>
              <button class="rounded-xl border-2 border-[#BCA5E3] text-[#6f57a8] hover:bg-[#BCA5E3]/20 transition-all px-4 py-2" onclick='joinQuizzPrompt()'>
                Join Quizz
              </button>
              </li>
              <script>
                function joinQuizzPrompt() {
                  const quizzId = prompt("Enter the Quizz ID:");
                  if (quizzId) {
                    window.location.href = `/quizz?quizz=${encodeURIComponent(quizzId)}`;
                  }
                }
              </script>
          <li class='mx-5'>
            <a class="rounded-xl border-2 border-[#F49CA0] text-[#d66b71] hover:bg-[#F49CA0]/20 transition-all px-4 py-2" href="/create">
              Create Quizz
            </a>
          </li>
        </ul>
      </div>
    
      <div class="navbar-end flex gap-3">
        <?php if (isset($username)): ?>
            <p class='text-black'>Connected as <?= $username ?></p>
        <?php endif; ?>
        <a class="btn rounded-xl bg-[#BCA5E3] border-none text-white shadow-md hover:bg-[#a58ed0]" href="/login">
          Login
        </a>
        <a class="btn rounded-xl bg-[#F8C873] border-none text-white shadow-md hover:bg-[#e7b760]" href="/register">
          Register
        </a>
      </div>
    </nav>