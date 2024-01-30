<template>
  <div class="bg-white mb-10 p-2 shadow-lg shadow-slate-800 rounded-lg">
    <h2 class="lg:text-2xl text-xl text-center font-bold mb-2">Jumlah Calon Tetap di setiap provinsi</h2>
    <div class="w-full h-[500px] ">
      <l-map ref="map" v-model:zoom="zoom" :center="center" :use-global-leaflet="false">
        <l-tile-layer
          url="https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png"
          layer-type="base"
          name="OpenStreetMap"
        ></l-tile-layer>
        <l-marker v-for="provinsi in data_provinsi" :lat-lng="geoprovinsi[provinsi.kode_wilayah].koordinat" class="bg-red-600">
          <l-popup class="text-center">
             <span class="font-bold">{{ geoprovinsi[provinsi.kode_wilayah].nama }}</span><br>
             Jumlah DCT : {{ provinsi.jumlah_caleg.toLocaleString() }}
          </l-popup>
        </l-marker>
      </l-map>
    </div>
  </div>
</template>
  
  <script>
  import "leaflet/dist/leaflet.css";
  import { LMap, LTileLayer, LGeoJson, LMarker, LPopup } from "@vue-leaflet/vue-leaflet";
  
  export default {
    props:{
      data_provinsi: Array
    },
    components: {
      LMap,
      LTileLayer,
      LGeoJson,
      LMarker,
      LPopup
    },
    data() {
      return {
        zoom: 5, // Initial zoom level
        center: [-2.5489, 118.0149],
        geoprovinsi: null,
      };
    },
    async created () {
      const response = await fetch('/assets/json/lat_lng.json');
      this.geoprovinsi = await response.json();
    },
    methods: {
      showPopup(event) {
        console.log("POPUP SHOWED");
      },
      hidePopup() {
        console.log("POPUP SHOWED");
      },
    },
  };
  </script>
  
  <style></style>