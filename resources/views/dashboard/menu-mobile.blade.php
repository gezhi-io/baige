

<!-- Mobile Header & Nav -->
<header x-data="{ isOpen: false }" class="w-full bg-sidebar py-5 px-6 sm:hidden">
    <div class="flex items-center justify-between">
        <div class="p-0.5 grid">
            <div class="place-self-center">
                <img class="w-4 h-4" src="{{ asset('logo-white.svg') }}" alt="Logo">
            </div>
        </div>
        <button @click="isOpen = !isOpen" class="text-white text-3xl focus:outline-none">
            <x-icon x-show="!isOpen" :icon="'menu-2'" class="mr-3" :withStroke="false" />
            <x-icon x-show="isOpen" :icon="'x'" class="mr-3" :withStroke="false" />
        </button>
    </div>

    <!-- Dropdown Nav -->
    <nav :class="isOpen ? 'flex' : 'hidden'" class="flex flex-col pt-4">
        <a href="index.html" class="flex items-center active-nav-link text-white py-2 pl-4 nav-item">
            <x-icon :icon="'home'" class="mr-3" :withStroke="false" />后台首页
        </a>
        <a href="blank.html" class="flex items-center text-white opacity-90 hover:opacity-100 py-2 pl-4 nav-item">
            <x-icon :icon="'news'" class="mr-3" :withStroke="false" />文章管理
        </a>
        <a href="tables.html" class="flex items-center text-white opacity-90 hover:opacity-100 py-2 pl-4 nav-item">
            <x-icon :icon="'file-info'" class="mr-3" :withStroke="false" />页面管理
        </a>
        <a href="forms.html" class="flex items-center text-white opacity-90 hover:opacity-100 py-2 pl-4 nav-item">
            <x-icon :icon="'tags'" class="mr-3" :withStroke="false" />标签管理
        </a>
        <a href="tabs.html" class="flex items-center text-white opacity-90 hover:opacity-100 py-2 pl-4 nav-item">
            <x-icon :icon="'menu-2'" class="mr-3" :withStroke="false" />菜单管理
        </a>
        <a href="calendar.html" class="flex items-center text-white opacity-90 hover:opacity-100 py-2 pl-4 nav-item">
            <x-icon :icon="'brush'" class="mr-3" :withStroke="false" />主题设置
        </a>
        
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <x-responsive-nav-link :class="'flex items-center text-white opacity-90 hover:opacity-100 py-2 pl-4 nav-item'" :href="route('logout')"
                onclick="event.preventDefault();
                                this.closest('form').submit();">
                <x-icon :icon="'logout'" class="mr-3" :withStroke="false" />{{ __('Log Out') }}
            </x-responsive-nav-link>
        </form>
    </nav>
</header>
