<template>
<div class="flex items-center justify-between border-t border-gray-200 bg-white px-4 py-3 sm:px-6">
  <div class="flex flex-1 justify-between sm:hidden">
    <a href="#" class="relative inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">Previous</a>
    <a href="#" class="relative ml-3 inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">Next</a>
  </div>
  <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
    <div>
      <p class="text-sm text-gray-700">
        Showing
        <span class="font-medium">{{ users.from }}</span>
        to
        <span class="font-medium">{{ users.to }}</span>
        of
        <span class="font-medium">{{ users.total }}</span>
        results
      </p>
    </div>
    <div>
      <nav class="isolate inline-flex -space-x-px rounded-md shadow-sm" aria-label="Pagination">
        <Component
            :is="users.prev_page_url ? 'Link' : 'span'"
            :href="users.prev_page_url"
            class="rounded-l-md relative inline-flex px-4 items-center ring-1 ring-inset ring-gray-300 py-2 hover:bg-gray-50 focus:outline-offset-0 focus:z-20"
            :class="[
                users.prev_page_url ?
                'text-gray-900 hover:bg-gray-50' :
                'text-gray-400 text-sm font-semibold']"
            >
            <ChevronLeftIcon class="h-4 w-4" aria-hidden="true"/>
        </Component>
        <PaginationLink v-for="link in users.links.slice(1, -1)" :link="link" />
        <Component
            :is="users.next_page_url ?
            'Link' : 'span'"
            :href="users.next_page_url"
            class="rounded-r-md relative inline-flex px-4 items-center ring-1 ring-inset ring-gray-300 py-2 hover:bg-gray-50 focus:outline-offset-0 focus:z-20"
            :class="[
                users.next_page_url ?
                'text-gray-900 hover:bg-gray-50' :
                'text-gray-400 text-sm font-semibold']"
            >
                <ChevronRightIcon class="h-4 w-4" aria-hidden="true"/>
        </Component>
      </nav>
    </div>
  </div>
</div>
</template>
<script setup>
import PaginationLink from './PaginationLink.vue';
import { ChevronLeftIcon, ChevronRightIcon } from '@heroicons/vue/24/outline'

defineProps({
    users : Object
});
</script>