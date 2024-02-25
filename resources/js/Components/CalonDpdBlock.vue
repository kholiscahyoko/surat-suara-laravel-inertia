<template>
    <a :href="$setUrl(`/profil-calon/${dapil.jenis_dewan === 'dprdp' ? 'dprd-provinsi' : dapil.jenis_dewan === 'dprdk' ? 'dprd-kabkota' : dapil.jenis_dewan}/${$slugify(dapil.nama_dapil)}/${dapil.kode_dapil}/${$slugify(calon.nama)}/${calon.id}`)" class="w-32 min-h-[380px] md:w-28 md:min-h-[320px] lg:w-32 lg:min-h-[380px] bg-white overflow-hidden shadow-xl shadow-slate-600 m-2 mb-10 border-2 border-slate-950 transition ease-in-out delay-150 hover:-translate-y-1 hover:scale-105 duration-300 cursor-pointer " :id="`calon-${calon.id}`" :class="checkId(calon.id) ? 'bg-yellow-400' : ''">
        <div class="text-center px-4 py-4 font-bold text-4xl">
            {{ calon.no_urut }}
        </div>
        <div>
            <img ref="image" :src="$setUrl(creatorImage)" @error="imageError = true" :alt="calon.nama" class="h-48 object-cover w-full" loading="lazy">
        </div>
        <h4 class="text-center px-4 py-4 min-h-24 text-sm md:text-xs lg:text-sm text-wrap break-words">
            {{ calon.nama }}
        </h4>
    </a>
</template>
<script>
export default{
    props: {
        calon : Object,
        calon_id: String,
        dapil: Object,
    },
    data(){
        return {
            imageError: false,
            defaultImage: `/assets/img/kpu_monochrome.webp`,
            queryParams : null,
        }
    },
    mounted(){
        this.queryParams = new URLSearchParams(window.location.search);
    },
    computed:{
        creatorImage(){
            return this.imageError ? this.defaultImage : `/assets/img/dpd_foto/compressed/${this.calon.foto.split('/').slice(-1).join().split('.').slice(0,-1).join().replace(/[^\p{L}\d]+/gu, '-').normalize('NFKD').replace(/[\u0300-\u036F]/g, '').replace(/[^-\w]+/g, '').trim().replace(/[\W_]+/g, ' ').trim().replace(/\s/g, '-').toLowerCase()}.webp`
        }
    },
    methods:{
        checkId : function(calonId) {
            if(this.calon_id == calonId){
                return true;
            }else{
                return false;
            }
        }
    }
};
</script>