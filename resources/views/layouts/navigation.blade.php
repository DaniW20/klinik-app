<nav x-data="{ open: false }" class="bg-green-900 border-b border-gray-800 shadow">    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">

            <!-- LEFT -->
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>

                <!-- MENU -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    
                    
                     <x-nav-link href="/dashboard"
                        :active="request()->is('dashboard*')"
                        class="text-white hover:bg-blue-500 px-3 py-2 rounded-lg">
                        Dashboard
                    </x-nav-link>

                     <x-nav-link href="/user"
                        :active="request()->is('user*')"
                        class="text-white hover:bg-blue-500 px-3 py-2 rounded-lg">
                        User
                    </x-nav-link>

                    <x-nav-link href="/pasien"
                        :active="request()->is('pasien*')"
                        class="text-white hover:bg-blue-500 px-3 py-2 rounded-lg">
                        Pasien
                    </x-nav-link>
                    
                     <x-nav-link href="/obat"
                        :active="request()->is('obat*')"
                        class="text-white hover:bg-blue-500 px-3 py-2 rounded-lg">
                        Obat
                    </x-nav-link>
                     <x-nav-link href="/tindakan"
                        :active="request()->is('tindakan*')"
                        class="text-white hover:bg-blue-500 px-3 py-2 rounded-lg">
                        Tindakan
                    </x-nav-link>
                    <x-nav-link href="/transaksi"
                        :active="request()->is('transaksi*')"
                        class="text-white hover:bg-blue-500 px-3 py-2 rounded-lg">
                        Transaksi
                    </x-nav-link>

                  

                </div>
            </div>

            <!-- RIGHT (USER DROPDOWN) -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-500 bg-white rounded-md hover:text-gray-700">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            Profile
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                Log Out
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- HAMBURGER -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 text-gray-400 rounded-md hover:text-gray-500 hover:bg-gray-100">
                    <svg class="w-6 h-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

        </div>
    </div>

    <!-- MOBILE MENU -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">

        <div class="pt-2 pb-3 space-y-1">

            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                Dashboard
            </x-responsive-nav-link>

            <x-responsive-nav-link href="/pasien" :active="request()->is('pasien*')">
                Pasien
            </x-responsive-nav-link>

            <x-responsive-nav-link href="/obat" :active="request()->is('obat*')">
                Obat
            </x-responsive-nav-link>

            <x-responsive-nav-link href="/tindakan" :active="request()->is('tindakan*')">
                Tindakan
            </x-responsive-nav-link>

            <x-responsive-nav-link href="/transaksi" :active="request()->is('transaksi*')">
                Transaksi
            </x-responsive-nav-link>

        </div>

        <!-- USER INFO -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="text-base font-medium text-gray-800">{{ Auth::user()->name }}</div>
                <div class="text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    Profile
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault(); this.closest('form').submit();">
                        Log Out
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>

    </div>
</nav>