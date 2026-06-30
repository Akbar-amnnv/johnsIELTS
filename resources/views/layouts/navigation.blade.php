<nav x-data="{ open: false }"
     class="sticky top-0 z-50 border-b border-white/10 bg-slate-950/85 backdrop-blur-xl">
    <div class="max-w-[1800px] mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20">
            <div class="flex items-center gap-8">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}"
                       class="flex items-center gap-3 group">
                        <div class="flex items-center justify-center w-12 h-12 rounded-2xl bg-white/5 border border-white/10 group-hover:bg-white/10 transition">
                            <x-application-logo class="block h-8 w-auto fill-current text-white/90" />
                        </div>

                        <div class="hidden sm:block">
                            <p class="text-xs uppercase tracking-[0.22em] text-slate-400">John's IELTS</p>
                            <p class="text-sm font-semibold text-white">Exam Portal</p>
                        </div>
                    </a>
                </div>

                <!-- Navigation Links -->
               
            </div>

            <!-- Desktop User Menu -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="56">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center gap-3 px-3 py-2.5 rounded-2xl border border-white/10 bg-white/5 text-sm font-medium text-slate-200 hover:bg-white/10 hover:text-white focus:outline-none transition">
                            <div class="flex items-center justify-center w-10 h-10 rounded-xl bg-sky-500/15 border border-sky-400/20 text-sky-200 font-bold">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>

                            <div class="text-left leading-tight">
                                <div class="text-sm font-semibold text-white">{{ Auth::user()->name }}</div>
                                <div class="text-xs text-slate-400">Candidate</div>
                            </div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4 text-slate-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="p-2 bg-slate-900 border border-white/10 rounded-2xl shadow-2xl">
                            <div class="px-3 py-2 border-b border-white/10 mb-2">
                                <p class="text-sm font-semibold text-white">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-slate-400">{{ Auth::user()->email }}</p>
                            </div>

                            <x-dropdown-link :href="route('profile.edit')"
                                class="rounded-xl text-slate-300 hover:text-white hover:bg-white/5 transition">
                                {{ __('Profile') }}
                            </x-dropdown-link>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('logout')"
                                    class="rounded-xl text-rose-300 hover:text-rose-200 hover:bg-rose-500/10 transition"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </div>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Mobile Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                        class="inline-flex items-center justify-center p-2.5 rounded-xl text-slate-300 border border-white/10 bg-white/5 hover:text-white hover:bg-white/10 focus:outline-none transition">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }"
                              class="inline-flex"
                              stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }"
                              class="hidden"
                              stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden border-t border-white/10 bg-slate-950/95 backdrop-blur-xl">
    

        <div class="pt-4 pb-4 border-t border-white/10 px-4">
            <div class="flex items-center gap-3 px-2 mb-4">
                <div class="flex items-center justify-center w-11 h-11 rounded-xl bg-sky-500/15 border border-sky-400/20 text-sky-200 font-bold">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>

                <div>
                    <div class="font-semibold text-base text-white">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-slate-400">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="space-y-2">
                <x-responsive-nav-link :href="route('profile.edit')"
                    class="block px-4 py-3 rounded-xl text-slate-300 hover:text-white hover:bg-white/5 transition">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                        class="block px-4 py-3 rounded-xl text-rose-300 hover:text-rose-200 hover:bg-rose-500/10 transition"
                        onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>