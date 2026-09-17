<div id="file-list" class="flex h-full flex-col gap-4 overflow-hidden rounded-2xl bg-white p-6 shadow-xl ring-1 ring-black/5">
    <h2 class="text-sm font-semibold tracking-wide text-gray-500 uppercase">Uploaded files</h2>

    <ul id="uploaded-gallery" class="grid flex-1 auto-rows-min grid-cols-3 gap-3 overflow-auto sm:grid-cols-4 md:grid-cols-5 xl:grid-cols-6">
        <li id="uploaded-empty" class="col-span-full py-10 text-center text-sm text-gray-400">No files yet</li>
    </ul>

    <div class="flex items-center justify-between border-t border-gray-100 pt-4 text-sm text-gray-600">
        <button type="button" id="prev-page"
                class="rounded-lg border border-gray-200 px-3 py-1.5 font-medium transition hover:bg-gray-100 disabled:cursor-not-allowed disabled:opacity-40">
            &larr; Prev
        </button>
        <span id="page-info"></span>
        <button type="button" id="next-page"
                class="rounded-lg border border-gray-200 px-3 py-1.5 font-medium transition hover:bg-gray-100 disabled:cursor-not-allowed disabled:opacity-40">
            Next &rarr;
        </button>
    </div>
</div>
