@extends('layouts.default')
@section('content')
    <div class="mt-16">
        <div class="grid grid-cols-1 lg:gap-8">
            <a href="/add-url"
                class="items-center scale-100 p-6 bg-white dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-2xl shadow-gray-500/20 dark:shadow-none flex motion-safe:hover:scale-[1.01] transition-all duration-250 focus:outline focus:outline-2 focus:outline-red-500">

                <div class="h-16 w-16 bg-red-50 dark:bg-red-800/20 flex items-center justify-center rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        class="w-7 h-7 stroke-red-500">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                    </svg>
                </div>

                <h2 class="px-6 text-xl font-semibold text-gray-900 dark:text-white">Add URLs</h2>

                <p class="text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
                    You can submit links which are validated and stored by the application.
                </p>


                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    class="self-center shrink-0 stroke-red-500 w-6 h-6 mx-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12h15m0 0l-6.75-6.75M19.5 12l-6.75 6.75" />
                </svg>
            </a>
        </div>
        <div x-data="urlList()" x-init="fetchData()" class="grid grid-cols-1 p-6 bg-white mt-6 rounded-lg">
            <div class="col-span-full flex lg:gap:4 mb-3 justify-between">
                <input
                    x-ref="searchField"
                    x-model="search"
                    x-on:keydown.window.prevent.slash="$refs.searchField.focus()"
                    placeholder="Search for an url..."
                    type="search"
                    x-on:keydown.debounce="searchPage()"
                    class="col-span-8 bg-gray-200 focus:outline-none focus:bg-white focus:shadow text-gray-700 font-bold rounded-lg px-4 py-3" />
                    <select x-model="sortBy" x-on:change.debounce="searchPage()">
                        <option value="id">Id</option>
                        <option value="url">Url</option>
                        <option value="created_at">Created At</option>
                    </select>
                    <select x-model="sortByDirection" x-on:change.debounce="searchPage()">
                        <option value="asc">Ascending</option>
                        <option value="desc">Descending</option>
                    </select>
                    <input
                    x-model="size"
                    placeholder="Per page"
                    type="number"
                    x-on:keydown.debounce="searchPage()"
                    x-on:change.debounce="searchPage()"
                    class="content-end col-span-4 bg-gray-200 focus:outline-none focus:bg-white focus:shadow text-gray-700 font-bold rounded-lg px-4 py-3" />
            </div>

            <table class="col-span-full table-auto w-full">
                <thead>
                    <tr class="text-gray-600 font-semibold">
                        <th class="px-4 py-2 bg-gray-100 border">Id</th>
                        <th class="px-4 py-2 bg-gray-100 border">Domain</th>
                        <th class="px-4 py-2 bg-gray-100 border">Url</th>
                        <th class="px-4 py-2 bg-gray-100 border">Created At</th>
                    </tr>
                </thead>
                <tbody>
                    <template x-for="url in urls" :key="url.id">
                        <tr>
                            <td class="px-4 py-8" x-text="url.id"></td>
                            <td class="px-4 py-8 " x-text="url.domain.name"></td>
                            <td class="px-4 py-8" x-text="url.url"></td>
                            <td class="px-4 py-8" x-text="url.created_at"></td>
                        </tr>
                    </template>
                </tbody>
            </table>

            <div class="w-full md:w-1/2 mx-auto py-6 flex justify-between items-center" x-show="pageCount() > 1">
                <!--First Button-->
                <button x-on:click="viewPage(0)" :disabled="pageNumber == 0"
                    :class="{ 'disabled cursor-not-allowed text-gray-600': pageNumber == 0 }">
                    <svg class="h-8 w-8 text-red-200" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polygon points="19 20 9 12 19 4 19 20"></polygon>
                        <line x1="5" y1="19" x2="5" y2="5"></line>
                    </svg>
                </button>

                <!--Previous Button-->
                <button x-on:click="prevPage" :disabled="pageNumber == 0"
                    :class="{ 'disabled cursor-not-allowed text-gray-600': pageNumber == 0 }">
                    <svg class="h-8 w-8 text-red-200" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="15 18 9 12 15 6"></polyline>
                    </svg>
                </button>

                <!-- Display page numbers -->
                <template x-for="(page,index) in pages()" :key="index">
                    <button class="px-3 py-2 rounded"
                        :class="{ 'bg-red-200 text-white font-bold': (index + 1) === pageNumber }" type="button"
                        x-on:click="viewPage(index)">
                        <span x-text="index+1"></span>
                    </button>
                </template>

                <!--Next Button-->
                <button x-on:click="nextPage" :disabled="pageNumber >= pageCount() - 1"
                    :class="{ 'disabled cursor-not-allowed text-gray-600': pageNumber >= pageCount() - 1 }">
                    <svg class="h-8 w-8 text-red-200" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="9 18 15 12 9 6"></polyline>
                    </svg>
                </button>

                <!--Last Button-->
                <button x-on:click="viewPage(Math.ceil(total/size)-1)" :disabled="pageNumber >= pageCount() - 1"
                    :class="{ 'disabled cursor-not-allowed text-gray-600': pageNumber >= pageCount() - 1 }">
                    <svg class="h-8 w-8 text-red-200" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polygon points="5 4 15 12 5 20 5 4"></polygon>
                        <line x1="19" y1="5" x2="19" y2="19"></line>
                    </svg>
                </button>
            </div>
        </div>
        <script>
            function urlList() {
                return {
                    urls: [],
                    search: '',
                    pageNumber: 1,
                    size: 3,
                    sortBy: 'id',
                    sortByDirection: 'asc',
                    total: 0,
                    fetchData() {
                        axios.get('/urls', {
                                params: {
                                    search: this.search,
                                    per_page: this.size,
                                    page: this.pageNumber,
                                    sort_by: this.sortBy,
                                    sort_by_direction: this.sortByDirection,
                                }
                            })
                            .then((result) => {
                                // console.log(result);
                                this.urls = result.data.urls.data;
                                this.total = result.data.urls.total;
                            }).catch((error) => {
                                console.log(error);
                            })
                    },
                    pages() {
                        return Array.from({
                            length: Math.ceil(this.total / this.size),
                        });
                    },

                    //Next Page
                    nextPage() {
                        this.pageNumber++;
                        this.fetchData();
                    },

                    //Previous Page
                    prevPage() {
                        this.pageNumber--;
                        this.fetchData();
                    },

                    //Total number of pages
                    pageCount() {
                        return Math.ceil(this.total / this.size);
                    },

                    //Return the start range of the paginated results
                    startResults() {
                        return this.pageNumber * this.size + 1;
                    },

                    //Return the end range of the paginated results
                    endResults() {
                        let resultsOnPage = (this.pageNumber + 1) * this.size;

                        if (resultsOnPage <= this.total) {
                            return resultsOnPage;
                        }

                        return this.total;
                    },

                    //Link to navigate to page
                    viewPage(index) {
                        this.pageNumber = index + 1;
                        this.fetchData();
                    },
                    searchPage() {
                        this.fetchData();
                    },
                }
            }
        </script>
    </div>
@stop
