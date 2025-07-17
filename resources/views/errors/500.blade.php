<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>500 - Server Error</title>
    @vite('resources/css/app.css')
</head>
<body>
<main>
    <section class="bg-white dark:bg-gray-900">
        <div class="container min-h-screen px-6 py-12 mx-auto lg:flex lg:items-center lg:gap-12">
            <div class="w-full lg:w-1/2">
                <p class="text-sm font-medium text-blue-500 dark:text-blue-400">500 error</p>
                <h1 class="mt-3 text-2xl font-semibold text-gray-800 dark:text-white md:text-3xl">Something went wrong</h1>
                <p class="mt-4 text-gray-500 dark:text-gray-400">We’re fixing it. Please try again later.</p>

                <div class="flex items-center mt-6 gap-x-3">
                    <a href="{{ route('filament.admin.auth.login') }}" class="w-1/2 px-5 py-3 text-sm tracking-wide font-semibold text-white transition-colors duration-200 bg-blue-500 rounded-lg shrink-0 sm:w-auto hover:bg-blue-600 dark:hover:bg-blue-500 dark:bg-blue-600">
                        Take me home
                    </a>
                </div>
            </div>

            <div class="relative w-full mt-8 lg:w-1/2 lg:mt-0">
                <img class="w-full lg:h-[32rem] h-80 md:h-96 rounded-lg object-cover" src="{{ asset('images/backgrounds/background-admin.jpg') }}" alt="Admin panel background illustration">
            </div>
        </div>
    </section>
</main>
</body>
</html>
