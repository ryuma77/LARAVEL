<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tailwind Test</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">

    <div class="bg-white p-10 rounded-2xl shadow-xl max-w-md w-full text-center">
        <h1 class="text-3xl font-bold text-gray-800 mb-4">
            TailwindCSS v4 Test ✔
        </h1>

        <p class="text-gray-600 mb-6">
            Jika kamu melihat kotak putih ini dengan styling rapih, TailwindCSS sudah aktif.
        </p>

        <button class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
            Contoh Button
        </button>
    </div>

</body>
</html>
