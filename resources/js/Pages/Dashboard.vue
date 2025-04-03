<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { onMounted, watch } from 'vue';

// Tema değişikliklerini izleyen ve HTML'e uygulayan fonksiyon
onMounted(() => {
  // Sayfa yüklendiğinde localStorage'dan mevcut temayı al
  const savedTheme = localStorage.getItem('theme') || 'default';
  document.documentElement.setAttribute('data-theme', savedTheme);

  // Tema kontrolcülerini dinle
  const themeControllers = document.querySelectorAll('.theme-controller');
  themeControllers.forEach(controller => {
    // Kayıtlı tema ile eşleşen kontrol düğmesini seç
    if (controller.value === savedTheme) {
      controller.checked = true;
    }

    controller.addEventListener('change', (e) => {
      const newTheme = e.target.value;
      document.documentElement.setAttribute('data-theme', newTheme);
      localStorage.setItem('theme', newTheme);
    });

    // Toggle için özel yönetim
const themeToggle = document.querySelector('.toggle.theme-controller');
themeToggle.addEventListener('change', (e) => {
  const newTheme = e.target.checked ? 'synthwave' : 'default';
  document.documentElement.setAttribute('data-theme', newTheme);
  localStorage.setItem('theme', newTheme);
});

  });
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
    <div class="input">https://daisyui.com</div>
  </div>
  <div class="grid place-content-center border-t border-base-300 h-80">Hello!</div>
</div>
                    <input type="checkbox" data-theme-toggle="synthwave" class="toggle" />


                    <div class="join join-vertical">
  <input
    type="radio"
    name="theme-buttons"
    class="btn theme-controller join-item"
    aria-label="Default"
    value="default" />
  <input
    type="radio"
    name="theme-buttons"
    class="btn theme-controller join-item"
    aria-label="Retro"
    value="retro" />
  <input
    type="radio"
    name="theme-buttons"
    class="btn theme-controller join-item"
    aria-label="Cyberpunk"
    value="cyberpunk" />
  <input
    type="radio"
    name="theme-buttons"
    class="btn theme-controller join-item"
    aria-label="Valentine"
    value="valentine" />
  <input
    type="radio"
    name="theme-buttons"
    class="btn theme-controller join-item"
    aria-label="Aqua"
    value="aqua" />
</div>
                    <input type="checkbox" value="synthwave" class="toggle theme-controller" />

                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
