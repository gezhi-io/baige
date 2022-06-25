<x-dashboard-layout>
    <h2 class="text-lg text-black pb-2">权限管理</h2>
    <div class="w-full mt-4">
        <form action="{{route('permission.sync')}}" method="post">
            @csrf
        
        <div class="w-full">
            <div class="grid grid-cols-12 gap-1">
                <div class=" col-span-1 justify-self-center self-center mb-3 mt-2"><label for="role"
                        class="text-gray-800 text-sm font-bold leading-tight tracking-normal">角色</label></div>
                <div class="col-span-4 bg-white pt-1 px-3 rounded-sm shadow-sm min-w-full">
                    <select name="role" id="role"
                        class="appearance-none w-full mb-3 mt-2 text-gray-600 focus:outline-none focus:border focus:border-indigo-700 font-normal h-10 flex items-center pl-3 text-sm border-gray-300 rounded border"
                        placeholder="选择角色">
                        <option></option>
                        @foreach ($roles as $role)
                            <option id="role-{{ $role->id }}" value="{{ $role->id }}">{{ $role->name_cn }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-span-4 justify-self-center self-center justify-between ml-6">
                    <button type="submit"
            class="w-20 mt-6 bg-indigo-600 rounded-lg px-4 py-2 text-white tracking-wide">{{ __('Confirm') }}</button>
        <button type="reset" class="w-20 mt-6 bg-indigo-100 rounded-lg px-4 py-2 text-gray-800 tracking-wide"
            onclick="window.location.reload()">{{ __('Cancel') }}</button>
                </div>
            </div>
        </div>
        <div class="w-full">
            <div class="grid grid-cols-12 gap-1">
                <div class="col-span-1 justify-self-center self-center mb-5 mt-2"><label for="role"
                        class="text-gray-800 text-sm font-bold leading-tight tracking-normal">授权</label></div>
                <div class="col-span-8 bg-white py-5 px-3 mt-4 rounded-lg shadow-lg min-w-full">
                    <h3 class="mx-5 py-3">
                        <input type="checkbox" id="check-all" name="permissions[]" value="{{$root->id}}"
                            class="parent appearance-none checked:bg-blue-600 rounded checked:border-transparent mr-5">所有权限
                    </h3>
                    <hr>
                    @foreach ($permissions as $permission)
                        <h3 class="mx-5 py-3">
                            <input type="checkbox" id="p-{{ $permission->id }}" pid="p-{{ $permission->id }}" name="permissions[]" value="{{ $permission->id }}"
                                class="parent appearance-none checked:bg-blue-600 rounded checked:border-transparent mr-5">{{ $permission->name_cn }}
                        </h3>
                        @if ($permission->children->count())
                            <div class="grid grid-cols-4 gap-4 py-5 px-3 place-items-center">
                                @foreach ($permission->children as $child)
                                    <div>
                                        <input type="checkbox" id="p-{{$child->id }}" pid="p-{{ $permission->id . '-' . $child->id }}"
                                            name="permissions[]" value="{{ $child->id }}"
                                            class="child appearance-none checked:bg-blue-600 rounded checked:border-transparent mr-5">
                                        <label
                                            for="p-{{$child->id }}">{{ Str::replace($permission->name_cn.'-', '', $child->name_cn) }}</label>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        <hr>
                    @endforeach
                </div>
            </div>
        </div>
    </form>
    </div>
    <x-toast></x-toast>
    @section('script')
        <script>
            $(function() {
                $("#check-all").change(function() {
                    var boxname = $(this).attr('name')
                    $('input[name="' + boxname + '"]').prop('checked', $(this).is(':checked'));

                });
                $('input.parent').on('change', function() {
                    var id = $(this).attr("pid");
                    $('input[pid^=' + id + '-]').prop('checked', $(this).is(':checked'));
                });
                $('input.child').on('change', function() {
                    var id = $(this).attr("id");
                    id = id.substring(0, id.lastIndexOf("-"));
                    var parent = $('input[pid=' + id + ']');
                    if ($(this).is(':checked')) {
                        parent.prop('checked', true);
                        //循环到顶级
                        console.log('index', id.lastIndexOf("-"))
                        while (id.lastIndexOf("-") > 2) {
                            id = id.substring(0, id.lastIndexOf("-"));
                            parent = $('input[pid=' + id + ']');
                            parent.prop('checked', true);
                        }
                    } else {
                        //父级
                        if ($('input[pid^=' + id + '-]:checked').length == 0) {
                            parent.prop('checked', false);
                            //循环到顶级
                            while (id.lastIndexOf("-") > 2) {
                                id = id.substring(0, id.lastIndexOf("-"));
                                parent = $('input[id=' + id + ']');
                                if ($('input[pid^=' + id + '-]:checked').length == 0) {
                                    parent.prop('checked', false);
                                }
                            }
                        }
                    }
                });

                
            });
            new TomSelect('#role', {
                create: false,
                render: {
                    no_results: function(data, escape) {
                        return '<div class="no-results">没有查到～</div>';
                    },
                },
                onChange:function(){
                    $('input[type="checkbox"]').prop('checked', false);
                    if (this.items[0]){
                        id =this.items[0]
                        var url = "{{ route('role.rpinfo', 100100101) }}".replace('100100101', id);
                        axios.get(url).then(function(response){
                            var pids=response.data;
                            pids.forEach(pid => {
                                $('#p-'+pid).prop('checked', true);
                            });
                        })
                    }
                },
            });

        </script>
    @endsection
</x-dashboard-layout>
