@extends('layouts.app')

@section('title', 'Register - TK Puspitasari')

@section('content')
<div class="min-h-screen bg-slate-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-3xl mx-auto bg-white rounded-3xl shadow-xl shadow-slate-200/50 overflow-hidden ring-1 ring-slate-100">
        <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-8 py-10 text-center">
            <h2 class="text-3xl font-extrabold text-white">Student Admission Form</h2>
            <p class="mt-2 text-indigo-100">Academic Year {{ date('Y') }}/{{ date('Y') + 1 }}</p>
        </div>

        <div class="p-8 sm:p-12">
            @if(session('success'))
            <div class="mb-8 rounded-xl bg-green-50 p-4 border border-green-200">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-green-800">Successfully Registered!</h3>
                        <div class="mt-2 text-sm text-green-700">
                            <p>{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <form action="{{ route('register.store') }}" method="POST" class="space-y-8">
                @csrf

                <div>
                    <h3 class="text-lg font-semibold text-slate-900 border-b border-slate-200 pb-2 mb-6">Student Information</h3>
                    <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2">
                        <div class="sm:col-span-2">
                            <label for="nama_lengkap" class="block text-sm font-medium text-slate-700">Full Name</label>
                            <div class="mt-1">
                                <input type="text" name="nama_lengkap" id="nama_lengkap" required value="{{ old('nama_lengkap') }}" class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm px-4 py-3 bg-slate-50 border ring-1 ring-slate-200/50">
                                @error('nama_lengkap') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div>
                            <label for="nama_panggilan" class="block text-sm font-medium text-slate-700">Nickname (Optional)</label>
                            <div class="mt-1">
                                <input type="text" name="nama_panggilan" id="nama_panggilan" value="{{ old('nama_panggilan') }}" class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm px-4 py-3 bg-slate-50 border ring-1 ring-slate-200/50">
                            </div>
                        </div>

                        <div>
                            <label for="jenis_kelamin" class="block text-sm font-medium text-slate-700">Gender</label>
                            <div class="mt-1">
                                <select id="jenis_kelamin" name="jenis_kelamin" required class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm px-4 py-3 bg-slate-50 border ring-1 ring-slate-200/50">
                                    <option value="">Select Gender...</option>
                                    <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Male (Laki-laki)</option>
                                    <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Female (Perempuan)</option>
                                </select>
                                @error('jenis_kelamin') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div>
                            <label for="tempat_lahir" class="block text-sm font-medium text-slate-700">Place of Birth</label>
                            <div class="mt-1">
                                <input type="text" name="tempat_lahir" id="tempat_lahir" required value="{{ old('tempat_lahir') }}" class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm px-4 py-3 bg-slate-50 border ring-1 ring-slate-200/50">
                            </div>
                        </div>

                        <div>
                            <label for="tanggal_lahir" class="block text-sm font-medium text-slate-700">Date of Birth</label>
                            <div class="mt-1">
                                <input type="date" name="tanggal_lahir" id="tanggal_lahir" required value="{{ old('tanggal_lahir') }}" class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm px-4 py-3 bg-slate-50 border ring-1 ring-slate-200/50">
                            </div>
                        </div>

                        <div class="sm:col-span-2">
                            <label for="nik" class="block text-sm font-medium text-slate-700">Student NIK</label>
                            <div class="mt-1">
                                <input type="text" name="nik" id="nik" required value="{{ old('nik') }}" class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm px-4 py-3 bg-slate-50 border ring-1 ring-slate-200/50">
                                @error('nik') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="sm:col-span-2">
                            <label for="alamat_jalan" class="block text-sm font-medium text-slate-700">Full Address</label>
                            <div class="mt-1">
                                <textarea id="alamat_jalan" name="alamat_jalan" rows="3" required class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm px-4 py-3 bg-slate-50 border ring-1 ring-slate-200/50">{{ old('alamat_jalan') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-10">
                    <h3 class="text-lg font-semibold text-slate-900 border-b border-slate-200 pb-2 mb-6">Parents Information</h3>
                    <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2">
                        <div>
                            <label for="nama_ayah" class="block text-sm font-medium text-slate-700">Father's Name</label>
                            <div class="mt-1">
                                <input type="text" name="nama_ayah" id="nama_ayah" required value="{{ old('nama_ayah') }}" class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm px-4 py-3 bg-slate-50 border ring-1 ring-slate-200/50">
                            </div>
                        </div>

                        <div>
                            <label for="nama_ibu" class="block text-sm font-medium text-slate-700">Mother's Name</label>
                            <div class="mt-1">
                                <input type="text" name="nama_ibu" id="nama_ibu" required value="{{ old('nama_ibu') }}" class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm px-4 py-3 bg-slate-50 border ring-1 ring-slate-200/50">
                            </div>
                        </div>

                        <div class="sm:col-span-2">
                            <label for="no_hp_ortu" class="block text-sm font-medium text-slate-700">WhatsApp / Phone Number</label>
                            <div class="mt-1">
                                <input type="tel" name="no_hp_ortu" id="no_hp_ortu" required value="{{ old('no_hp_ortu') }}" class="block w-full rounded-xl border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm px-4 py-3 bg-slate-50 border ring-1 ring-slate-200/50">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pt-5 mt-10 border-t border-slate-200 content-end">
                    <button type="submit" class="w-full flex justify-center py-4 px-4 border border-transparent rounded-2xl shadow-lg shadow-indigo-500/30 text-base font-bold text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-300">
                        Submit Registration
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
