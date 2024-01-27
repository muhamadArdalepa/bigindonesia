<x-layouts.app>
    <div class="card">
        <div class="card-header">
            <div class="">
                <h6 class="m-0">
                    Kelola Pengguna
                </h6>
            </div>
        </div>
        <div class="card-body" x-data="{ active: 0 }">
            <nav class="nav nav-pills bg-light p-2  mb-3">
                <span class="nav-link cursor-pointer" :class="section == active ? 'active' : ''" @click="active=0"
                    x-data="{ section: 0 }">Karyawan</span>
                <span class="nav-link cursor-pointer" :class="section == active ? 'active' : ''" @click="active=1"
                    x-data="{ section: 1 }">Supervisor</span>
                <span class="nav-link cursor-pointer" :class="section == active ? 'active' : ''" @click="active=2"
                    x-data="{ section: 2 }">Super Admin</span>
            </nav>
            <table>

            </table>
        </div>
    </div>
</x-layouts.app>
