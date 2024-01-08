@push('css')
<style>
    .lightbox {
        position: fixed;
        z-index: 5000;
        inset: 0;
        height: 100vh;
        width: 100vw;
        background-color: rgba(0, 0, 0, 0.8);
    }

    .lightbox-container {
        height: 100vh;
        width: 100vw;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .lightbox-container img {
        max-width: 80%;
        max-height: 80%;
    }
</style>
@endpush
<div class="lightbox" x-data="{lightboxOpen: false, imgSrc: ''}" x-show="lightboxOpen" x-transition @lightbox.window="lightboxOpen = true; imgSrc = $event.detail;">
    <div class="lightbox-container">
        <img :src="imgSrc" @click.away="lightboxOpen = false">
    </div>
</div>
