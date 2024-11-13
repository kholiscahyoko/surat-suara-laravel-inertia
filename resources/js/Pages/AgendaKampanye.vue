<template>
    <div class="md:flex md:justify-between">
      <h1 class="text-3xl font-bold tracking-tight text-gray-900 mb-4 drop-shadow-md shadow-black">
        Agenda Kampanye Pasangan {{ paslon.nama }}
      </h1>
    </div>
    <AgendaKampanye :paslon="paslon" :wilayah="wilayah" :filters="filters"/>

</template>

<script setup>
import AgendaKampanye from '../Shared/AgendaKampanye.vue';

let props = defineProps({
    paslon: Object,
    wilayah: Object,
    filters: Object
})
</script>