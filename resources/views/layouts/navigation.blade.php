<nav class="bg-gray-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex items-center justify-between h-16">
        <div class="flex items-center">
          <div class="flex-shrink-0 w-14">
          <a href="/">
            <x-application-logo />
            </a>
          </div>
          <!-- Nav -->
          <div class="hidden md:block">
            <div class="ml-10 flex items-baseline space-x-4">
              <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
              @if(Auth::user())
              <!-- Logged in user -->
                <!-- <a href="#" 
                class="bg-gray-900 text-white px-3 py-2 rounded-md text-sm font-medium">
                    Dashboard
                </a> -->
                <x-nav-link :href="route('dashboard.index')" :active="request()->routeIs('dashboard.index')">
                    {{ __('Home') }}
                </x-nav-link> 

                <!-- <x-nav-link :href="route('dashboard.index')" :active="request()->routeIs('dashboard.index')">
                    {{ __('None') }}
                </x-nav-link> 

                <x-nav-link :href="route('dashboard.index')" :active="request()->routeIs('dashboard.index')">
                    {{ __('None') }}
                </x-nav-link> 

                <x-nav-link :href="route('dashboard.index')" :active="request()->routeIs('dashboard.index')">
                    {{ __('None') }}
                </x-nav-link>  -->

                @if(Auth::user() && Auth::user()->isAdmin())
                <!-- Logged in admin -->
                <x-nav-link :href="route('ingredient.control')" :active="request()->routeIs('ingredient.control')">
                    {{ __('Ingredients') }}
                </x-nav-link> 
                <x-nav-link :href="route('meal.control')" :active="request()->routeIs('meal.control')">
                    {{ __('Meals') }}
                </x-nav-link> 
                @endif

                @else
                <!-- Guest -->
                <x-nav-link :href="route('dashboard.index')" :active="request()->routeIs('dashboard.index')">
                    {{ __('Home') }}
                </x-nav-link>                
                <x-nav-link :href="route('login')" :active="request()->routeIs('login')">
                    {{ __('Login') }}
                </x-nav-link>                
                <x-nav-link :href="route('register')" :active="request()->routeIs('register')">
                    {{ __('Register') }}
                </x-nav-link>
                @endif
            </div>
          </div>
          <!-- Nav -->
        </div>

        <!-- Profile -->
        @if(Auth::user())
        <div class="hidden md:block">
          <div class="ml-4 flex items-center md:ml-6">
            <button class="bg-gray-800 p-1 rounded-full text-gray-400 hover:text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white">
              <span class="sr-only">View notifications</span>
              <!-- Heroicon name: outline/bell -->
              <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
              </svg>
            </button>

            <!-- Profile dropdown -->
            <div class="ml-3 relative">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                            <span class="sr-only">Open user menu</span>
                            <img class="h-8 w-8" src="{{url('storage/icons/user_icon.svg')}}" alt="">
                        </button>
                    </x-slot>
              <!--
                Dropdown menu, show/hide based on menu state.

                Entering: "transition ease-out duration-100"
                  From: "transform opacity-0 scale-95"
                  To: "transform opacity-100 scale-100"
                Leaving: "transition ease-in duration-75"
                  From: "transform opacity-100 scale-100"
                  To: "transform opacity-0 scale-95"
              -->
                <x-slot name="content">
            
                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Your Profile</a>

                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Settings</a>

                    <form action="{{route('logout')}}" method="POST">
                    @csrf
                    <button type="submit" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Sign out</button>
                    </form>
                
                </x-slot>
              </x-dropdown>
            </div>
            <!-- End profile dropdown -->
          </div>
        </div>
        @endif
        <!-- End profile -->
      </div>
    </div>

  </nav>