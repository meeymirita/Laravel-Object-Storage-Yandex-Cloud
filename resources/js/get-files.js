export function initFileList() {
    const gallery = document.getElementById('uploaded-gallery');
    if (!gallery) return;

    const empty = document.getElementById('uploaded-empty');
    const pageInfo = document.getElementById('page-info');
    const prevBtn = document.getElementById('prev-page');
    const nextBtn = document.getElementById('next-page');

    let currentPage = 1;

    function render(paginator) {
        gallery.querySelectorAll('.uploaded-item').forEach((el) => el.remove());

        if (paginator.data.length === 0) {
            empty.classList.remove('hidden');
        } else {
            empty.classList.add('hidden');
            paginator.data.forEach((file) => {
                const li = document.createElement('li');
                li.className = 'uploaded-item aspect-square overflow-hidden rounded-lg bg-gray-100 shadow-sm ring-1 ring-black/5';
                li.innerHTML = `<img src="${file.url}" alt="" class="h-full w-full object-cover">`;
                gallery.appendChild(li);
            });
        }

        currentPage = paginator.current_page;
        pageInfo.textContent = `Page ${paginator.current_page} of ${paginator.last_page}`;
        prevBtn.disabled = !paginator.prev_page_url;
        nextBtn.disabled = !paginator.next_page_url;
    }

    function load(page = 1) {
        fetch(`/files?page=${page}`)
            .then((response) => response.json())
            .then(render)
            .catch((error) => console.error(error));
    }

    prevBtn.onclick = () => load(currentPage - 1);
    nextBtn.onclick = () => load(currentPage + 1);

    // refresh the list once new files finish uploading
    document.addEventListener('files-uploaded', () => load(1));

    load(1);
}
