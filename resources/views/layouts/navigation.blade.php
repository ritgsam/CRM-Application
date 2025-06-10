<nav x-data="{ open: false }" style="background-color: black" class="border-b border-gray-800">
    <div class=" max-w-7xl mx-auto px-4 sm:px-6  lg:px-8">
        <div class="flex justify-between h-16">
            <div class=" flex items-center space-x-8">
                <div class="shrink-0">
                    <a href="{{ route('dashboard') }}">
                    </a>
                </div>

                <a href="{{ route('dashboard') }}"  class=" text-gray-400 font-medium ">Dashboard</a>
                <a href="{{ route('leads.index') }}" class="text-gray-400  font-medium">Leads</a>
                <a href="{{ route('deals.index') }}" class="text-gray-400  font-medium">Deals</a>
                <a href="{{ route('contacts.index') }}" class="text-gray-400  font-medium">Contacts</a>
                <a href="{{ route('tasks.index') }}" class="text-gray-400  font-medium">Tasks</a>
            <a href="{{ route('meetings.index') }}" class="text-gray-400  font-medium">Meetings</a>
                <a href="{{ route('accounts.index') }}" class="text-gray-400  font-medium">Account</a>
                <a href="{{ route('reports.index') }}" class="text-gray-400  font-medium">Reports</a>
            </div>

            <div class="hidden sm:flex sm:items-center space-x-4">
                @auth
                    <div class="text-sm text-gray-400 font-semibold">{{ Auth::user()->name }}</div>
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="flex items-center text-sm text-gray-400 hover:text-gray-400">
                                Menu
                                <svg class="ms-1 h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10
                                    10.586l3.293-3.293a1 1 0 111.414
                                    1.414l-4 4a1 1 0 01-1.414
                                    0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                                </svg>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            {{-- <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Profile') }}
                            </x-dropdown-link> --}}
                            <form  method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    <a href="{{ route('login') }}" class="text-sm text-red-500 hover:underline">Logout</a>
                @endauth
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = !open" class="p-2 text-gray-400 hover:text-gray-600">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                              stroke="currentColor" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden"
                              stroke="currentColor" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{ 'block': open, 'hidden': !open }" class="sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">Dashboard</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('leads.index')" :active="request()->routeIs('leads.*')">Leads</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('deals.index')" :active="request()->routeIs('deals.*')">Deals</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('contacts.index')" :active="request()->routeIs('contacts.*')">Contacts</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('tasks.index')" :active="request()->routeIs('tasks.*')">Tasks</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('reports.index')" :active="request()->routeIs('reports.*')">Reports</x-responsive-nav-link>
        </div>

        <div class="pt-4 pb-1 border-t border-gray-200">
            @auth
                <div class="px-4">
                    <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>
                <div class="mt-3 space-y-1">
                    {{-- <x-responsive-nav-link :href="route('profile.edit')">Profile</x-responsive-nav-link> --}}
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">Log Out</x-responsive-nav-link>
                    </form>
                </div>
            @else
                <div class="px-4 text-gray-700">Guest</div>
            @endauth
        </div>
    </div>
</nav>
