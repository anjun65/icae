<x-guest-layout>
    <body class="antialiased bg-gray-100">
        <div class="relative items-top justify-center min-h-screen">
            

            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
                <br/>
                <div class="bg-gray-50">
                <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:py-16 lg:px-8 lg:flex lg:items-center lg:justify-between">
                    <h2 class="text-3xl font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                    <span class="block">Registration</span>
                    </h2>
                    <div class="mt-8 flex lg:mt-0 lg:flex-shrink-0">
                    <div class="inline-flex rounded-md shadow">
                        <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700"> Register Now </a>
                    </div>
                    </div>
                </div>
                </div>
                <div class="mt-8 bg-white overflow-hidden shadow sm:rounded-lg">
                    
                    <div class="relative bg-white overflow-hidden">
                    <div class="max-w-7xl mx-auto">
                        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                            <div class="px-4 py-5 sm:px-6">
                                <p class="text-xl text-bold leading-6 text-gray-900">
                                    Important Notes:
                                </p>
                                
                                
                                <p>1. When you register as an author, please bear in mind to state your Paper ID. If you have more than one paper, you can separate the numbers by a comma.</p>
                                <p>2. After selecting your registration package, you will be able to pay using Direct Bank Transfer. Please, make sure that your name is the same in the registration and in the payment forms.</p>
                                    <br/>
                                <p class=" text-xl text-bold text-gray-900">
                                    <b>Bank BSI</b>

                                    <li>Account name : Anjelina qq ICAE</li>
                                    <li>Account Number : 8080008553</li>
                                    <li>SWIFT CODE : BSMDIDJA-PT Bank Syariah Indonesia tbk</li>
                                </p>
                                <br/>
                                <p>3. The Registration link will be available 19 September 2022</p>
                                
                                <a href="{{ route('register') }}" class="m-5 btn text-white">Registration Link</a>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</x-guest-layout>