<script setup>
import MainLayout from '@/Layouts/MainLayout.vue';
import { Head } from '@inertiajs/vue3';
import { onMounted } from 'vue';

// Vue şablonu yüklendikten sonra çalışacak
onMounted(() => {
  // Sayfa yüklendiğinde localStorage'dan mevcut temayı al ve uygula
  const savedTheme = localStorage.getItem('theme') || 'light';
  document.documentElement.setAttribute('data-theme', savedTheme);

  // Sayfa yüklendiğinde doğru radyo düğmesini seç
  setTimeout(() => {
    const radio = document.querySelector(`input[name="tema"][value="${savedTheme}"]`);
    if (radio) {
      radio.checked = true;
    }
  }, 500);  // Şablonun tamamen yüklenmesi için biraz bekle

  // Tema değişikliklerini izle ve localStorage'a kaydet
  const observer = new MutationObserver((mutations) => {
    mutations.forEach((mutation) => {
      if (mutation.attributeName === 'data-theme') {
        const currentTheme = document.documentElement.getAttribute('data-theme');
        if (currentTheme) {
          localStorage.setItem('theme', currentTheme);
        }
      }
    });
  });

  observer.observe(document.documentElement, {
    attributes: true,
    attributeFilter: ['data-theme']
  });

  // Global tema değiştirme fonksiyonu oluştur
  window.setTheme = function(theme) {
    document.documentElement.setAttribute('data-theme', theme);
    localStorage.setItem('theme', theme);
  };
});
</script>

<template>
    <Head title="Gösterge Paneli" />

    <MainLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Gösterge Paneli
            </h2>
        </template>

        <div class="py-6">
            <!-- İstatistik Kartları -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                <div class="card bg-base-100 shadow-sm p-4">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Toplam Kullanıcı</p>
                            <p class="text-2xl font-semibold mt-1">3,721</p>
                        </div>
                        <div class="p-2 bg-blue-50 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                    </div>
                    <div class="flex items-center mt-4">
                        <span class="text-sm font-medium text-green-500 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                            </svg>
                            16.5%
                        </span>
                        <span class="text-sm text-gray-500 ml-2">Bu ay</span>
                    </div>
                </div>

                <div class="card bg-base-100 shadow-sm p-4">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Toplam İçerik</p>
                            <p class="text-2xl font-semibold mt-1">842</p>
                        </div>
                        <div class="p-2 bg-purple-50 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                    </div>
                    <div class="flex items-center mt-4">
                        <span class="text-sm font-medium text-green-500 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                            </svg>
                            8.2%
                        </span>
                        <span class="text-sm text-gray-500 ml-2">Bu hafta</span>
                    </div>
                </div>

                <div class="card bg-base-100 shadow-sm p-4">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Toplam Görüntülenme</p>
                            <p class="text-2xl font-semibold mt-1">52,439</p>
                        </div>
                        <div class="p-2 bg-green-50 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </div>
                    </div>
                    <div class="flex items-center mt-4">
                        <span class="text-sm font-medium text-green-500 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                            </svg>
                            23.1%
                        </span>
                        <span class="text-sm text-gray-500 ml-2">Bu ay</span>
                    </div>
                </div>

                <div class="card bg-base-100 shadow-sm p-4">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Ortalama Oturum</p>
                            <p class="text-2xl font-semibold mt-1">5m 24s</p>
                        </div>
                        <div class="p-2 bg-amber-50 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                    <div class="flex items-center mt-4">
                        <span class="text-sm font-medium text-red-500 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                            </svg>
                            3.4%
                        </span>
                        <span class="text-sm text-gray-500 ml-2">Bu hafta</span>
                    </div>
                </div>
            </div>

            <!-- Ana İçerik Alanı -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Son Aktiviteler -->
                <div class="card bg-base-100 shadow-sm lg:col-span-2">
                    <div class="card-title p-4 border-b border-base-200">
                        <h3 class="font-semibold text-lg">Son Aktiviteler</h3>
                    </div>
                    <div class="p-4">
                        <div class="space-y-4">
                            <div class="flex items-start">
                                <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 flex-shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium">Yeni bir kullanıcı kayıt oldu.</p>
                                    <p class="text-xs text-gray-500 mt-1">20 dakika önce</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start">
                                <div class="h-10 w-10 rounded-full bg-purple-100 flex items-center justify-center text-purple-600 flex-shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium">Yeni bir içerik eklendi: "Lorem ipsum dolor sit amet"</p>
                                    <p class="text-xs text-gray-500 mt-1">1 saat önce</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start">
                                <div class="h-10 w-10 rounded-full bg-green-100 flex items-center justify-center text-green-600 flex-shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium">Bir içerik güncellendi: "Lorem ipsum dolor sit amet"</p>
                                    <p class="text-xs text-gray-500 mt-1">3 saat önce</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start">
                                <div class="h-10 w-10 rounded-full bg-red-100 flex items-center justify-center text-red-600 flex-shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium">Bir içerik silindi: "Lorem ipsum dolor sit amet"</p>
                                    <p class="text-xs text-gray-500 mt-1">5 saat önce</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-6">
                            <button class="btn btn-ghost w-full py-2 text-sm">Tüm aktiviteleri görüntüle</button>
                        </div>
                    </div>
                </div>

                <!-- Tema Ayarları -->
                <div class="card bg-base-100 shadow-sm">
                    <div class="card-title p-4 border-b border-base-200">
                        <h3 class="font-semibold text-lg">Tema Ayarları</h3>
                    </div>
                    <div class="p-4">
                        <div class="space-y-3">
                            <div class="form-control">
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="radio" name="tema" value="light" class="radio" onclick="setTheme('light')" />
                                    <span>Açık Tema</span>
                                </label>
                            </div>

                            <div class="form-control">
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="radio" name="tema" value="dark" class="radio" onclick="setTheme('dark')" />
                                    <span>Koyu Tema</span>
                                </label>
                            </div>

                            <div class="form-control">
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="radio" name="tema" value="retro" class="radio" onclick="setTheme('retro')" />
                                    <span>Retro Tema</span>
                                </label>
                            </div>

                            <div class="form-control">
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="radio" name="tema" value="cyberpunk" class="radio" onclick="setTheme('cyberpunk')" />
                                    <span>Cyberpunk Tema</span>
                                </label>
                            </div>

                            <div class="form-control">
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="radio" name="tema" value="valentine" class="radio" onclick="setTheme('valentine')" />
                                    <span>Valentine Tema</span>
                                </label>
                            </div>
                        </div>
                        
                        <div class="mt-6 space-y-2">
                            <h4 class="text-sm font-medium text-gray-700">Örnekler</h4>
                            <div class="grid grid-cols-2 gap-2">
                                <div class="bg-primary text-primary-content p-2 text-xs rounded">Primary</div>
                                <div class="bg-secondary text-secondary-content p-2 text-xs rounded">Secondary</div>
                                <div class="bg-accent text-accent-content p-2 text-xs rounded">Accent</div>
                                <div class="bg-neutral text-neutral-content p-2 text-xs rounded">Neutral</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </MainLayout>
</template>