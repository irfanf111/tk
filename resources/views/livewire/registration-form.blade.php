<div class="py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-3xl mx-auto">

        {{-- Success Alert --}}
        @if ($successMessage)
        <div class="mb-8 rounded-2xl bg-gradient-to-r from-emerald-50 to-teal-50 p-6 border border-emerald-200 shadow-lg shadow-emerald-100/50 animate-fade-in">
            <div class="flex items-start gap-4">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 rounded-full bg-gradient-to-br from-emerald-400 to-teal-500 flex items-center justify-center shadow-lg shadow-emerald-500/30">
                        <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                        </svg>
                    </div>
                </div>
                <div class="flex-1">
                    <h3 class="text-lg font-bold text-emerald-800">Pendaftaran Berhasil!</h3>
                    <p class="mt-1 text-sm text-emerald-700">{{ $successMessage }}</p>
                </div>
                <button wire:click="$set('successMessage', '')" class="text-emerald-400 hover:text-emerald-600 transition-colors">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
        @endif

        {{-- Form Card --}}
        <div class="bg-white rounded-3xl shadow-xl shadow-slate-200/50 overflow-hidden ring-1 ring-slate-100">

            {{-- Header --}}
            <div class="bg-gradient-to-r from-indigo-600 via-indigo-700 to-purple-700 px-8 py-10 text-center relative overflow-hidden">
                {{-- Decorative circles --}}
                <div class="absolute top-0 left-0 w-32 h-32 bg-white/5 rounded-full -translate-x-16 -translate-y-16"></div>
                <div class="absolute bottom-0 right-0 w-40 h-40 bg-white/5 rounded-full translate-x-20 translate-y-20"></div>

                <div class="relative">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-white/10 backdrop-blur-sm mb-4 ring-1 ring-white/20">
                        <svg class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7.007 11.55A5.981 5.981 0 0 0 6.75 15.75v-1.5" />
                        </svg>
                    </div>
                    <h2 class="text-3xl font-extrabold text-white">Formulir Pendaftaran</h2>
                    <p class="mt-2 text-indigo-200 font-medium">Penerimaan Peserta Didik Baru — Tahun Ajaran {{ date('Y') }}/{{ date('Y') + 1 }}</p>
                </div>
            </div>

            {{-- Form Body --}}
            <form wire:submit="submit" class="p-8 sm:p-12 space-y-10">

                {{-- SECTION 1: Informasi Siswa --}}
                <div>
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 rounded-xl bg-indigo-100 flex items-center justify-center">
                            <svg class="w-5 h-5 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-slate-900">Informasi Siswa</h3>
                            <p class="text-sm text-slate-500">Lengkapi data calon peserta didik</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-y-5 gap-x-4 sm:grid-cols-2">

                        {{-- Nama Lengkap --}}
                        <div class="sm:col-span-2">
                            <label for="nama_lengkap" class="block text-sm font-semibold text-slate-700 mb-1.5">Nama Lengkap <span class="text-red-400">*</span></label>
                            <input wire:model.blur="nama_lengkap" type="text" id="nama_lengkap" placeholder="Masukkan nama lengkap siswa"
                                class="block w-full rounded-xl border px-4 py-3 text-sm bg-slate-50 shadow-sm transition-all duration-200
                                       focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 focus:bg-white
                                       @error('nama_lengkap') border-red-400 ring-2 ring-red-100 @else border-slate-200 ring-1 ring-slate-200/50 @enderror">
                            @error('nama_lengkap') <p class="mt-1.5 text-xs font-medium text-red-500 flex items-center gap-1"><svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>{{ $message }}</p> @enderror
                        </div>

                        {{-- Nama Panggilan --}}
                        <div>
                            <label for="nama_panggilan" class="block text-sm font-semibold text-slate-700 mb-1.5">Nama Panggilan</label>
                            <input wire:model.blur="nama_panggilan" type="text" id="nama_panggilan" placeholder="Contoh: Ani, Budi"
                                class="block w-full rounded-xl border px-4 py-3 text-sm bg-slate-50 shadow-sm transition-all duration-200
                                       focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 focus:bg-white
                                       border-slate-200 ring-1 ring-slate-200/50">
                        </div>

                        {{-- Jenis Kelamin (Select) --}}
                        <div>
                            <label for="jenis_kelamin" class="block text-sm font-semibold text-slate-700 mb-1.5">Jenis Kelamin <span class="text-red-400">*</span></label>
                            <select wire:model.blur="jenis_kelamin" id="jenis_kelamin"
                                class="block w-full rounded-xl border px-4 py-3 text-sm bg-slate-50 shadow-sm transition-all duration-200
                                       focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 focus:bg-white
                                       @error('jenis_kelamin') border-red-400 ring-2 ring-red-100 @else border-slate-200 ring-1 ring-slate-200/50 @enderror">
                                <option value="">— Pilih Jenis Kelamin —</option>
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                            @error('jenis_kelamin') <p class="mt-1.5 text-xs font-medium text-red-500 flex items-center gap-1"><svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>{{ $message }}</p> @enderror
                        </div>

                        {{-- Tempat Lahir --}}
                        <div>
                            <label for="tempat_lahir" class="block text-sm font-semibold text-slate-700 mb-1.5">Tempat Lahir <span class="text-red-400">*</span></label>
                            <input wire:model.blur="tempat_lahir" type="text" id="tempat_lahir" placeholder="Contoh: Jakarta"
                                class="block w-full rounded-xl border px-4 py-3 text-sm bg-slate-50 shadow-sm transition-all duration-200
                                       focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 focus:bg-white
                                       @error('tempat_lahir') border-red-400 ring-2 ring-red-100 @else border-slate-200 ring-1 ring-slate-200/50 @enderror">
                            @error('tempat_lahir') <p class="mt-1.5 text-xs font-medium text-red-500 flex items-center gap-1"><svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>{{ $message }}</p> @enderror
                        </div>

                        {{-- Tanggal Lahir (Date Picker) --}}
                        <div>
                            <label for="tanggal_lahir" class="block text-sm font-semibold text-slate-700 mb-1.5">Tanggal Lahir <span class="text-red-400">*</span></label>
                            <input wire:model.blur="tanggal_lahir" type="date" id="tanggal_lahir"
                                class="block w-full rounded-xl border px-4 py-3 text-sm bg-slate-50 shadow-sm transition-all duration-200
                                       focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 focus:bg-white
                                       @error('tanggal_lahir') border-red-400 ring-2 ring-red-100 @else border-slate-200 ring-1 ring-slate-200/50 @enderror">
                            @error('tanggal_lahir') <p class="mt-1.5 text-xs font-medium text-red-500 flex items-center gap-1"><svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>{{ $message }}</p> @enderror
                        </div>

                        {{-- NIK --}}
                        <div class="sm:col-span-2">
                            <label for="nik" class="block text-sm font-semibold text-slate-700 mb-1.5">NIK Siswa <span class="text-red-400">*</span></label>
                            <input wire:model.blur="nik" type="text" id="nik" placeholder="Masukkan 16 digit NIK" maxlength="20"
                                class="block w-full rounded-xl border px-4 py-3 text-sm bg-slate-50 shadow-sm transition-all duration-200
                                       focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 focus:bg-white
                                       @error('nik') border-red-400 ring-2 ring-red-100 @else border-slate-200 ring-1 ring-slate-200/50 @enderror">
                            @error('nik') <p class="mt-1.5 text-xs font-medium text-red-500 flex items-center gap-1"><svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>{{ $message }}</p> @enderror
                        </div>

                        {{-- Alamat --}}
                        <div class="sm:col-span-2">
                            <label for="alamat_jalan" class="block text-sm font-semibold text-slate-700 mb-1.5">Alamat Lengkap <span class="text-red-400">*</span></label>
                            <textarea wire:model.blur="alamat_jalan" id="alamat_jalan" rows="3" placeholder="Masukkan alamat lengkap tempat tinggal"
                                class="block w-full rounded-xl border px-4 py-3 text-sm bg-slate-50 shadow-sm transition-all duration-200 resize-none
                                       focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 focus:bg-white
                                       @error('alamat_jalan') border-red-400 ring-2 ring-red-100 @else border-slate-200 ring-1 ring-slate-200/50 @enderror"></textarea>
                            @error('alamat_jalan') <p class="mt-1.5 text-xs font-medium text-red-500 flex items-center gap-1"><svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                {{-- Divider --}}
                <div class="border-t border-slate-200"></div>

                {{-- SECTION 2: Informasi Orang Tua --}}
                <div>
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 rounded-xl bg-purple-100 flex items-center justify-center">
                            <svg class="w-5 h-5 text-purple-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-slate-900">Informasi Orang Tua</h3>
                            <p class="text-sm text-slate-500">Data orang tua/wali siswa</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-y-5 gap-x-4 sm:grid-cols-2">

                        {{-- Nama Ayah --}}
                        <div>
                            <label for="nama_ayah" class="block text-sm font-semibold text-slate-700 mb-1.5">Nama Ayah <span class="text-red-400">*</span></label>
                            <input wire:model.blur="nama_ayah" type="text" id="nama_ayah" placeholder="Masukkan nama ayah"
                                class="block w-full rounded-xl border px-4 py-3 text-sm bg-slate-50 shadow-sm transition-all duration-200
                                       focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 focus:bg-white
                                       @error('nama_ayah') border-red-400 ring-2 ring-red-100 @else border-slate-200 ring-1 ring-slate-200/50 @enderror">
                            @error('nama_ayah') <p class="mt-1.5 text-xs font-medium text-red-500 flex items-center gap-1"><svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>{{ $message }}</p> @enderror
                        </div>

                        {{-- Nama Ibu --}}
                        <div>
                            <label for="nama_ibu" class="block text-sm font-semibold text-slate-700 mb-1.5">Nama Ibu <span class="text-red-400">*</span></label>
                            <input wire:model.blur="nama_ibu" type="text" id="nama_ibu" placeholder="Masukkan nama ibu"
                                class="block w-full rounded-xl border px-4 py-3 text-sm bg-slate-50 shadow-sm transition-all duration-200
                                       focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 focus:bg-white
                                       @error('nama_ibu') border-red-400 ring-2 ring-red-100 @else border-slate-200 ring-1 ring-slate-200/50 @enderror">
                            @error('nama_ibu') <p class="mt-1.5 text-xs font-medium text-red-500 flex items-center gap-1"><svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>{{ $message }}</p> @enderror
                        </div>

                        {{-- No HP --}}
                        <div class="sm:col-span-2">
                            <label for="no_hp_ortu" class="block text-sm font-semibold text-slate-700 mb-1.5">Nomor WhatsApp / HP <span class="text-red-400">*</span></label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 1.5H8.25A2.25 2.25 0 0 0 6 3.75v16.5a2.25 2.25 0 0 0 2.25 2.25h7.5A2.25 2.25 0 0 0 18 20.25V3.75a2.25 2.25 0 0 0-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 18.75h3" />
                                    </svg>
                                </div>
                                <input wire:model.blur="no_hp_ortu" type="tel" id="no_hp_ortu" placeholder="Contoh: 08123456789"
                                    class="block w-full rounded-xl border pl-11 pr-4 py-3 text-sm bg-slate-50 shadow-sm transition-all duration-200
                                           focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 focus:bg-white
                                           @error('no_hp_ortu') border-red-400 ring-2 ring-red-100 @else border-slate-200 ring-1 ring-slate-200/50 @enderror">
                            </div>
                            @error('no_hp_ortu') <p class="mt-1.5 text-xs font-medium text-red-500 flex items-center gap-1"><svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                {{-- Submit Button --}}
                <div class="pt-6 border-t border-slate-200">
                    <button type="submit"
                        class="w-full flex items-center justify-center gap-3 py-4 px-6 border border-transparent rounded-2xl
                               text-base font-bold text-white
                               bg-gradient-to-r from-indigo-600 to-purple-600
                               hover:from-indigo-700 hover:to-purple-700
                               shadow-lg shadow-indigo-500/30 hover:shadow-xl hover:shadow-indigo-500/40
                               focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500
                               transition-all duration-300 transform hover:-translate-y-0.5
                               disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:translate-y-0"
                        wire:loading.attr="disabled">

                        {{-- Normal state --}}
                        <span wire:loading.remove>
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 12 3.269 3.125A59.769 59.769 0 0 1 21.485 12 59.768 59.768 0 0 1 3.27 20.875L5.999 12Zm0 0h7.5" />
                            </svg>
                        </span>
                        <span wire:loading.remove>Kirim Pendaftaran</span>

                        {{-- Loading state --}}
                        <span wire:loading class="inline-flex items-center gap-2">
                            <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Mengirim...
                        </span>
                    </button>
                </div>
            </form>
        </div>

        {{-- Footer note --}}
        <p class="text-center text-xs text-slate-400 mt-6">
            Dengan mengirim formulir ini, Anda menyetujui proses pendaftaran di TK Puspitasari.
        </p>
    </div>
</div>
