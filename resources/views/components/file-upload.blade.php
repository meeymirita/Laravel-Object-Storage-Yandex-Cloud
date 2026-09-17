<form id="file-upload" enctype="multipart/form-data" aria-label="File Upload"
      class="relative flex h-full w-full flex-col overflow-hidden rounded-2xl bg-white shadow-xl ring-1 ring-black/5">

    {{-- drag-over overlay --}}
    <div id="overlay"
         class="pointer-events-none absolute inset-0 z-50 flex flex-col items-center justify-center rounded-2xl opacity-0 transition-opacity">
        <svg class="mb-3 h-12 w-12 fill-current text-indigo-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
            <path d="M19.479 10.092c-.212-3.951-3.473-7.092-7.479-7.092-4.005 0-7.267 3.141-7.479 7.092-2.57.463-4.521 2.706-4.521 5.408 0 3.037 2.463 5.5 5.5 5.5h13c3.037 0 5.5-2.463 5.5-5.5 0-2.702-1.951-4.945-4.521-5.408zm-7.479-1.092l4 4h-3v4h-2v-4h-3l4-4z"/>
        </svg>
        <p class="text-lg font-medium text-indigo-600">Drop files to upload</p>
    </div>

    <section class="flex h-full w-full flex-col overflow-auto p-6 sm:p-8">
        <header class="flex flex-col items-center justify-center rounded-xl border-2 border-dashed border-gray-300 bg-gray-50/60 py-14 text-center transition-colors">
            <p class="mb-3 flex flex-wrap justify-center gap-1 font-semibold text-gray-900">
                <span>Drag and drop your files anywhere or</span>
            </p>
            <input id="hidden-input" type="file" name="files[]" multiple class="hidden"/>
            <button type="button" id="upload-trigger"
                    class="rounded-lg bg-gray-900 px-4 py-2 text-sm font-medium text-white shadow-sm transition hover:bg-gray-700 focus:outline-none focus-visible:ring-2 focus-visible:ring-gray-900 focus-visible:ring-offset-2">
                Upload a file
            </button>
        </header>

        <h2 class="pt-8 pb-3 text-sm font-semibold tracking-wide text-gray-500 uppercase">
            To upload
        </h2>

        <ul id="gallery" class="grid flex-1 grid-cols-2 gap-3 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6">
            <li id="empty" class="col-span-full flex flex-col items-center justify-center gap-2 py-10 text-center">
                <img class="w-28 opacity-80"
                     src="https://user-images.githubusercontent.com/507615/54591670-ac0a0180-4a65-11e9-846c-e55ffce0fe7b.png"
                     alt="no data"/>
                <span class="text-sm text-gray-400">No files selected</span>
            </li>
        </ul>
    </section>

    <footer class="flex justify-end gap-3 border-t border-gray-100 bg-gray-50 px-6 py-4 sm:px-8">
        <button type="button" id="cancel"
                class="rounded-lg border border-gray-200 px-4 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-100 focus:outline-none focus-visible:ring-2 focus-visible:ring-gray-300">
            Cancel
        </button>
        <button type="button" id="submit"
                class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm transition hover:bg-indigo-500 focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-600 focus-visible:ring-offset-2">
            Upload now
        </button>
    </footer>
</form>

{{-- reused for every non-image file --}}
<template id="file-template">
    <li tabindex="0"
        class="group relative h-28 cursor-pointer rounded-lg bg-gray-100 shadow-sm ring-1 ring-black/5 focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500">
        <img alt="upload preview" class="img-preview hidden h-full w-full rounded-lg object-cover"/>

        <section class="absolute inset-0 z-20 flex h-full w-full flex-col rounded-lg p-3 text-xs break-words">
            <h1 class="flex-1 text-gray-800 group-hover:text-indigo-700"></h1>
            <div class="flex items-center">
                <span class="rounded-md p-1 text-indigo-700">
                    <svg class="ml-auto h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path d="M15 2v5h5v15h-16v-20h11zm1-2h-14v24h20v-18l-6-6z"/>
                    </svg>
                </span>
                <p class="size p-1 text-xs text-gray-600"></p>
                <button type="button" class="delete ml-auto rounded-md p-1 text-gray-700 hover:bg-gray-300 focus:outline-none">
                    <svg class="pointer-events-none ml-auto h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path class="pointer-events-none"
                              d="M3 6l3 18h12l3-18h-18zm19-4v2h-20v-2h5.711c.9 0 1.631-1.099 1.631-2h5.316c0 .901.73 2 1.631 2h5.711z"/>
                    </svg>
                </button>
            </div>
        </section>
    </li>
</template>

{{-- reused for every image file --}}
<template id="image-template">
    <li tabindex="0"
        class="group has-image relative h-28 cursor-pointer rounded-lg bg-gray-100 text-transparent shadow-sm ring-1 ring-black/5 hover:text-white focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500">
        <img alt="upload preview" class="img-preview h-full w-full rounded-lg object-cover"/>

        <section class="absolute inset-0 z-20 flex h-full w-full flex-col rounded-lg p-3 text-xs break-words transition-colors group-hover:bg-black/40">
            <h1 class="flex-1"></h1>
            <div class="flex items-center">
                <span class="rounded-md p-1">
                    <svg class="ml-auto h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path d="M5 8.5c0-.828.672-1.5 1.5-1.5s1.5.672 1.5 1.5c0 .829-.672 1.5-1.5 1.5s-1.5-.671-1.5-1.5zm9 .5l-2.519 4-2.481-1.96-4 5.96h14l-5-8zm8-4v14h-20v-14h20zm2-2h-24v18h24v-18z"/>
                    </svg>
                </span>
                <p class="size p-1 text-xs"></p>
                <button type="button" class="delete ml-auto rounded-md p-1 hover:bg-white/20 focus:outline-none">
                    <svg class="pointer-events-none ml-auto h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path class="pointer-events-none"
                              d="M3 6l3 18h12l3-18h-18zm19-4v2h-20v-2h5.711c.9 0 1.631-1.099 1.631-2h5.316c0 .901.73 2 1.631 2h5.711z"/>
                    </svg>
                </button>
            </div>
        </section>
    </li>
</template>
