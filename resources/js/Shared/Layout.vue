<template>
    <Head>
        <title>My App</title>
        <meta name="description" content="Surat Suara Information" head-key="meta-description">
    </Head>
    <section class="p-0">
        <header class="bg-white shadow">
            <Nav />
        </header>
    </section>
    <section class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
        <main>
            <slot />
        </main>
    </section>
    <section>
        <Footer />
    </section>

</template>
  
<script setup>
import Nav from './Nav.vue'
import Footer from './Footer.vue'
</script>