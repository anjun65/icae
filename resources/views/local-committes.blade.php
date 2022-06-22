<x-guest-layout>
    <body class="antialiased bg-gray-100 dark:bg-gray-900">
        <div class="relative items-top justify-center min-h-screen mb-6">
            

            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
                <br/>
                <div class="bg-gray-50">
                <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:py-16 lg:px-8 lg:flex lg:items-center lg:justify-between">
                    <h2 class="text-3xl font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                        <span class="font-base text-grey-200">Organizing Committess</span>
                    </h2>
                    <div class="mt-8 flex lg:mt-0 lg:flex-shrink-0">
                    <div class="inline-flex rounded-md shadow">
                        <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700"> Register Now </a>
                    </div>
                    </div>
                </div>
                </div>
                <div class="mt-8 bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg">
                    
                    <x-local-committess></x-local-committess>
                </div>
            </div>
        </div>
    </body>
</x-guest-layout>