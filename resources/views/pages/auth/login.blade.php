<x-layout-auth>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="flex flex-col items-center justify-center w-full h-full space-y-4">
        <div class="w-full max-w-sm p-4 bg-white rounded-lg shadow-md dark:bg-gray-800">
            <img src="/images/logo.png" class="h-8 sm:h-10 md:h-12 m-auto mb-4" alt="Logo" />
            <h1 class="text-2xl font-semibold text-center text-gray-800 dark:text-white">Login</h1>

            <form action="{{ route('login.store') }}" method="POST" class="mt-4 space-y-4">
                @csrf

                <div class="space-y-2">
                    <label for="email"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                    <input type="email" name="email" id="email"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                        placeholder="Email" required>
                    @error('email')
                        <p class="text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-2">
                    <label for="password"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
                    <div class="relative">
                        <input type="password" name="password" id="password"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                            placeholder="Password" required>
                        <div class="absolute inset-y-0 right-0 flex cursor-pointer items-center px-3 text-gray-600">
                            <i class="fa-solid fa-eye toggle-password hidden"></i>
                            <i class="fa-solid fa-eye-slash toggle-password"></i>
                        </div>
                    </div>
                    @error('password')
                        <p class="text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <x-button type="submit" color="blue" class="w-full">
                    Login
                </x-button>
            </form>
        </div>
    </div>
</x-layout-auth>

<script>
    $(document).ready(function() {
        $('.toggle-password').click(function() {
            $('.toggle-password').toggleClass('hidden');

            var input = $('#password');
            if (input.attr('type') === 'password') {
                input.attr('type', 'text');
            } else {
                input.attr('type', 'password');
            }
        });
    });
</script>
