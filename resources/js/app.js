const hideFlashSuccess = () => {
    document.querySelectorAll('.flash-success').forEach((flash) => {
        if (flash.dataset.flashInit === '1') {
            return;
        }
        flash.dataset.flashInit = '1';
        window.setTimeout(() => {
            flash.classList.add('flash-hide');
            window.setTimeout(() => {
                flash.remove();
            }, 320);
        }, 5000);
    });
};

document.addEventListener('DOMContentLoaded', hideFlashSuccess);

const initFlashSuccessObserver = () => {
    if (! document.body || window.__flashSuccessObserver) {
        return;
    }
    const scheduleHide = () => {
        window.clearTimeout(window.__flashSuccessTimer);
        window.__flashSuccessTimer = window.setTimeout(hideFlashSuccess, 0);
    };
    window.__flashSuccessObserver = new MutationObserver((mutations) => {
        let found = false;
        mutations.forEach((mutation) => {
            mutation.addedNodes.forEach((node) => {
                if (node.nodeType !== 1) {
                    return;
                }
                if (node.matches('.flash-success') || node.querySelector?.('.flash-success')) {
                    found = true;
                }
            });
        });
        if (found) {
            scheduleHide();
        }
    });
    window.__flashSuccessObserver.observe(document.body, {
        childList: true,
        subtree: true,
    });
};

document.addEventListener('DOMContentLoaded', initFlashSuccessObserver);

document.addEventListener('livewire:init', () => {
    hideFlashSuccess();
    initFlashSuccessObserver();
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

document.addEventListener('livewire:navigated', hideFlashSuccess);
