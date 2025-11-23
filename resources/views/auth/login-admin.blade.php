@extends('layouts.main')

@section('title', 'Login Admin')

@section('content')

    <div id="modalLogin"
        class="fixed inset-0 bg-gray-100 flex items-center justify-center px-4">
    
        <!-- Modal Box -->
        <div class="bg-white rounded-xl w-full max-w-md p-6 shadow-lg relative py-12">

            <!-- Judul -->
            <h2 class="text-center text-lg font-semibold text-gray-800">
            Admin Web Alumni TPL
            </h2>
            <h3 class="text-center text-sm text-gray-500 mb-6">
            Masukkan email dan password untuk melanjutkan
            </h3>

            <!-- Form -->
            <form class="space-y-4" {{ route('admin.login') }}" method="POST" class="space-y-4">
            @csrf

            <!-- Jenjang -->
                <div>
                    <label class="block text-sm text-gray-700 mb-1">Email</label>
                    <input type="email" name="email"
                            placeholder="cth. budiono67@gmail.com"
                            class="w-full px-4 py-2 bg-gray-100 rounded-lg text-sm focus:ring-2 
                                    focus:ring-purple-500 focus:outline-none">
                </div>

                <!-- Nama Perusahaan -->
                <div>
                    <label class="block text-sm text-gray-700 mb-1">Password</label>
                    <input type="password" name="password"
                        placeholder="*******"
                        class="w-full px-4 py-2 bg-gray-100 rounded-lg text-sm focus:ring-2 
                                focus:ring-purple-500 focus:outline-none">
                </div>
                
                <!-- Tombol Simpan -->
                <button type="submit"
                        class="w-full py-2 mt-4 bg-purple-600  
                                text-white rounded-lg font-medium hover:opacity-90 transition">
                    Masuk
                </button>
                <h2 class="text-center text-sm text-gray-500 mb-6">
                Punya masalah? hubungi tpl@admin.ipb
                </h2>
            </form>

        </div>
    </div>



@endsection
