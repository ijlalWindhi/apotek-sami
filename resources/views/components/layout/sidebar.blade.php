<aside id="logo-sidebar"
    class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform -translate-x-full bg-white border-r border-gray-200 sm:translate-x-0 dark:bg-gray-800 dark:border-gray-700"
    aria-label="Sidebar">
    <div class="h-full px-3 pb-4 overflow-y-auto bg-white dark:bg-gray-800">
        <ul class="space-y-2 font-medium">
            @foreach (config('constants.MENU_ITEMS') as $menuItem)
                <li>
                    @if (isset($menuItem['isDropdown']) && $menuItem['isDropdown'])
                        @php
                            $isActiveDropdown = collect($menuItem['submenu'])->contains(function ($submenuItem) {
                                return request()->is(trim($submenuItem['path'], '/') ?: '/');
                            });
                        @endphp
                        <button type="button"
                            class="flex items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 {{ $isActiveDropdown ? 'bg-gray-100 dark:bg-gray-700' : '' }}"
                            aria-controls="dropdown-{{ Str::slug($menuItem['title']) }}"
                            data-collapse-toggle="dropdown-{{ Str::slug($menuItem['title']) }}">
                            <div
                                class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white {{ $isActiveDropdown ? 'text-gray-900 dark:text-white' : '' }}">
                                {!! $menuItem['icon'] !!}
                            </div>
                            <span
                                class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap">{{ $menuItem['title'] }}</span>
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 4 4 4-4" />
                            </svg>
                        </button>
                        <ul id="dropdown-{{ Str::slug($menuItem['title']) }}" class="hidden py-2 space-y-2">
                            @foreach ($menuItem['submenu'] as $submenuItem)
                                <li>
                                    <a href="{{ $submenuItem['path'] }}"
                                        class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700 {{ request()->is(trim($submenuItem['path'], '/') ?: '/') ? 'bg-gray-100 dark:bg-gray-700' : '' }}">
                                        {{ $submenuItem['title'] }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        @php
                            $currentPath = trim($menuItem['path'], '/');
                            $isActive = $currentPath === '' ? request()->is('/') : request()->is($currentPath);
                        @endphp
                        <a href="{{ $menuItem['path'] }}"
                            class="flex items-center p-2 rounded-lg text-gray-500 hover:text-gray-900 hover:bg-gray-100 dark:hover:bg-gray-700 group {{ $isActive ? 'bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white' : '' }}">
                            {!! $menuItem['icon'] !!}
                            <span class="flex-1 ms-3 whitespace-nowrap">{{ $menuItem['title'] }}</span>
                            @if (isset($menuItem['badge']))
                                <span
                                    class="inline-flex items-center justify-center {{ $menuItem['badge']['type'] === 'blue' ? 'w-3 h-3 p-3 ms-3 text-sm font-medium text-blue-800 bg-blue-100 rounded-full dark:bg-blue-900 dark:text-blue-300' : 'px-2 ms-3 text-sm font-medium text-gray-800 bg-gray-100 rounded-full dark:bg-gray-700 dark:text-gray-300' }}">
                                    {{ $menuItem['badge']['text'] }}
                                </span>
                            @endif
                        </a>
                    @endif
                </li>
            @endforeach
        </ul>
    </div>
</aside>
