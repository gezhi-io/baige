<!-- Desktop Header -->
<header class="w-full items-center bg-white py-2 px-6 hidden sm:flex">
    <div class="w-1/2"></div>
    <div class="relative w-1/2 flex justify-end">
        <x-tippy :id="'account'"
            class="realtive z-10 w-12 h-12 rounded-full overflow-hidden border-2 border-gray-200 hover:border-gray-300 focus:border-gray-300 focus:outline-none">
            <x-slot name="inner">
                <img src="https://source.unsplash.com/uJ8LNVCBjFQ/400x400">
            </x-slot>
            <x-slot name="content">
                <a class="px-4 py-2 w-full text-sm leading-5 flex items-center justify-center hover:bg-blue-700 hover:text-slate-50"
                    href="route('logout')">
                    <x-icon :icon="'user'" class="mr-3" :withStroke="false" />个人中心
                </a>
                <a class="px-4 py-2 w-full text-sm leading-5 flex items-center justify-center hover:bg-blue-700 hover:text-slate-50"
                    href="route('logout')">
                    <x-icon :icon="'shield'" class="mr-3" :withStroke="false" />密码修改
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a class="px-4 py-2 w-full text-sm leading-5 flex items-center justify-center hover:bg-blue-700 hover:text-slate-50"
                        href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                                    this.closest('form').submit();">
                        <x-icon :icon="'logout'" class="mr-3" :withStroke="false" />{{ __('Log Out') }}
                    </a>
                </form>
            </x-slot>
        </x-tippy>
    </div>
</header>