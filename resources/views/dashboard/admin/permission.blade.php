<x-dashboard-layout>
    <h2 class="text-lg text-black pb-2">权限管理</h2>
    <div class="my-2 flex sm:flex-row flex-col">
        <div class="flex flex-row mb-1 sm:mb-0">
            <div class="relative">
                <select
                    class="h-full rounded-l border block w-full bg-white border-gray-400 text-gray-700 py-2 px-4 pr-8 leading-tight focus:outline-none focus:bg-white focus:border-gray-500  appearance-none">
                    <option>10</option>
                    <option>20</option>
                    <option>50</option>
                </select>
            </div>
        </div>
        <div class="block relative">
            <span class="h-full absolute inset-y-0 left-0 flex items-center pl-2">
                <x-icon :icon="'search'" class="fill-current h-4 w-4 text-gray-500" />
            </span>
            <input placeholder="搜索"
                class="appearance-none rounded-r rounded-l sm:rounded-l-none border border-gray-400 border-b block pl-8 pr-6 py-2 w-full bg-white text-sm placeholder-gray-400 text-gray-700 focus:bg-white focus:placeholder-gray-600 focus:text-gray-700 focus:outline-none" />
        </div>
    </div>

    <div class="w-full grid md:grid-cols-12 gap-4 mt-4">
        <div class="md:col-span-8">
            <div class="-mx-4 sm:-mx-8 px-4 sm:px-8 py-4 overflow-x-auto">
                <div class="inline-block min-w-full rounded-lg shadow-lg overflow-hidden">
                    <table class="min-w-full leading-normal table-auto">
                        <thead>
                            <tr class="bg-indigo-400 text-center text-xs font-semibold text-gray-900">
                                <th class="px-5 py-3 border-b-2 border-gray-200"># ID</th>
                                <th class="px-5 py-3 border-b-2 border-gray-200">名称</th>
                                <th class="px-5 py-3 border-b-2 border-gray-200 ">英文标识</th>
                                <th class="px-5 py-3 border-b-2 border-gray-200">Guard</th>
                                <th class="px-5 py-3 border-b-2 border-gray-200">创建时间</th>
                                <th class="px-5 py-3 border-b-2 border-gray-200">操作</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($permissions as $item)
                                <tr class="bg-white text-sm  text-center text-slate-800 border-b border-indigo-200">
                                    <td class="item-id px-3 py-3 border-r border-indigo-200">
                                        {{ $item->id }}
                                    </td>
                                    <td class="px-3 py-3">
                                        {{ $item->name_cn }}
                                    </td>
                                    <td class="px-3 py-3">
                                        {{ $item->name }}
                                    </td>
                                    <td class="px-3 py-3">
                                        {{ $item->guard_name }}
                                    </td>
                                    <td class="px-3 py-3  border-r border-indigo-200">
                                        {{ $item->created_at->format('Y 年 m 月 d 日') }}
                                    </td>
                                    <td class="px-3 py-3">
                                        <div>
                                            <button class="edit-btn mr-3 text-teal-500">
                                                <x-icon :icon="'pencil'" :withStroke="false" />
                                            </button>
                                            <button class="del-btn text-amber-600" onclick="del(this)">
                                                <x-icon :icon="'trash'" :withStroke="false" />
                                            </button>
                                        </div>
                                    </td>

                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                    <div class="px-5 py-5 bg-white border-t">
                        {{ $permissions->onEachSide(1)->links() }}
                    </div>
                </div>
            </div>
        </div>

        <div class="md:col-span-4">
            <form id="edit-form" class="bg-white py-10 px-5 mt-4 rounded-lg shadow-lg min-w-full"
                action="{{ route('permission.store') }}" method="POST">
                @csrf
                <h2 class="text-gray-800 font-lg font-bold text-center leading-tight mb-4">添加/更新</h2>
                <div>
                    <label class="text-gray-800 text-sm font-bold leading-tight tracking-normal"
                        for="name_cn">权限名称</label>
                    <input
                        class="mb-5 mt-2 text-gray-600 focus:outline-none focus:border focus:border-indigo-700 font-normal w-full h-10 flex items-center pl-3 text-sm border-gray-300 rounded border"
                        type="text" name="name_cn" id="name_cn" placeholder="中文名称" />
                </div>
                <div>
                    <label class="text-gray-800 text-sm font-bold leading-tight tracking-normal"
                        for="name">英文标识</label>
                    <input
                        class="mb-5 mt-2 text-gray-600 focus:outline-none focus:border focus:border-indigo-700 font-normal w-full h-10 flex items-center pl-3 text-sm border-gray-300 rounded border"
                        type="text" name="name" id="name" placeholder="name" />
                </div>
                <div>
                    <label class="text-gray-800 text-sm font-bold leading-tight tracking-normal"
                        for="guard">Guard</label>
                    <input
                        class="mb-5 mt-2 text-gray-600 focus:outline-none focus:border focus:border-indigo-700 font-normal w-full h-10 flex items-center pl-3 text-sm border-gray-300 rounded border"
                        type="text" name="guard" id="guard" value="web" placeholder="web" />
                </div>
                <div class="flex justify-between">
                    <button type="submit"
                        class="w-20 mt-6 bg-indigo-600 rounded-lg px-4 py-2 text-white tracking-wide">{{ __('Confirm') }}</button>
                    <button type="reset"
                        class="w-20 mt-6 bg-indigo-100 rounded-lg px-4 py-2 text-gray-800 tracking-wide"
                        onclick="window.location.reload()">{{ __('Cancel') }}</button>
                </div>

            </form>
        </div>
    </div>
    <div class="hidden py-12 bg-gray-700 transition duration-150 ease-in-out z-10 absolute top-0 right-0 bottom-0 left-0"
        id="modal">
        <div role="alert" class="container mx-auto w-11/12 md:w-2/3 max-w-lg">
            <div class="relative py-8 px-5 md:px-10 bg-white shadow-md rounded border border-gray-400">
                <div class="w-full flex justify-start text-gray-600 mb-3">
                    <h2 class="text-gray-800 font-lg font-bold tracking-normal leading-tight mb-4">确认删除</h2>
                </div>
                <p class="text-center"> 确认删除权限 吗？</p>
            </div>
            <div class="flex items-center justify-start w-full">
                <form id="del-form" action="" method="post">
                    @csrf
                    <button type="submit"
                        class="focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-700 transition duration-150 ease-in-out hover:bg-indigo-600 bg-indigo-700 rounded text-white px-8 py-2 text-sm">确认</button>
                </form>
                <button
                    class="focus:outline-none focus:ring-2 focus:ring-offset-2  focus:ring-gray-400 ml-3 bg-gray-100 transition duration-150 text-gray-600 ease-in-out hover:border-gray-400 hover:bg-gray-300 border rounded px-8 py-2 text-sm"
                    onclick="modalHandler()">取消</button>
            </div>
            <button
                class="cursor-pointer absolute top-0 right-0 mt-4 mr-5 text-gray-400 hover:text-gray-600 transition duration-150 ease-in-out rounded focus:ring-2 focus:outline-none focus:ring-gray-600"
                onclick="modalHandler()" aria-label="close modal" role="button">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-x" width="20"
                    height="20" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" fill="none"
                    stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" />
                    <line x1="18" y1="6" x2="6" y2="18" />
                    <line x1="6" y1="6" x2="18" y2="18" />
                </svg>
            </button>
        </div>
    </div>
    </div>
    <x-toast></x-toast>
    @section('script')
        <script>
            $('.edit-btn').on('click', function() {
                var tr = $(this).closest('tr');
                var id = tr.find('.item-id').html();
                var info_url = "{{ route('permission.info', 100100101) }}".replace('100100101', id);
                var update_url = "{{ route('permission.update', 100100101) }}".replace('100100101', id);
                axios.get(info_url).then(function(response) {
                    $('#edit-form').attr("action", update_url)
                    $('#name_cn').attr("value", response.data.name_cn);
                    $('#name').attr("value", response.data.name);
                    $('#guard').attr("value", response.data.guard_name);

                }).catch(function(error) {
                    // 处理错误情况
                    console.log(error);
                });
            })

            let del = (target) => {
                console.log(this)
                var tr = target.closest('tr');
                var id = tr.querySelectorAll('.item-id')[0].innerText;
                var info_url = "{{ route('permission.info', 100100101) }}".replace('100100101', id);
                var delete_url = "{{ route('permission.delete', 100100101) }}".replace('100100101', id);
                axios.get(info_url).then(function(response) {
                    $('#del-form').attr("action", delete_url)

                }).catch(function(error) {
                    // 处理错误情况
                    console.log(error);
                });
                console.log(bgModal)
            }
        </script>
    @endsection
</x-dashboard-layout>
