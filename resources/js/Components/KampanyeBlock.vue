<template>
    <h2 class="font-bold text-xl lg:text-3xl text-center">{{ title }}</h2>
    <div class="overflow-x-auto justify-center mt-4 md:mt-10 shadow-lg border rounded-md">
        <div v-if="paginatedkampanye.length > 0" v-for="(item, index) in paginatedkampanye" :key="index" class="sm:flex border last:border-b-0">
            <div class="py-1 lg:py-3 px-6 text-center font-semibold">
                <div>
                    <CalendarIcon class="mx-auto h-5 w-5 md:h-8 md:w-8" aria-hidden="true"/>
                </div>
                <div class="text-sm md:text-base">{{ formatDateIndonesian(item["Tanggal"]) }}</div>
            </div>
            <div class="py-1 lg:py-3 px-6 text-center">
                <div>
                    <AdjustmentsHorizontalIcon class="mx-auto h-5 w-5 md:h-8 md:w-8" aria-hidden="true"/>
                </div>
                <div class="text-sm md:text-base">{{ item["Metode"] }}</div>
            </div>
            <div class="py-1 lg:py-3 px-6 text-center">
                <div>
                    <MapPinIcon class="mx-auto h-5 w-5 md:h-8 md:w-8" aria-hidden="true"/>
                </div>
                <div class="text-sm md:text-base">{{ item["Tempat"] }}</div>
            </div>
            <div class="py-1 lg:py-3 px-6 text-center">
                <div>
                    <ClipboardDocumentListIcon class="mx-auto h-5 w-5 md:h-8 md:w-8" aria-hidden="true"/>
                </div>
                <div class="text-sm md:text-base">{{ item["Kegiatan"] }}</div>
            </div>
            <div class="py-1 lg:py-3 px-6 text-center">
                <div>
                    <UserGroupIcon class="mx-auto h-5 w-5 md:h-8 md:w-8" aria-hidden="true"/>
                </div>
                <div class="text-sm md:text-base">{{ item["Jumlah Peserta"] }} Orang</div>
            </div>
            <div class="py-1 lg:py-3 px-6 text-center">
                <div>
                    <CheckCircleIcon class="mx-auto h-5 w-5 md:h-8 md:w-8" aria-hidden="true"/>
                </div>
                <div class="text-sm md:text-base">{{ item["Status Pelaksanaan"] }}</div>
            </div>
        </div>
        <div v-else class="text-2xl text-center py-2">
            Maaf, data tidak ditemukan
        </div>

        <div class="mt-4">
            <Pagination :data="pagination" />
        </div>
    </div>
</template>
<script setup>
import { CalendarIcon, AdjustmentsHorizontalIcon, MapPinIcon, ClipboardDocumentListIcon, UserGroupIcon, CheckCircleIcon } from '@heroicons/vue/24/outline'
import Pagination from '../Shared/Pagination.vue';
import { ref, computed} from "vue";

let props = defineProps({
    data_kampanye : Array,
    title : String,
    filters: Object
});

let formatDateIndonesian = function(dateString){
    const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
    const months = [
        'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 
        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
    ];

    const date = new Date(dateString);
    const dayName = days[date.getDay()];
    const day = date.getDate();
    const monthName = months[date.getMonth()];
    const year = date.getFullYear();

    return `${dayName}, ${day} ${monthName} ${year}`;
}


const perPage = props.filters.perPage || 5;
const currentPage = ref(parseInt(new URLSearchParams(window.location.search).get('page')) || 1);

const dataKampanye = computed(() => {
  return props.data_kampanye.filter(kampanye =>
      kampanye
  );
});

// Complete pagination metadata object
const pagination = computed(() => {
  const total = Math.ceil(dataKampanye.value.length / perPage);
  const lastPage = total;

  const links = [];
  
  // Previous link
  links.push({
    url: currentPage.value > 1 ? `?page=${currentPage.value - 1}` : null,
    label: '&laquo; Previous',
    active: false,
  });

  // First page
  if (lastPage > 1) {
    links.push({
      url: `?page=1`,
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
      url: `?page=${i}`,
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
      url: `?page=${lastPage}`,
      label: `${lastPage}`,
      active: currentPage.value === lastPage,
    });
  }

  // Next link
  links.push({
    url: currentPage.value < lastPage ? `?page=${currentPage.value + 1}` : null,
    label: 'Next &raquo;',
    active: false,
  });

  return {
    current_page: currentPage.value,
    first_page_url: `?page=1`,
    from: (currentPage.value - 1) * perPage + 1,
    last_page: lastPage,
    last_page_url: `?page=${lastPage}`,
    links: links,
    next_page_url: currentPage.value < lastPage ? `?page=${currentPage.value + 1}` : null,
    path: window.location.pathname, // Use current path
    per_page: perPage,
    prev_page_url: currentPage.value > 1 ? `?page=${currentPage.value - 1}` : null,
    to: Math.min(currentPage.value * perPage, dataKampanye.value.length),
    total: dataKampanye.value.length,
  };
});

// Paginate filtered kampanye for the current page
const paginatedkampanye = computed(() => {
  const start = (currentPage.value - 1) * perPage;
  return dataKampanye.value.slice(start, start + perPage);
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


</script>