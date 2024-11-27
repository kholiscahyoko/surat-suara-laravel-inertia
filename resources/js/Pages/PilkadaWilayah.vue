<template>
    <h1 class="text-3xl font-bold tracking-tight text-gray-900">
        Cari Surat Suara Pilkada Berdasarkan Wilayah
    </h1>
    <form class="mt-4 flex space-x-2" action="/pilkada/wilayah">
        <input name="search" :value="search" type="text" placeholder="Cari" class="border px-2 rounded-lg text-lg h-12 w-full" v-on:keyup.native.enter="handleInput" :disabled="processing">
        <button class="px-8 bg-blue-600 text-white font-semibold rounded-lg">Cari</button>
    </form>
    <div class="mt-4 w-full">
        <HorizontalAds1/>
    </div>
    <div class="mt-4">
        <!-- table -->
        <div class="flex flex-col">
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                    <div v-if="paginatedFilteredRegions.length > 0" class="flex flex-wrap justify-center" >
                        <RealCountPilkadaSampul v-for="wilayah in paginatedFilteredRegions" :wilayah="wilayah"/>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-4">
            <Pagination :data="pagination" />
        </div>
    </div>
    <Donations />
</template>

<script setup>
import Pagination from '../Shared/Pagination.vue';
// import SuratSuaraPilkadaSampul from '../Shared/SuratSuaraPilkadaSampul.vue';
import RealCountPilkadaSampul from '../Shared/RealCountPilkadaSampul.vue';
import Donations from '../Components/Donations.vue';
import { ref, computed, watch } from "vue";
import HorizontalAds1 from '../Components/HorizontalAds1.vue';

// Define props for regions and filters
const props = defineProps({
  wilayahs: Array,
  filters: Object
});

const search = ref(props.filters.search || '');
const perPage = props.filters.perPage || 5;
const currentPage = ref(parseInt(new URLSearchParams(window.location.search).get('page')) || 1);

// Filter regions based on search query
const filteredRegions = computed(() => {
  return props.wilayahs.filter(wilayah =>
    wilayah.nama.toLowerCase().includes(search.value.toLowerCase())
  );
});

// Complete pagination metadata object
const pagination = computed(() => {
  const total = Math.ceil(filteredRegions.value.length / perPage);
  const lastPage = total;

  const links = [];
  
  // Previous link
  links.push({
    url: currentPage.value > 1 ? `?page=${currentPage.value - 1}&search=${encodeURIComponent(search.value)}` : null,
    label: '&laquo; Previous',
    active: false,
  });

  // First page
  if (lastPage > 1) {
    links.push({
      url: `?page=1&search=${encodeURIComponent(search.value)}`,
      label: '1',
      active: currentPage.value === 1,
    });
  }

  // Pages in the middle
  const startPage = Math.max(2, currentPage.value - 3);
  const endPage = Math.min(lastPage - 1, currentPage.value + 3);
  
  if (startPage > 2) {
    links.push({ url: null, label: '...', active: false });
  }

  for (let i = startPage; i <= endPage; i++) {
    links.push({
      url: `?page=${i}&search=${encodeURIComponent(search.value)}`,
      label: `${i}`,
      active: i === currentPage.value,
    });
  }

  if (endPage < lastPage - 1) {
    links.push({ url: null, label: '...', active: false });
  }

  // Last page
  if (lastPage > 1) {
    links.push({
      url: `?page=${lastPage}&search=${encodeURIComponent(search.value)}`,
      label: `${lastPage}`,
      active: currentPage.value === lastPage,
    });
  }

  // Next link
  links.push({
    url: currentPage.value < lastPage ? `?page=${currentPage.value + 1}&search=${encodeURIComponent(search.value)}` : null,
    label: 'Next &raquo;',
    active: false,
  });

  return {
    current_page: currentPage.value,
    first_page_url: `?page=1&search=${encodeURIComponent(search.value)}`,
    from: (currentPage.value - 1) * perPage + 1,
    last_page: lastPage,
    last_page_url: `?page=${lastPage}&search=${encodeURIComponent(search.value)}`,
    links: links,
    next_page_url: currentPage.value < lastPage ? `?page=${currentPage.value + 1}&search=${encodeURIComponent(search.value)}` : null,
    path: window.location.pathname, // Use current path
    per_page: perPage,
    prev_page_url: currentPage.value > 1 ? `?page=${currentPage.value - 1}&search=${encodeURIComponent(search.value)}` : null,
    to: Math.min(currentPage.value * perPage, filteredRegions.value.length),
    total: filteredRegions.value.length,
  };
});

// Paginate filtered regions for the current page
const paginatedFilteredRegions = computed(() => {
  const start = (currentPage.value - 1) * perPage;
  return filteredRegions.value.slice(start, start + perPage);
});

// Navigation functions
function nextPage() {
  if (pagination.value.next_page_url) {
    currentPage.value++;
    updateQueryString();
  }
}

function prevPage() {
  if (pagination.value.prev_page_url) {
    currentPage.value--;
    updateQueryString();
  }
}

var processing = ref(false);

//simulate form submission
const submitSearch = function(value){
    router.get('/wilayah', { search : value }, {
        preserveState : true,
        replace: true,
        onStart: () => {
            processing.value = true;
        },
        onFinish: () => {
            processing.value = false;
        }
    });
}

// Function to handle input events
const handleInput = () => {
//   // Clear any existing timeout
//   clearTimeout(timerId);

//   // Start a new timeout
//   timerId = setTimeout(() => {
//     // Perform action when user stops typing for 1 second
//     console.log('User stopped typing');
//     // You can call your submitForm method here if needed
//     if(search.value.length >= 4 && search.value.charAt(search.value.length - 1) !== ' '){
        submitSearch(search.value); // 1000 milliseconds = 1 second
//     }else{
//         console.log("MINIMAL 4 KARAKTER");
//     }
//   }, 2000); // Timeout duration in milliseconds
};
</script>