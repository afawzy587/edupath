const getExploreComponent = () => {
    const root = document.querySelector('[data-explore-component-id]');
    const componentId = root?.dataset?.exploreComponentId;
    if (! componentId || ! window.Livewire || typeof window.Livewire.find !== 'function') {
        return null;
    }

    return window.Livewire.find(componentId);
};

const callExploreMetric = (method, ...args) => {
    const component = getExploreComponent();
    if (! component || typeof component.call !== 'function') {
        return false;
    }

    component.call(method, ...args);
    return true;
};

const cleanupExploreVideoTracking = () => {
    (window.__exploreCleanupCallbacks || []).forEach((cleanup) => {
        cleanup();
    });
    window.__exploreCleanupCallbacks = [];
};

const reinitExploreVideos = () => {
    cleanupExploreVideoTracking();
    initExploreVideos();
};

const initExploreFilterSoundIntent = () => {
    if (window.__exploreFilterIntentInit) {
        return;
    }
    window.__exploreFilterIntentInit = true;

    document.addEventListener('click', (event) => {
        const filterButton = event.target.closest('[data-explore-filter]');
        if (! filterButton) {
            return;
        }
        window.__forceUnmuteOnNextExploreInit = true;
    });
};

const initExploreVideos = () => {
    if (! window.__exploreCleanupCallbacks) {
        window.__exploreCleanupCallbacks = [];
    }

    if (typeof window.__exploreMutedPreference !== 'boolean') {
        window.__exploreMutedPreference = true;
    }

    if (window.__forceUnmuteOnNextExploreInit) {
        window.__exploreMutedPreference = false;
        window.__forceUnmuteOnNextExploreInit = false;
    }

    const videoStates = new Map();
    const visibilityRatios = new Map();
    let activeVideo = null;

    const applyMutedPreferenceToAll = () => {
        const muted = window.__exploreMutedPreference;
        videoStates.forEach((state, video) => {
            video.muted = muted;
            state.updateControls();
        });
    };

    const setActiveVideo = (nextVideo, forcePlay = false) => {
        if (activeVideo === nextVideo && ! forcePlay) {
            return;
        }

        if (activeVideo && activeVideo !== nextVideo) {
            const activeState = videoStates.get(activeVideo);
            activeState?.pause(false);
        }

        activeVideo = nextVideo;

        if (nextVideo) {
            const nextState = videoStates.get(nextVideo);
            if (nextState) {
                nextVideo.muted = window.__exploreMutedPreference;
                nextState.play();
                nextState.markViewed();
            }
        }

        videoStates.forEach((state) => state.updateControls());
    };

    const pickMostVisibleVideo = () => {
        let candidate = null;
        let bestRatio = 0;

        visibilityRatios.forEach((ratio, video) => {
            if (ratio > bestRatio) {
                bestRatio = ratio;
                candidate = video;
            }
        });

        if (bestRatio >= 0.15) {
            setActiveVideo(candidate);
            return;
        }

        setActiveVideo(null);
    };

    const getViewportVisibilityRatio = (video) => {
        const rect = video.getBoundingClientRect();
        const viewportWidth = window.innerWidth || document.documentElement.clientWidth || 1;
        const viewportHeight = window.innerHeight || document.documentElement.clientHeight || 1;

        const visibleWidth = Math.max(0, Math.min(rect.right, viewportWidth) - Math.max(rect.left, 0));
        const visibleHeight = Math.max(0, Math.min(rect.bottom, viewportHeight) - Math.max(rect.top, 0));
        const visibleArea = visibleWidth * visibleHeight;
        const totalArea = Math.max(1, rect.width * rect.height);

        return Math.max(0, Math.min(1, visibleArea / totalArea));
    };

    const bootstrapVisibleVideo = () => {
        const videos = Array.from(document.querySelectorAll('[data-explore-video]'));
        if (videos.length === 1) {
            const onlyVideo = videos[0];
            visibilityRatios.set(onlyVideo, Math.max(getViewportVisibilityRatio(onlyVideo), 1));
            setActiveVideo(onlyVideo, true);
            return;
        }

        let candidate = null;
        let bestRatio = 0;

        videos.forEach((video) => {
            const ratio = getViewportVisibilityRatio(video);
            visibilityRatios.set(video, ratio);
            if (ratio > bestRatio) {
                bestRatio = ratio;
                candidate = video;
            }
        });

        if (candidate && bestRatio > 0) {
            setActiveVideo(candidate, true);
            return;
        }

        pickMostVisibleVideo();
    };

    document.querySelectorAll('[data-explore-video]').forEach((video) => {
        if (video.dataset.exploreInit === '1') {
            return;
        }
        video.dataset.exploreInit = '1';
        video.muted = window.__exploreMutedPreference;
        video.pause();

        const courseId = Number.parseInt(video.dataset.courseId || '', 10);
        const wrapper = video.closest('[data-explore-video-wrapper]');
        const playToggleButton = wrapper?.querySelector('[data-reel-play-toggle]');
        const playIcon = wrapper?.querySelector('[data-icon-play]');
        const muteToggleButton = wrapper?.querySelector('[data-reel-mute-toggle]');
        const muteIcon = wrapper?.querySelector('[data-icon-mute]');
        const unmuteIcon = wrapper?.querySelector('[data-icon-unmute]');
        const progressBar = wrapper?.querySelector('[data-reel-progress]');

        let hasTrackedView = false;
        let hasLoadedVideo = false;
        let bufferedWatchSeconds = 0;
        let lastTickTime = Date.now();
        const state = {
            markViewed: () => {},
            play: () => {},
            pause: () => {},
            togglePlay: () => {},
            toggleMute: () => {},
            updateControls: () => {},
            updateProgress: () => {},
        };

        const flushWatchTime = () => {
            const roundedSeconds = Math.round(bufferedWatchSeconds);
            if (roundedSeconds <= 0 || ! Number.isInteger(courseId)) {
                bufferedWatchSeconds = 0;
                return;
            }

            if (callExploreMetric('trackWatchTime', courseId, roundedSeconds)) {
                bufferedWatchSeconds = 0;
            }
        };

        const tick = () => {
            const now = Date.now();
            const diffSeconds = (now - lastTickTime) / 1000;
            lastTickTime = now;

            if (video.paused || video.ended || document.hidden || diffSeconds <= 0 || diffSeconds >= 15) {
                return;
            }

            bufferedWatchSeconds += diffSeconds;
            if (bufferedWatchSeconds >= 10) {
                flushWatchTime();
            }
        };

        const markViewed = () => {
            if (hasTrackedView || ! Number.isInteger(courseId)) {
                return;
            }
            if (callExploreMetric('trackView', courseId)) {
                hasTrackedView = true;
            }
        };

        const ensureVideoLoaded = () => {
            if (hasLoadedVideo) {
                return;
            }

            hasLoadedVideo = true;
            video.preload = 'auto';
            if (typeof video.load === 'function') {
                video.load();
            }
        };

        state.markViewed = markViewed;

        state.play = () => {
            ensureVideoLoaded();
            const playPromise = video.play();
            if (playPromise && typeof playPromise.catch === 'function') {
                playPromise.catch(() => {
                    // Browser may block unmuted autoplay; fallback to muted autoplay.
                    video.muted = true;
                    window.__exploreMutedPreference = true;
                    state.updateControls();
                    const retryPromise = video.play();
                    if (retryPromise && typeof retryPromise.catch === 'function') {
                        retryPromise.catch(() => {});
                    }
                });
            }
        };

        state.pause = () => {
            video.pause();
            flushWatchTime();
        };

        state.togglePlay = () => {
            if (video.paused) {
                setActiveVideo(video, true);
                return;
            }

            state.pause();
            state.updateControls();
        };

        state.toggleMute = () => {
            window.__exploreMutedPreference = ! window.__exploreMutedPreference;
            applyMutedPreferenceToAll();
        };

        state.updateControls = () => {
            if (playToggleButton) {
                const playText = playToggleButton.dataset.labelPlay || 'Play';
                const pauseText = playToggleButton.dataset.labelPause || 'Pause';
                playToggleButton.setAttribute('aria-label', video.paused ? playText : pauseText);
                playToggleButton.classList.toggle('hidden', ! video.paused);
            }

            if (playIcon) {
                playIcon.classList.toggle('hidden', ! video.paused);
            }

            if (muteToggleButton) {
                const muteText = muteToggleButton.dataset.labelMute || 'Mute';
                const unmuteText = muteToggleButton.dataset.labelUnmute || 'Unmute';
                muteToggleButton.setAttribute('aria-label', video.muted ? unmuteText : muteText);
            }

            if (muteIcon && unmuteIcon) {
                muteIcon.classList.toggle('hidden', video.muted);
                unmuteIcon.classList.toggle('hidden', ! video.muted);
            }
        };

        state.updateProgress = () => {
            if (! progressBar) {
                return;
            }

            if (! Number.isFinite(video.duration) || video.duration <= 0) {
                progressBar.style.width = '0%';
                return;
            }

            const percent = Math.max(0, Math.min(100, (video.currentTime / video.duration) * 100));
            progressBar.style.width = `${percent}%`;
        };

        const visibilityHandler = () => {
            if (document.hidden) {
                flushWatchTime();
                state.pause();
                return;
            }
            lastTickTime = Date.now();
            if (video === activeVideo) {
                state.play();
            }
        };

        const onWrapperClick = (event) => {
            if (! wrapper) {
                return;
            }

            const interactiveTarget = event.target.closest('a, button, [data-reel-play-toggle], [data-reel-mute-toggle]');
            if (interactiveTarget) {
                return;
            }

            state.togglePlay();
        };

        const onPlayClick = (event) => {
            event.preventDefault();
            event.stopPropagation();
            state.togglePlay();
        };

        const onMuteClick = (event) => {
            event.preventDefault();
            event.stopPropagation();
            state.toggleMute();
        };

        const onVideoEnded = () => {
            state.updateProgress();
            if (progressBar) {
                progressBar.style.width = '100%';
            }
        };

        const observer = new IntersectionObserver(
            (entries) => {
                entries.forEach((entry) => {
                    visibilityRatios.set(video, entry.isIntersecting ? entry.intersectionRatio : 0);
                    if (entry.isIntersecting && entry.intersectionRatio >= 0.2) {
                        ensureVideoLoaded();
                    }
                });
                pickMostVisibleVideo();
            },
            { threshold: [0.2, 0.35, 0.5, 0.65, 0.8, 0.95] }
        );

        videoStates.set(video, state);
        visibilityRatios.set(video, 0);
        observer.observe(video);
        wrapper?.addEventListener('click', onWrapperClick);
        video.addEventListener('pause', flushWatchTime);
        video.addEventListener('ended', flushWatchTime);
        video.addEventListener('timeupdate', state.updateProgress);
        video.addEventListener('loadedmetadata', state.updateProgress);
        video.addEventListener('ended', onVideoEnded);
        playToggleButton?.addEventListener('click', onPlayClick);
        muteToggleButton?.addEventListener('click', onMuteClick);
        document.addEventListener('visibilitychange', visibilityHandler);
        window.addEventListener('beforeunload', flushWatchTime);

        const timer = window.setInterval(tick, 1000);
        state.updateControls();
        state.updateProgress();

        window.__exploreCleanupCallbacks.push(() => {
            window.clearInterval(timer);
            observer.disconnect();
            wrapper?.removeEventListener('click', onWrapperClick);
            video.removeEventListener('pause', flushWatchTime);
            video.removeEventListener('ended', flushWatchTime);
            video.removeEventListener('timeupdate', state.updateProgress);
            video.removeEventListener('loadedmetadata', state.updateProgress);
            video.removeEventListener('ended', onVideoEnded);
            playToggleButton?.removeEventListener('click', onPlayClick);
            muteToggleButton?.removeEventListener('click', onMuteClick);
            document.removeEventListener('visibilitychange', visibilityHandler);
            window.removeEventListener('beforeunload', flushWatchTime);
            flushWatchTime();
            visibilityRatios.delete(video);
            videoStates.delete(video);
            if (activeVideo === video) {
                activeVideo = null;
            }
            delete video.dataset.exploreInit;
        });
    });

    bootstrapVisibleVideo();
    window.requestAnimationFrame(() => {
        window.requestAnimationFrame(() => {
            bootstrapVisibleVideo();
        });
    });
};

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
document.addEventListener('DOMContentLoaded', () => initExploreVideos());
document.addEventListener('DOMContentLoaded', initExploreFilterSoundIntent);

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
document.addEventListener('livewire:navigated', () => {
    reinitExploreVideos();
});

const initExploreObserver = () => {
    if (! document.body || window.__exploreObserver) {
        return;
    }

    const scheduleReinit = () => {
        window.clearTimeout(window.__exploreReinitTimer);
        window.__exploreReinitTimer = window.setTimeout(() => {
            if (! document.querySelector('[data-explore-component-id]')) {
                return;
            }
            reinitExploreVideos();
        }, 0);
    };

    window.__exploreObserver = new MutationObserver((mutations) => {
        let shouldReinit = false;

        mutations.forEach((mutation) => {
            mutation.addedNodes.forEach((node) => {
                if (node.nodeType !== 1) {
                    return;
                }
                if (node.matches?.('[data-explore-video]') || node.querySelector?.('[data-explore-video]')) {
                    shouldReinit = true;
                }
            });
        });

        if (shouldReinit) {
            scheduleReinit();
        }
    });

    window.__exploreObserver.observe(document.body, {
        childList: true,
        subtree: true,
    });
};

document.addEventListener('DOMContentLoaded', initExploreObserver);
document.addEventListener('livewire:init', initExploreObserver);
document.addEventListener('livewire:init', initExploreFilterSoundIntent);
