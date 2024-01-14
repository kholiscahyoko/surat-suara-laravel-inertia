<template>
    <section class="p-0">
        <header class="bg-white shadow">
            <Nav />
        </header>
    </section>
    <AppSection class="p-0">
        <main>
            <slot />
        </main>
    </AppSection>

</template>
  
<script>
import Nav from './Nav.vue'
export default{
    components:{ Nav }
}
</script>