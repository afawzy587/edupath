document.addEventListener('livewire:init', () => {
    Livewire.on('assessment-saved', () => {
        const toast = document.getElementById('save-toast');
        if (! toast) {
            return;
        }
        toast.classList.remove('hidden');
        if (window.__saveToastTimer) {
            clearTimeout(window.__saveToastTimer);
        }
        window.__saveToastTimer = setTimeout(() => {
            toast.classList.add('hidden');
        }, 10000);
    });
    Livewire.on('hobbies-saved', () => {
        const toast = document.getElementById('save-toast');
        if (! toast) {
            return;
        }
        toast.classList.remove('hidden');
        if (window.__saveToastTimer) {
            clearTimeout(window.__saveToastTimer);
        }
        window.__saveToastTimer = setTimeout(() => {
            toast.classList.add('hidden');
        }, 10000);
    });
});
