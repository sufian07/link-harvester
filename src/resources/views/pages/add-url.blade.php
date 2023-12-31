@extends('layouts.default')
@section('content')
    <div class="mt-16">
        <div class="grid grid-cols-1 lg:gap-8">
            <a href="/"
                class="items-center scale-100 p-6 bg-white dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-2xl shadow-gray-500/20 dark:shadow-none flex motion-safe:hover:scale-[1.01] transition-all duration-250 focus:outline focus:outline-2 focus:outline-red-500">

                <div class="h-16 w-16 bg-red-50 dark:bg-red-800/20 flex items-center justify-center rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        class="w-7 h-7 stroke-red-500">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                    </svg>
                </div>

                <h2 class="text-xl font-semibold text-gray-900 dark:text-white px-6">Show URLs</h2>

                <p class="text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
                    See a paginated list of stored URLs
                </p>


                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    class="self-center shrink-0 stroke-red-500 w-6 h-6 mx-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12h15m0 0l-6.75-6.75M19.5 12l-6.75 6.75" />
                </svg>
            </a>
            <form x-data="formData()" @submit.prevent="submit()" id="url-form">
                @csrf
                <textarea style="min-height: 250px" class="bg-white w-full px-6 py-6" name="urls" x-model="urls"
                    placeholder="Add URLs" data-rules='["required"]'></textarea>
                <p class="text-red-600" x-show.transition.in="errors.urls" x-text="errors.urls"></p>
                <button class="bg-white w-full px-6 py-6 hover:bg-gray transition-all duration-250">Save URLs</button>
            </form>
        </div>
        <script>
            function formData() {
                return {
                    urls: '',
                    errors: {
                        urls: '',
                    },
                    submit() {
                        if (!this.urls) {
                            this.errors.urls = 'Please enter url data';
                            return;
                        } else {
                            this.errors.urls = undefined;
                        }
                        axios.post('/', {
                                urls: this.urls
                            })
                            .then((result) => {
                                this.urls = ''
                            })
                            .catch((error) => {
                                this.errors.urls = error?.response?.data?.message ||
                                    'Please enter valid urls seperated by newline';
                            })
                    }
                }
            }
        </script>
    </div>
@stop
