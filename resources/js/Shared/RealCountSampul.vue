<template>
    <a class="w-72 bg-white rounded-lg overflow-hidden mx-10 shadow-xl shadow-slate-600 mr-4 mb-10 transition ease-in-out delay-150 hover:-translate-y-1 hover:scale-105 duration-300" :href="$setUrl(`/hitung-suara/${jenis}${surat_suara ? '/'+ $slugify(surat_suara.nama_dapil)+ '/' +surat_suara.kode_dapil : ''}`)">
        <div>
            <div class="flex items-center justify-center pt-5 px-5 min-h-20 space-x-4">
                <img v-bind:src="$setUrl('/assets/img/logo-kpu.webp')" class="object-contain w-10 h-11" alt="Komisi Pemilihan Umum" loading="lazy">
                <div v-if="configs[jenis].header" class="block text-center font-bold lg:text-lg">
                    <h3>
                        HITUNG SUARA
                    </h3>
                </div>
            </div>
        </div>
        <div class="flex justify-center min-h-14 items-center align-middle text-center font-bold ">
            <div class="p-2 border-2 border-black" v-html="configs[jenis].footer.label"></div>
        </div>
        <div class="min-h-44 flex justify-center mt-4">
            <h2 class="text-center whitespace-normal">
                <span v-for="body in configs[jenis].body" class="block" v-html="surat_suara !== null && surat_suara !== undefined ? replacePlaceholder(surat_suara.nama_dapil, body.label) : body.label" :class="body.class">
                </span>
            </h2>
        </div>
        <div class="text-center text-xs py-2">
            KOMISI PEMILIHAN UMUM
        </div>
    </a>
</template>
<script setup>
defineProps({
    surat_suara : Object,
    jenis : String
})

let configs = {
    'pilpres' : {
        header : { label : "HITUNG SUARA", class: "font-bold text-2xl" },
        body : [
            { label : "PEMILIHAN UMUM<br>PRESIDEN DAN WAKIL PRESIDEN<br>REPUBLIK INDONESIA<br>TAHUN 2024", class: "font-bold text-sm" },
        ],
        footer : { label : "PILPRES", class: "border-2 border-black" }
    },
    'dpd' : {
        header : { label : "SURAT SUARA", class: "font-bold text-2xl" },
        body : [
            { label : "PEMILIHAN UMUM<br>ANGGOTA<br>DEWAN PERWAKILAN DAERAH<br>REPUBLIK INDONESIA<br>TAHUN 2024", class: "font-bold text-sm" },
            { label : "DAERAH PEMILIHAN", class: "text-sm mt-3" },
            { label : "[NAMA_DAERAH_PEMILIHAN]", class: "font-bold text-sm" },
        ],
        footer : { label : "DPD RI", class: "bg-red-600 text-white text-lg" }
    },
    'dpr' : {
        header : { label : "SURAT SUARA", class: "font-bold text-2xl" },
        body : [
            { label : "PEMILIHAN UMUM<br>ANGGOTA<br>DEWAN PERWAKILAN RAKYAT<br>REPUBLIK INDONESIA<br>TAHUN 2024", class: "font-bold text-sm" },
            { label : "DAERAH PEMILIHAN", class: "text-xs mt-3" },
            { label : "[NAMA_DAERAH_PEMILIHAN]", class: "font-bold text-sm" },
        ],
        footer : { label : "DPR RI", class: "bg-yellow-400 text-black text-lg" }
    },
    'dprd-provinsi' : {
        header : { label : "SURAT SUARA", class: "font-bold text-2xl" },
        body : [
            { label : "PEMILIHAN UMUM<br>ANGGOTA<br>DEWAN PERWAKILAN RAKYAT<br>DAERAH PROVINSI<br>[NAMA_WILAYAH]<br>TAHUN 2024", class: "font-bold text-sm" },
            { label : "DAERAH PEMILIHAN", class: "text-sm mt-3" },
            { label : "[NAMA_DAERAH_PEMILIHAN]", class: "font-bold text-sm" },
        ],
        footer : { label : "DPRD PROV", class: "bg-blue-600 text-white" }
    },
    'dprd-kabkota' : {
        header : { label : "SURAT SUARA", class: "font-bold text-2xl" },
        body : [
            { label : "PEMILIHAN UMUM<br>ANGGOTA<br>DEWAN PERWAKILAN RAKYAT<br>DAERAH KABUPATEN/KOTA<br>[NAMA_WILAYAH]<br>TAHUN 2024", class: "font-bold text-sm" },
            { label : "DAERAH PEMILIHAN", class: "text-sm mt-3" },
            { label : "[NAMA_DAERAH_PEMILIHAN]", class: "font-bold text-sm" },
        ],
        footer : { label : "DPRD KAB/KOTA", class: "bg-green-600 text-white" }
    },
}

function replaceLastWord(inputString) {
    // Regular expression to match a word with 4 or fewer letters at the end of the string
    const regex = /\b\d+\b$/;
    // Find the last word in the string
    const lastWordMatch = inputString.match(regex);

    if (lastWordMatch) {
        const lastWord = lastWordMatch[0];

        if (!isNaN(lastWord)) {
        const modifiedString = inputString.replace(regex, '');
        return modifiedString.trim();
        }
    }

  return inputString;
}

function prependIfNot(wordToCheck, originalString, prefix) {
  const words = originalString.trim().split(' ');
  if (words.length > 0 && words[0].toLowerCase() !== wordToCheck.toLowerCase()) {
    return `${prefix}${originalString}`;
  }
  return originalString;
}

function replacePlaceholder(nama_dapil, label){
    return label.replace(/\[NAMA_WILAYAH\]/, replaceLastWord(nama_dapil)).replace(/\[NAMA_DAERAH_PEMILIHAN\]/, nama_dapil);
}
</script>