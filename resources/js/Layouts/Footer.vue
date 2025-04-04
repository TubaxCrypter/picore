<script setup>
const currentYear = new Date().getFullYear();
</script>

<template>
    <footer class="bg-base-100 border-t border-base-200 py-4">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row justify-between items-center text-base-content/70 text-sm">
                <div>
                    &copy; {{ currentYear }} PiNet. Tüm hakları saklıdır.
                </div>
                <div class="mt-2 md:mt-0">
                    <a href="#" class="hover:text-primary mr-4">Hakkımızda</a>
                    <a href="#" class="hover:text-primary mr-4">Gizlilik Politikası</a>
                    <a href="#" class="hover:text-primary">İletişim</a>
                </div>
            </div>
        </div>
    </footer>
</template>