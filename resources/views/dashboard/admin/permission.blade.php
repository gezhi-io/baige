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
                                            <button class="del-btn text-amber-600">
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
    <x-toast></x-toast>
    @section('script')
        <script>
            $('.edit-btn').on('click', function() {
                var tr = $(this).closest('tr');
                console.log(tr.find('.item-id')[0].innerText);
                var id = tr.find('.item-id')[0].innerText;
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


            $('.del-btn').on('click', function() {
                console.log(this)
                var tr = $(this).closest('tr');
                var id = tr.find('.item-id')[0].innerText;
                var info_url = "{{ route('permission.info', 100100101) }}".replace('100100101', id);
                var delete_url = "{{ route('permission.delete', 100100101) }}".replace('100100101', id);

                axios.get(info_url).then(function(response) {
                    Swal.fire({
                        title: '确定删除权限 ' + response.data.name_cn + ' 吗',
                        text: "该操作不可撤销，该权限所有关联也会一并删除",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: '确认删除'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            axios.post(delete_url).then(function(res){
                                console.log(res)
                                // window.location.reload();
                            }).catch(function(error) {
                                console.log(error);
                            });
                        }
                    })
                }).catch(function(error) {
                    // 处理错误情况
                    console.log(error);
                });
            });
        </script>
    @endsection
</x-dashboard-layout>
