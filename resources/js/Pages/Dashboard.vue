<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { onMounted, watch } from 'vue';

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
          console.log('Tema değiştirildi (observer):', currentTheme);
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
    console.log('Tema manuel olarak değiştirildi:', theme);
  };
});
</script>
<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                Dashboard 123
            </h2>
        </template>


        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div
                    class="overflow-hidden bg-white shadow-sm sm:rounded-lg"
                >
                    <div class="p-6 text-gray-900">
                        You're logged in! asdasd
                    </div>
                    <div class="mockup-browser border-base-300 border w-full">
                <div class="mockup-browser-toolbar">
                    <div class="input">https://daisyui.com  </div>
                </div>
                <div class="grid place-content-center border-t border-base-300 h-80">Hello!</div>
                </div>
                    <div class="p-4 border-2 border-base-300 rounded-box my-4">
                    <h3 class="text-xl font-bold mb-2">Manuel Tema Kontrolü</h3>
                    <p class="mb-4 text-sm opacity-70">DaisyUI otomatik kontrolü çalışmadığı için manuel kontroller</p>
                    <div class="flex flex-col gap-4">
                        <div class="form-control">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="tema" value="light" class="radio" onclick="setTheme('light')" />
                                <span>Light Tema</span>
                            </label>
                        </div>

                        <div class="form-control">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="tema" value="dark" class="radio" onclick="setTheme('dark')" />
                                <span>Dark Tema</span>
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
                                <input type="radio" name="tema" value="synthwave" class="radio" onclick="setTheme('synthwave')" />
                                <span>Synthwave Tema</span>
                            </label>
                        </div>

                        <div class="form-control">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="tema" value="valentine" class="radio" onclick="setTheme('valentine')" />
                                <span>Valentine Tema</span>
                            </label>
                        </div>
                    </div>

                    </div>


                    <div class="p-4 border border-base-300 rounded-box mt-4 mb-8">
                    <h3 class="text-lg font-bold mb-4">DaisyUI Tema Renkleri</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                      <div class="bg-primary text-primary-content p-4 rounded-box">
                        Primary
                      </div>
                      <div class="bg-secondary text-secondary-content p-4 rounded-box">
                        Secondary
                      </div>
                      <div class="bg-accent text-accent-content p-4 rounded-box">
                        Accent
                      </div>
                      <div class="bg-neutral text-neutral-content p-4 rounded-box">
                        Neutral
                      </div>
                      <div class="bg-base-100 text-base-content p-4 rounded-box border border-base-300">
                        Base 100
                      </div>
                      <div class="bg-base-200 text-base-content p-4 rounded-box">
                        Base 200
                      </div>
                      <div class="bg-base-300 text-base-content p-4 rounded-box">
                        Base 300
                      </div>
                      <div class="bg-info text-info-content p-4 rounded-box">
                        Info
                      </div>
                      <div class="bg-success text-success-content p-4 rounded-box">
                        Success
                      </div>
                      <div class="bg-warning text-warning-content p-4 rounded-box">
                        Warning
                      </div>
                      <div class="bg-error text-error-content p-4 rounded-box">
                        Error
                      </div>
                    </div>

                    <div class="flex gap-2 mb-4">
                      <button class="btn btn-primary">Primary</button>
                      <button class="btn btn-secondary">Secondary</button>
                      <button class="btn btn-accent">Accent</button>
                      <button class="btn btn-ghost">Ghost</button>
                    </div>
                    </div>

                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
