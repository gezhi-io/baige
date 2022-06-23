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
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="bg-white text-sm  text-center text-slate-800 border-indigo-200">
                                <td class="px-3 py-5">
                                    1
                                </td>
                                <td class="px-3 py-5">
                                    后台管理
                                </td>
                                <td class="px-3 py-5">
                                    dashboard
                                </td>
                                <td class="px-3 py-5">
                                    web
                                </td>
                                <td class="px-3 py-5">
                                    2022-01-01 12:30
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div
                        class="px-5 py-5 bg-white border-t flex flex-col xs:flex-row items-center xs:justify-between          ">
                        <span class="text-xs xs:text-sm text-gray-900">
                            Showing 1 to 4 of 50 Entries
                        </span>
                        <div class="inline-flex mt-2 xs:mt-0">
                            <button
                                class="text-sm bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 rounded-l">
                                Prev
                            </button>
                            <button
                                class="text-sm bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 rounded-r">
                                Next
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="md:col-span-4">
            <form class="bg-white py-10 px-5 mt-4 rounded-lg shadow-lg min-w-full">
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
                    <button
                        class="w-20 mt-6 bg-indigo-100 rounded-lg px-4 py-2 text-gray-800 tracking-wide">{{ __('Cancel') }}</button>
                </div>

            </form>
        </div>
    </div>
</x-dashboard-layout>
