{{-- Global Loading Indicator --}}
<div 
    x-data 
    x-cloak 
    x-show="$store.isLoading.value"
    class="fixed inset-0 flex items-center justify-center z-[999999] bg-white/30 dark:bg-black/40 backdrop-blur-sm"
>
    <div class="loader"></div>
</div>

{{-- Alpine.js + Livewire Hooks --}}
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.store('isLoading', {
            value: false,
            delayTimer: null,
            set(value) {
                clearTimeout(this.delayTimer);
                if (value === false) {
                    this.value = false;
                } else {
                    this.delayTimer = setTimeout(() => this.value = true, 200);
                }
            }
        });
    });

    document.addEventListener("livewire:init", () => {
        Livewire.hook('commit.prepare', () => Alpine.store('isLoading').set(true));
        Livewire.hook('commit', ({succeed}) => succeed(() => queueMicrotask(() => Alpine.store('isLoading').set(false))));
    });
</script>

{{-- CSS (Inline for Blade) --}}
<style>
    @keyframes spin {
        100% {
            transform: rotate(360deg);
        }
    }

    /* From Uiverse.io by SchawnnahJ */ 
    .loader {
        position: relative;
        width: 2.5rem;
        height: 2.5em;
        transform: rotate(165deg);
    }

    .loader:before, .loader:after {
        content: "";
        position: absolute;
        top: 50%;
        left: 50%;
        display: block;
        width: 0.5em;
        height: 0.5em;
        border-radius: 0.25em;
        transform: translate(-50%, -50%);
    }

    .loader:before {
        animation: before8 2s infinite;
    }

    .loader:after {
        animation: after6 2s infinite;
    }

    @keyframes before8 {
        0% {
            width: 0.5em;
            box-shadow: 1em -0.5em rgba(225, 20, 98, 0.75), -1em 0.5em rgba(111, 202, 220, 0.75);
        }

        35% {
            width: 2.5em;
            box-shadow: 0 -0.5em rgba(225, 20, 98, 0.75), 0 0.5em rgba(111, 202, 220, 0.75);
        }

        70% {
            width: 0.5em;
            box-shadow: -1em -0.5em rgba(225, 20, 98, 0.75), 1em 0.5em rgba(111, 202, 220, 0.75);
        }

        100% {
            box-shadow: 1em -0.5em rgba(225, 20, 98, 0.75), -1em 0.5em rgba(111, 202, 220, 0.75);
        }
    }

    @keyframes after6 {
        0% {
            height: 0.5em;
            box-shadow: 0.5em 1em rgba(61, 184, 143, 0.75), -0.5em -1em rgba(233, 169, 32, 0.75);
        }

        35% {
            height: 2.5em;
            box-shadow: 0.5em 0 rgba(61, 184, 143, 0.75), -0.5em 0 rgba(233, 169, 32, 0.75);
        }

        70% {
            height: 0.5em;
            box-shadow: 0.5em -1em rgba(61, 184, 143, 0.75), -0.5em 1em rgba(233, 169, 32, 0.75);
        }

        100% {
            box-shadow: 0.5em 1em rgba(61, 184, 143, 0.75), -0.5em -1em rgba(233, 169, 32, 0.75);
        }
    }

    .loader {
        position: absolute;
        top: calc(50% - 1.25em);
        left: calc(50% - 1.25em);
    }
</style>
