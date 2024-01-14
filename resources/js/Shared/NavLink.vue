<template>
    <Link
    :class="[active ? 'bg-white text-red-700' : 'text-gray-100 hover:bg-gray-200 hover:text-red-600', 'rounded-md px-3 py-2 text-sm font-medium']" :aria-current="active ? 'page' : undefined"
    >
        <slot />
    </Link>
</template>

<script>
import { Link } from '@inertiajs/vue3';
export default{
    props:{
        active: Boolean,
        name: String,
        key: String
    },
    components: { Link }
};
</script>