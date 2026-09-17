// Drag-and-drop file upload widget (resources/views/components/file-upload.blade.php).
export function initFileUpload() {
    const form = document.getElementById('file-upload');
    if (!form) return;

    const fileTempl = document.getElementById('file-template');
    const imageTempl = document.getElementById('image-template');
    const empty = document.getElementById('empty');
    const gallery = document.getElementById('gallery');
    const overlay = document.getElementById('overlay');
    const hiddenInput = document.getElementById('hidden-input');

    // pre-selected files, keyed by their temporary object URL
    let files = {};

    function addFile(target, file) {
        const isImage = file.type.match('image.*');
        const objectURL = URL.createObjectURL(file);

        const clone = (isImage ? imageTempl : fileTempl).content.cloneNode(true);

        clone.querySelector('h1').textContent = file.name;
        clone.querySelector('li').id = objectURL;
        clone.querySelector('.delete').dataset.target = objectURL;
        clone.querySelector('.size').textContent = formatSize(file.size);

        if (isImage) {
            Object.assign(clone.querySelector('img'), { src: objectURL, alt: file.name });
        }

        empty.classList.add('hidden');
        target.prepend(clone);

        files[objectURL] = file;
    }

    function formatSize(bytes) {
        if (bytes > 1048576) return Math.round(bytes / 1048576) + 'mb';
        if (bytes > 1024) return Math.round(bytes / 1024) + 'kb';
        return bytes + 'b';
    }

    function resetGallery() {
        while (gallery.lastChild) {
            gallery.lastChild.remove();
        }
        files = {};
        empty.classList.remove('hidden');
        gallery.append(empty);
    }

    // click the hidden input when the visible button is pressed
    document.getElementById('upload-trigger').onclick = () => hiddenInput.click();
    hiddenInput.onchange = (e) => {
        for (const file of e.target.files) addFile(gallery, file);
    };

    // drag and drop handling
    const hasFiles = ({ dataTransfer: { types = [] } }) => types.indexOf('Files') > -1;
    let dragCounter = 0;

    form.addEventListener('dragenter', (e) => {
        e.preventDefault();
        if (!hasFiles(e)) return;
        dragCounter++;
        overlay.classList.add('opacity-100');
    });

    form.addEventListener('dragleave', () => {
        if (--dragCounter <= 0) overlay.classList.remove('opacity-100');
    });

    form.addEventListener('dragover', (e) => {
        if (hasFiles(e)) e.preventDefault();
    });

    form.addEventListener('drop', (e) => {
        e.preventDefault();
        for (const file of e.dataTransfer.files) addFile(gallery, file);
        overlay.classList.remove('opacity-100');
        dragCounter = 0;
    });

    // delete a single file (event delegation)
    gallery.addEventListener('click', ({ target }) => {
        const button = target.closest('.delete');
        if (!button) return;

        const objectURL = button.dataset.target;
        document.getElementById(objectURL)?.remove();
        delete files[objectURL];

        // only the hidden "empty" placeholder is left
        if (gallery.children.length === 1) {
            empty.classList.remove('hidden');
        }
    });

    document.getElementById('submit').onclick = () => {
        alert(`Submitted files:\n${Object.values(files).map((f) => f.name).join('\n')}`);
        console.log(files);
    };

    document.getElementById('cancel').onclick = resetGallery;
}
