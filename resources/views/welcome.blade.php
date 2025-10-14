<x-guest-layout>
    <!-- Hero Section -->
    <div class="relative bg-gray-800 text-white overflow-hidden">
        <div class="absolute inset-0">
            <img src="https://images.unsplash.com/photo-1604328698692-f76ea9498e7b?q=80&w=2070&auto=format&fit=crop" alt="A happy couple reviewing their finances together on a laptop." class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gray-900 opacity-60"></div>
        </div>
        <div class="relative container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="py-32 sm:py-48">
                <div class="text-center">
                    <h1 class="text-4xl font-bold tracking-tight text-white sm:text-6xl">
                        <span class="block">Intelligent Banking,</span>
                        <span class="block text-purple-400">Made for You.</span>
                    </h1>
                    <p class="mt-6 max-w-2xl mx-auto text-lg leading-8 text-gray-300">
                        Welcome to Inviting Bank, the AI-centric banking experience that makes managing your finances easier and more intuitive than ever before.
                    </p>
                    <div class="mt-10 flex items-center justify-center gap-x-6">
                        <a href="{{ route('register') }}" class="rounded-md bg-purple-600 px-6 py-3 text-base font-semibold text-white shadow-sm hover:bg-purple-500">Experience AI Banking</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="bg-gray-50 py-24 sm:py-32">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Experience AI-Powered Banking</h2>
                <p class="mt-4 text-lg text-gray-600">Our intelligent features work for you, making banking effortless.</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Feature Cards -->
                <div class="text-center p-8 bg-white rounded-lg shadow-md">
                    <div class="mx-auto h-12 w-12 flex items-center justify-center rounded-full bg-purple-100 text-purple-700">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </div>
                    <h3 class="mt-6 text-lg font-semibold text-gray-900">Smart Transfers</h3>
                    <p class="mt-2 text-base text-gray-600">Our AI predicts frequent payees and helps you schedule payments, making transfers faster than ever.</p>
                </div>
                <div class="text-center p-8 bg-white rounded-lg shadow-md">
                    <div class="mx-auto h-12 w-12 flex items-center justify-center rounded-full bg-purple-100 text-purple-700">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    </div>
                    <h3 class="mt-6 text-lg font-semibold text-gray-900">AI-Powered Security</h3>
                    <p class="mt-2 text-base text-gray-600">Our intelligent fraud detection system works 24/7 to analyze transactions and keep your account safe.</p>
                </div>
                <div class="text-center p-8 bg-white rounded-lg shadow-md">
                    <div class="mx-auto h-12 w-12 flex items-center justify-center rounded-full bg-purple-100 text-purple-700">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                    <h3 class="mt-6 text-lg font-semibold text-gray-900">Intelligent Bill Pay</h3>
                    <p class="mt-2 text-base text-gray-600">Never miss a payment. Our AI helps you track due dates and manage your bills automatically.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- AI Insights Section -->
    <div class="bg-white py-24 sm:py-32">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div>
                    <img src="https://images.unsplash.com/photo-1551288049-bebda4e38f71?q=80&w=2070&auto=format&fit=crop" alt="A person analyzing financial charts on a modern tablet." class="rounded-lg shadow-2xl">
                </div>
                <div class="text-center lg:text-left">
                    <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Get Personalized Financial Insights</h2>
                    <p class="mt-6 text-lg leading-8 text-gray-600">
                        Our AI analyzes your spending habits to provide you with clear, actionable insights. Understand where your money is going, get smart budgeting tips, and reach your financial goals faster.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Testimonials Section -->
    <div class="bg-gray-50 py-24 sm:py-32" x-data="{ testimonials: [ { quote: 'The AI insights are a game-changer! I finally feel in control of my finances.', author: 'Adebayo Adekunle' }, { quote: 'This is the smartest bank I have ever used. It feels like it was built just for me.', author: 'Chiamaka Nwosu' } ], current: 0 }">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">What Our Customers Are Saying</h2>
            <div class="mt-10 relative max-w-2xl mx-auto">
                <template x-for="(testimonial, index) in testimonials" :key="index">
                    <div x-show="current === index" class="transition-opacity duration-500 ease-in-out">
                        <blockquote class="text-xl italic text-gray-700" x-text="testimonial.quote"></blockquote>
                        <p class="mt-4 font-semibold text-gray-900" x-text="testimonial.author"></p>
                    </div>
                </template>
                <button @click="current = (current > 0) ? current - 1 : testimonials.length - 1" class="absolute left-0 top-1/2 -translate-y-1/2 bg-white p-2 rounded-full shadow-md hover:bg-gray-100">&#8592;</button>
                <button @click="current = (current < testimonials.length - 1) ? current + 1 : 0" class="absolute right-0 top-1/2 -translate-y-1/2 bg-white p-2 rounded-full shadow-md hover:bg-gray-100">&#8594;</button>
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="bg-purple-700">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-16 text-center">
            <h2 class="text-3xl font-bold text-white">Ready to Experience the Future of Banking?</h2>
            <p class="mt-4 text-lg text-purple-200">Open an account in minutes and let our AI work for you.</p>
            <a href="{{ route('register') }}" class="mt-8 inline-block bg-white text-purple-700 px-8 py-3 rounded-md font-semibold hover:bg-gray-100">Create an Account</a>
        </div>
    </div>
</x-guest-layout>
