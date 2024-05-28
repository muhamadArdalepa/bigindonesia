<x-layouts.app>

    <div x-data="{ imagePreview: null, isLightboxOpen: false }">
        <input type="file" @change="previewImage($event)">

        <!-- Image Preview -->
        <div x-show="imagePreview" @click="openLightbox()">
            <img :src="imagePreview" alt="Preview" style="max-width: 100%; max-height: 200px;">
        </div>

        <!-- Lightbox Overlay -->
        <div class="lightbox-overlay" x-show="isLightboxOpen" @click="closeLightbox()">
            <img :src="imagePreview" alt="Lightbox" class="lightbox-image">
        </div>


    </div>

</x-layouts.app>
<script>
    function previewImage(event) {
        const input = event.target;

        if (input.files && input.files[0]) {
            const reader = new FileReader();

            reader.onload = (e) => {
                Alpine.store('imagePreview', e.target.result);
            };

            reader.readAsDataURL(input.files[0]);
        } else {
            Alpine.store('imagePreview', null);
        }
    }

    function openLightbox() {
        Alpine.store('isLightboxOpen', true);
    }

    function closeLightbox() {
        Alpine.store('isLightboxOpen', false);
    }

    // Adding functions to data Alpine.js
    Alpine.data('previewImage', previewImage);
    Alpine.data('openLightbox', openLightbox);
    Alpine.data('closeLightbox', closeLightbox);
</script>
