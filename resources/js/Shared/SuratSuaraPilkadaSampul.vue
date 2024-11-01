<template>
    <a class="w-72 bg-white rounded-lg overflow-hidden mx-10 shadow-xl shadow-slate-600 mr-4 mb-10 transition ease-in-out delay-150 hover:-translate-y-1 hover:scale-105 duration-300" :href="wilayah.url">
        <div>
            <div class="bg-red-600 flex items-center justify-between pt-5 px-5 min-h-20">
                <img v-bind:src="$setUrl('/assets/img/logo-kpu.webp')" class="object-contain w-10 h-11" alt="Komisi Pemilihan Umum" loading="lazy">
                <img v-bind:src="$setUrl('/assets/img/Logo_Pemilu_Sarana_Integrasi_Bangsa_2024.svg')" class="object-contain w-10 h-14" alt="Pemilu Sarana Integrasi Bangsa" loading="lazy">
            </div>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 35.28 2.17" preserveAspectRatio="none" class="fill-current text-red-600 -mt-1">
                <path d="M0 1c3.17.8 7.29-.38 10.04-.55 2.75-.17 9.25 1.47 12.67 1.3 3.43-.17 4.65-.84 7.05-.87 2.4-.02 5.52.88 5.52.88V0H0z" fill="%23ff0000"/>
            </svg>
        </div>
        <div class="min-h-44 font-bold">
            <h3 class="block text-center lg:text-lg">
                SURAT SUARA
            </h3>
            <h2 class="text-center whitespace-normal">
                PEMILIHAN<br>
                {{ wilayah.title_kada }} DAN WAKIL {{ wilayah.title_kada }}<br>
                {{ wilayah.title }}<br>
                TAHUN 2024
            </h2>
        </div>
        <div class="flex justify-center min-h-14 items-center align-middle text-center font-bold " :class="configs[wilayah.title_kada].footer.class">
            KOMISI PEMILIHAN UMUM
        </div>
    </a>
</template>
<script setup>
defineProps({
    wilayah : Object
})

let configs = {
    'GUBERNUR' : {
        footer : { class: "bg-red-900 text-xs text-white" }
    },
    'WALIKOTA' : {
        footer : { class: "bg-cyan-600 text-xs text-white" }
    },
    'BUPATI' : {
        footer : { class: "bg-cyan-300 text-xs text-black" }
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