@php
    $logo = get_option('site_logo');
@endphp

<header x-data="{ isOpen: false }" class="bg-white border-b-4 border-gradient relative">
    <div class="container flex flex-wrap justify-between py-8">
        <a href="{{ home_url('/') }}" class="flex">
            @if($logo)
                <img src="{{ $logo }}" width="140" height="73" alt="{{ get_bloginfo('name') }}">
            @else
                <img src="{{ get_template_directory_uri() }}/assets/images/logo.svg" width="140" height="73" alt="{{ get_bloginfo('name') }}">
            @endif
        </a>

        <div x-data="{dropdownMenu: false}" class="flex items-center md:order-2 relative">
            <span class="border-l border-gray-200 pl-4">
                <button @click="dropdownMenu = !dropdownMenu" :class="{ 'text-blue-100': dropdownMenu }"
                    type="button" class="flex items-center text-sm font-bold text-gray-100 hover:text-blue-100"
                    id="user-menu-button" :aria-expanded="dropdownMenu ? 'true' : 'false'">
                    <span class="relative inline-block rounded-full text-red-50">
                        <svg class="w-7 h-7 md:w-6 md:h-6" aria-hidden="true" focusable="false" width="24"
                            height="24" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M11.652 14.001C14.0992 14.001 16.083 12.0172 16.083 9.57001C16.083 7.12283 14.0992 5.13901 11.652 5.13901C9.20482 5.13901 7.22099 7.12283 7.22099 9.57001C7.22099 12.0172 9.20482 14.001 11.652 14.001Z"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round"></path>
                            <path d="M18.4599 19.729C16.622 17.9836 14.1842 17.0104 11.6495 17.0104C9.11486 17.0104 6.6769 17.9836 4.83897 19.729"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round"></path>
                            <path d="M11.653 22.306C17.5365 22.306 22.306 17.5365 22.306 11.653C22.306 5.76951 17.5365 1 11.653 1C5.76951 1 1 5.76951 1 11.653C1 17.5365 5.76951 22.306 11.653 22.306Z"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round"></path>
                        </svg>
                    </span>
                    <span class="ml-3 text-inherit hidden lg:inline-block">My account</span>
                </button>
            </span>
        </div>

        <!-- Mobile Menu Toggle -->
        <button @click="isOpen = !isOpen" :class="{ 'text-blue-100': isOpen }"
            :aria-expanded="isOpen ? 'true' : 'false'"
            class="menu-toggler inline-flex items-center p-1 ml-3 text-sm text-gray-100 hover:text-blue-100 rounded-lg md:hidden"
            type="button" aria-controls="mobile-menu">
            <span class="sr-only">Open main menu</span>
            <svg x-show="!isOpen" class="w-6 h-6" width="19" height="17" viewBox="0 0 19 17" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <path d="M1 1H17.063" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round"></path>
                <path d="M1 8.079H17.063" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round"></path>
                <path d="M1 15.158H9.381" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round"></path>
            </svg>
            <svg x-show="isOpen" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
                xmlns="http://www.w3.org/2000/svg" style="display: none;">
                <path fill-rule="evenodd"
                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                    clip-rule="evenodd"></path>
            </svg>
        </button>

<nav x-bind:class="!isOpen ? 'hidden' : ''"
    class="nav fixed md:static left-0 bg-slate-50 z-10 overflow-y-auto md:overflow-y-visible md:bg-transparent justify-between items-center w-full md:flex md:w-auto md:order-1 hidden"
    id="mobile-menu">
    @if (has_nav_menu('primary_navigation'))
        <ul class="flex flex-col mt-6 pb-6 md:pb-0 md:flex-row md:space-x-4 lg:space-x-14 md:mt-0 text-base md:text-[15px] font-bold">
            @foreach (wp_get_nav_menu_items(get_nav_menu_locations()['primary_navigation']) as $menu_item)
                <li>
                    <a href="{{ esc_url($menu_item->url) }}" class="block py-1 px-4 md:p-0 text-blue-100 hover:text-blue-200 transition-colors duration-200 transform md:border-b-2 md:border-transparent md:hover:border-blue-100">
                        {{ esc_html($menu_item->title) }}
                    </a>
                </li>
            @endforeach
        </ul>
    @endif
</nav>
    </div>
</header>