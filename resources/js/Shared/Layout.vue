<template>
    <div class="flex flex-col min-h-screen justify-between">
        <section class="p-0">
            <header class="bg-white shadow">
                <Nav />
            </header>
        </section>
        <section class="mx-auto px-1 py-6 mb-auto md:px-6 lg:px-8">
            <main>
                <slot />
            </main>
        </section>
        <section class="p-0 bottom-0">
            <Footer />
        </section>
    </div>
</template>
  
<script setup>
import Nav from './Nav.vue'
import Footer from './Footer.vue'
</script>