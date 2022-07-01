<x-dashboard-layout>
    <div class="grid grid-cols-3 w-full md:w-1/3">
        <h2 class="text-lg text-black pb-2">配置选项  </h2> 
    </div>
    <div class="w-full grid md:grid-cols-12 gap-4 mt-4">
        <div class="md:col-span-8">
            <div class="-mx-4 sm:-mx-8 px-4 sm:px-8 py-4 overflow-x-auto">
                <div class="inline-block min-w-full rounded-lg shadow-lg overflow-hidden">
                    <table class="min-w-full leading-normal table-auto">
                        <thead>
                            <tr class="bg-indigo-400 text-center text-xs font-semibold text-gray-900">
                                <th class="px-5 py-3 border-b-2 border-gray-200"># ID</th>
                                <th class="px-5 py-3 border-b-2 border-gray-200">标识</th>
                                <th class="px-5 py-3 border-b-2 border-gray-200 ">用途</th>
                                <th class="px-5 py-3 border-b-2 border-gray-200">当前值</th>
                                <th class="px-5 py-3 border-b-2 border-gray-200">操作</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($options as $item)
                                <tr class="bg-white text-sm  text-center text-slate-800 border-b border-indigo-200">
                                    <td class="item-id px-3 py-3 border-r border-indigo-200">
                                        {{ $item->id }}
                                    </td>
                                    <td class="px-3 py-3">
                                        {{ $item->name }}
                                    </td>
                                    <td class="px-3 py-3">
                                        {{ $item->excerpt }}
                                    </td>
                                    <td class="px-3 py-3">
                                        {{ $item->value }}
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
                        {{ $options->onEachSide(1)->links() }}
                    </div>
                </div>
            </div>
        </div>

        <div class="md:col-span-4">
            <form id="edit-form" class="bg-white py-10 px-5 mt-4 mb-10 rounded-lg shadow-lg min-w-full"
                action="{{ route('option.store') }}" method="POST">
                @csrf
                <h2 class="text-gray-800 font-lg font-bold text-center leading-tight mb-4">添加/更新</h2>
                
                <div>
                    <label class="text-gray-800 text-sm font-bold leading-tight tracking-normal"
                        for="name">标识</label>
                    <input
                        class="mb-5 mt-2 text-gray-600 focus:outline-none focus:border focus:border-indigo-700 font-normal w-full h-10 flex items-center pl-3 text-sm border-gray-300 rounded border"
                        type="text" name="name" id="name" placeholder="name" />
                </div>
                <div>
                    <label class="text-gray-800 text-sm font-bold leading-tight tracking-normal"
                        for="value">默认值</label>
                    <input
                        class="mb-5 mt-2 text-gray-600 focus:outline-none focus:border focus:border-indigo-700 font-normal w-full h-10 flex items-center pl-3 text-sm border-gray-300 rounded border"
                        type="text" name="value" id="value" placeholder="默认值" />
                </div>
                <div>
                    <label class="text-gray-800 text-sm font-bold leading-tight tracking-normal"
                        for="excerpt">用途说明</label>
                    <input
                        class="mb-5 mt-2 text-gray-600 focus:outline-none focus:border focus:border-indigo-700 font-normal w-full h-10 flex items-center pl-3 text-sm border-gray-300 rounded border"
                        type="text" name="excerpt" id="excerpt"/>
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
                var info_url = "{{ route('option.info', 100100101) }}".replace('100100101', id);
                var update_url = "{{ route('option.update', 100100101) }}".replace('100100101', id);
                axios.get(info_url).then(function(response) {
                    $('#edit-form').attr("action", update_url)
                    $('#value').attr("value", response.data.value);
                    $('#name').attr("value", response.data.name);
                    $('#excerpt').attr("value", response.data.excerpt);

                }).catch(function(error) {
                    // 处理错误情况
                    console.log(error);
                });
            })


            $('.del-btn').on('click', function() {
                console.log(this)
                var tr = $(this).closest('tr');
                var id = tr.find('.item-id')[0].innerText;
                var info_url = "{{ route('option.info', 100100101) }}".replace('100100101', id);
                var delete_url = "{{ route('option.delete', 100100101) }}".replace('100100101', id);

                axios.get(info_url).then(function(response) {
                    Swal.fire({
                        title: '确定删除选项 ' + response.data.name + ' 吗',
                        text: "该操作不可撤销，该选项所有关联也会一并删除",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: '确认删除'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            axios.post(delete_url).then(function(res){
                                window.location.reload();
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
