<x-layouts.app>
    @volt
        <div class="" >
            <div class="card card-body" style="min-width: 15rem; max-width: 30rem">
                <div class="d-flex align-items-center">
                    <div class="text-sm" id="whichAbsen"></div>
                    <div class="ms-auto text-end">
                        <div class="text-sm">{{ now()->translatedFormat('l, j F Y') }}</div>
                    </div>
                </div>
                <div class="text-xs  mt-2"><i class="fa-regular fa-clock me-1"></i>{{ date('H:i') }}</div>
                <div class="text-xs opacity-7 my-2">
                    <i class="fa-solid fa-location-dot me-1"></i>
                    <span id="koordinat">
                        <i class="fa-solid fa-spin fa-spinner me-1"></i>
                        Sedang mendapatkan koordinat...
                    </span>
                </div>
                <div class="text-xs opacity-7" id="location">
                    <i class="fa-solid fa-spin fa-spinner me-1"></i>
                    Sedang mendapatkan lokasi...
                </div>
                <div class="mt-2">
                    <video id="webcam" autoplay style="width: 100%; transform: scaleX(-1)" class="rounded-3"></video>
                    <canvas id="canvas" class="d-none rounded-3" style="width: 100%"></canvas>
                </div>


                <button id="cameraButton"
                    class="btn rounded-circle align-self-center d-flex justify-content-center align-items-center"
                    style="
                        width: 4rem;
                        height: 4rem;
                        margin-top: -5rem;
                        margin-bottom: 1rem;
                        z-index: 2;
                        background-color: #fff4;
                        color: white;
                        ">
                    <i class="fa-solid fa-camera fa-xl"></i>
                </button>
                <input type="hidden" id="foto">
                <div id="fotoFeedback" class="invalid-feedback text-xs "></div>

                <input type="text" id="aktivitas" class="form-control mt-2" placeholder="Aktivitas">
                <div id="aktivitasFeedback" class="invalid-feedback text-xs mt-2"></div>

                <button id="absenButton" class="btn bg-gradient-success w-100 mt-2" disabled>Absen</button>

            </div>
        </div>
    @endvolt
</x-layouts.app>
