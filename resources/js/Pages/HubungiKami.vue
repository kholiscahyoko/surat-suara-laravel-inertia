<template>
    <div class="m-2 bg-white rounded-lg shadow-lg p-6">
        <h1 class="text-3xl font-bold tracking-tight text-gray-900">
            Hubungi Kami
        </h1>
        <div class="mt-4 mb-6 max-w-[800px]">
            <p class="mt-2">
                Kami selalu siap membantu dan mendengar masukan, pertanyaan, serta saran Anda. Jangan ragu untuk menghubungi kami melalui salah satu media sosial berikut:
            </p>
            <h2 class="mt-4 text-2xl font-semibold mb-2">Media Sosial</h2>
            <ul class="list-none p-0">
                <li class="mb-2"><a href="https://www.facebook.com/vikingcurvasud" target="_blank" class="hover:underline text-indigo-600 font-semibold">Facebook</a></li>
                <li class="mb-2"><a href="https://www.twitter.com/chaobianconerri" target="_blank" class="hover:underline text-indigo-600 font-semibold">Twitter</a></li>
                <li class="mb-2"><a href="https://www.instagram.com/kholis.cahyoko" target="_blank" class="hover:underline text-indigo-600 font-semibold">Instagram</a></li>
                <li class="mb-2"><a href="https://www.linkedin.com/in/kholis-cahyoko" target="_blank" class="hover:underline text-indigo-600 font-semibold">LinkedIn</a></li>
                <li class="mb-2"><a href="https://me.kholiscahyoko.my.id" target="_blank" class="hover:underline text-indigo-600 font-semibold">Website</a></li>
            </ul>
        </div>        
        <Donations />
    </div>
</template>
<script setup>
import Donations from '../Components/Donations.vue';
</script>