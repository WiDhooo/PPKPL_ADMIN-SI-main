<style>
.sidebar-hover-custom:hover:not(.sidebar-active) {
  background-color: rgba(61, 153, 112, 0.3) !important;
}
.sidebar-active {
  background-color: rgba(61, 153, 112, 0.8) !important;
}
</style>

<div class="flex flex-col h-screen text-white px-4 overflow-y-auto" x-data="{ activeMenu: 'dashboard' }">
  <!-- Sidebar Content -->
  <div class="overflow-y-auto flex-grow space-y-2">
    <div class="flex items-center mb-6">
      <img src="{{ asset('img/11zon_cropped.png') }}" alt="Logo" class="w-12 h-12 mr-2">
      <span class="text-xl font-bold">TPQ Nurul Iman</span>
    </div>

    <!-- Dashboard Menu -->
    <a href="{{ route('dashboard') }}"
       class="flex items-center px-4 py-2 sidebar-hover-custom rounded-lg group text-white
       @if(request()->is('admin/dashboard*')) sidebar-active @endif">
      <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
      </svg>
      <span>Dashboard</span>
    </a>

    <!-- SPP Menu
    <a href="{{ route('spp') }}" class="flex items-center px-4 py-2 hover:bg-white/10 rounded-lg group {{ request()->is('spp*') ? 'bg-green-600 text-white': 'text-white' }}">
        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
        </svg>
        <span>SPP</span>
    </a> -->

      <!-- Kelas Menu -->
     <a href="{{ route('kelas') }}" class="flex items-center px-4 py-2 sidebar-hover-custom rounded-lg group text-white @if(request()->is('admin/kelas*')) sidebar-active @endif">
  <svg class="w-6 h-6 mr-3" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
    <!-- Bingkai papan tulis -->
    <rect x="3" y="4" width="18" height="12" rx="2" ry="2" />
    <line x1="7" y1="20" x2="7" y2="16" />
    <line x1="17" y1="20" x2="17" y2="16" />
    <line x1="7" y1="20" x2="17" y2="20" />
  </svg>
  <span>Kelas</span>
</a>


    <!-- Akademik Menu -->
    <a href="{{ route('akademik') }}"
       class="flex items-center px-4 py-2 sidebar-hover-custom rounded-lg group text-white
       @if(request()->is('admin/akademik*')) sidebar-active @endif">
      <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
      </svg>
      <span>Akademik</span>
    </a>

    <!-- Foto Kegiatan Menu -->
    <a href="{{ route('fotokegiatan') }}"
       class="flex items-center px-4 py-2 sidebar-hover-custom rounded-lg group text-white
       @if(request()->is('admin/fotokegiatan*')) sidebar-active @endif">
      <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
      </svg>
      <span>Foto Kegiatan</span>
    </a>

    <!-- Data Santri -->
    <a href="{{ route('santri') }}"
       class="flex items-center px-4 py-2 sidebar-hover-custom rounded-lg group text-white
       @if(request()->is('admin/santri*')) sidebar-active @endif">
      <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
        </svg>

      <span>Santri</span>
    </a>

    <!-- Panduan Menu -->
    <a href="{{ route('panduan') }}"
       class="flex items-center px-4 py-2 sidebar-hover-custom krounded-lg group text-white
       @if(request()->is('admin/panduan*')) sidebar-active @endif">
      <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M12 11a4 4 0 1 0 0-8 4 4 0 1 0 0 8zm-6 10v-2a6 6 0 0 1 12 0v2"/>
      </svg>
      <span>Panduan</span>
    </a>

    <!-- Aduan Menu -->
    {{-- <a href="{{ route('aduan') }}" class="flex items-center px-4 py-2 hover:bg-white/10 rounded-lg group {{ request()->is('aduan*') ? 'bg-green-600 text-white': 'text-white' }}">
    {{-- <a href="{{ route('aduan') }}" class="flex items-center px-4 py-2 hover:bg-white/10 rounded-lg group {{ request()->is('aduan*') ? 'bg-green-600 text-white': 'text-white' }}">
        <svg class="w-5 h-5 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l9-6 9 6v8a9 9 0 0 1-18 0z" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M8 16h8" />
        </svg>
        <span>Aduan</span>
    </a> --}}
    </div>

    <!-- Tombol Logout agak naik -->
    <div class="xl mb-8">
    <button @click="open = true" class="transition-colors duration-200 hover:text-red-700  flex items-center gap-2 text-left px-4 py-2 hover:bg-white/10 rounded-lg transition {{ request()->is('keluar*') ? 'bg-green-600 text-white': 'text-white' }}">
    <button @click="open = true" class="transition-colors duration-200 hover:text-red-700  flex items-center gap-2 text-left px-4 py-2 hover:bg-white/10 rounded-lg transition {{ request()->is('keluar*') ? 'bg-green-600 text-white': 'text-white' }}">
            <!-- Icon Logout -->
        <svg class="w-5 h-5 mr-3 hover:stroke-red-700" xmlns="hover:red-700 http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class=" w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12H3m12 0l-4 4m4-4l-4-4m8-5H9a2 2 0 00-2 2v14a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2z" />
        </svg>
        <span>Keluar</span>
    </button>
  </div>
</div>
