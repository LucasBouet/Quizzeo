<div class="pt-32 min-h-screen bg-cover bg-center flex items-start justify-center px-4 text-black"
     style="background-image: url('img/mesh.svg');">

    <div class="w-full max-w-md bg-white/80 backdrop-blur-md shadow-xl rounded-2xl p-8 border border-[#f7e4e4]">

        <h2 class="text-3xl font-extrabold text-center mb-6 text-[#F49CA0] drop-shadow">
            Login to Quizzeo
        </h2>

        <a href="/register"
           class="block text-center mb-6 text-[#6f57a8] hover:underline">
            No account? Register here
        </a>

        <form action="#" method="POST" class="space-y-5">

            <div>
                <label for="username" class="block font-semibold mb-1">Username:</label>
                <input type="text" id="username" name="username" required
                       class="w-full input input-bordered rounded-xl border-[#BCA5E3] focus:border-[#6f57a8] focus:outline-none" />
            </div>

            <div>
                <label for="password" class="block font-semibold mb-1">Password:</label>
                <input type="password" id="password" name="password" required
                       class="w-full input input-bordered rounded-xl border-[#F49CA0] focus:border-[#d66b71] focus:outline-none" />
            </div>

            <button type="submit"
                    class="w-full btn bg-[#F8C873] text-white border-none rounded-xl shadow-md hover:bg-[#e7b760]">
                Login
            </button>

        </form>

        <?php if ($error): ?>
            <div class="mt-4 text-center text-red-500 font-semibold">
                <?= htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="mt-4 text-center text-green-600 font-semibold">
                <?= htmlspecialchars($success); ?>
            </div>
        <?php endif; ?>

    </div>
</div>
</body>
</html>