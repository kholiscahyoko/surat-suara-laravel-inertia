<template>
  <div class="bg-white mb-10 p-2 shadow-lg shadow-slate-800 rounded-lg">
    <h2 class="lg:text-2xl text-xl text-center font-bold mb-2">Daftar Calon Tetap di setiap provinsi</h2>
    <div class="w-full h-[500px] ">
      <l-map ref="map" v-model:zoom="zoom" :min-zoom="(zoom-1)" :max-zoom="(zoom+2)" :center="center" :use-global-leaflet="false">
        <l-tile-layer
          url="https://basemap.nationalmap.gov/arcgis/rest/services/USGSTopo/MapServer/tile/{z}/{y}/{x}"
          layer-type="base"
          name="OpenStreetMap"
        ></l-tile-layer>
        <l-marker v-for="provinsi in data_provinsi" :lat-lng="geo_provinsi[provinsi.kode_wilayah].koordinat" class="bg-red-600">
          <l-popup class="text-center">
             <span class="font-bold">{{ geo_provinsi[provinsi.kode_wilayah].nama }}</span><br>
             Jumlah DCT : {{ provinsi.jumlah_caleg.toLocaleString() }}
          </l-popup>
        </l-marker>
      </l-map>
    </div>
  </div>
</template>
  
<script setup>
import "leaflet/dist/leaflet.css";
import { ref, onMounted, onUnmounted } from 'vue'
import { LMap, LTileLayer, LGeoJson, LMarker, LPopup } from "@vue-leaflet/vue-leaflet";

let props = defineProps({
  data_provinsi: Array,
  geo_provinsi: Object,
})

let zoom = 5; // Initial zoom level
let center = [-2.5489, 118.0149];
</script>