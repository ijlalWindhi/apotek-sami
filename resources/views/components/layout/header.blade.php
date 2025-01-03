<nav class="fixed top-0 z-40 w-full bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700">
    <div class="px-3 py-3 lg:px-5 lg:pl-3">
        <div class="flex items-center justify-between">
            <div class="flex items-center justify-start rtl:justify-end">
                {{-- Toggle sidebar in mobile --}}
                <button aria-controls="logo-sidebar" type="button"
                    class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600">
                    <span class="sr-only">Open sidebar</span>
                    <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path clip-rule="evenodd" fill-rule="evenodd"
                            d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z">
                        </path>
                    </svg>
                </button>

                {{-- Logo --}}
                <a href="/" class="flex ms-2 md:me-24">
                    <img src="/images/logo.png" class="h-8 sm:h-10 md:h-12 me-3" alt="Logo" />
                </a>
            </div>
            <div class="flex items-center">
                {{-- Tampilkan tombol hanya jika user adalah admin --}}
                @if (Auth::check() && Auth::user()->role == '0')
                    <a href="{{ request()->is('inventory*') ? route('pos.index') : route('inventory.dashboard') }}">
                        <x-button color="blue">
                            @if (request()->is('inventory*'))
                                Point of Sales (POS)
                            @elseif (request()->is('pos*'))
                                Dashboard
                            @endif
                        </x-button>
                    </a>
                @endif
                <div class="flex items-center ms-3">
                    {{-- Toggle user profile --}}
                    <button type="button"
                        class="flex text-sm bg-gray-800 rounded-full focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600"
                        aria-expanded="false" data-dropdown-toggle="dropdown-user">
                        <span class="sr-only">Open user menu</span>
                        <span
                            class="inline-flex items-center justify-center w-8 h-8 text-sm font-medium text-white bg-gray-500 rounded-full">
                            {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                        </span>
                    </button>

                    {{-- Dropdown profile --}}
                    <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded shadow dark:bg-gray-700 dark:divide-gray-600"
                        id="dropdown-user">
                        <div class="px-4 py-3" role="none">
                            <p class="text-sm text-gray-900 dark:text-white" role="none">
                                {{ Auth::user()->name }}
                            </p>
                            <p class="text-sm font-medium text-gray-900 truncate dark:text-gray-300" role="none">
                                {{ Auth::user()->email }}
                            </p>
                        </div>
                        <ul class="py-1" role="none">
                            @foreach (config('constants.MENU_USER') as $menuItem)
                                @if ($menuItem['title'] == 'Keluar')
                                    <li>
                                        <form action="{{ route('logout') }}" method="POST"
                                            class="block px-4 py-2 text-sm text-red-500 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600">
                                            @csrf
                                            <button type="submit" role="menuitem" class="w-full text-left">
                                                {{ $menuItem['title'] }}
                                            </button>
                                        </form>
                                    </li>
                                @else
                                    <li>
                                        <div id="btn-edit-profile"
                                            class="cursor-pointer block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white"
                                            role="menuitem" data-drawer-target="drawer-profile"
                                            data-drawer-show="drawer-profile" aria-controls="drawer-profile">
                                            {{ $menuItem['title'] }}
                                        </div>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>
