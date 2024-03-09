<template>
    <footer class="bg-slate-950 shadow mt-4 ">
        <div class="p-4 sm:items-center space-y-2">
            <div class="flex-wrap inline-flex justify-center text-base text-white text-center w-full">
                <a href="/tentang-kami" class="px-4 text-nowrap hover:underline">Tentang Kami</a>
                <a href="/kebijakan-privasi" class="px-4 text-nowrap hover:underline">Kebijakan Privasi</a>
                <a href="/hubungi-kami" class="px-4 text-nowrap hover:underline">Hubungi Kami</a>
            </div>
            <div class="text-base text-white text-center">&copy; 2024 <a href="https://me.kholiscahyoko.my.id/" target="_blank" class="hover:underline text-purple-500">Kholis Cahyoko </a>.
            </div>
        </div>
        <BottomAds />
    </footer>
</template>
<script setup>
import BottomAds from '../Components/BottomAds.vue';
</script>