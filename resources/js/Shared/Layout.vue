<template>
    <div class="flex flex-col min-h-screen justify-between">
        <section class="p-0">
            <header class="bg-white shadow">
                <Nav />
            </header>
        </section>
        <section class="px-1 py-6 mb-auto md:px-6 lg:px-8 w-full max-w-[1366px] mx-auto">
            <main>
                <slot />
            </main>
        </section>
        <section class="w-full">
            <MultiplexAds1 />
        </section>
        <section class="p-0 bottom-0">
            <Footer />
        </section>
        <section class="sticky bottom-0 text-red-600">
            <BottomAds />
        </section>
    </div>
</template>
  
<script setup>
import Nav from './Nav.vue'
import Footer from './Footer.vue'
import MultiplexAds1 from '../Components/MultiplexAds1.vue'
import BottomAds from '../Components/BottomAds.vue'
</script>