<aside class="relative bg-sidebar h-screen w-64 hidden sm:block shadow-xl">
    <div class="p-4 grid">
        <div class="place-self-center">
            <img class="w-10 h-10" src="{{ asset('logo-white.svg') }}" alt="Logo">
        </div>
    </div>
    <nav class="text-white bg-sidebar text-base pt-3 overflow-y-auto">
        <a href="#" class="flex items-center active-nav-link text-white py-4 pl-6 nav-item">
            <x-icon :icon="'home'" class="mr-3" :withStroke="false" />
            后台首页
        </a>
        <a href="#" class="flex items-center text-white opacity-90 hover:opacity-100 py-4 pl-6 nav-item">
            <x-icon :icon="'news'" class="mr-3" :withStroke="false" />
            文章管理
        </a>
        <a href="#" class="flex items-center text-white opacity-90 hover:opacity-100 py-4 pl-6 nav-item">
            <x-icon :icon="'file-info'" class="mr-3" :withStroke="false" />
            页面管理
        </a>
        <a href="#" class="flex items-center text-white opacity-90 hover:opacity-100 py-4 pl-6 nav-item">
            <x-icon :icon="'tags'" class="mr-3" :withStroke="false" />
            标签管理
        </a>
        <a href="#" class="flex items-center text-white opacity-90 hover:opacity-100 py-4 pl-6 nav-item">
            <x-icon :icon="'menu-2'" class="mr-3" :withStroke="false" />
            菜单管理
        </a>
        <a href="#" class="flex items-center text-white opacity-90 hover:opacity-100 py-4 pl-6 nav-item">
            <x-icon :icon="'brush'" class="mr-3" :withStroke="false" />
            主题设置
        </a>
    </nav>
    <x-tippy :id="'setting'" :placement="'right-end'"
        class="absolute bottom-0 w-full upgrade-btn  active-nav-link text-white flex items-center justify-center py-4">
        <x-slot name="inner">
            <x-icon :icon="'settings'" class="mr-3" :withStroke="false" />网站管理
        </x-slot>
        <x-slot name="content">
            <a class="px-4 py-2 w-full text-sm leading-5 flex items-center justify-center hover:bg-blue-700 hover:text-slate-50" href="#">
                <x-icon :icon="'tool'" class="mr-3" :withStroke="false" />通用配置
            </a>
            <a class="px-4 py-2 w-full text-sm leading-5 flex items-center justify-center hover:bg-blue-700 hover:text-slate-50" href="#">
                <x-icon :icon="'users'" class="mr-3" :withStroke="false" />用户管理
            </a>
            <a class="px-4 py-2 w-full text-sm leading-5 flex items-center justify-center hover:bg-blue-700 hover:text-slate-50" href="#">
                <x-icon :icon="'affiliate'" class="mr-3" :withStroke="false" />角色管理
            </a>
            <a class="px-4 py-2 w-full text-sm leading-5 flex items-center justify-center hover:bg-blue-700 hover:text-slate-50" href="{{route('permission')}}">
                <x-icon :icon="'license'" class="mr-3" :withStroke="false" />权限管理
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                
                <a class="px-4 py-2 w-full text-sm leading-5 flex items-center justify-center hover:bg-blue-700 hover:text-slate-50" href="{{route('logout')}}"
                    onclick="event.preventDefault();
                                    this.closest('form').submit();">
                    <x-icon :icon="'logout'" class="mr-3" :withStroke="false" />{{ __('Log Out') }}
                </a>
            </form>
        </x-slot>
    </x-tippy>
</aside>
